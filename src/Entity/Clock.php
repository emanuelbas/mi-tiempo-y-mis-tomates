<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClockRepository")
 */
class Clock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $lap;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $pauseStamp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periodType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $previousPeriod;

    /**
     * @ORM\Column(type="datetime")
     */
    private $periodStartStamp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deadline;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ready;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Task", inversedBy="clock", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", inversedBy="clock", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function __construct(Client $client, Task $task){
        $this->client=$client;
        $this->task=$task;
        $this->lap=0;
        $this->pauseStamp=NULL;
        $this->periodType='Trabajo';
        $this->previousPeriod='Descanso';
        $this->ready=FALSE;

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->periodStartStamp= new \DateTime();
        $time= new \DateTime();
        $minutesToAdd= $client->getPomodorosConfiguration()->getWorkingTime();
        $time->modify("+{$minutesToAdd} minutes");
        $this->deadline=$time;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLap(): ?int
    {
        return $this->lap;
    }

    public function setLap(int $lap): self
    {
        $this->lap = $lap;

        return $this;
    }

    public function getPauseStamp(): ?\DateTimeInterface
    {
        return $this->pauseStamp;
    }

    public function setPauseStamp(?\DateTimeInterface $pauseStamp): self
    {
        $this->pauseStamp = $pauseStamp;

        return $this;
    }

    public function getPeriodType(): ?string
    {
        return $this->periodType;
    }

    public function setPeriodType(string $periodType): self
    {
        $this->periodType = $periodType;

        return $this;
    }

    public function getPreviousPeriod(): ?string
    {
        return $this->previousPeriod;
    }

    public function setPreviousPeriod(?string $previousPeriod): self
    {
        $this->previousPeriod = $previousPeriod;

        return $this;
    }

    public function getPeriodStartStamp(): ?\DateTimeInterface
    {
        return $this->periodStartStamp;
    }

    public function setPeriodStartStamp(\DateTimeInterface $periodStartStamp): self
    {
        $this->periodStartStamp = $periodStartStamp;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getReady(): ?bool
    {
        return $this->ready;
    }

    public function setReady(): self
    {
        $this->ready = True;
        $this->periodStartStamp = $this->deadline;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTaskName(): ?string
    {      
        return $this->getTask()->getTaskName();
    }

    public function canBePaused(): ?bool
    {
    //El reloj puede pausarse cuando no esta en pausa ni esperando el next

        return ((is_null($this->pauseStamp))&& !($this->canDoNext()));
    }

    public function canBeResumed(): ?bool
    {
    //Si está en pausa puede retomarse

        return !(is_null($this->pauseStamp)) && !($this->canDoNext());
    }

    public function canDoNext(): ?bool
    {
    //Se puede hacer next solo cuando está ready

        return ($this->secondsRemaining() <= 1);
    }

    public function isPaused(): ?bool
    {
            return (is_null($this->pauseStamp));
    }

    public function resume(): self
    {
    //Resume recalcula el deadline

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $aDate =new \DateTime();
        $secondsToAdd = strtotime($aDate->format('Y-m-d H:i:s')) - strtotime($this->pauseStamp->format('Y-m-d H:i:s'));
        
        $time= $this->deadline;
        $time= $time->format('Y-m-d H:i:s');
        
        $time = strtotime($time) + $secondsToAdd;
        date_timestamp_set($aDate, $time);
        $this->deadline= $aDate;

        //Poner el pauseStamp en null para quitar la pausa
        $this->setPauseStamp(NULL);

        return $this;
    }

    public function pause(): self
    {
    //Pause debe guardar el pauseStamp

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->pauseStamp= new \DateTime();

        return $this;
    }

    public function stop(TaskState $state): self
    {
        $this->task->setTaskState($state);

        return $this;
    }

    public function next(): self
    {
    //Setea las variables para el proximo periodo
        
        $this->ready = FALSE;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->periodStartStamp=  new \DateTime();

        //Actualizar la deadline y el tipo de periodo segun el periodo anterior
        if ($this->periodType == 'Trabajo')
        {
            //El true indica que aun no se hizo store de este pomodoro, la idea es que cuando llegue a 0 se almacene el pomo solo si está en ready=true, esto es para evitar que se haga store del mismo pomo más de una vez 
            $this->setReady(TRUE); 

            $this->previousPeriod = 'Trabajo';
            $this->periodType = 'Descanso';
            if ($this->lap == 3){
                $minutesToAdd= $this->getClient()->getPomodorosConfiguration()->getLongBreakTime();
                $this->lap = 0;
            } else {
                $minutesToAdd = $this->getClient()->getPomodorosConfiguration()->getBreakTime();
                $this->lap = $this->lap + 1;                
            }          
        } else {
            $this->previousPeriod = 'Descanso';
            $this->periodType = 'Trabajo';
            $minutesToAdd=$this->getClient()->getPomodorosConfiguration()->getWorkingTime();
        }
        $timenow = new \DateTime();
        $this->deadline = $timenow->modify("+{$minutesToAdd} minutes");

        return $this;
    }
    
    public function addToDeadlineSeconds(Int $seconds): self
    {
        $deadline = $this->deadline;
        $deadline = strtotime($deadline);
        $this->deadline = $deadline + $seconds;
        return $this;
    }

    public function secondsRemaining(): Int
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    if (is_null($this->pauseStamp)){ //Si no esta en pausa
        $secondsRemaining = strtotime($this->deadline->format('Y-m-d H:i:s')) - strtotime((new \DateTime())->format('Y-m-d H:i:s'));
    } else { //Si esta pausado
        $secondsRemaining = strtotime($this->deadline->format('Y-m-d H:i:s')) - strtotime($this->pauseStamp->format('Y-m-d H:i:s'));
    }
        return $secondsRemaining;
    }
    



}

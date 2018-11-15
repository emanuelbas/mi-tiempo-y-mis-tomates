<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
        $this->periodType='WORK';
        $this->previousPeriod='BREAK';
        $this->ready=FALSE;

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $this->periodStartStamp= new \DateTime();
        $time= new \DateTime();
        $minutesToAdd= $client->getPomodorosConfiguration()->getWorkingTime();
        $time->modify("+{$minutesToAdd} minutes");
        $this->deadline=$time;
    }

    /*public function __construct(Client $client, Task $task)
    {
        //Al crearse el reloj se le pasa la tarea y el usuario
        //La idea es que sea la clase usuario la que crea el reloj
        //usando la función startTask(), desde alli se envian estos parametros
        $this->client=$client;
        $this->task=$task;


        //En base a la configuración del cliente se obtiene el deadline

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $dateTime = new \DateTime();

        $minutesToAdd = $this->getClient()->getPomodorosConfiguration()->getWorkingTime();
        $dateTime->modify("+{$minutesToAdd} minutes");

        $this->deadline=$dateTime

        //Lap en 0, son las vueltas antes del descanso largo
        $this->lap=0;

        //pauseStamp se mantiene en null para indicar que no está pausado
        $this->pauseStamp=NULL;

        //periodType se le asigna 'work'
        $this->periodType='WORK';

        //previousPeriod se inicializa en 'break' para evitar irregularidades
        $this->previousPeriod='BREAK';

        //periodStartStamp arranca en la hora actual
        $this->periodStartStamp= new \DateTime();

        //ready debe arrancar en false
        $this->ready=FALSE;
    }
    */

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

        return ((is_null($this->pauseStamp))&& (!($this->ready)));
    }

    public function canBeResumed(): ?bool
    {
    //Si está en pausa puede retomarse

        return !(is_null($this->pauseStamp));
    }

    public function canDoNext(): ?bool
    {
    //Se puede hacer next solo cuando está ready

        return $this->ready;
    }

    public function resume(): self
    {
    //Resume recalcula el deadline

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $nowStamp = new \DateTime();
        $timePaused = $nowStamp - $this->pauseStamp;
        $this->deadline = $this->deadline + $timePaused;

        //Poner el pauseStamp en null para quitar la pausa
        unset($this->pauseStamp);

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
        if ($this->previousPeriod == 'WORK')
        {
            $this->previousPeriod = 'WORK';
            $this->periodType = 'BREAK';
            if ($this->lap == 3){
                $minutesToAdd= $this->getClient()->getPomodorosConfiguration()->getLongBreakTime();
                $this->lap = 0;
            } else {
                $minutesToAdd = $this->getClient()->getPomodorosConfiguration()->getBreakTime();
                $this->lap = $this->lap + 1;                
            }          
        } else {
            $this->previousPeriod = 'BREAK';
            $this->periodType = 'WORK';
            $minutesToAdd=$this->getClient()->getPomodorosConfiguration()->getWorkingTime();
        }
        $timenow = new DateTime();
        $this->deadline = $timenow->modify("+{$minutesToAdd} minutes");

        /*
            EJEMPLO DE COMO AGREGAR MINUTOS A UNA DATETIME
            $dateTime = new DateTime('2011-11-17 05:05');
            $minutesToAdd = 5;
            $dateTime->modify("+{$minutesToAdd} minutes");
        */
      


        return $this;
    }

    public function storeData(): self
    {
    //Si el periodo es de trabajo, crea un pomo nuevo y lo guarda en la tarea
    if ($this->periodType == 'WORK') {
            $newPomodoro=new Pomodoro();
            $newPomodoro->setStartDate($this->periodStartStamp);
            $newPomodoro->setEndingDate($this->deadline);
            $this->task->addPomodoro($newPomodoro);

            //Ahora necesitaria persistir $newPomodoro y $this->task
        }


        return $this;
    }



}

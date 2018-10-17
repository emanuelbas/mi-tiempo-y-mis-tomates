<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $task_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $stimated_pomodoros;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="tasks")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TaskState", inversedBy="tasks")
     */
    private $task_state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pomodoro", mappedBy="task")
     */
    private $pomodoros;

    public function __construct()
    {
        $this->pomodoros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskName(): ?string
    {
        return $this->task_name;
    }

    public function setTaskName(string $task_name): self
    {
        $this->task_name = $task_name;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getStimatedPomodoros(): ?int
    {
        return $this->stimated_pomodoros;
    }

    public function setStimatedPomodoros(int $stimated_pomodoros): self
    {
        $this->stimated_pomodoros = $stimated_pomodoros;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTaskState(): ?TaskState
    {
        return $this->task_state;
    }

    public function setTaskState(?TaskState $task_state): self
    {
        $this->task_state = $task_state;

        return $this;
    }

    /**
     * @return Collection|Pomodoro[]
     */
    public function getPomodoros(): Collection
    {
        return $this->pomodoros;
    }

    public function addPomodoro(Pomodoro $pomodoro): self
    {
        if (!$this->pomodoros->contains($pomodoro)) {
            $this->pomodoros[] = $pomodoro;
            $pomodoro->setTask($this);
        }

        return $this;
    }

    public function removePomodoro(Pomodoro $pomodoro): self
    {
        if ($this->pomodoros->contains($pomodoro)) {
            $this->pomodoros->removeElement($pomodoro);
            // set the owning side to null (unless already changed)
            if ($pomodoro->getTask() === $this) {
                $pomodoro->setTask(null);
            }
        }

        return $this;
    }
}

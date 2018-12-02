<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientUsesApplicationRepository")
 */
class ClientUsesApplication
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $time_ammount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="clientUsesApplications")
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="clientUsesApplications")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="clientUsesApplications")
     */
    private $task;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getTimeAmmount(): ?int
    {
        return $this->time_ammount;
    }

    public function setTimeAmmount(?int $time_ammount): self
    {
        $this->time_ammount = $time_ammount;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

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

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}

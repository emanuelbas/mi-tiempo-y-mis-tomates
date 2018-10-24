<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PomodorosConfigurationRepository")
 */
class PomodorosConfiguration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\Column(type="integer")
     */
    private $break_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $working_time;

    /**
     * @ORM\Column(type="boolean")
     */
    private $end_break_alarm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $end_work_alarm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $clock_sound;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreakTime(): ?int
    {
        return $this->break_time;
    }

    public function setBreakTime(int $break_time): self
    {
        $this->break_time = $break_time;

        return $this;
    }

    public function getWorkingTime(): ?int
    {
        return $this->working_time;
    }

    public function setWorkingTime(int $working_time): self
    {
        $this->working_time = $working_time;

        return $this;
    }

    public function getEndBreakAlarm(): ?bool
    {
        return $this->end_break_alarm;
    }

    public function setEndBreakAlarm(bool $end_break_alarm): self
    {
        $this->end_break_alarm = $end_break_alarm;

        return $this;
    }

    public function getEndWorkAlarm(): ?bool
    {
        return $this->end_work_alarm;
    }

    public function setEndWorkAlarm(bool $end_work_alarm): self
    {
        $this->end_work_alarm = $end_work_alarm;

        return $this;
    }

    public function getClockSound(): ?bool
    {
        return $this->clock_sound;
    }

    public function setClockSound(bool $clock_sound): self
    {
        $this->clock_sound = $clock_sound;

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
}

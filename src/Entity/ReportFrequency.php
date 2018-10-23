<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReportFrequencyRepository")
 */
class ReportFrequency
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
    private $frequency_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="report_frequency")
     */
    private $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrequencyName(): ?string
    {
        return $this->frequency_name;
    }

    public function setFrequencyName(string $frequency_name): self
    {
        $this->frequency_name = $frequency_name;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setReportFrequency($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getReportFrequency() === $this) {
                $client->setReportFrequency(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->frequency_name;
    }

}

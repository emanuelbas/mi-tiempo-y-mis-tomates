<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
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
    private $app_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $app_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="applications")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientUsesApplication", mappedBy="application")
     */
    private $clientUsesApplications;

    public function __construct()
    {
        $this->clientUsesApplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppId(): ?int
    {
        return $this->app_id;
    }

    public function setAppId(int $app_id): self
    {
        $this->app_id = $app_id;

        return $this;
    }

    public function getAppName(): ?string
    {
        return $this->app_name;
    }

    public function setAppName(string $app_name): self
    {
        $this->app_name = $app_name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|ClientUsesApplication[]
     */
    public function getClientUsesApplications(): Collection
    {
        return $this->clientUsesApplications;
    }

    public function addClientUsesApplication(ClientUsesApplication $clientUsesApplication): self
    {
        if (!$this->clientUsesApplications->contains($clientUsesApplication)) {
            $this->clientUsesApplications[] = $clientUsesApplication;
            $clientUsesApplication->setApplication($this);
        }

        return $this;
    }

    public function removeClientUsesApplication(ClientUsesApplication $clientUsesApplication): self
    {
        if ($this->clientUsesApplications->contains($clientUsesApplication)) {
            $this->clientUsesApplications->removeElement($clientUsesApplication);
            // set the owning side to null (unless already changed)
            if ($clientUsesApplication->getApplication() === $this) {
                $clientUsesApplication->setApplication(null);
            }
        }

        return $this;
    }
}

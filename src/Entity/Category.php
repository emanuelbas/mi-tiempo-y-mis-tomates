<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientApplicationsConfiguration", mappedBy="category")
     */
    private $clientApplicationsConfigurations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientCategoryConfiguration", mappedBy="category", orphanRemoval=true)
     */
    private $clientCategoryConfigurations;

    public function __construct(string $name)
    {
        $this->clientApplicationsConfigurations = new ArrayCollection();
        $this->clientCategoryConfigurations = new ArrayCollection();
        $this->category_name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection|ClientApplicationsConfiguration[]
     */
    public function getClientApplicationsConfigurations(): Collection
    {
        return $this->clientApplicationsConfigurations;
    }

    public function addClientApplicationsConfiguration(ClientApplicationsConfiguration $clientApplicationsConfiguration): self
    {
        if (!$this->clientApplicationsConfigurations->contains($clientApplicationsConfiguration)) {
            $this->clientApplicationsConfigurations[] = $clientApplicationsConfiguration;
            $clientApplicationsConfiguration->setCategory($this);
        }

        return $this;
    }

    public function removeClientApplicationsConfiguration(ClientApplicationsConfiguration $clientApplicationsConfiguration): self
    {
        if ($this->clientApplicationsConfigurations->contains($clientApplicationsConfiguration)) {
            $this->clientApplicationsConfigurations->removeElement($clientApplicationsConfiguration);
            // set the owning side to null (unless already changed)
            if ($clientApplicationsConfiguration->getCategory() === $this) {
                $clientApplicationsConfiguration->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientCategoryConfiguration[]
     */
    public function getClientCategoryConfigurations(): Collection
    {
        return $this->clientCategoryConfigurations;
    }

    public function addClientCategoryConfiguration(ClientCategoryConfiguration $clientCategoryConfiguration): self
    {
        if (!$this->clientCategoryConfigurations->contains($clientCategoryConfiguration)) {
            $this->clientCategoryConfigurations[] = $clientCategoryConfiguration;
            $clientCategoryConfiguration->setCategory($this);
        }

        return $this;
    }

    public function removeClientCategoryConfiguration(ClientCategoryConfiguration $clientCategoryConfiguration): self
    {
        if ($this->clientCategoryConfigurations->contains($clientCategoryConfiguration)) {
            $this->clientCategoryConfigurations->removeElement($clientCategoryConfiguration);
            // set the owning side to null (unless already changed)
            if ($clientCategoryConfiguration->getCategory() === $this) {
                $clientCategoryConfiguration->setCategory(null);
            }
        }

        return $this;
    }

}

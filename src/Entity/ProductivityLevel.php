<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductivityLevelRepository")
 */
class ProductivityLevel
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
    private $level_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="productivity_level")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientCategoryConfiguration", mappedBy="productivityLevel", orphanRemoval=true)
     */
    private $clientCategoryConfigurations;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->clientCategoryConfigurations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevelName(): ?string
    {
        return $this->level_name;
    }

    public function setLevelName(string $level_name): self
    {
        $this->level_name = $level_name;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setProductivityLevel($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getProductivityLevel() === $this) {
                $category->setProductivityLevel(null);
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
            $clientCategoryConfiguration->setProductivityLevel($this);
        }

        return $this;
    }

    public function removeClientCategoryConfiguration(ClientCategoryConfiguration $clientCategoryConfiguration): self
    {
        if ($this->clientCategoryConfigurations->contains($clientCategoryConfiguration)) {
            $this->clientCategoryConfigurations->removeElement($clientCategoryConfiguration);
            // set the owning side to null (unless already changed)
            if ($clientCategoryConfiguration->getProductivityLevel() === $this) {
                $clientCategoryConfiguration->setProductivityLevel(null);
            }
        }

        return $this;
    }
}

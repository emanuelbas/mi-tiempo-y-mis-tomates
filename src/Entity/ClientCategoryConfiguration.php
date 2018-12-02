<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientCategoryConfigurationRepository")
 */
class ClientCategoryConfiguration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="clientCategoryConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="clientCategoryConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductivityLevel", inversedBy="clientCategoryConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productivityLevel;

    public function __construct($client , $category , $level)
    {
        $this->client = $client;
        $this->category = $category;
        $this->productivityLevel = $level;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProductivityLevel(): ?ProductivityLevel
    {
        return $this->productivityLevel;
    }

    public function setProductivityLevel(?ProductivityLevel $productivityLevel): self
    {
        $this->productivityLevel = $productivityLevel;

        return $this;
    }
}

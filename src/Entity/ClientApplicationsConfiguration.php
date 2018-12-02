<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientApplicationsConfigurationRepository")
 */
class ClientApplicationsConfiguration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Application", inversedBy="clientApplicationsConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="clientApplicationsConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="clientApplicationsConfigurations")
     */
    private $client;

    public function __construct($aClient , $anApplication , $aCategory)
    {
        $this->client = $aClient;
        $this->application = $anApplication;
        $this->category = $aCategory;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

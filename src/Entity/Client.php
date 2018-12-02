<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              length   = 191,
 *              unique   = true
 *          )
 *      )
 * })
 * @UniqueEntity(fields={"email"}, message="Ya existe un usuario con ese email.")
 */

class Client implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secret_answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SecretQuestion", inversedBy="clients")
     */
    private $secret_question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ReportFrequency", inversedBy="clients")
     */
    private $report_frequency;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PomodorosConfiguration", cascade={"persist", "remove"})
     */
    private $pomodoros_configuration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="client")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientUsesApplication", mappedBy="client")
     */
    private $clientUsesApplications;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Clock", mappedBy="client", cascade={"persist", "remove"})
     */
    private $clock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientApplicationsConfiguration", mappedBy="client")
     */
    private $clientApplicationsConfigurations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientCategoryConfiguration", mappedBy="client", orphanRemoval=true)
     */
    private $clientCategoryConfigurations;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->clientUsesApplications = new ArrayCollection();
        $this->clientApplicationsConfigurations = new ArrayCollection();
        $this->clientCategoryConfigurations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  public function getUsername(): ?string
    {
        return $this->email;
    }

    public function setUsername(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

     public function getRoles()
        {
            return array('ROLE_USER');
        }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->first_name,
            $this->last_name,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->first_name,
            $this->last_name,
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function getSecretAnswer(): ?string
    {
        return $this->secret_answer;
    }

    public function setSecretAnswer(string $secret_answer): self
    {
        $this->secret_answer = $secret_answer;

        return $this;
    }

    public function getSecretQuestion(): ?SecretQuestion
    {
        return $this->secret_question;
    }

    public function setSecretQuestion(?SecretQuestion $secret_question): self
    {
        $this->secret_question = $secret_question;

        return $this;
    }

    public function getReportFrequency(): ?ReportFrequency
    {
        return $this->report_frequency;
    }

    public function setReportFrequency(?ReportFrequency $report_frequency): self
    {
        $this->report_frequency = $report_frequency;

        return $this;
    }

    public function getPomodorosConfiguration(): ?PomodorosConfiguration
    {
        return $this->pomodoros_configuration;
    }

    public function setPomodorosConfiguration(?PomodorosConfiguration $pomodoros_configuration): self
    {
        $this->pomodoros_configuration = $pomodoros_configuration;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setClient($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getClient() === $this) {
                $task->setClient(null);
            }
        }

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
            $clientUsesApplication->setClient($this);
        }

        return $this;
    }

    public function removeClientUsesApplication(ClientUsesApplication $clientUsesApplication): self
    {
        if ($this->clientUsesApplications->contains($clientUsesApplication)) {
            $this->clientUsesApplications->removeElement($clientUsesApplication);
            // set the owning side to null (unless already changed)
            if ($clientUsesApplication->getClient() === $this) {
                $clientUsesApplication->setClient(null);
            }
        }

        return $this;
    }

    public function getClock(): ?Clock
    {
        return $this->clock;
    }

    public function setClock(Clock $clock): self
    {
        $this->clock = $clock;

        // set the owning side of the relation if necessary
        if ($this !== $clock->getClient()) {
            $clock->setClient($this);
        }

        return $this;
    }

    public function canShowClock(): bool
    {
        //Lo puede mostrar si no es null
        return !(is_null($this->clock));
    }

    public function canStartTask(): bool
    {
        //el usuario puede iniciar tareas solo si no hay una en curso
        return is_null($this->clock);
    }

    public function canStopTask(): bool
    {
        return !(is_null($this->clock));
    }

    public function canFinishTask(): bool
    {
        return !(is_null($this->clock));
    }
    public function stopTask(TaskState $state): self
    {
        //Cambiar el state de la tarea
        $this->clock->stop($state);

        //Destruir el reloj
        unset($this->clock);

        return $this;
    }

    public function startClockForTask(Task $task): self
    {
        //Cambiar el state de la tarea a activo viene a ser responsabilidad de la funcion que llama a esta.
        
        $this->setClock(new Clock($this, $task));
      
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
            $clientApplicationsConfiguration->setClient($this);
        }

        return $this;
    }

    public function removeClientApplicationsConfiguration(ClientApplicationsConfiguration $clientApplicationsConfiguration): self
    {
        if ($this->clientApplicationsConfigurations->contains($clientApplicationsConfiguration)) {
            $this->clientApplicationsConfigurations->removeElement($clientApplicationsConfiguration);
            // set the owning side to null (unless already changed)
            if ($clientApplicationsConfiguration->getClient() === $this) {
                $clientApplicationsConfiguration->setClient(null);
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
            $clientCategoryConfiguration->setClient($this);
        }

        return $this;
    }

    public function removeClientCategoryConfiguration(ClientCategoryConfiguration $clientCategoryConfiguration): self
    {
        if ($this->clientCategoryConfigurations->contains($clientCategoryConfiguration)) {
            $this->clientCategoryConfigurations->removeElement($clientCategoryConfiguration);
            // set the owning side to null (unless already changed)
            if ($clientCategoryConfiguration->getClient() === $this) {
                $clientCategoryConfiguration->setClient(null);
            }
        }

        return $this;
    }

}

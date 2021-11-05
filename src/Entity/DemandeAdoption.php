<?php

namespace App\Entity;

use App\Repository\DemandeAdoptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeAdoptionRepository::class)
 */
class DemandeAdoption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="listAdoption")
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity=Chien::class, inversedBy="demandeAdoptions")
     */
    private $chien;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="demandeAdoption",cascade={"remove"})
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="demandeAdoption")
     */
    private $annonce;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valider;

    public function __construct()
    {
        $this->chien = new ArrayCollection();
        $this->message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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

    /**
     * @return Collection|Chien[]
     */
    public function getChien(): Collection
    {
        return $this->chien;
    }

    public function addChien(Chien $chien): self
    {
        if (!$this->chien->contains($chien)) {
            $this->chien[] = $chien;
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        $this->chien->removeElement($chien);

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message[] = $message;
            $message->setDemandeAdoption($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDemandeAdoption() === $this) {
                $message->setDemandeAdoption(null);
            }
        }

        return $this;
    }


    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): self
    {
        $this->valider = $valider;

        return $this;
    }
}

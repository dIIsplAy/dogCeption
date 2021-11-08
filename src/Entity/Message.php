<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lue = false;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="message", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=DemandeAdoption::class, inversedBy="message", cascade={"remove"})
     */
    private $demandeAdoption;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getLue(): ?bool
    {
        return $this->lue;
    }

    public function setLue(bool $lue): self
    {
        $this->lue = $lue;

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

    public function getDemandeAdoption(): ?DemandeAdoption
    {
        return $this->demandeAdoption;
    }

    public function setDemandeAdoption(?DemandeAdoption $demandeAdoption): self
    {
        $this->demandeAdoption = $demandeAdoption;

        return $this;
    }
}

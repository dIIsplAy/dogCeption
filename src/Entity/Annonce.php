<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id= null;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pourvu = false;

    /**
     * @ORM\OneToMany(targetEntity=Chien::class, mappedBy="annonce", cascade={"persist"} )
     */
    private $listeChien;

    /**
     * @ORM\ManyToOne(targetEntity=Annonceur::class, inversedBy="listeAnnonce")
     */
    private $annonceur;

    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="annonce")
     */
    private $demandeAdoption;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function __construct()
    {
        $this->listeChien = new ArrayCollection();
        $this->demandeAdoption = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getPourvu(): ?bool
    {
        return $this->pourvu;
    }

    public function setPourvu(bool $pourvu): self
    {
        $this->pourvu = $pourvu;

        return $this;
    }

    /**
     * @return Collection|Chien[]
     */
    public function getListeChien(): Collection
    {
        return $this->listeChien;
    }

    public function addListeChien(Chien $listeChien): self
    {
        if (!$this->listeChien->contains($listeChien)) {
            $this->listeChien[] = $listeChien;
            $listeChien->setAnnonce($this);
        }

        return $this;
    }

    public function removeListeChien(Chien $listeChien): self
    {
        if ($this->listeChien->removeElement($listeChien)) {
            // set the owning side to null (unless already changed)
            if ($listeChien->getAnnonce() === $this) {
                $listeChien->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getAnnonceur(): ?Annonceur
    {
        return $this->annonceur;
    }

    public function setAnnonceur(?Annonceur $annonceur): self
    {
        $this->annonceur = $annonceur;

        return $this;
    }

    /**
     * @return Collection|DemandeAdoption[]
     */
    public function getDemandeAdoption(): Collection
    {
        return $this->demandeAdoption;
    }

    public function addDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if (!$this->demandeAdoption->contains($demandeAdoption)) {
            $this->demandeAdoption[] = $demandeAdoption;
            $demandeAdoption->setAnnonce($this);
        }

        return $this;
    }

    public function removeDemandeAdoption(DemandeAdoption $demandeAdoption): self
    {
        if ($this->demandeAdoption->removeElement($demandeAdoption)) {
            // set the owning side to null (unless already changed)
            if ($demandeAdoption->getAnnonce() === $this) {
                $demandeAdoption->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFirstImage(): ?Photo
    {
        foreach ($this->getListeChien() as $chien) {
            foreach ($chien->getPhoto() as $photo) {
                if (!empty($photo->getImgUrl())) {
                    return $photo;
                }
            }
        }

        return null;
    }
}

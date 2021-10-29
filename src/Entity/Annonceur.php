<?php

namespace App\Entity;

use App\Repository\AnnonceurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=AnnonceurRepository::class)
 */
class Annonceur extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="annonceur")
     */
    private $listeAnnonce;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSpa;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEleveur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomAsso;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addresse;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    public function __construct()
    {
        $this->listeAnnonce = new ArrayCollection();
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getListeAnnonce(): Collection
    {
        return $this->listeAnnonce;
    }

    public function addListeAnnonce(Annonce $listeAnnonce): self
    {
        if (!$this->listeAnnonce->contains($listeAnnonce)) {
            $this->listeAnnonce[] = $listeAnnonce;
            $listeAnnonce->setAnnonceur($this);
        }

        return $this;
    }

    public function removeListeAnnonce(Annonce $listeAnnonce): self
    {
        if ($this->listeAnnonce->removeElement($listeAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($listeAnnonce->getAnnonceur() === $this) {
                $listeAnnonce->setAnnonceur(null);
            }
        }

        return $this;
    }

    public function getIsSpa(): ?bool
    {
        return $this->isSpa;
    }

    public function setIsSpa(?bool $isSpa): self
    {
        $this->isSpa = $isSpa;

        return $this;
    }

    public function getIsEleveur(): ?bool
    {
        return $this->isEleveur;
    }

    public function setIsEleveur(bool $isEleveur): self
    {
        $this->isEleveur = $isEleveur;

        return $this;
    }

    public function getNomAsso(): ?string
    {
        return $this->nomAsso;
    }

    public function setNomAsso(string $nomAsso): self
    {
        $this->nomAsso = $nomAsso;

        return $this;
    }
    public function countAnnonce():int{
        $cpt = 0;
        foreach($this->listeAnnonce as $annonce){
            if($annonce->getPourvu()){
                $cpt++;
            }
        }
        return $cpt;
    }
    public function countAnnonceNonPourvu():int{
        $cpt = 0;
        foreach($this->listeAnnonce as $annonce){
            if(!$annonce->getPourvu()){
                $cpt++;
            }
        }
        return $cpt;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }



    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

}

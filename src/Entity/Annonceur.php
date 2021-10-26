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

}

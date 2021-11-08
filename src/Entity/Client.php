<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client extends User
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="client")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="client", orphanRemoval=true, cascade={"persist"})
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity=DemandeAdoption::class, mappedBy="client")
     */
    private $listAdoption;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    public function __construct()
    {
        $this->message = new ArrayCollection();
        $this->listAdoption = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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
            $message->setClient($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getClient() === $this) {
                $message->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DemandeAdoption[]
     */
    public function getListAdoption(): Collection
    {
        return $this->listAdoption;
    }

    public function addListAdoption(DemandeAdoption $listAdoption): self
    {
        if (!$this->listAdoption->contains($listAdoption)) {
            $this->listAdoption[] = $listAdoption;
            $listAdoption->setClient($this);
        }

        return $this;
    }

    public function removeListAdoption(DemandeAdoption $listAdoption): self
    {
        if ($this->listAdoption->removeElement($listAdoption)) {
            // set the owning side to null (unless already changed)
            if ($listAdoption->getClient() === $this) {
                $listAdoption->setClient(null);
            }
        }

        return $this;
    }

     public function getRoles(): array
    {
        $roles = parent::getRoles();
        
        return array_merge($roles, [
            'ROLE_CLIENT',
        ]);
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

     public function getDateInscription(): ?\DateTimeInterface
     {
         return $this->dateInscription;
     }

     public function setDateInscription(\DateTimeInterface $dateInscription): self
     {
         $this->dateInscription = $dateInscription;

         return $this;
     }

     public function getNotificationsMessageClient(){
         $cpt = 0;
         foreach($this->getListAdoption() as $demande ){
             foreach($demande->getMessage() as $message){
                //  dd($message);
                 if($message->getLue() == false && !$message->getClient()){
                    $cpt++;
                 }
             }
         }
         return $cpt;
     }
}

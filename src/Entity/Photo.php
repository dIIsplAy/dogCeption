<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
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
    private $imgUrl;

    /**
     * @ORM\ManyToOne(targetEntity=Chien::class, inversedBy="photo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    public function getChien(): ?Chien
    {
        return $this->chien;
    }

    public function setChien(?Chien $chien): self
    {
        $this->chien = $chien;

        return $this;
    }
}

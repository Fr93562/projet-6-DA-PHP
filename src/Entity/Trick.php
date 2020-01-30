<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Service\Tools\Slugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    private $slug;

    /**
     * @ORM\Column(type="json")
     */
    private $lienVideo= [];

    private $lienVideos;

    /**
     * @ORM\Column(type="json")
     */
    private $lienImage= [];

    private $lienImages = null;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateMiseAJour;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $titre): self
    {
        $this->slug = Slugger::slugify($titre);

        return $this;
    }

    public function getLienVideo(): ?array
    {
        return $this->lienVideo;
    }

    public function setLienVideo(?array $lienVideo): self
    {
        $this->lienVideo = $lienVideo;

        return $this;
    }

    public function getLienVideos(): ?string
    {
        return $this->lienVideos;
    }

    public function setLienVideos(?string $lienVideos): self
    {
        $this->lienVideos = $lienVideos;

        return $this;
    }

    public function getLienImage(): ?array
    {
        return $this->lienImage;
    }

    public function setLienImage(?array $lienImage): self
    {
        $this->lienImage = $lienImage;

        return $this;
    }

    public function getLienImages(): ?string
    {
        return $this->lienImages;
    }

    public function setLienImages(?string $lienImages): self
    {
        $this->lienImages = $lienImages;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateMiseAJour;
    }

    public function setDateMiseAJour(?\DateTimeInterface $dateMiseAJour): self
    {
        $this->dateMiseAJour = $dateMiseAJour;

        return $this;
    }
}

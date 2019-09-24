<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?User
    {
        return $this->Pseudo;
    }

    public function setPseudo(?User $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

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
}

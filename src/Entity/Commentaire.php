<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Livres::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Livres $livre = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Assert\NotBlank(message: 'Veuillez donner une note.')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'La note doit être comprise entre {{ min }} et {{ max }}.',
    )]
    private int $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLivre(): ?Livres
    {
        return $this->livre;
    }

    public function setLivre(?Livres $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }
}

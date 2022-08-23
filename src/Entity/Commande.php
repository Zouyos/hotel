<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\ManyToOne(inversedBy: 'commandes')]
  private ?Chambre $chambre = null;

  #[ORM\ManyToOne(inversedBy: 'commandes')]
  private ?User $user = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTime $startAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTime $endAt = null;

  #[ORM\Column(nullable: true)]
  private ?float $prix = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getChambre(): ?Chambre
  {
    return $this->chambre;
  }

  public function setChambre(?Chambre $chambre): self
  {
    $this->chambre = $chambre;

    return $this;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(?User $user): self
  {
    $this->user = $user;

    return $this;
  }

  public function getStartAt(): ?\DateTime
  {
    return $this->startAt;
  }

  public function setStartAt(?\DateTime $startAt): self
  {
    $this->startAt = $startAt;

    return $this;
  }

  public function getEndAt(): ?\DateTime
  {
    return $this->endAt;
  }

  public function setEndAt(?\DateTime $endAt): self
  {
    $this->endAt = $endAt;

    return $this;
  }

  public function getPrix(): ?float
  {
    return $this->prix;
  }

  public function setPrix(?float $prix): self
  {
    $this->prix = $prix;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(?\DateTimeImmutable $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }
}

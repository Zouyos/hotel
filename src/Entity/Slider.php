<?php

namespace App\Entity;

use App\Repository\SliderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SliderRepository::class)]
class Slider
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $photo = null;

  #[ORM\Column(nullable: true)]
  private ?int $ordre = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $title = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $alt = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $caption = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $description = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $status = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getPhoto(): ?string
  {
    return $this->photo;
  }

  public function setPhoto(?string $photo): self
  {
    $this->photo = $photo;

    return $this;
  }

  public function getOrdre(): ?int
  {
    return $this->ordre;
  }

  public function setOrdre(?int $ordre): self
  {
    $this->ordre = $ordre;

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

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getAlt(): ?string
  {
    return $this->alt;
  }

  public function setAlt(?string $alt): self
  {
    $this->alt = $alt;

    return $this;
  }

  public function getCaption(): ?string
  {
    return $this->caption;
  }

  public function setCaption(?string $caption): self
  {
    $this->caption = $caption;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  public function getStatus(): ?string
  {
    return $this->status;
  }

  public function setStatus(?string $status): self
  {
    $this->status = $status;

    return $this;
  }
}

<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $Titre = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $descriptionCourte = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $descriptionLongue = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $photo = null;

  #[ORM\Column(nullable: true)]
  private ?float $prix = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Commande::class)]
  private Collection $commandes;

  public function __construct()
  {
    $this->commandes = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitre(): ?string
  {
    return $this->Titre;
  }

  public function setTitre(?string $Titre): self
  {
    $this->Titre = $Titre;

    return $this;
  }

  public function getDescriptionCourte(): ?string
  {
    return $this->descriptionCourte;
  }

  public function setDescriptionCourte(?string $descriptionCourte): self
  {
    $this->descriptionCourte = $descriptionCourte;

    return $this;
  }

  public function getDescriptionLongue(): ?string
  {
    return $this->descriptionLongue;
  }

  public function setDescriptionLongue(?string $descriptionLongue): self
  {
    $this->descriptionLongue = $descriptionLongue;

    return $this;
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

  /**
   * @return Collection<int, Commande>
   */
  public function getCommandes(): Collection
  {
      return $this->commandes;
  }

  public function addCommande(Commande $commande): self
  {
      if (!$this->commandes->contains($commande)) {
          $this->commandes->add($commande);
          $commande->setChambre($this);
      }

      return $this;
  }

  public function removeCommande(Commande $commande): self
  {
      if ($this->commandes->removeElement($commande)) {
          // set the owning side to null (unless already changed)
          if ($commande->getChambre() === $this) {
              $commande->setChambre(null);
          }
      }

      return $this;
  }
}

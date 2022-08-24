<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $nom = null;

  #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Chambre::class)]
  private Collection $chambres;

  public function __construct()
  {
    $this->chambres = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNom(): ?string
  {
    return $this->nom;
  }

  public function setNom(string $nom): self
  {
    $this->nom = $nom;

    return $this;
  }

  /**
   * @return Collection<int, Chambre>
   */
  public function getChambres(): Collection
  {
    return $this->chambres;
  }

  public function addChambre(Chambre $chambre): self
  {
    if (!$this->chambres->contains($chambre)) {
      $this->chambres->add($chambre);
      $chambre->setCategorie($this);
    }

    return $this;
  }

  public function removeChambre(Chambre $chambre): self
  {
    if ($this->chambres->removeElement($chambre)) {
      // set the owning side to null (unless already changed)
      if ($chambre->getCategorie() === $this) {
        $chambre->setCategorie(null);
      }
    }

    return $this;
  }
}

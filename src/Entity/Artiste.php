<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\ManyToMany(targetEntity: Metier::class, inversedBy: 'artistes')]
    private $metier;

    #[ORM\OneToMany(mappedBy: 'Auteur', targetEntity: Documents::class)]
    private $documents;

    public function __construct()
    {
        $this->metier = new ArrayCollection();
        $this->documents = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Metier>
     */
    public function getMetier(): Collection
    {
        return $this->metier;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->metier->contains($metier)) {
            $this->metier[] = $metier;
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        $this->metier->removeElement($metier);

        return $this;
    }

    /**
     * @return Collection<int, Documents>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Documents $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setAuteur($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getAuteur() === $this) {
                $document->setAuteur(null);
            }
        }

        return $this;
    }
}

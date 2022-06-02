<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["documents" => Documents::class, "cd" => CD::class, "livres" => Livres::class, "revues" => Revues::class])]
class Documents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'integer')]
    private $etat;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Emprunts::class)]
    private $emprunts;

    #[ORM\ManyToOne(targetEntity: Artiste::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private $Auteur;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
    }

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

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Emprunts>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunts $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts[] = $emprunt;
            $emprunt->setDocument($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunts $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getDocument() === $this) {
                $emprunt->setDocument(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?Artiste
    {
        return $this->Auteur;
    }

    public function setAuteur(?Artiste $Auteur): self
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    public function getMyDiscriminator()
    {
        $myDiscriminator = null;
        switch (get_class($this)) {
            case CD::class:
                $myDiscriminator = "CD";
                break;
            case Livres::class:
                $myDiscriminator = "Livres";
                break;
            case Revues::class:
                $myDiscriminator = "Revues";
                break;
        }
        return $myDiscriminator;
    }

}

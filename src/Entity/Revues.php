<?php

namespace App\Entity;

use App\Repository\RevuesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RevuesRepository::class)]
class Revues extends Documents
{

    #[ORM\Column(type: 'integer')]
    private $periodicite;

    public function getPeriodicite(): ?int
    {
        return $this->periodicite;
    }

    public function setPeriodicite(int $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RevuesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RevuesRepository::class)]
class Revues extends Documents
{
    #[ORM\Column(type: 'string', length: 255)]
    private $periodicite;

    public function getPeriodicite(): ?string
    {
        return $this->periodicite;
    }

    public function setPeriodicite(string $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }
}

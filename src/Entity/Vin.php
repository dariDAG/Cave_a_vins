<?php

namespace App\Entity;

use App\Repository\VinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VinRepository::class)]
class Vin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'integer')]
    private $millesime;

    #[ORM\Column(type: 'string', length: 255)]
    private $robe;

    #[ORM\Column(type: 'integer')]
    private $qtt_stock;

    #[ORM\Column(type: 'string', length: 255)]
    private $contenance;

    #[ORM\Column(type: 'text')]
    private $remarques;

    #[ORM\ManyToOne(targetEntity: Region::class)]
    private $region;

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

    public function getMillesime(): ?int
    {
        return $this->millesime;
    }

    public function setMillesime(int $millesime): self
    {
        $this->millesime = $millesime;

        return $this;
    }

    public function getRobe(): ?string
    {
        return $this->robe;
    }

    public function setRobe(string $robe): self
    {
        $this->robe = $robe;

        return $this;
    }

    public function getQttStock(): ?int
    {
        return $this->qtt_stock;
    }

    public function setQttStock(int $qtt_stock): self
    {
        $this->qtt_stock = $qtt_stock;

        return $this;
    }

    public function getContenance(): ?string
    {
        return $this->contenance;
    }

    public function setContenance(string $contenance): self
    {
        $this->contenance = $contenance;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }
}

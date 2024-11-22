<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RecetaRepuesto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Receta::class, inversedBy: 'recetaRepuestos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Receta $receta = null;

    #[ORM\ManyToOne(targetEntity: Repuestos::class, inversedBy: 'recetaRepuestos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Repuestos $repuesto = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceta(): ?Receta
    {
        return $this->receta;
    }

    public function setReceta(?Receta $receta): self
    {
        $this->receta = $receta;
        return $this;
    }

    public function getRepuesto(): ?Repuestos
    {
        return $this->repuesto;
    }

    public function setRepuesto(?Repuestos $repuesto): self
    {
        $this->repuesto = $repuesto;
        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }
}
<?php
namespace App\Entity;

use App\Repository\RepuestosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepuestosRepository::class)]
class Repuestos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column(type: 'integer')]
    private int $stockMinimo = 0;

    #[ORM\OneToMany(targetEntity: RecetaRepuesto::class, mappedBy: 'repuesto', cascade: ['remove'])]
    private Collection $recetaRepuestos;

    public function __construct()
    {
        $this->recetas = new ArrayCollection();
        $this->recetaRepuestos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre !== null ? $nombre : '';

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion !== null ? $descripcion : '';

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(?int $cantidad): static
    {
        $this->cantidad = $cantidad !== null ? $cantidad : 0;

        return $this;
    }

    public function getStockMinimo(): ?int
    {
        return $this->stockMinimo;
    }

    public function setStockMinimo(int $stockMinimo): static
    {
        $this->stockMinimo = max(0, $stockMinimo);
        return $this;
    }

    public function esStockSuficiente(): bool
    {
        return $this->cantidad > 0;
    }

    public function necesitaReabastecimiento(): bool
    {
        return $this->cantidad <= $this->stockMinimo;
    }

    /**
     * @return Collection<int, Receta>
     */
    public function getRecetas(): Collection
    {
        return $this->recetas;
    }

    public function addReceta(Receta $receta): static
    {
        if (!$this->recetas->contains($receta)) {
            $this->recetas->add($receta);
            $receta->addRepuesto($this);
        }

        return $this;
    }

    public function removeReceta(Receta $receta): static
    {
        if ($this->recetas->removeElement($receta)) {
            $receta->removeRepuesto($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, RecetaRepuesto>
     */
    public function getRecetaRepuestos(): Collection
    {
        return $this->recetaRepuestos;
    }

    public function addRecetaRepuesto(RecetaRepuesto $recetaRepuesto): static
    {
        if (!$this->recetaRepuestos->contains($recetaRepuesto)) {
            $this->recetaRepuestos->add($recetaRepuesto);
            $recetaRepuesto->setRepuesto($this);
        }

        return $this;
    }

    public function removeRecetaRepuesto(RecetaRepuesto $recetaRepuesto): static
    {
        if ($this->recetaRepuestos->removeElement($recetaRepuesto)) {
            if ($recetaRepuesto->getRepuesto() === $this) {
                $recetaRepuesto->setRepuesto(null);
            }
        }

        return $this;
    }
}
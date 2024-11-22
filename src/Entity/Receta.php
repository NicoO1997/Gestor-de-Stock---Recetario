<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetaRepository::class)]
class Receta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'recetas')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Maquinaria::class, mappedBy: 'recetas')]
    private Collection $maquinarias;

    #[ORM\OneToMany(targetEntity: RecetaRepuesto::class, mappedBy: 'receta', cascade: ['persist', 'remove'])]
    private Collection $recetaRepuestos;

    public function __construct()
    {
        $this->maquinarias = new ArrayCollection();
        $this->repuestos = new ArrayCollection();
        $this->recetaRepuestos = new ArrayCollection();
    }

    public function getRecetaRepuestos(): Collection
    {
        return $this->recetaRepuestos;
    }

    public function addRepuestoConCantidad(Repuestos $repuesto, int $cantidad): self
    {
        $recetaRepuesto = new RecetaRepuesto();
        $recetaRepuesto->setRepuesto($repuesto);
        $recetaRepuesto->setReceta($this);
        $recetaRepuesto->setCantidad($cantidad);
        
        $this->recetaRepuestos->add($recetaRepuesto);
        
        return $this;
    }

    public function removeRecetaRepuesto(RecetaRepuesto $recetaRepuesto): self
    {
        if ($this->recetaRepuestos->removeElement($recetaRepuesto)) {
            if ($recetaRepuesto->getReceta() === $this) {
                $recetaRepuesto->setReceta(null);
            }
        }

        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->user;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Maquinaria>
     */
    public function getMaquinarias(): Collection
    {
        return $this->maquinarias;
    }

    public function addMaquinaria(Maquinaria $maquinaria): static
    {
        if (!$this->maquinarias->contains($maquinaria)) {
            $this->maquinarias->add($maquinaria);
        }

        return $this;
    }

    public function removeMaquinaria(Maquinaria $maquinaria): static
    {
        $this->maquinarias->removeElement($maquinaria);

        return $this;
    }

    /**
     * @return Collection<int, Repuestos>
     */
    public function getRepuestos(): Collection
    {
        return $this->repuestos;
    }

    public function addRepuesto(Repuestos $repuesto): static
    {
        if (!$this->repuestos->contains($repuesto)) {
            $this->repuestos->add($repuesto);
        }

        return $this;
    }

    public function removeRepuesto(Repuestos $repuesto): static
    {
        $this->repuestos->removeElement($repuesto);

        return $this;
    }
}
<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    const TIPOS=['opinion'=>'Opinion','Humor'=>'Humor','politico'=>'Politico'];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Tematica = null;

    #[ORM\Column(nullable: true)]
    private ?int $Cant_part = null;

    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'evento')]
    private Collection $usuarios;

    #[ORM\OneToOne(inversedBy: 'evento', cascade: ['persist', 'remove'])]
    private ?Cronograma $cronograma = null;

    #[ORM\ManyToMany(targetEntity: Investigacion::class, inversedBy: 'eventos')]
    private Collection $investigacion;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->investigacion = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getTematica(): ?string
    {
        return $this->Tematica;
    }

    public function setTematica(string $Tematica): self
    {
        $this->Tematica = $Tematica;

        return $this;
    }

    public function getCantPart(): ?int
    {
        return $this->Cant_part;
    }

    public function setCantPart(?int $Cant_part): self
    {
        $this->Cant_part = $Cant_part;

        return $this;
    }


    public function getCronograma(): ?Cronograma
    {
        return $this->cronograma;
    }

    public function setCronograma(?Cronograma $cronograma): self
    {
        // unset the owning side of the relation if necessary
        if ($cronograma === null && $this->cronograma !== null) {
            $this->cronograma->setEvento(null);
        }

        // set the owning side of the relation if necessary
        if ($cronograma !== null && $cronograma->getEvento() !== $this) {
            $cronograma->setEvento($this);
        }

        $this->cronograma = $cronograma;

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->addEvento($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeEvento($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Investigacion>
     */
    public function getInvestigacion(): Collection
    {
        return $this->investigacion;
    }

    public function addInvestigacion(Investigacion $investigacion): self
    {
        if (!$this->investigacion->contains($investigacion)) {
            $this->investigacion->add($investigacion);
        }

        return $this;
    }

    public function removeInvestigacion(Investigacion $investigacion): self
    {
        $this->investigacion->removeElement($investigacion);

        return $this;
    }

}

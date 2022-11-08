<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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


    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'evento')]
    private Collection $usuarios;


    #[ORM\ManyToMany(targetEntity: Investigacion::class, inversedBy: 'eventos')]
    private Collection $investigacion;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_ini = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hora_inic = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hora_fin = null;

    #[ORM\ManyToMany(targetEntity: Cronograma::class, inversedBy: 'eventos')]
    private Collection $cronogramas;


    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->investigacion = new ArrayCollection();
        $this->cronogramas = new ArrayCollection();
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

    public function getFechaIni(): ?\DateTimeInterface
    {
        return $this->fecha_ini;
    }

    public function setFechaIni(\DateTimeInterface $fecha_ini): self
    {
        $this->fecha_ini = $fecha_ini;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    public function getHoraInic(): ?\DateTimeInterface
    {
        return $this->hora_inic;
    }

    public function setHoraInic(\DateTimeInterface $hora_inic): self
    {
        $this->hora_inic = $hora_inic;

        return $this;
    }

    public function getHoraFin(): ?\DateTimeInterface
    {
        return $this->hora_fin;
    }

    public function setHoraFin(\DateTimeInterface $hora_fin): self
    {
        $this->hora_fin = $hora_fin;

        return $this;
    }

    /**
     * @return Collection<int, Cronograma>
     */
    public function getCronogramas(): Collection
    {
        return $this->cronogramas;
    }

    public function addCronograma(Cronograma $cronograma): self
    {
        if (!$this->cronogramas->contains($cronograma)) {
            $this->cronogramas->add($cronograma);
        }

        return $this;
    }

    public function removeCronograma(Cronograma $cronograma): self
    {
        $this->cronogramas->removeElement($cronograma);

        return $this;
    }

}

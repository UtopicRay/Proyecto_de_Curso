<?php

namespace App\Entity;

use App\Repository\CronogramaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CronogramaRepository::class)]
class Cronograma
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tema = null;

    #[ORM\Column(length: 255)]
    private ?string $catedra = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_ini = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;


    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hora_inic = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hora_final = null;

    #[ORM\OneToOne(mappedBy: 'cronograma', cascade: ['persist', 'remove'])]
    private ?Evento $evento = null;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTema(): ?string
    {
        return $this->tema;
    }

    public function setTema(?string $tema): self
    {
        $this->tema = $tema;

        return $this;
    }

    public function getCatedra(): ?string
    {
        return $this->catedra;
    }

    public function setCatedra(string $catedra): self
    {
        $this->catedra = $catedra;

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

    public function getHoraFinal(): ?\DateTimeInterface
    {
        return $this->hora_final;
    }

    public function setHoraFinal(\DateTimeInterface $hora_final): self
    {
        $this->hora_final = $hora_final;

        return $this;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        // unset the owning side of the relation if necessary
        if ($evento === null && $this->evento !== null) {
            $this->evento->setCronograma(null);
        }

        // set the owning side of the relation if necessary
        if ($evento !== null && $evento->getCronograma() !== $this) {
            $evento->setCronograma($this);
        }

        $this->evento = $evento;

        return $this;
    }

}

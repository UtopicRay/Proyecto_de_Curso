<?php

namespace App\Entity;

use App\Repository\InvestigacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestigacionRepository::class)]
class Investigacion
{

    const option=['Facultad 1'=>'1','Facultad 2'=>'2','Facultad 3'=>'3','Facultad 4'=>'4','Facultad 5'=>'5','FTE'=>'6','No pertenece a una facultad'=>'7'];
    const catedras=['Estudios del pensamiento y la obra de “Fidel Castro Ruz'=>'Estudios del pensamiento y la obra de “Fidel Castro Ruz','Julio Antonio Mella'=>'Julio Antonio Mella','Antonio Maceo y Grajales'=>'Antonio Maceo y Grajales'
    ,'Ernesto “Che” Guevara'=>'Ernesto “Che” Guevara','Remberto Fernández González'=>'Remberto Fernández González','Pensamiento Bolivariano'=>'Pensamiento Bolivariano',
     'Vilma Espín Guillois'=>'Vilma Espín Guillois','Rosa Elene Simeón Negrín'=>'Rosa Elene Simeón Negrín','José Martí Pérez'=>'José Martí Pérez'];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titulo = null;

    #[ORM\Column]
    private ?int $Facultad = null;

    #[ORM\Column(length: 255)]
    private ?string $Catedra = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $puntuacion = null;

    #[ORM\Column(length: 255)]
    private ?string $archivo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'investigacion')]
    private Collection $usuarios;

    #[ORM\ManyToMany(targetEntity: Evento::class, mappedBy: 'investigacion')]
    private Collection $eventos;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->eventos = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->Titulo;
    }

    public function setTitulo(string $Titulo): self
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    public function getFacultad(): ?int
    {
        return $this->Facultad;
    }

    public function setFacultad(int $Facultad): self
    {
        $this->Facultad = $Facultad;

        return $this;
    }

    public function getCatedra(): ?string
    {
        return $this->Catedra;
    }

    public function setCatedra(string $Catedra): self
    {
        $this->Catedra = $Catedra;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getInvestigacion(): Collection
    {
        return $this->investigacion;
    }

    public function addInvestigacion(self $investigacion): self
    {
        if (!$this->investigacion->contains($investigacion)) {
            $this->investigacion->add($investigacion);
        }

        return $this;
    }

    public function removeInvestigacion(self $investigacion): self
    {
        $this->investigacion->removeElement($investigacion);

        return $this;
    }










    public function getPuntuacion(): ?string
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(?string $puntuacion): self
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    public function getArchivo(): ?string
    {
        return $this->archivo;
    }

    public function setArchivo(string $archivo): self
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

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
            $usuario->addInvestigacion($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeInvestigacion($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Evento>
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos->add($evento);
            $evento->addInvestigacion($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->removeElement($evento)) {
            $evento->removeInvestigacion($this);
        }

        return $this;
    }
}


<?php

namespace App\Service;
use App\Entity\Investigacion;
use App\Service\UsuarioInterface;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class UsuarioService implements GeneralInterface {



    public function MostrarDatos(EntityManagerInterface $em)
    {
        // TODO: Implement MostrarDatos() method.
    }

    public function MostrarDatostId(EntityManagerInterface $em, $id)
    {
        // TODO: Implement MostrarDatostId() method.
    }

    public function BorrarId(EntityManagerInterface $em, $id)
    {
        $app = $em->getRepository(Usuario::class)->find($id);
        $em->remove($app);
        $em->flush();
    }
}
<?php

namespace App\Service;
use App\Service\UsuarioInterface;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class UsuarioService implements UsuarioInterface {

    public function MostrarUsuario(EntityManagerInterface $em)
    {
        $app=$em->createQuery('select usuario from App:Usuario usuario')->getArrayResult();
        return $app;
    }


}
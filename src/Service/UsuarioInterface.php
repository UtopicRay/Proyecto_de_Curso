<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

interface UsuarioInterface
{
    public function MostrarUsuario(EntityManagerInterface $em);

}
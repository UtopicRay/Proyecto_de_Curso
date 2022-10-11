<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

interface GeneralInterface
{
    public function MostrarDatos(EntityManagerInterface $em);

    public function MostrarDatostId(EntityManagerInterface $em, $id);
    public function BorrarId(EntityManagerInterface $em,$id);
}
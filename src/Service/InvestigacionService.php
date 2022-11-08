<?php

namespace App\Service;

use App\Entity\Investigacion;
use Doctrine\ORM\EntityManagerInterface;



class InvestigacionService implements GeneralInterface
{
public function MostrarDatos(EntityManagerInterface $em):array
{
    $app=$em->createQuery('select investigacion from App:Investigacion investigacion')->getArrayResult();
    return $app;

}

    public function MostrarDatostId(EntityManagerInterface $em, $id)
    {

        $app=$em->getRepository(Investigacion::class)->mostrarInvest($id);
        return $app;
    }

    public function BorrarId(EntityManagerInterface $em, $id)
    {
        $app = $em->getRepository(Investigacion::class)->find($id);
        $em->remove($app);
        $em->flush();
    }

}
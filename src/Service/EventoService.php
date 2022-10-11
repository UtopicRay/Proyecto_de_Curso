<?php

namespace App\Service;

use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;


class EventoService implements GeneralInterface
{

    public function MostrarDatos(EntityManagerInterface $em): array
    {

        return $em->createQuery('select evento from App:Evento evento')->getArrayResult();
    }

    public function MostrarDatostId(EntityManagerInterface $em, $id): array
    {
        $app = $em->createQuery('select evento
         from App:Evento evento 
         where evento.id=:id')
            ->setParameter('id', $id)
            ->getArrayResult();
        return $app;
    }


    public function BorrarId(EntityManagerInterface $em, $id)
    {
        $app = $em->getRepository(Evento::class)->find($id);
        $em->remove($app);
        $em->flush();

    }
}
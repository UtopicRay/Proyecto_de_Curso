<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;

/**
 * @extends ServiceEntityRepository<Evento>
 *
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    public function save(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function hola($date){
        return $this->getEntityManager()->createQuery('Select e 
        From App:Evento e
        where e.fecha_ini<= :date and e.fecha_fin>=:date')->setParameter('date',$date);
    }

    public function ContarUsuario($id)
    {
       return $this->getEntityManager()->createQuery('Select COUNT(f.id) 
        From App:Evento e Join e.usuarios f 
        where e.id=:id')
            ->setParameter('id',$id)
            ->getSingleResult();
    }
    public function ContarInvestigacion($id)
    {
       return $this->getEntityManager()->createQuery('Select COUNT(f.id) 
        From App:Evento e Join e.investigacion f 
        where e.id=:id')
            ->setParameter('id',$id)
            ->getSingleResult();
    }
    public function ContarCronograma($id)
    {
       return $this->getEntityManager()->createQuery('Select COUNT(f.id) 
        From App:Evento e Join e.cronogramas f 
        where e.id=:id')
            ->setParameter('id',$id)
            ->getSingleResult();
    }
    public function mostrarEventVarias($ids)
    {
        return $this->getEntityManager()->createQuery('select evento
       from App:Evento evento 
       Join evento.usuarios usuario
       where evento.id IN (:id)')
            ->setParameter('id', $ids)
            ->getResult();
    }
public function MisEventos($ids){
    return $this->getEntityManager()->createQuery('select evento
       from App:Evento evento 
       Join evento.usuarios usuario
       where evento.id IN (:id)')
        ->setParameter('id', $ids);
}


//    /**
//     * @return Evento[] Returns an array of Evento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evento
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

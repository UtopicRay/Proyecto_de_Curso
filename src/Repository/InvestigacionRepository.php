<?php

namespace App\Repository;

use App\Entity\Investigacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Investigacion>
 *
 * @method Investigacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Investigacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Investigacion[]    findAll()
 * @method Investigacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestigacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Investigacion::class);
    }

    public function save(Investigacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Investigacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function mostrarInvest($id)
    {
        return $this->getEntityManager()->createQuery('select investigacion.Titulo,investigacion.descripcion,investigacion.Catedra,investigacion.puntuacion,investigacion.archivo,usuario.id 
       from App:Investigacion investigacion 
       Join investigacion.usuarios usuario
       where investigacion.id=:id')
            ->setParameter('id', $id)
            ->getResult();
    }
    public function mostrarInvestVarias($ids)
    {
        return $this->getEntityManager()->createQuery('select investigacion.Titulo,investigacion.descripcion,investigacion.Catedra,investigacion.puntuacion,investigacion.archivo,usuario.id 
       from App:Investigacion investigacion 
       Join investigacion.usuarios usuario
       where investigacion.id IN (:id)')
            ->setParameter('id', $ids)
            ->getResult();
    }


    public function BuscarUsuario($id)
    {
        return $this->getEntityManager()->createQuery('Select usuario.id 
       from App:Investigacion investigacion 
       Join investigacion.usuarios usuario
       where investigacion.id=:id')
            ->setParameter('id', $id)
            ->getResult();
    }

//    /**
//     * @return Investigacion[] Returns an array of Investigacion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Investigacion
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

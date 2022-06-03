<?php

namespace App\Repository;

use App\Entity\CodeAuth;
use App\Helper\Status\AbstractStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @extends ServiceEntityRepository<CodeAuth>
 *
 * @method CodeAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodeAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodeAuth[]    findAll()
 * @method CodeAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeAuthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodeAuth::class);
    }

    public function add(CodeAuth $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(CodeAuth $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function check($code, $email)
    {
        $qb = $this->createQueryBuilder('cc');
        $qb->andWhere('cc.code = :code')
            ->andWhere("cc.liveTime >= :now")
            ->innerJoin('cc.patient', 'p')
            ->andWhere('p.email = :email')
            ->setParameter('email', $email)
            ->setParameter('code', $code)
            ->setParameter('now', new \DateTime());

        return $qb->getQuery()->getOneOrNullResult();
    }
}

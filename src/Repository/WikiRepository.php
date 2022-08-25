<?php

namespace App\Repository;

use App\Entity\Wiki;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wiki>
 *
 * @method Wiki|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wiki|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wiki[]    findAll()
 * @method Wiki[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WikiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wiki::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Wiki $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Wiki $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findWikisWithCategories($searchFormValues)
    {
        $qb = $this->createQueryBuilder('wiki')
            ->select('wiki')
            ->leftJoin('wiki.categories', 'categories')
            ->orderBy('wiki.date', 'DESC')
            ->addSelect('categories')
        ;

        if (!empty($searchFormValues['titre'])) {
            $qb->andWhere('wiki.titre LIKE :titre')
                ->setParameter('titre', '%' . $searchFormValues['titre'] . '%');
        }
        if (!empty($searchFormValues['categories'])) {
            $qb->andWhere(':categories MEMBER OF wiki.categories')
                ->setParameter('categories', $searchFormValues['categories']);
        }

        $query = $qb->getQuery();
        return $query->execute();

    }

    public function findOneWikiByIdAndCategories($id)
    {
        $qb = $this->createQueryBuilder('wiki')
            ->select('wiki')
            ->leftJoin('wiki.categories', 'categories')
            ->addSelect('categories')
            ->where('wiki.id = :id')
            ->setParameter('id', $id)
        ;

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    public function getLastWiki()
    {
        $qb = $this->createQueryBuilder('wiki')
            ->select('wiki')
            ->orderBy('wiki.date','DESC')
            ->setMaxResults(4)
            ->getQuery();
            $lastwikis = $qb->getResult();
        return $lastwikis;
        }
}

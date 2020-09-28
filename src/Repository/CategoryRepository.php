<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllCategoryQuestions($categoryId): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        // $qb = $this->createQueryBuilder('c')
        //     ->select("q.category_id", 'q.id as question_id', 'q.question', 'a.id as answer_id', 'a.answer')
        //     ->innerJoin(Question::class, "q", Join::ON, "c.id = q.category_id")
        //     ->innerJoin(Answer::class, "a", Join::ON, "q.id = a.question_id")
        //     ->where('c.id = :id')
        //     ->setParameter('id', $categoryId);
        // // ->orderBy('p.price', 'ASC');

        // $query = $qb->getQuery();

        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT  q.id as question_id, q.question, a.id as answer_id, a.answer 
            FROM App\Entity\Question q
            INNER JOIN q.answers a 
            INNER JOIN q.Category c  
            WHERE c.id = :id'
        )->setParameter('id', $categoryId);

        // dump(($query));
        // return $query->execute(null,\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        return $query->execute();

        // dump($query->execute());
        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
}

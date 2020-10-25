<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

//     public function findAllQuizQuestions($quizId)
//     {
//         $entityManager = $this->getEntityManager();

//         // $query = $entityManager->createQuery(
//         //     'SELECT c.id, c.name, q.id as question_id, q.question, a.id as answer_id, a.answer 
//         //     FROM App\Entity\Question q
//         //     INNER JOIN q.answers a 
//         //     INNER JOIN q.Quiz c  
//         //     WHERE c.id = :id'
//         // )->setParameter('id', $quizId)
//         //                ->setFirstResult(0)
//         //                ->setMaxResults(5)
//         //                ;


//         $qb = $this->createQueryBuilder('q')
//             ->addSelect('q.id as question_id', 
//             'q.question', 'a.id as answer_id', 'a.answer')
//             ->innerJoin('q.answers', 'a')
//             ->innerJoin('q.Quiz', 'qz')
//             ->where('q.Quiz = :id')
//             ->setParameter('id', $quizId)
//         ;


//                     //    $paginator = new Paginator();

// // $paginator = new Paginator($query, $fetchJoinCollection = true);

// // $pagination = $paginator->paginate(
// //     $query, 
// //     1, 
// //     10, 
// //     array(
// //         'distinct' => false,
// //     )
// // );

// // $pagination = (new Paginator($query))->paginate(1); 
// // return (new Paginator($query))->paginate($page);
//         $query = $qb->getQuery();

//         return $query->execute();

//         // $paginator = new DoctrinePaginator($query, true);

//         // $this->results = $paginator->getIterator();
//         // $this->numResults = $paginator->count();

//         // dump($pagination);
//         // dump(get_class_methods($pagination));
//         // // die();
//         // return $pagination;
//     }

public function findAllQuizQuestions($quizId)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT qz, q, a
            FROM App\Entity\Quiz qz
            INNER JOIN qz.questions q  
            INNER JOIN q.answers a 
            WHERE qz.id = :id'
        )
            ->setParameter('id', $quizId);

        return $query->execute();
    }



}

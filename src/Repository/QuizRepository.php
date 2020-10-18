<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\UserAnswer;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    // /**
    //  * @return Quiz[] Returns an array of Quiz objects
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
    public function findOneBySomeField($value): ?Quiz
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllQuizQuestions($quizId): array
    {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT c.id, c.name, q.id as question_id, q.question, a.id as answer_id, a.answer 
            FROM App\Entity\Question q
            INNER JOIN q.answers a 
            INNER JOIN q.Quiz c  
            WHERE c.id = :id'
        )->setParameter('id', $quizId);

        return $query->execute();
    }

    public function findUserSubmittedCategories($user_id): array
    {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT c.id, c.name, q.id as question_id, q.question, a.id as answer_id, a.answer 
            FROM App\Entity\Question q
            INNER JOIN q.answers a 
            INNER JOIN q.Quiz c  
            INNER JOIN a.userAnswers ua  
            WHERE ua.User != :User'
        )->setParameter('User', $user_id);

        return $query->execute();
    }

}

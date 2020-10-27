<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\User;
use App\Entity\UserAnswer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserAnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            QuizFixtures::class,
        );
    }

    public function load(ObjectManager $manager)
    {
        $quiz = $manager->getRepository(Quiz::class)->findAll();

        $quizData = $manager->getRepository(Question::class)
            ->findAllQuizQuestions($quiz[0]->getId());

        $questions = $quizData[0]->getQuestions();

        $users = $manager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            // $random_question = rand(1, 10);

            foreach ($questions as $k => $question) {
                $random_answer = rand(0, 5);

                $answers = $question->getAnswers();

                $userAnswer = new UserAnswer();
                $userAnswer->setUser($user);
                $userAnswer->setAnswer($answers[$random_answer]);

                $manager->persist($userAnswer);
            }
        }

        $manager->flush();
    }
}

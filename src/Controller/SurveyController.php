<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    // /**
    //  * @Route("/survey", name="survey")
    //  */
    // public function index()
    // {
    //     return $this->render('survey/index.html.twig', [
    //         'controller_name' => 'SurveyController',
    //     ]);
    // }

    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function questions(CategoryRepository $categoryRepository)
    {
        $unordered_questions = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAllCategoryQuestions(1);

        var_dump($unordered_questions);

        $questions = array();
        foreach ($unordered_questions as $question) {

            $questions[$question["question_id"]]["question"] =  $question["question"];
            $questions[$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
        }



        var_dump($questions);
        // die();
        return $this->render('survey/questions.html.twig', [
            'questions' => $questions,
        ]);
    }
}

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
        // var_dump($question["question_id"]);
        $questions[$question["question_id"]]["question"] =  $question["question"];
        $questions[$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
        // if (array_key_exists($question["question_id"], $questions)) {
        //     $questions[$question["question_id"]]["answers"][$question["answer"]] = $question["answer"];
        // }
        // else{
        //     $questions[$question["question_id"]]["question"] =  $question["question"];
            
        // }

            // if (!array_key_exists($question["question_id"], $questions)) {
            //     $questions[$question["question_id"]] = array(
            //         "question" => array(
            //             "id" => $question["question_id"],
            //             "question" => $question["question"]
            //         ),
            //         "answer" => array(
            //             $question["answer_id"] => $question["answer"]
            //         )
            //     );
                
            // }
            // else{
            //     $question["question_id"]["answer"][$question["answer_id"]] = $question["answer"];
            // }


//  $questions["question_" . $question["question_id"]]["question"][$question["question_id"]] =  $question["question"];
//         $questions["question_" . $question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
       
    }



    dump($questions);
    // die();
        return $this->render('survey/questions.html.twig', [
            'questions' => $questions,
        ]);
    }

}

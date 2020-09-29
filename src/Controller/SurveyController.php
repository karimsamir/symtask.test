<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\SurveyType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('survey/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{id}", name="survey", methods={"GET"})
     */
    public function questions(Request $request, $id)
    {
        $unordered_questions = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAllCategoryQuestions($id);

        var_dump($unordered_questions);
        $questions = array();

        if (count($unordered_questions) > 0) {

            foreach ($unordered_questions as $question) {

                $questions[$question["question_id"]]["question"] =  $question["question"];
                $questions[$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
            }

            $questions["category_id"] = $unordered_questions[0]["id"];
            $questions["category_name"] = $unordered_questions[0]["name"];
        }
        var_dump($questions);


        $form = $this->createForm(SurveyType::class, $questions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        // return $this->render('category/edit.html.twig', [
        //     'category' => $category,
        //     'form' => $form->createView(),
        // ]);

        // die();
        return $this->render('survey/questions.html.twig', [
            'questions' => $questions,
        ]);
    }
}

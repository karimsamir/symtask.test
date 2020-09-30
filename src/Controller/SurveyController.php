<?php

namespace App\Controller;

use App\Entity\Category;
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
        $unordered_categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAllCategoryQuestions($id);

        // var_dump($unordered_questions);
        $categories = array();

        if (count($unordered_categories) > 0) {

            foreach ($unordered_categories as $question) {

                $categories["questions"][$question["question_id"]]["question"] =  $question["question"];
                $categories["questions"][$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
            }

            $categories["category_id"] = $unordered_categories[0]["id"];
            $categories["category_name"] = $unordered_categories[0]["name"];
        }
        dump($categories);


        // $form = $this->createFormBuilder($questions["questions"]);

        // foreach ($questions["questions"] as $key => $question) {

        //     dump($question);
        //     $form->add(
        //         "question_" . $key,
        //         ChoiceType::class,
        //         [
        //             'choices' => $question["answers"]
        //         ],
        //         array(
        //             "label" => $question["question"],
        //             "expanded" => true,
        //             "multiple" => false,
        //             "attr" => array(
        //             //     "expanded" => true,
        //             // "multiple" => false,
        //             "label" => $question["question"],
        //                 "class" => "form-control"
        //             )
        //         )
        //     );

        //     // $form->add("question_" . $key,  ChoiceType::class, array(
        //     //     "attr" => array(
        //     //         "class" => "form-control"
        //     //     )
        //     // ));
        // }

        // $form->add("save",  SubmitType::class, array(
        //     "label" => "Submit Survey",
        //     "attr" => array(
        //         "class" => "btn btn-primary mt-3"
        //     )
        // ));

        // $form = $form->getForm();

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $this->getDoctrine()->getManager()->flush();

        //     $this->addFlash("info", "Thank you for submitting the survey");
        //     return $this->redirectToRoute('homepage');
        // }

        // return $this->render('category/edit.html.twig', [
        //     'category' => $category,
        //     'form' => $form->createView(),
        // ]);

        // die();
        return $this->render('survey/questions.html.twig', [
            'categories' => $categories,
            // 'form' => $form->createView(),
        ]);
    }
}

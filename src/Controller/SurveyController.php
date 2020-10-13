<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\UserAnswer;
// use App\Form\SurveyType;
// use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// use Symfony\Component\Form\Extension\Core\Type\RadioType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

 /**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted ("ROLE_USER")
  */
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
     * @Route("/save_survey", name="save_survey", methods={"POST"})
     */
    public function save_survey(Request $request)
    {

        $submittedToken = $request->request->get('token');

        // 'delete-item' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('survey_submit', $submittedToken)) {
            
            $answers = $request->request->get('questions');
            // var_dump($questions  );
            // dump($request);
        // die();
        $entityManager = $this->getDoctrine()->getManager();

        foreach ($answers as $selectedAnswerId) {
 
            $answer = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->find($selectedAnswerId);

            // dump($question);
            // dump($selectedAnswerId);
            // dump($answer);        
            // die(var_dump($question, $selectedAnswerId));

            $userAnswer = new UserAnswer();

            $userAnswer->setAnswer($answer);
            $userAnswer->setUser($this->getUser());
            
            $entityManager->persist($userAnswer);

        }

        $entityManager->flush();
        
            $this->addFlash('success', 'Survey saved successfully');
            return $this->redirectToRoute('homepage');
        
        }

        $this->addFlash('error', 'Invalid Data, Please reload the form');
        return $this->redirectToRoute('homepage');
    

    }

    /**
     * @Route("/{id}", name="survey", methods={"GET"})
     */
    public function questions($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
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


        // $form = $this->createFormBuilder();
        // // $form = $this->createForm(SurveyType::class, $category);

        // // $slugify = new Slugify();

        // foreach ($categories["questions"] as $key => $question) {

        //     dump($question);
        //     // $form->add("question_" . $key,   )
        //     $form->add(
        //         "question_" . $key,
        //         ChoiceType::class,
        //         [
        //             'choices' => $question["answers"]
        //         ],
        //         array(
        //             "widget" => $question["question"],
        //             "placeholder" => $question["question"],
        //             "help" => $question["question"],
        //                 "expanded" => true,
        //             "multiple" => false,
        //             "attr" => array(
        //             //     "expanded" => true,
        //             // "multiple" => false,
        //             "label" => $question["question"],
        //             "placeholder" => $question["question"],
        //             "help" => $question["question"],

        //                 "class" => "form-control"
        //             )
        //         )
        //     );

        //     foreach ($question["answers"] as $k => $answer) {
        //         $form->add(
        //             "question_" . $key,
        //             RadioType::class,
        //             array(
        //                 "attr" => array(
        //                 //     "expanded" => true,
        //                 // "multiple" => false,
        //                 "label" => $answer,
        //                 "placeholder" => $answer,
        //                 "help" => $answer,

        //                     "class" => "form-control"
        //                 )
        //             )
        //         );
        //     }



        // $form->add("question_" . $key,  ChoiceType::class, array(
        //     "attr" => array(
        //         "class" => "form-control"
        //     )
        // ));
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

<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\UserAnswer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            ->getRepository(Quiz::class)
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
            $user = $this->getUser();

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
                $userAnswer->setUser($user);
                // $user->addUserAnswer($userAnswer);

                $entityManager->persist($userAnswer);
                // $entityManager->persist($user);

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
    public function questions(Request $request, $id)
    {
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($id);
        $unordered_categories = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAllQuizQuestions($id);

        // var_dump($unordered_questions);
        $categories = array();

        if (count($unordered_categories) > 0) {

            foreach ($unordered_categories as $question) {

                $categories["questions"][$question["question_id"]]["question"] =  $question["question"];
                $categories["questions"][$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
            }

            $categories["quiz_id"] = $unordered_categories[0]["id"];
            $categories["quiz_name"] = $unordered_categories[0]["name"];
        }
        dump($categories);

        return $this->render('survey/questions.html.twig', [
            'categories' => $categories,
            // 'form' => $form->createView(),
        ]);


        // $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($id);
        // // $unordered_categories = $this->getDoctrine()
        // //     ->getRepository(Quiz::class)
        // //     ->findAllQuizQuestions($id);

        // dump($quiz);
        // // die();
        // $form = $this->createForm(QuizType::class, $quiz);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // ... do your form processing, like saving the Task and Tag entities
        // }
        // dump($form);
        return $this->render('survey/questions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

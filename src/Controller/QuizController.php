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
 * @Route("/quiz", name="quiz_")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $quizes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();

        $submittedQuizes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findUserSubmittedQuizes($this->getUser());

        $doneQuizes = array();

        // create a modified array of the return
        // $doneQuizes = array_map(function($value){
        //     return $value["quiz_id"];
        // }, $submittedQuizes);

        foreach ($quizes as $quiz) {

            foreach ($submittedQuizes as $submittedQuiz) {
                if ($quiz->getId() == $submittedQuiz["quiz_id"]) {

                    $doneQuizes[$submittedQuiz["quiz_id"]] = true;
                }
            }
        }

        return $this->render('quiz/index.html.twig', [
            'quizes' => $quizes,
            'doneQuizes' => $doneQuizes
        ]);
    }

    /**
     * @Route("/save_quiz", name="save_quiz", methods={"POST"})
     */
    public function save_quiz(Request $request)
    {

        $submittedToken = $request->request->get('token');

        // 'delete-item' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('quiz_submit', $submittedToken)) {

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

            $this->addFlash('success', 'Quiz saved successfully');
            return $this->redirectToRoute('quiz_homepage');
        }

        $this->addFlash('error', 'Invalid Data, Please reload the form');
        return $this->redirectToRoute('quiz_homepage');
    }

    /**
     * @Route("/{id}", name="detail", methods={"GET"})
     */
    public function questions(Request $request, $id)
    {
        // check if user submitted this quiz before
        $submittedQuiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findUserSubmitThisQuiz($this->getUser(), $id);

            if (count($submittedQuiz) > 0) {
                $this->addFlash('warning', 'Quiz already submitted');
                return $this->redirectToRoute('quiz_homepage');
            }

        // $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($id);
        $unordered_quizes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAllQuizQuestions($id);

        // var_dump($unordered_questions);
        $quizes = array();

        if (count($unordered_quizes) > 0) {

            foreach ($unordered_quizes as $question) {

                $quizes["questions"][$question["question_id"]]["question"] =  $question["question"];
                $quizes["questions"][$question["question_id"]]["answers"][$question["answer_id"]] = $question["answer"];
            }

            $quizes["quiz_id"] = $unordered_quizes[0]["id"];
            $quizes["quiz_name"] = $unordered_quizes[0]["name"];
        }
        // dump($quizes);

        return $this->render('quiz/questions.html.twig', [
            'quizes' => $quizes,
            // 'form' => $form->createView(),
        ]);


        // $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($id);
        // // $unordered_quizes = $this->getDoctrine()
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
        return $this->render('quiz/questions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

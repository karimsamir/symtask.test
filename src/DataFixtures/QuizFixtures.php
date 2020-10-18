<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $quizes = array(
            "Social Media" => array(
                "What is your favourite social media platform?" => array(
                    "answers" => array(
                        "Facebook", "Instagram", "Twitter", "Pinterest", "WhatsApp"
                    )

                ),
                "How many times a day do you look at social media?" => array(
                    "answers" => array(
                        "not everyday", "once a day", "2-5 times a day",
                        "5-10 times a day", "10 + times"
                    )

                ),
                "How long do you spend on Social Media daily?" => array(
                    "answers" => array(
                        "15 mins", "30 mins", "45 mins", "1 Hour", "More than an hour"
                    )

                ),
                "how often do you post on social media?" => array(
                    "answers" => array(
                        "multiple times a day", "daily", "weekly", "every few weeks", "never"
                    )

                ),
                "when do you access social media?" => array(
                    "answers" => array(
                        "during free time", "whilst at school/ work",
                        "during social occasions", "meal times", "any spare moment"
                    )

                ),

            ),
            "Sports" => array(

                "How often do you participate in sport or physical activity?" => array(
                    "answers" => array(
                        "Daily", "Weekly", "Monthly", "Yearly", "Never"
                    )

                ),
                "How many hours a week, on average, do you participate in sport or physical activity?" => array(
                    "answers" => array(
                        "1-2 hours", "2-3 hours", "2-4 hours", "4+ hours", "Not applicable"
                    )

                ),
                "What sports/activities would you like the opportunity to participate in?" => array(
                    "answers" => array(
                        "Basketball", "Cycling", "Football", "Swimming", "Tennis"
                    )

                ),
                "Which quiz best desribes your involvement in sport?" => array(
                    "answers" => array(
                        "participator", "PE Teacher", "Coach", "Activity Leader", "Manager"
                    )

                ),
                "How long to you participate in sports per week?" => array(
                    "answers" => array(
                        "0-1 hour", "1-2 hours", "2-5 hours", "5-10 hours", "10 + hours"
                    )

                ),

            )
        );

        foreach ($quizes as $quiz_name => $questions) {

            $quiz = new Quiz();
            $quiz->setName($quiz_name);

            $manager->persist($quiz);

            foreach ($questions as $question_name => $answers) {

                $question = new Question();
                $question->setQuestion($question_name);
                $question->setQuiz($quiz);

                $manager->persist($question);

                foreach ($answers["answers"] as  $answer_text) {

                    $answer = new Answer();
                    $answer->setAnswer($answer_text);
                    $answer->setQuestion($question);

                    $manager->persist($answer);
                }
            }
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuizFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

    public function load(ObjectManager $manager)
    {

        $quizes = array(
            "General" => array(
                "What is your favourite social media platform?" => array(
                    "answers" => array(
                        "Facebook", "Instagram", "Twitter", "Pinterest", "WhatsApp", "Linkedin"
                    )

                ),
                "How many times a day do you look at social media?" => array(
                    "answers" => array(
                        "not everyday", "once a day", "2-5 times a day",
                        "5-10 times a day", "10 + times", "all day"
                    )

                ),
                "How long do you spend on Social Media daily?" => array(
                    "answers" => array(
                        "15 mins", "30 mins", "45 mins", "1 Hour", "2 Hours", "More than 2 hours"
                    )

                ),
                "how often do you post on social media?" => array(
                    "answers" => array(
                        "never", "every few weeks", "weekly", "daily", "multiple times a day", "more than 10 times a day"
                    )

                ),
                "when do you access social media?" => array(
                    "answers" => array(
                        "during free time", "whilst at school/ work",
                        "during social occasions", "meal times", "Hangout times", "any spare moment"
                    )

                ),

                // ),
                "How often do you participate in sport or physical activity?" => array(
                    "answers" => array(
                        "Never", "Yearly", "Monthly", "Weekly", "Daily", "Many times a day"
                    )

                ),
                "How many hours a week, on average, do you participate in sport or physical activity?" => array(
                    "answers" => array(
                        "Never", "1-2 hours", "2-3 hours", "3-4 hours", "4-5 hours", "More than 5 hours"
                    )

                ),
                "What sports/activities would you like the opportunity to participate in?" => array(
                    "answers" => array(
                        "Walking", "Cycling", "Basketball", "Football", "Swimming", "Tennis"
                    )

                ),
                "Which quiz best desribes your involvement in sport?" => array(
                    "answers" => array(
                        "Not Applicable", "Participator", "PE Teacher", "Coach", "Activity Leader", "Manager"
                    )

                ),
                "What is the sport that you like to watch the most?" => array(
                    "answers" => array(
                        "Car racing", "Cycling", "Basketball", "Football", "Swimming", "Tennis"
                    )

                ),
                // "Sports" => array(

                //     "How often do you participate in sport or physical activity?" => array(
                //         "answers" => array(
                //             "Daily", "Weekly", "Monthly", "Yearly", "Never"
                //         )

                //     ),
                //     "How many hours a week, on average, do you participate in sport or physical activity?" => array(
                //         "answers" => array(
                //             "1-2 hours", "2-3 hours", "2-4 hours", "4+ hours", "Not applicable"
                //         )

                //     ),
                //     "What sports/activities would you like the opportunity to participate in?" => array(
                //         "answers" => array(
                //             "Basketball", "Cycling", "Football", "Swimming", "Tennis"
                //         )

                //     ),
                //     "Which quiz best desribes your involvement in sport?" => array(
                //         "answers" => array(
                //             "participator", "PE Teacher", "Coach", "Activity Leader", "Manager"
                //         )

                //     ),
                //     "How long to you participate in sports per week?" => array(
                //         "answers" => array(
                //             "0-1 hour", "1-2 hours", "2-5 hours", "5-10 hours", "10 + hours"
                //         )

                //     ),

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

                foreach ($answers["answers"] as $weight => $answer_text) {

                    $answer = new Answer();
                    $answer->setAnswer($answer_text);
                    $answer->setWeight($weight);
                    $answer->setQuestion($question);

                    $manager->persist($answer);
                }
            }
        }

        $manager->flush();
    }
}

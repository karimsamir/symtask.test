<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            // ->add('Quiz')
            // ->add('userAnswers')
        ;

        // $builder->add('answers', ChoiceType::class, [
        //     'entry_type' => AnswerType::class,
        //     'entry_options' => ['label' => false],
        // ]);

        // $builder->add('answers', ChoiceType::class, [
        //     // 'choices' => [
        //     //     'answers'
        //     // ],
        //     'choices'  => [
        //         'Maybe' => null,
        //         'Yes' => true,
        //         'No' => false,
        //     ],
        //     // "name" is a property path, meaning Symfony will look for a public
        //     // property or a public method like "getName()" to define the input
        //     // string value that will be submitted by the form
        //     'choice_value' => 'answer',
        //     // a callback to return the label for a given choice
        //     // if a placeholder is used, its empty value (null) may be passed but
        //     // its label is defined by its own "placeholder" option
        //     'choice_label' => function(?Answer $answer) {
        //         return $answer ? strtoupper($answer->getAnswer()) : '';
        //     },
        //     // returns the html attributes for each option input (may be radio/checkbox)
        //     'choice_attr' => function(?Answer $answer) {
        //         return $answer ? ['class' => 'answer'.strtolower($answer->getAnswer())] : [];
        //     },
        //     // every option can use a string property path or any callable that get
        //     // passed each choice as argument, but it may not be needed
        //     'group_by' => function() {
        //         // randomly assign things into 2 groups
        //         return rand(0, 1) == 1 ? 'Group A' : 'Group B';
        //     },
        //     // a callback to return whether a category is preferred
        //     // 'preferred_choices' => function(?Answer $answer) {
        //     //     return $answer && 100 < $answer->getArticleCounts();
        //     // },
        // ]);

        // $builder->add('answers', ChoiceType::class, [
        //     'choices'  => [
        //         'Maybe' => null,
        //         'Yes' => true,
        //         'No' => false,
        //     ],
        // ]);

        $builder->add('answers',  EntityType::class, array(
            'class' => 'App\Entity\Answer',
            'choice_label' => 'answer'
));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}

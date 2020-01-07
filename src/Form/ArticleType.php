<?php

namespace App\Form;

use App\DTO\CreateArticleDTO;
use App\Entity\Article;
use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    //1 -> lie le formulaire avec le DTO par data_class
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateArticleDTO::class,
            'empty_data' => function (FormInterface $form) {
                return new CreateArticleDTO($form->get('title')->getData(), $form->get('content')->getData());
            }
        ]);
    }
}

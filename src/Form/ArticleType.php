<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le titre ne peut pas être vide',
                    ]),
                ],
                'label' => 'Titre'
            ])
            ->add('contenuA', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu ne peut pas être vide',
                    ]),
                ], 'label' => 'Contenu'
            ])->add('image', TextareaType::class, ['label' => 'Images', 'required' => false,]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

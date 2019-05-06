<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class AddedBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => function($author) {
                    return $author->getFirstname();
                }
            ])
            ->add('publisher', TextType::class)
            ->add('publishedDate', DateType::class, [
                  'widget' => 'single_text'  
            ])
            ->add('description', TextareaType::class)
            ->add('cover', TextType::class)
            ->add('category', EntityType::class, [
                'class'        => Category::class,
                'placeholder'  => 'Choisir une catégorie ...' ,
                'choice_label' => function ($category) {
                    return $category->getTitle();
                },
                'required' => true
                
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

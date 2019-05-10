<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class AddedBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', AuthorType::class)
            ->add('publisher', TextType::class)
            ->add('publishedDate', DateType::class, [
                  'widget' => 'single_text'  
            ])
            ->add('summary', TextareaType::class)
            ->add('imageFile', FileType::class)
            // ->add('category', CategoryType::class)
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'title',
                'expanded' => false,
                'multiple' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'book_item',
 
        ]);
    }
}

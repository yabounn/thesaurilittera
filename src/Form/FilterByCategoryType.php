<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\CategoryRepository;

class FilterByCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $category) {
                    return $category->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'label' => false,
                'placeholder' => 'Catégories',
                'choice_label' => 'title'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // 'data_class' => Category::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    // Pour une url plus propre
    public function getBlockPrefix()
    {
        return '';
    }
}

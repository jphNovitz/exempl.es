<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Site;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'form.title',
                'translation_domain' => 'messages'
            ])
            ->add('description', TextType::class, [
                'label' => 'form.description',
                'translation_domain' => 'messages'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false
            ])
            ->add('repo', TextType::class, [
                'label' => 'form.repository',
                'translation_domain' => 'messages'
            ])
            ->add('categories', EntityType::class, [
                'required' => false,
                'class' => Category::class,
//                'query_builder' => function (EntityRepository $er): QueryBuilder {
//                    return $er->createQueryBuilder('c')
//                        ->orderBy('c.name', 'ASC');
//                },
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('tags', EntityType::class, [
                'required' => false,
                'class' => Tag::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}

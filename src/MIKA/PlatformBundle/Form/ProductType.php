<?php

namespace MIKA\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameproduct',    TextType::class)
            ->add('designation',    TextareaType::class)
            ->add('picture',        PictureType::class)
            ->add('unitprice',      TextType::class)
            ->add('discount',       TextType::class, array('required' => false))
            ->add('quantity',       TextType::class)
            ->add('tva',            EntityType::class, array(
                'class'        => 'MIKAPlatformBundle:Tva',
                'choice_label' => 'name',
                'multiple'     => false,))
            ->add('categories', EntityType::class, array(
                'class'         => 'MIKAPlatformBundle:Category',
                'choice_label'  => 'name',
                'multiple'      => true,))
            ->add('save',           SubmitType::class);


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MIKA\PlatformBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mika_platformbundle_product';
    }


}

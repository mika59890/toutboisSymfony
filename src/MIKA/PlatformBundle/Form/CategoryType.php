<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 25/04/18
 * Time: 21:27
 */
namespace MIKA\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MIKA\PlatformBundle\Entity\Category'
        ));
    }
    public function getBlockPrefix()
    {
        return 'mika_platformbundle_category';
    }
}
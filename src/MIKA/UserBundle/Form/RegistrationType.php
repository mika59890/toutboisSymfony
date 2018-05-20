<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 18/04/18
 * Time: 13:47
 */
namespace MIKA\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    // Formulaire d'enregistrement d'un utilisateur
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array('label'=>'form.name', 'translation_domain' => 'messages'))
            ->add('firstname',TextType::class, array( 'label'=>'form.firstname','translation_domain' => 'messages'))
            ->add('streetnumber',TextType::class, array( 'label'=>'form.streetnumber','translation_domain' => 'messages'))
            ->add('channeltype',ChoiceType::class, array(
                'label'=>'form.channeltype',
                'translation_domain' => 'messages',
                'choices'=> array('rue'=>'rue','avenue'=>'avenue','boulevard'=>'boulevard','allée'=>'allée',
                                    'square'=>'square')))
            ->add('street',TextType::class, array( 'label'=>'form.street','translation_domain' => 'messages'))
            ->add('postalcode',TextType::class, array( 'label'=>'form.postalcode','translation_domain' => 'messages'))
            ->add('city',TextType::class, array( 'label'=>'form.city','translation_domain' => 'messages'))
            ->add('country',CountryType::class, array( 'label'=>'form.country','translation_domain' => 'messages',
                'placeholder' => 'France'))
            ->add('phone',TextType::class, array( 'label'=>'form.phone','translation_domain' => 'messages'))
        ;
    }
    // Appel du formulaire de FOSUserBundle
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
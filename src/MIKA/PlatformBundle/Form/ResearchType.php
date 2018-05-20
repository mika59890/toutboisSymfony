<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 03/05/18
 * Time: 20:00
 */

namespace MIKA\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ResearchType extends AbstractType
{
    public function buildForm(FormbuilderInterface $builder, array $option)
    {
        $builder->add('research',TextType::class, array('label' => false,
            'attr' => array('class' => 'input-medium search-query')));
    }

    public function getName()
    {
        return 'MIKAPlatformbundle_research';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 04/05/18
 * Time: 20:24
 */
namespace MIKA\PlatformBundle\Twig;

class MontantTvaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('montantTva', array($this,'montantTva')));
    }

    function montantTva($unitprice,$tva)
    {
        return round(($unitprice / $tva)-$unitprice,2);
    }

    public function getName()
    {
        return 'montant_tva_extension';
    }
}
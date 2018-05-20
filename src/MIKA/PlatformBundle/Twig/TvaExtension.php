<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 04/05/18
 * Time: 13:36
 */

namespace MIKA\PlatformBundle\Twig;

class TvaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('tva', array($this,'calculTva')));
    }

    function calculTva($unitprice,$tva)
    {
        return round($unitprice / $tva,2);
    }

    public function getName()
    {
        return 'tva_extension';
    }
}
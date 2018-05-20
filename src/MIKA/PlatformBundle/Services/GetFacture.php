<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 06/05/18
 * Time: 20:13
 */

namespace MIKA\PlatformBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

require_once dirname(__FILE__).'/../../../../vendor/autoload.php';
require_once(dirname( __FILE__ ).'/../../../../vendor/spipu/html2pdf/html2pdf.class.php');

class GetFacture
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function facture($facture)
    {
        $html = $this->container->get('templating')->render('MIKAUserBundle:User:facturesPDF.html.twig', array('facture' => $facture));

        $html2pdf = new \HTML2PDF('P','A4','fr');
        $html2pdf->pdf->SetAuthor('Toutbois');
        $html2pdf->pdf->SetTitle('Facture '.$facture->getProducts());
        $html2pdf->pdf->SetSubject('Facture Toutbois');
        $html2pdf->pdf->SetKeywords('facture,Toutbois');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }
}
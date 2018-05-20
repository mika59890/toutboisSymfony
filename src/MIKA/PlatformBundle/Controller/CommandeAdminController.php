<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 08/05/18
 * Time: 18:30
 */

namespace MIKA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MIKA\PlatformBundle\Entity\Commandes;
use MIKA\PlatformBundle\Entity\Product;
class CommandeAdminController extends Controller
{
    public function commandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('MIKAPlatformBundle:Commandes')->findAll();

        return $this->render('MIKAPlatformBundle:Admin:index.html.twig', array('commandes' => $commandes));
    }

    public function showFactureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('MIKAPlatformBundle:Commandes')->find($id);

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('mika_platform_adminCommande'));
        }

        $this->container->get('setNewFacture')->facture($facture);
    }
}
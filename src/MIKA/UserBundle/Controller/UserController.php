<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 06/05/18
 * Time: 20:43
 */

namespace MIKA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('MIKAPlatformBundle:Commandes')->byFacture($this->getUser());

        return $this->render('MIKAUserBundle:User:facture.html.twig', array('factures' => $factures));
    }

    public function facturesPDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('MIKAPlatformBundle:Commandes')->findOneBy(array('user' => $this->getUser(),
            'validate' => 1,
            'id' => $id));

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('mika_facture'));
        }

        $this->container->get('setNewFacture')->facture($facture);
    }
}
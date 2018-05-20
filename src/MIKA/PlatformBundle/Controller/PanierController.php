<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 24/04/18
 * Time: 08:57
 */

namespace MIKA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('MIKAPlatformBundle:Panier:menuPanier.html.twig', array('articles' => $articles));
    }

    public function addPanierAction(Request $request ,$id)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;

            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }
        $session->set('panier',$panier);

        return $this->redirect($this->generateUrl('mika_platform_panier'));
    }

    public function deletePanierAction(Request $request ,$id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('mika_platform_panier'));
    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $session->set('panier', array());

        $em = $this->getDoctrine()->getManager();
        $listProduct = $em->getRepository('MIKAPlatformBundle:Product')->findArray(array_keys($session->get('panier')));
        return $this->render('MIKAPlatformBundle:Panier:panier.html.twig', array('listProduct' => $listProduct,
            'panier' => $session->get('panier')));
    }

    public function livraisonAction(Request $request)
    {
        $session = $request->getSession();
        $user = $this->getUser();
        return $this->render('MIKAPlatformBundle:Panier:livraison.html.twig', array('user' => $user));
    }

    public function validationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('MIKAPlatformBundle:Commande:prepareCommande');
        $commande = $em->getRepository('MIKAPlatformBundle:Commandes')->find($prepareCommande->getContent());

        /*$user = $this->getUser();
        $session = $request->getSession();
        $listProduct = $em->getRepository('MIKAPlatformBundle:Product')->findArray(array_keys($session->get('panier')));
        */

        return $this->render('MIKAPlatformBundle:Panier:validation.html.twig', array('commande' => $commande));
    }
}
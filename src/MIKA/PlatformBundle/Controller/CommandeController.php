<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 06/05/18
 * Time: 15:05
 */

namespace MIKA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MIKA\PlatformBundle\Entity\Commandes;
use MIKA\PlatformBundle\Entity\Product;

class CommandeController extends Controller
{
    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $user = $this->getUser();
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;
        $totalTVA = 0;

        $listProduct = $em->getRepository('MIKAPlatformBundle:Product')->findArray(array_keys($session->get('panier')));

        foreach($listProduct as $product)
        {
            $prixHT = ($product->getUnitprice() * $panier[$product->getId()]);
            $prixTTC = ($product->getUnitprice() * $panier[$product->getId()] / $product->getTva()->getMultiplicate());
            $totalHT += $prixHT;

            if (!isset($commande['tva']['%'.$product->getTva()->getValeur()]))
            {
                $commande['tva']['%' . $product->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
            }else{
                $commande['tva']['%' . $product->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);
            }
            $totalTVA += round($prixTTC-$prixHT,2);
            $commande['product'][$product->getId()] = array('reference' => $product->getNameproduct(),
                'quantite' => $panier[$product->getId()],
                'prixHT' => round($product->getUnitprice(),2),
                'prixTTC' => round($product->getUnitprice() / $product->getTva()->getMultiplicate(),2));
        }

        $commande['livraison'] = array('prenom' => $user->getFirstname(),
                                          'nom' => $user->getName(),
                                    'telephone' => $user->getPhone(),
                                       'numero' => $user->getStreetnumber(),
                                     'typevoie' => $user->getChanneltype(),
                                      'nomvoie' => $user->getStreet(),
                                           'cp' => $user->getPostalcode(),
                                        'ville' => $user->getCity(),
                                         'pays' => $user->getCountry(),
                                        'email' => $user->getEmail()
        );
        $commande['prixHT'] = round($totalHT,2);
        $commande['prixTTC'] = round($totalHT+$totalTVA,2);

        return $commande;
    }

    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if (!$session->has('commande'))
            $commande = new Commandes();
        else
            $commande = $em->getRepository('MIKAPlatformBundle:Commandes')->find($session->get('commande'));

        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setValidate(0);
        $commande->setProducts(0);
        $commande->setCommande($this->facture($request));

        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande',$commande);
        }

        $em->flush();

        return new Response($commande->getId());
    }

    public function validationCommandeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('MIKAPlatformBundle:Commandes')->find($id);

        if (!$commande || $commande->getValidate() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');

        $commande->setValidate(1);
        $commande->setProducts($this->container->get('setNewReference')->reference()); //Service
        $em->flush();

        $session = $request->getSession();
        $session->remove('panier');
        $session->remove('commande');

        $message = \Swift_Message::newInstance()
            ->setSubject('Validation de votre commande')
            ->setFrom(array('mikagti16@gmail.com' => "Toutbois"))
            ->setTo($commande->getUser()->getEmailCanonical())
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody($this->renderView('MIKAPlatformBundle:Panier:validationCommande.html.twig',array('user' => $commande->getUser())));

        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('success','Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('mika_facture'));
    }
}
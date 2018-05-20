<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 10/04/18
 * Time: 09:58
 */

namespace MIKA\PlatformBundle\Controller;

use MIKA\PlatformBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use MIKA\PlatformBundle\Entity\Product;
use MIKA\PlatformBundle\Form\ProductType;
use MIKA\PlatformBundle\Form\CategoryType;
use MIKA\PlatformBundle\Form\ResearchType;

class ProductController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')
            ->render('MIKAPlatformBundle:Product:index.html.twig');
        return new Response($content);
    }

    public function researchAction()
    {
        $form = $this->createForm(ResearchType::class);
        return $this
            ->render('MIKAPlatformBundle:Product:research.html.twig', array('form' => $form->createView()));
    }
    public function researchTreatmentAction(Request $request)
    {
        $session = $request->getSession();
        if ($session->has('panier'))
        {
            $panier = $session->get('panier');
        }else {
            $panier = false;
        }
        $form = $this->createForm(ResearchType::class);
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            //$form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $listProducts = $em->getRepository('MIKAPlatformBundle:Product')->research($form['research']->getData());
        }else{
            throw $this->createNotFoundException('La page n\'existe pas.');
        }
        return $this
            ->render('MIKAPlatformBundle:Product:view.html.twig', array('listProducts' => $listProducts,
                                                             'panier'       => $panier));
    }
    public function viewAction(Request $request, Category $categories = null)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()
            ->getManager();
        if ($session->has('panier'))
        {
            $panier = $session->get('panier');
        }else {
            $panier = false;
        }
        // choix par catégorie
        if ($categories != null){
            $listProductsF = $em->getRepository('MIKAPlatformBundle:Product')->byCategorie($categories);
        }else {
            $listProductsF = $em->getRepository('MIKAPlatformBundle:Product')->findAll();
        }
        // On récupère l'objet Paginator
        $paginator  = $this->get('knp_paginator');
        $listProducts = $paginator->paginate(
            $listProductsF, /* query NOT result */
            $request->query->getInt('page', 1)/*numéro de page*/,
            6/*limite par page*/
        );
        // On donne les informations à la vue
        return $this->render('MIKAPlatformBundle:Product:view.html.twig', array(
            'listProducts'=> $listProducts,
            'panier'      => $panier,
            'categorie'   => $categories
        ));
    }
    public function detailAction(Request $request, Product $product)
    {
        $session = $request->getSession();
        if ($session->has('panier')) {
            $panier = $session->get('panier');
        } else {
            $panier = false;
        }
        return $this->render('MIKAPlatformBundle:Product:detail.html.twig', array(
            'product' => $product,
            'panier'  => $panier
        ));

    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
        // On crée un objet Product
        $product = new Product();
        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->create(ProductType::class, $product);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Produit bien enregistré.');
            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_platform_detail', array('id' => $product->getId()));

        }
        return $this->render('MIKAPlatformBundle:Product:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addcategoryAction(Request $request)
    {
        // On crée un objet Product
        $category = new Category();
        // On crée le FormBuilder grâce au service form factory
        $form = $this->get('form.factory')->create(CategoryType::class, $category);
        // Si la requête est en POST
        if ($request->isMethod('POST')&& $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Categorie bien enregistré.');
            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirectToRoute('mika_platform_add');

        }
        return $this->render('MIKAPlatformBundle:Product:addcategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('MIKAPlatformBundle:Product')->find($id);
        $form = $this->get('form.factory')->create(ProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Produit bien modifiée.');
            return $this->redirectToRoute('mika_platform_detail', array('id' => $product->getId()));
        }
        return $this->render('MIKAPlatformBundle:Product:edit.html.twig', array(
            'product' => $product,
            'form'   => $form->createView(),
        ));
    }
    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('MIKAPlatformBundle:Product')->find($id);

        if (null === $product) {
            throw new NotFoundHttpException("Le produit d'id ".$id." n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "Le produit a bien été supprimé.");
            return $this->redirectToRoute('mika_platform_home');
        }
        return $this->render('MIKAPlatformBundle:Product:delete.html.twig', array(
            'product' => $product,
            'form'   => $form->createView(),
        ));
    }
}
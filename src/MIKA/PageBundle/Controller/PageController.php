<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 24/04/18
 * Time: 14:02
 */
namespace  MIKA\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('MIKAPageBundle:Page')->findAll();

        return $this->render('MIKAPageBundle:Page:menu.html.twig', array('pages' => $pages));
    }

    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('MIKAPageBundle:Page')->find($id);

        if (!$page) throw $this->createNotFoundException('La page n\'existe pas.');

        return $this->render('MIKAPageBundle:Page:page.html.twig', array('page' => $page));
    }
}
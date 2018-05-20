<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 02/05/18
 * Time: 11:34
 */
namespace  MIKA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('MIKAPlatformBundle:Category')->findAll();

        return $this->render('MIKAPlatformBundle:Product:menuCategory.html.twig', array('category' => $category));
    }


}
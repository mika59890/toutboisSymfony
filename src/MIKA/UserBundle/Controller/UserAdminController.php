<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 06/05/18
 * Time: 20:43
 */

namespace MIKA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('MIKAUserBundle:User')->findAll();

        return $this->render('MIKAUserBundle:User:index.html.twig', array('users' => $users));
    }

    public function userAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MIKAUserBundle:User')->find($id);

        if ($this->container->get('request_stack')->getCurrentRequest()->get('_route') == 'mika_platform_adminUserDetail')
            return $this->render('MIKAUserBundle:User:detailuser.html.twig', array('user' => $user));
        elseif ($this->container->get('request_stack')->getCurrentRequest()->get('_route') == 'mika_platform_adminFactureUser')
            return $this->render('MIKAUserBundle:User:detailfactureuser.html.twig', array('user' => $user));
        else
            throw $this->createNotFoundException('La page n\'existe pas !!!');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: mika
 * Date: 06/05/18
 * Time: 20:13
 */

namespace MIKA\PlatformBundle\Services;

use Symfony\Component\Security\Core\Security;

class GetReference
{
    public function __construct($securityContext, $entityManager)
    {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }

    public function reference()
    {
        $reference = $this->em->getRepository('MIKAPlatformBundle:Commandes')->findOneBy(array('validate' => 1), array('id' => 'DESC'),1,1);

        if (!$reference)
            return 1;
        else
            return $reference->getProducts() +1;
    }
}
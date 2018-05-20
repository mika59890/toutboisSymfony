<?php

namespace MIKA\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MIKAUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

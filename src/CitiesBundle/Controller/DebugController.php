<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DebugController extends Controller
{
    public function phpinfoAction()
    {
        return phpinfo();
    }


    public function route404Action()
    {

    }
}

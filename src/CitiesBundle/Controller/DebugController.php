<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DebugController extends Controller
{
    public function phpinfoAction()
    {
        return phpinfo();
    }


    public function route404Action(Request $request)
    {
        return $this->render("CitiesBundle:Debug:404.html.twig", array(
            'title' => "Page 404",
            "message" => "La page que vous demandez n'est pas attribué, veuillez vous la mettre dans un endroit approprié"
        ));
    }


    public function route503Action(Request $request)
    {
        return $this->render("CitiesBundle:Debug:404.html.twig", array(
            'title' => "Page 503",
            'code' => 503,
            "message" => "Une erreur serveur s'est produite"
        ));
    }
}

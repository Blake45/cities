<?php

namespace CitiesBundle\Controller;

use CitiesBundle\Entity\User;
use CitiesBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{

    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('CitiesBundle:User:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    public function logoutAction(Request $request)
    {

    }


    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
            }
        }

        return $this->render("CitiesBundle:User:register.html.twig", array(
            'form' => $form->createView(),
            'title' => "Inscription"
        ));
    }

}

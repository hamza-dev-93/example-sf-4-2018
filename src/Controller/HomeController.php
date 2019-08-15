<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * HomeController.
 *
 * @author	Hamza
 * @since	v0.0.1
 * @version	v1.0.0	Thursday, August 15th, 2019.
 * @see		Controller
 * @global
 * @Route("/home", name="home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
    * @Route("/hello/{name?}", name="hello")
    */
    public function hello(Request $request, $name){

        // $name = $request->get('name');

        return $this->render('home/greet.html.twig', [
            'name' => $name
        ]);
    }
}


<?php

namespace App\Controller;

use App\Entity\Post;
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

        // explain different between createForm and createFormBuilder
        $form = $this->createFormBuilder()
                    ->add('Fullname')
                    ->getForm();

        // $name = $request->get('name');
        $person = [
            'name' => 'Hamza',
            'lastname' => 'bedoui',
            'age' => 40
        ];
        ///////////////////////////////
        // store stuf in the database//
        ///////////////////////////////
        $post = new Post();
        $post->setTitle("hamza b")
            ->setDescription('description de hamza b a lire');
        $em = $this->getDoctrine()->getManager();
        $reteivedPost = $em->getRepository(Post::class)->findAll();
        $em->persist($post);
        // $em->flush();

        return $this->render('home/greet.html.twig', [
            // 'name' => $name,
            'person' => $person,
            'posts' => $reteivedPost,
            'user_form' => $form->createView()

        ]);
    }
}


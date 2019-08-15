<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class,$post, [

            'action' => $this->generateUrl('form'),
            'method' => 'POST'
        ]);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

        }

        return $this->render('form/index.html.twig', [
            'post_form' => $form->createView(),
        ]);
    }
}

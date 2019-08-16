<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Services\Fetcher;
use App\Services\Paginator;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('post')['my_files'];
            $uploads_directory = $this->getParameter('uploads_directory');
            foreach ($files as $key => $file) {
                # code...
                $filename = md5(uniqid ()).'.'.$file->guessExtension() ;
                $file->move(
                    $uploads_directory,
                    $filename
                );
            }
            // echo "<pre>";
            // var_dump($file);
            // die();
            // echo "<\pre>";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,            
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/upload", name="post_upload", methods={"GET","POST"})
     */
    public function upload(Request $request, Fetcher $fetcher, Paginator $page): Response
    {
        //URL : https://api.coinmarketcap.com/v2/listings/
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('post')['my_files'];
            $uploads_directory = $this->getParameter('uploads_directory');
            foreach ($files as $key => $file) {
                # code...
                $filename = md5(uniqid ()).'.'.$file->guessExtension() ;
                $file->move(
                    $uploads_directory,
                    $filename
                );
            }
            // echo "<pre>";
            // var_dump($file);
            // die();
            // echo "<\pre>";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_upload');
        }
        $result = $fetcher->get('https://api.coinmarketcap.com/v2/listings/');
        $partialArrau = $page->getPartiel($result['data'], 10, 10);

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'getData' => $partialArrau,
            'img' => '5179ab66488ec722113a2f9ad853d099.png',         
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'img' => '5179ab66488ec722113a2f9ad853d099.png'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}

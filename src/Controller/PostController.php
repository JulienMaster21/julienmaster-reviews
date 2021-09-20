<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/post")
 */
class PostController extends AbstractController {

    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository,
                          Request $request,
                          PaginatorInterface $paginator): Response {

        // Get all posts
        $publishedPosts = $postRepository->findAllPublished();

        // Paginate result
        $pagination = $paginator->paginate(
            $publishedPosts,
            $request->query->getInt('page', 1)
        );

        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/create", name="post_create", methods={"GET","POST"})
     * @IsGranted("ROLE_POST_CREATE")
     */
    public function create(Request $request,
                           ValidatorInterface $validator,
                           FileUploader $fileUploader): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Handle file upload
            $photoFile = $form->get('photo_filename')->getData();
            if ($photoFile) {
                $photoFilename = $fileUploader->upload($photoFile);
                $post->setPhotoFilename($photoFilename);
            }

            # Set publication date if post is published
            $status = $form->get('status')->getData();
            if ($status === "published") {
                $post->setPublicationDate(new \DateTime('now'));
            }

            # Set author
            $user = $this->getUser();
            if ($user) {
                $post->setUser($user);
            }

            # Validate form
            $errors = $validator->validate($post);
            if (count($errors) > 0) {
                return $this->renderForm('post/create.html.twig', [
                    'post' => $post,
                    'form' => $form,
                    'errors' => $errors
                ]);
            }

            # Persist rest of data
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $post->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/create.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_POST_EDIT")
     */
    public function edit(Request $request,
                         ValidatorInterface $validator,
                         Post $post,
                         FileUploader $fileUploader,
                         UserRepository $userRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            # Handle file upload
            $photoFile = $form->get('photo_filename')->getData();
            if ($photoFile) {
                $photoFilename = $fileUploader->upload($photoFile);
                $post->setPhotoFilename($photoFilename);
            }
            else {
                $post->setPhotoFilename($post->getPhotoFilename());
            }

            # Set publication date if post is published
            $status = $form->get('status')->getData();
            if ($status === "published") {
                $post->setPublicationDate(new \DateTime('now'));
            }

            # Set author
            $user = $this->getUser();
            if ($user) {
                $post->setUser($user);
            }

            # Validate form
            $errors = $validator->validate($post);
            if (count($errors) > 0) {
                return $this->renderForm('post/edit.html.twig', [
                    'post' => $post,
                    'form' => $form,
                    'button_label' => 'Update',
                    'errors' => $errors
                ]);
            }

            # Persist rest of data
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $post->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'button_label' => 'Update'
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"POST"})
     * @IsGranted("ROLE_POST_DELETE")
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }
}

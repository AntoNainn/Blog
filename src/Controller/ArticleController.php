<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/blog-full-width.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    #[IsGranted('EDIT', subject: 'article')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('article', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('categorie/{slug}/article', name: 'app_article_categorie', methods: ['GET'])]
    public function articlecategorie(ArticleRepository $articleRepository, Categorie $categorie): Response
    {
        return $this->render('article/blog-full-width.html.twig', [
            'articles' => $articleRepository->findByCategorie($categorie)
        ]);
    }
    
    public function recentArticle(ArticleRepository $articleRepository,int $max): Response
    {
        return $this->render('recentArticle.html.twig', [
            'articles' => $articleRepository->findBy([],[],$max,0),
        ]);
    }

    #[Route('/result/r', name: 'app_article_result', methods: ['GET'])]
    public function result(ArticleRepository $articleRepository, Request $request): Response
    {
        $form = ($request->get('form'));
        $value = $form['value'];
        $articles = $articleRepository->findBySearch($value);
        return $this->render('article/blog-full-width.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/form/f', name: 'app_article_recherche', methods: ['GET'])]
    public function recherche(ArticleRepository $articleRepository): Response
    {
        $form = $this->createFormBuilder(null, [
            'attr' => ['class' => 'd-flex']
        ])
        ->setAction($this->generateUrl('app_article_result'))
        ->add('value',TextType::class, ['label'=>false,
            'attr' => ['placeholder' => 'Recherche...',
            'class' => 'form-control me-2' 
            ]])
        ->add('Recherche', SubmitType::class,[
            'attr' => ['class' => 'btn btn-outline-success']
        ])
        ->setMethod('GET')
        ->getForm();
            
        return $this->render('search.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/show-api/{id}', name: 'app_article_showapi', methods: ['GET'])]
    public function showapi(Article $article, SerializerInterface $serializer): JsonResponse
    {
        $jsonContent = $serializer->serialize($article, 'json', ['groups' => ['article']]);
        return new JsonResponse($jsonContent);
    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/article", name="admin_article", methods={"GET"})
     */
    public function article(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/article.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/new", name="admin_article_new", methods={"GET","POST"})
     */
    public function articleNew(Request $request, ArticleRepository $articleRepository): Response
    {
        /* INITIALIZE ARTICLE REPOSITORY FOR ALL ARTICLE WITH isHomePage == true */
        $articles = $articleRepository->findBy([
            "isHomePage" => true,
        ]);

        $newArticle = new Article();
        $form = $this->createForm(ArticleType::class, $newArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL ARTICLES IsHomePage TO FALSE*/
            if ($newArticle->getIsHomePage() == true) {
                foreach ($articles as $article) {
                    $article->setIsHomePage(false);
                    $slug = Slugify::generate($article->getTitle());
                    $article->setSlug($slug);
                }
                $newArticle->setIsHomePage(true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newArticle);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin/article_new.html.twig', [
            'article' => $newArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function articleEdit(Request $request, Article $newArticle, ArticleRepository $articleRepository): Response
    {
        /* INITIALIZE ARTICLE REPOSITORY FOR ALL ARTICLE WITH isHomePage == true */
        $articles = $articleRepository->findBy([
            "isHomePage" => true,
        ]);

        $form = $this->createForm(ArticleType::class, $newArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* CONVERT ALL ARTICLES IsHomePage TO FALSE*/
            if ($newArticle->getIsHomePage() == true) {
                foreach ($articles as $article) {
                    $article->setIsHomePage(false);
                }
                $newArticle->setIsHomePage(true);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin/article_edit.html.twig', [
            'article' => $newArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="admin_article_delete", methods={"DELETE"})
     */
    public function articleDelete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article');
    }
}

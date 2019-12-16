<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\BusinessHour;
use App\Entity\Category;
use App\Entity\Professional;
use App\Form\ArticleType;
use App\Form\BusinessHourType;
use App\Form\CategoryType;
use App\Form\ProfessionalType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProfessionalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="admin_index")
     */
    public function index(): Response
    {
        return $this->render("admin/index.html.twig");
    }

    /**
     * @Route("/category", name="admin_category", methods={"GET"})
     */
    public function category(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/new", name="admin_category_new", methods={"GET","POST"})
     */
    public function categoryNew(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/category_new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}/edit", name="admin_category_edit", methods={"GET","POST"})
     */
    public function categoryEdit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/category_edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="admin_category_delete", methods={"DELETE"})
     */
    public function categoryDelete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category');
    }

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
    public function articleNew(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin/article_new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function articleEdit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin/article_edit.html.twig', [
            'article' => $article,
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

    /**
     * @Route("/professional", name="admin_professional", methods={"GET"})
     */
    public function professional(ProfessionalRepository $professionalRepository): Response
    {
        return $this->render('admin/professional.html.twig', [
            'professionals' => $professionalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/professional/new", name="admin_professional_new", methods={"GET","POST"})
     */
    public function professionalNew(Request $request): Response
    {
        $professional = new Professional();
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professional);
            $entityManager->flush();

            return $this->redirectToRoute('admin_professional');
        }

        return $this->render('admin/professional_new.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/professional/{id}/edit", name="admin_professional_edit", methods={"GET","POST"})
     */
    public function professionalEdit(Request $request, Professional $professional): Response
    {
        $form = $this->createForm(ProfessionalType::class, $professional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_professional');
        }

        return $this->render('admin/professional_edit.html.twig', [
            'professional' => $professional,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("professional/{id}", name="admin_professional_delete", methods={"DELETE"})
     */
    public function professionalDelete(Request $request, Professional $professional): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professional->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($professional);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_professional');
    }

    /**
     * @Route("/business-hours/new", name="admin_business_hour_new", methods={"GET","POST"})
     */
    public function businessHoursNew(Request $request): Response
    {
        $businessHour = new BusinessHour();
        $form = $this->createForm(BusinessHourType::class, $businessHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($businessHour);
            $entityManager->flush();

            return $this->redirectToRoute('business_hour_index');
        }

        return $this->render('business_hour/new.html.twig', [
            'business_hour' => $businessHour,
            'form' => $form->createView(),
        ]);
    }
}

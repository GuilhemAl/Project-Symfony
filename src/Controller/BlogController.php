<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    #[Route('/add', name: 'add_article')]
    public function addArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $article->setDatePublication(new \DateTime);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('list_articles');
        }

        return $this->render('blog/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'show_article')]

    public function showArticle($id)
    {
        $article = $this->doctrine->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Aucun article trouvé avec l\'id ' . $id
            );
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/list_articles', name: 'list_articles')]
    public function listeArticles(ArticleRepository $articleRepo)
    {
        $list_aticles = $articleRepo->findAll();

        $mavriable = "symfo c'est cool";

        return $this->render('blog/list_articles.html.twig', [
            'catalogue' => $list_aticles,
            'var' => $mavriable
        ]);
    }
    #[Route('/deletePost/{id}', name: 'deletePost')]
    public function delete(Article $article)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('list_articles');
    }
    #[Route('/modifPost/{id}', name: 'modifPost')]
    public function modifArticle(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('list_articles');
        }

        return $this->render('blog/modif.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

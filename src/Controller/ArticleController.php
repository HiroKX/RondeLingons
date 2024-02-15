<?php

namespace App\Controller;

use App\Dtalist\Type\ArticleDatalistType;
use App\Entity\Article;
use App\Entity\Type;
use App\Repository\ArticleRepository;
use App\Service\AlertServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Leapt\CoreBundle\Datalist\Datalist;
use Leapt\CoreBundle\Datalist\DatalistFactory;
use Leapt\CoreBundle\Datalist\Datasource\DoctrineORMDatasource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{

    public function __construct(private ArticleRepository $articleRepository,private AlertServiceInterface $alertService, private readonly DatalistFactory $datalistFactory, private EntityManagerInterface $entityManager){
    }

    /**
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function articles(Request $request): Response
    {
        return $this->render('article/index.html.twig',[
            'articles' => $this->getDatalist($request)
        ]);
    }

    private function getDatalist(Request $request): Datalist
    {
        $queryBuilder = $this->articleRepository->createQueryBuilder('n')
        ->orderBy('n.dateAdd', 'DESC');

        $datalist = $this->datalistFactory
            ->createBuilder(ArticleDatalistType::class, [
                'limit_per_page' => 10,
            ])
            ->getDatalist();

        $datalist->setRoute($request->attributes->get('_route'))
            ->setRouteParams($request->query->all());
        $datasource = new DoctrineORMDatasource($queryBuilder);
        $datalist->setDatasource($datasource);
        $datalist->bind($request);

        return $datalist;
    }


    /**
     * @param string $pathAttachmentArticle
     * @return Response
     */
    #[Route('/download/attachment/{filename}', name: 'article_download_attachment')]
    public function downloadAttachment(String $filename): Response
    {
        return $this->file('uploads/' . $filename);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @return Response
     * @throws ORMException
     */
    #[Route('/reglement', name: 'article_reg', methods: ['GET'])]
    public function reglement(): Response
    {
        return $this->showArticle(Type::CODE_REGLEMENT);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @return Response
     * @throws ORMException
     */
    #[Route('/engagement', name: 'article_eng', methods: ['GET'])]
    public function engagement(): Response
    {
        return $this->showArticle(Type::CODE_ENGAGEMENT);
    }

    /**
     * @param string $codeType
     * @param ArticleRepository $articleRepository
     * @return Response
     * @throws ORMException
     */
    private function showArticle(string $codeType): Response
    {
        $type = $this->entityManager->getReference(Type::class, $codeType);
        $article = $this->articleRepository->findOneBy(['type' => $type],['dateAdd'=>'DESC']);

        if (!$article) {
            $this->alertService->info(sprintf('Aucun article de type "%s". Vous avez été rediriger vers la page d\'accueil.', $type->getNom()));
            return $this->redirectToRoute('index');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @param Article $article
     * @return Response
     */
    #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

}

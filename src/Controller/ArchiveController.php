<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Repository\ArchiveRepository;
use App\Repository\ArticleRepository;
use App\Service\AlertServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/archive')]
class ArchiveController extends AbstractController
{

    private AlertServiceInterface $alertService;

    public function __construct(AlertServiceInterface $alertService){
        $this->alertService = $alertService;
    }

    /**
     * @param ArchiveRepository $achiveRepository
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/document', name: 'archive_doc', methods: ['GET'])]
    public function document(ArchiveRepository $achiveRepository,ArticleRepository $articleRepository): Response
    {
        $archive = $achiveRepository->findOneBy(['annee' => date('Y')]);
        if (!$archive) {
            $this->alertService->info('Aucune information pour cette année n\'a été trouvé pour le moment.');
            return $this->redirectToRoute('index');
        }
        $article = $articleRepository->findBy(['annee'=> $archive->getId()]);

        return $this->render('archive/show.html.twig', [
            'archive' => $archive,
            'articles' => $article
        ]);
    }

    /**
     * @param Archive $archive
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/{id}', name: 'archive_show', methods: ['GET'])]
    public function show(Archive $archive,ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findBy(['annee'=> $archive->getId()]);
        return $this->render('archive/show.html.twig', [
            'archive' => $archive,
            'articles' => $article
        ]);
    }


}

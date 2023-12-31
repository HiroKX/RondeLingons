<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Attachment;
use App\Form\ArticleType;
use App\Repository\ArchiveRepository;
use App\Repository\ArticleRepository;
use App\Repository\TypeRepository;
use App\Service\AlertServiceInterface;
use App\Service\FileUploadServiceInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;

/**
 * Created by HiroKX
 * 18/Jan/2022
 */
#[ROUTE('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{

    /**
     * @var FileUploadServiceInterface
     */
    private FileUploadServiceInterface $uploaderService;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var AlertServiceInterface
     */
    private AlertServiceInterface $alertService;

    /**
     * @param FileUploadServiceInterface $uploaderService
     * @param EntityManagerInterface $entityManager
     * @param AlertServiceInterface $alertService
     */
    public function __construct(FileUploadServiceInterface $uploaderService, EntityManagerInterface $entityManager, AlertServiceInterface $alertService){
        $this->entityManager = $entityManager;
        $this->alertService = $alertService;
        $this->uploaderService = $uploaderService;
    }

    /**
     * @return Response
     */
    #[ROUTE('/',name:'admin_index')]
    public function indexAdmin(): Response
    {
        return $this->render('admin/index.html.twig',[]);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[ROUTE('/articles',name:'admin_articles')]
    public function adminArticles(ArticleRepository $articleRepository):Response
    {

        return $this->render('admin/Articles.html.twig',[
            'articles' => $articleRepository->findBy([],['dateAdd' => 'DESC'])
        ]);
    }

    /**
     * @param ArchiveRepository $archiveRepository
     * @return Response
     */
    #[ROUTE('/archives',name:'admin_archives')]
    public function adminArchives(ArchiveRepository $archiveRepository):Response
    {
        return $this->render('admin/Archives.html.twig',[
            'archives' => $archiveRepository->findByDateDESC()
        ]);
    }

    /**
     * @param TypeRepository $typeRepository
     * @return Response
     */
    #[ROUTE('/types',name:'admin_types')]
    public function adminTypes(TypeRepository $typeRepository):Response
    {

        return $this->render('admin/Types.html.twig',[
            'types' => $typeRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    #[Route('/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadAttachment($form->get('files')->getData(), $article);
            $this->uploadImage($form->get('images')->getData(), $article);
            $this->uploadImageGallery($form->get('imagesGallery')->getData(), $article);
            $this->entityManager->flush();
            $this->alertService->success('Article modifié');

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/articles/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadAttachment($form->get('files')->getData(), $article);
            $this->uploadImage($form->get('images')->getData(), $article);
            $this->uploadImageGallery($form->get('imagesGallery')->getData(), $article);
            if(is_null($form->get('contenu')->getData())){
                $article->setContenu('<p></p>');
            }
            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->alertService->success('Article créer');

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    /**
     * @param Article $article
     * @param Attachment $attachment
     * @param Request $request
     * @return Response
     */
    #[Route('/article/delete/attachment/{article}/{attachment}', name: 'article_delete_attachment')]
    public function deleteAttachment(Article $article, Attachment $attachment, Request $request): Response
    {
        $article->removeAttachment($attachment);
        $this->entityManager->flush();
        $this->uploaderService->delete($attachment);


        $this->alertService->success('Fichier supprimer');

        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    #[Route('/article/delete/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $attachments = $article->getFiles();
            foreach ($attachments as $attachment) {
                $article->removeFile($attachment);
                $this->entityManager->persist($article);
                $this->entityManager->flush();
            }

            $images = $article->getImages();
            foreach ($images as $image) {
                $article->removeImage($image);
                $this->entityManager->persist($article);
                $this->entityManager->flush();
            }

            $imagesAttach = $article->getImagesGallery();
            foreach ($imagesAttach as $image) {
                $article->removeImagesGallery($image);
                $this->entityManager->persist($article);
                $this->entityManager->flush();
            }

            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }

        $this->alertService->success('Article supprimé');

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }




    /**
     * @param Collection $attachments
     * @param Article $article
     * @return void
     */
    private function uploadAttachment(Collection $attachments, Article $article): void
    {
        foreach ($attachments as $attachment) {
            /** @var UploadedFile $imageUploadedFile */
            $imageUploadedFile = $attachment->getFile();

            if ($imageUploadedFile) {
                $attachmentObject = $this->uploaderService->upload($attachment);
                $article->addFile($attachmentObject);
            }
        }
    }

    /**
     * @param array $images
     * @param Article $article
     * @return void
     */
    private function uploadImageGallery(array $images, Article $article): void
    {
        foreach ($images as $image) {
            $attachment = new Attachment();
            $attachment->setFile($image);

            $attachmentObject = $this->uploaderService->upload($attachment);
            $article->addImagesGallery($attachmentObject);
        }
    }

    /**
     * @param array $images
     * @param Article $article
     * @return void
     */
    private function uploadImage(array $images, Article $article): void
    {
        foreach ($images as $image) {
            $attachment = new Attachment();
            $attachment->setFile($image);

            $attachmentObject = $this->uploaderService->upload($attachment);
            $article->addImage($attachmentObject);
        }
    }

}
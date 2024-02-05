<?php

namespace App\Controller\Admin;

use App\Entity\Archive;
use App\Entity\Article;
use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator){}



    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirect($this->adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    #[Route('/admin/trix-upload', name: 'admin-trix',methods: 'POST')]
    public function upload(Request $request, ValidatorInterface $validator): Response
    {
        /** @var UploadedFile $file */
        $uploadedFile = $request->files->get('file');

        // Set up validation rules you need.
        $violations = $validator->validate($uploadedFile, [
            new NotBlank(),
            new File([
                'mimeTypes' => [
                    'image/*',
                    'application/pdf',
                ]
            ])]);

        // Send error message if any.
        if ($violations->count() > 0) {
            /** @var ConstraintViolation $violation */
            $violation = $violations[0];
            return new Response($violation->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();

        // Here you can create file entity and attach to post entity and so on.
        // As a simple example, just move file to public directory without saving to DB.
        $uploadedFile->move('uploads', $newFilename);

        return new Response('/' . 'uploadsDir' . '/' . $newFilename);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('NewRonde');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Articles','fa fa-article', Article::class);
        yield MenuItem::linkToCrud('Types d\'articles','fa fa-article', Type::class);
        yield MenuItem::linkToCrud('Archives','fa fa-article', Archive::class);
        yield MenuItem::linkToRoute('Revenir à l\'accueil','fa fa-article','index');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

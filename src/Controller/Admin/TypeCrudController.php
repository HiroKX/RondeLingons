<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeCrudController extends AbstractCrudController
{

    use NoDeleteAndDetail;
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Type d\'article')
            ->setEntityLabelInPlural('Types d\'article')
            ->setPageTitle(Crud::PAGE_INDEX,'Liste des %entity_label_plural%')
            ->setPageTitle(Crud::PAGE_NEW,'Créer un %entity_label_singular%')
            ->setPageTitle(Crud::PAGE_EDIT,'Modifier un %entity_label_singular%')
            ->setEntityPermission('ROLE_USER')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code'),
            TextField::new('nom'),
            ImageField::new('image')
                ->setFormTypeOptions([
                    "multiple" => false,
                    "attr" => [
                        "accept" => "image/x-png,image/pdg,image/jpeg"
                    ],
                ])
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern("[randomhash].[extension]"),
            ];
    }

}

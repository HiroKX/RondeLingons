<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\AttachmentType;
use App\Form\MultipleAttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\AssignOp\Mul;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['annee'=>'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('type','Type d\'article')->autocomplete(),
            AssociationField::new('annee','Edition')->setSortProperty('annee')->autocomplete(),
            TextField::new('titre'),
            TextField::new('utitre','Sous-titre'),
            TextEditorField::new('contenu','Contenu'),
            ImageField::new('files')
                ->setFormTypeOptions([
                    "multiple" => true,
                    "attr" => [
                        "accept" => "image/x-png,image/pdg,image/jpeg,application/pdf,application/zip,application/x-zip,application/x-zip-compressed,application/octet-stream"
                    ],
                ])
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern("/[timestamp]_[slug].[extension]"),
            ImageField::new('images')
                ->setFormTypeOptions([
                    "multiple" => true,
                    "attr" => [
                        "accept" => "image/x-png,image/gif,image/jpeg"
                    ],
                ])
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern("/[timestamp]_[slug].[extension]"),
            ImageField::new('imagesGallery')
                ->setFormTypeOptions([
                    "multiple" => true,
                    "attr" => [
                        "accept" => "image/x-png,image/gif,image/jpeg"
                    ],
                ])
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern("/[timestamp]_[slug].[extension]"),
        ];
    }

}

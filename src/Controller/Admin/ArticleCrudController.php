<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\AttachmentType;
use App\Form\MultipleAttachmentType;
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


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('type','Type d\'article'),
            AssociationField::new('annee','Edition'),
            TextField::new('files')->setFormType(AttachmentType::class)->onlyOnForms(),
            CollectionField::new('images')->setEntryType(MultipleAttachmentType::class)->onlyOnForms(),
            CollectionField::new('imagesGallery')->setEntryType(MultipleAttachmentType::class)->onlyOnForms(),
            TextField::new('titre'),
            TextField::new('utitre','Sous-titre'),
            TextEditorField::new('contenu','Contenu'),
        ];
    }

}

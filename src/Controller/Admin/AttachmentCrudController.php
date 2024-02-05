<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AttachmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Attachment::class;
    }




    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('originalFilename'),
            TextField::new('filename'),
            TextEditorField::new('taille'),
        ];
    }
}

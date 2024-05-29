<?php

namespace App\Controller\Admin;

use App\Entity\Archive;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArchiveCrudController extends AbstractCrudController
{

    use NoDetail;

    public static function getEntityFqcn(): string
    {
        return Archive::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['annee'=>'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('denom','Dénomination'),
            IntegerField::new('annee','Année'),
        ];
    }

}

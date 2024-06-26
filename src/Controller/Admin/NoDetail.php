<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

trait NoDetail
{
    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable(Action::DETAIL);
    }
}
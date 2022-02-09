<?php

namespace App\Controller\Admin;

use App\Entity\Complement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ComplementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Complement::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Livres;
use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('content'),
            DateTimeField::new('createdAt'),
            AssociationField::new('livre'),
            AssociationField::new('user'),
        ];
    }
}

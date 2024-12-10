<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            TextField::new('adress', 'Adresse'),
            TextField::new('ville', 'Ville'),
            TextField::new('tel', 'Téléphone'),
            EmailField::new('email', 'Email'),
            ArrayField::new('roles', 'Rôles')
                ->hideOnIndex(),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderAsBadges(),
            DateField::new('date_de_naissance', 'Date de naissance')->setFormat('d/M/Y'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['prenom', 'nom', 'email'])
            ->setDefaultSort(['nom' => 'ASC']);
    }
}

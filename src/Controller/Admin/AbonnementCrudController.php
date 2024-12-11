<?php

namespace App\Controller\Admin;

use App\Entity\Abonnement;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;


class AbonnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Abonnement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Abonnements')
            ->setEntityLabelInSingular('Abonnement')
            ->setDefaultSort(['type' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type', 'Type d\'Abonnement'),
            DateField::new('dateDebut', 'Date de Début'),
            DateField::new('dateFin', 'Date de Fin'),
            AssociationField::new('user', 'Utilisateur'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('type');
    }
}

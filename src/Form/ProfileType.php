<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', textType::class, ['label' => 'Prénom'])
            ->add('nom', textType::class, ['label' => 'Nom'])
            ->add('email', textType::class, ['label' => 'Email'])
            ->add('adress', textType::class, ['label' => 'Adresse'])
            ->add('ville', textType::class, ['label' => 'Ville'])
            ->add('dateDeNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text',
                'required' => false,
                ])
            ->add('tel', textType::class, ['label' => 'Téléphone'])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'required' => false, 
                'mapped' => false,   
            ])
            ->add('plainPasswordConfirm', PasswordType::class, [
                'label' => 'Confirmez le mot de passe',
                'required' => false,
                'mapped' => false, 
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Choississez votre avatar :',
                'mapped' => false, 
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

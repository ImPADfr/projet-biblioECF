<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            $plainPasswordConfirm = $form->get('plainPasswordConfirm')->getData();
            if ($plainPassword !== $plainPasswordConfirm) {
                $form->get('plainPasswordConfirm')->addError(
                    new \Symfony\Component\Form\FormError('Les mots de passe ne correspondent pas.')
                );
            } else {

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $user->setEmail($form->get('email')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setNom($form->get('nom')->getData());
            $user->setAdress($form->get('adress')->getData());
            $user->setVille($form->get('ville')->getData());
            $user->setDateDeNaissance($form->get('dateDeNaissance')->getData());
            $user->setTel($form->get('tel')->getData());
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}

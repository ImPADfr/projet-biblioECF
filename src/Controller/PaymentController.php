<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment_page')]
    public function payment(Request $request, ValidatorInterface $validator): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $paymentType = $request->request->get('paymentType');
            $errors = [];
            
            if ($paymentType === 'card') {
                $cardNumber = $request->request->get('cardNumber');
                $cardCvc = $request->request->get('cardCvc');
                $cardHolderName = $request->request->get('cardHolderName');

                // Validate fields
                $violations = $validator->validate($cardNumber, [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 16, 'max' => 16]),
                    new Assert\Regex(['pattern' => '/^\d+$/', 'message' => 'Numéro de carte invalide.']),
                ]);

                $violations->addAll($validator->validate($cardCvc, [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 3, 'max' => 3]),
                    new Assert\Regex(['pattern' => '/^\d+$/', 'message' => 'Cryptogramme invalide.']),
                ]));

                $violations->addAll($validator->validate($cardHolderName, [
                    new Assert\NotBlank(),
                    new Assert\EqualTo($user->getFullName(), 'Le nom sur la carte doit correspondre au nom de l\'utilisateur.'),
                ]));

                if (count($violations) > 0) {
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }
            } elseif ($paymentType === 'paypal') {
                $paypalEmail = $request->request->get('paypalEmail');

                $violations = $validator->validate($paypalEmail, [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\EqualTo($user->getEmail(), 'L\'email PayPal doit correspondre à votre email utilisateur.'),
                ]);

                if (count($violations) > 0) {
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }
            } else {
                $errors[] = 'Méthode de paiement invalide.';
            }

            if (empty($errors)) {
                $this->addFlash('success', 'Votre paiement a été effectué avec succès !');
                return $this->redirectToRoute('payment_confirmation');
            } else {
                $this->addFlash('error', implode('<br>', $errors));
            }
        }

        return $this->render('payment/index.html.twig');
    }

    #[Route('/payment/confirmation', name: 'payment_confirmation')]
    public function confirmation(): Response
    {
        return $this->render('payment/confirmation.html.twig');
    }
}

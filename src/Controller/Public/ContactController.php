<?php

namespace App\Controller\Public;

use App\Form\ContactType;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'public_contact_display')]
    public function display(Request $request, MailService $mailService): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($mailService->send($data['email'], 'tokiniaina.randriamanga@gmail.com', $data['subject'], $data['message'])) {
                $this->addFlash('success', 'Votre message a bien été envoyé !');
            } else {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre message');
            }
        }

        return $this->render('public/contact/display.html.twig', ['form' => $form->createView()]);
    }
}
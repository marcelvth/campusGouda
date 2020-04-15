<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            dump($contactFormData);

            $message = (new \Swift_Message($contactFormData['Onderwerp']))
                ->setFrom($contactFormData['Uw_Email'])
                ->setTo('je.email@gmail.com')
                ->setBody(
                    $contactFormData['Bericht']
                );

            $mailer->send($message);

            $this->addFlash('success', 'Mail has been sent');

            //return $this->redirectToRoute('contact');

            $form = $this->createForm(new ContactType(), $message);
        }

        return $this->render(
            'home/contact.html.twig',
            array('form' => $form)
        );


//        return $this->render('', [
//            'form' => $form->createView()
//        ]);
    }
}

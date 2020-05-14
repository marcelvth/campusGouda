<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
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

            $form = $this->createForm(new ContactType(), $form);
        }

        $post = $this->getDoctrine()->getRepository(Blog::class)->findBy([],['id'=>'DESC'],4,0);

        return $this->render('home/index.html.twig', [

                'controller_name' => 'HomeController',
                'form' => $form->createView(),
                'post' => $post

            ]
        );

    }
    /**
     * @Route("/viewpost/{id}")
     */
    public function viewpost($id){

        $post = $this->getDoctrine()->getRepository(Blog::class)->find($id);

        return $this->render("home/viewpost.html.twig",[

            'post' => $post
        ]);
    }

//    /**
//     * @Route("/contact", name="contact")
//     */
//    public function contact(Request $request, \Swift_Mailer $mailer)
//    {
//        $form = $this->createForm(ContactType::class);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $contactFormData = $form->getData();
//
//            dump($contactFormData);
//
//            $message = (new \Swift_Message($contactFormData['Onderwerp']))
//                ->setFrom($contactFormData['Uw_Email'])
//                ->setTo('je.email@gmail.com')
//                ->setBody(
//                    $contactFormData['Bericht']
//                );
//
//            $mailer->send($message);
//
//            $this->addFlash('success', 'Mail has been sent');
//
//            //return $this->redirectToRoute('contact');
//
//            $form = $this->createForm(new ContactType(), $form);
//        }
//
//        return $this->render(
//            'home/index.html.twig',
//            array('form' => $form)
//        );
//
//
////        return $this->render('', [
////            'form' => $form->createView()
////        ]);
//    }
}

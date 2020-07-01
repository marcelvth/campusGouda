<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Letter;
use App\Entity\Read;
use App\Form\ContactType;
use App\Entity\Blog;
use App\Form\LetterType;
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

        $letter = new Letter();
        $lform = $this->createForm(LetterType::class, $letter);
        $lform->handleRequest($request);

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($lform->isSubmitted() && $lform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ltr = $entityManager->getRepository('App:Letter')->findBy(['email' => $lform->getViewData()->getEmail()]);
            if ($ltr) {
                $this->addFlash('notice', 'Reeds eerder al aangemeld voor nieuwsbrief!');

                return $this->redirectToRoute('home');

            }

            $letter->setMoment(new \DateTime('now'));
            $letter->setIp($this->container->get('request_stack')->getCurrentRequest()->getClientIp());
            $entityManager->persist($letter);
            $entityManager->flush();

            $message = (new \Swift_Message('Aanmelding Campus Gouda Nieuwsbrief!'))
                ->setFrom('info@campusgouda.nl')
                ->setTo($lform->getViewData()->getEmail())
                ->setCc('info@campusgouda.nl')
                ->setBody(
                    'U heeft zich aangemeld bij Nieuwsbrief Campus Gouda met email adres : '.$lform->getViewData()->getEmail()
                );

            $mailer->send($message);

            $this->addFlash('notice', 'Aangemeld voor nieuwsbrief!');

            return $this->redirectToRoute('home');

        }

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            //dump($contactFormData);

            $message = (new \Swift_Message($contactFormData['Onderwerp']))
                ->setFrom($contactFormData['Uw_Email'])
                ->setTo('info@campusgouda.nl')
                ->setBody(
                    $contactFormData['Bericht']
                );

            $mailer->send($message);

            $this->addFlash('success', 'Mail is verzonden');

            return $this->redirectToRoute('home');

            //$form = $this->createForm(new ContactType(), $form);
        }

        $posts = $this->getDoctrine()->getRepository(Blog::class)->findBy(['front' => true], ['id'=>'DESC'],4,0);
//        foreach ($posts as $post) {
//            $post->setBody(substr($post->getBody(),0, strpos(wordwrap($post->getBody(), 300), "\n" )).'......');
//        }
        $reads = $this->getDoctrine()->getRepository(Read::class)->findAll();
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $dir    = './img/sponsors';
        $array_files = scandir($dir);

        return $this->render('home/index.html.twig', [

                'controller_name' => 'HomeController',
                'form' => $form->createView(),
                'lform' => $lform->createView(),
                'posts' => $posts,
                'reads' => $reads,
                'items' => $items,
                'array_files' => $array_files,

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

    /**
     * @Route("/privacy-statement", name="privacy_statement")
     */
    public function privacy()
    {
        return $this->render('home/privacy.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/terms-of-service", name="terms_service")
     */
    public function terms()
    {
        return $this->render('home/terms.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

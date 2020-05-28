<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Form\LetterType;
use App\Repository\LetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/letter")
 */
class LetterController extends AbstractController
{
    /**
     * @Route("/", name="letter_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(LetterRepository $letterRepository): Response
    {
        return $this->render('letter/index.html.twig', [
            'letters' => $letterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/export", name="letter_export", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function export(LetterRepository $letterRepository): Response
    {
        return $this->render('letter/index.html.twig', [
            'letters' => $letterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="letter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $letter = new Letter();
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($letter);
            $entityManager->flush();

            return $this->redirectToRoute('letter_index');
        }

        return $this->render('letter/new.html.twig', [
            'letter' => $letter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="letter_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Letter $letter): Response
    {
        return $this->render('letter/show.html.twig', [
            'letter' => $letter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="letter_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Letter $letter): Response
    {
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('letter_index');
        }

        return $this->render('letter/edit.html.twig', [
            'letter' => $letter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="letter_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Letter $letter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$letter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($letter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('letter_index');
    }
}

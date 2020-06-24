<?php

namespace App\Controller;

use App\Entity\Read;
use App\Form\ReadType;
use App\Repository\ReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/read")
 * @IsGranted("ROLE_USER")
 */
class ReadController extends AbstractController
{
    /**
     * @Route("/", name="read_index", methods={"GET"})
     */
    public function index(ReadRepository $readRepository): Response
    {
        return $this->render('read/index.html.twig', [
            'reads' => $readRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="read_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $read = new Read();
        $form = $this->createForm(ReadType::class, $read);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($read);
            $entityManager->flush();

            return $this->redirectToRoute('read_index');
        }

        return $this->render('read/new.html.twig', [
            'read' => $read,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read_show", methods={"GET"})
     */
    public function show(Read $read): Response
    {
        return $this->render('read/show.html.twig', [
            'read' => $read,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="read_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Read $read): Response
    {
        $form = $this->createForm(ReadType::class, $read);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('read/edit.html.twig', [
            'read' => $read,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Read $read): Response
    {
        if ($this->isCsrfTokenValid('delete'.$read->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($read);
            $entityManager->flush();
        }

        return $this->redirectToRoute('read_index');
    }
}

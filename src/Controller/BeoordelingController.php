<?php

namespace App\Controller;

use App\Entity\Beoordeling;
use App\Form\BeoordelingType;
use App\Repository\BeoordelingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/beoordeling")
 */
class BeoordelingController extends AbstractController
{
    /**
     * @Route("/", name="beoordeling_index", methods={"GET"})
     */
    public function index(BeoordelingRepository $beoordelingRepository): Response
    {
        return $this->render('beoordeling/index.html.twig', [
            'beoordelings' => $beoordelingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="beoordeling_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $beoordeling = new Beoordeling();
        $form = $this->createForm(BeoordelingType::class, $beoordeling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($beoordeling);
            $entityManager->flush();

            return $this->redirectToRoute('beoordeling_index');
        }

        return $this->render('beoordeling/new.html.twig', [
            'beoordeling' => $beoordeling,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="beoordeling_show", methods={"GET"})
     */
    public function show(Beoordeling $beoordeling): Response
    {
        return $this->render('beoordeling/show.html.twig', [
            'beoordeling' => $beoordeling,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="beoordeling_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Beoordeling $beoordeling): Response
    {
        $form = $this->createForm(BeoordelingType::class, $beoordeling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('beoordeling_index');
        }

        return $this->render('beoordeling/edit.html.twig', [
            'beoordeling' => $beoordeling,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="beoordeling_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Beoordeling $beoordeling): Response
    {
        if ($this->isCsrfTokenValid('delete'.$beoordeling->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($beoordeling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('beoordeling_index');
    }
}

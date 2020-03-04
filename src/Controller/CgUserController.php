<?php

namespace App\Controller;

use App\Entity\CgUser;
use App\Form\CgUserType;
use App\Repository\CgUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cg/user")
 */
class CgUserController extends AbstractController
{
    /**
     * @Route("/", name="cg_user_index", methods={"GET"})
     */
    public function index(CgUserRepository $cgUserRepository): Response
    {
        return $this->render('cg_user/index.html.twig', [
            'cg_users' => $cgUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cg_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cgUser = new CgUser();
        $form = $this->createForm(CgUserType::class, $cgUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cgUser);
            $entityManager->flush();

            return $this->redirectToRoute('cg_user_index');
        }

        return $this->render('cg_user/new.html.twig', [
            'cg_user' => $cgUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cg_user_show", methods={"GET"})
     */
    public function show(CgUser $cgUser): Response
    {
        return $this->render('cg_user/show.html.twig', [
            'cg_user' => $cgUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cg_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CgUser $cgUser): Response
    {
        $form = $this->createForm(CgUserType::class, $cgUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cg_user_index');
        }

        return $this->render('cg_user/edit.html.twig', [
            'cg_user' => $cgUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cg_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CgUser $cgUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cgUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cgUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cg_user_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilClientType;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use App\Services\ProfilServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="app_profil_index", methods={"GET"})
     */
    public function index(ProfilRepository $profilRepository): Response
    {
        return $this->render('profil/index.html.twig', [
            'profils' => $profilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_profil_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProfilRepository $profilRepository): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profilRepository->add($profil, true);

            return $this->redirectToRoute('app_profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit", name="app_profil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProfilRepository $profilRepository, ProfilServices $profilServices): Response
    {
        $profil = $profilServices->recupererProfil();
        $client = null;
        if (!$profil) {
            return $this->redirectToRoute('app_login');
        } else {
            $client = $profil;
            $profil = $profil->getUserProfil();
        }


        $form = $this->createForm(ProfilClientType::class, [
            'profil' => $profil,
            'client' => $client,
            'user' => $profil->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profilRepository->add($profil, true);
            $this->addFlash("success", "Profil mis ?? jour.");
            return $this->redirectToRoute('app_main_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="app_profil_show", methods={"GET"})
     */
    public function show(Profil $profil): Response
    {
        return $this->render('profil/show.html.twig', [
            'profil' => $profil,
        ]);
    }

    /**
     * @Route("/{id}", name="app_profil_delete", methods={"POST"})
     */
    public function delete(Request $request, Profil $profil, ProfilRepository $profilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getId(), $request->request->get('_token'))) {
            $profilRepository->remove($profil, true);
        }

        return $this->redirectToRoute('app_profil_index', [], Response::HTTP_SEE_OTHER);
    }
}

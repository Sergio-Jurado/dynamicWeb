<?php

namespace App\Controller;

use App\Entity\Pagina;
use App\Form\PaginaType;
use App\Repository\PaginaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pagina')]
class PaginaController extends AbstractController
{
    #[Route('/', name: 'app_pagina_index', methods: ['GET'])]
    public function index(PaginaRepository $paginaRepository): Response
    {
        return $this->render('pagina/index.html.twig', [
            'paginas' => $paginaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pagina_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pagina = new Pagina();
        $form = $this->createForm(PaginaType::class, $pagina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pagina);
            $entityManager->flush();

            return $this->redirectToRoute('app_pagina_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pagina/new.html.twig', [
            'pagina' => $pagina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pagina_show', methods: ['GET'])]
    public function show(Pagina $pagina): Response
    {
        return $this->render('pagina/show.html.twig', [
            'pagina' => $pagina,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pagina_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pagina $pagina, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaginaType::class, $pagina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pagina_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pagina/edit.html.twig', [
            'pagina' => $pagina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pagina_delete', methods: ['POST'])]
    public function delete(Request $request, Pagina $pagina, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pagina->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pagina);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pagina_index', [], Response::HTTP_SEE_OTHER);
    }
}

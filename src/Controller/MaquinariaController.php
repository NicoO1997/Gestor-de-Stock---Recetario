<?php

namespace App\Controller;

use App\Entity\Maquinaria;
use App\Form\MaquinariaType;
use App\Repository\MaquinariaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/maquinaria')]
class MaquinariaController extends AbstractController
{
    #[Route('/', name: 'maquinaria_index', methods: ['GET'])]
    public function index(MaquinariaRepository $maquinariaRepository): Response
    {
        $maquinarias = $maquinariaRepository->findAll();

        return $this->render('view_catalog/view_catalog.html.twig', [
            'maquinarias' => $maquinarias,
        ]);
    }

    #[Route('/new', name: 'maquinaria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maquinaria = new Maquinaria();
        $form = $this->createForm(MaquinariaType::class, $maquinaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $uploadDir = $this->getParameter('images_directory');

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imagenFilename = uniqid() . '.' . $imagen->guessExtension();
                $imagen->move($uploadDir, $imagenFilename);
                $maquinaria->setImagen($imagenFilename);
            }

            $entityManager->persist($maquinaria);
            $entityManager->flush();

            $this->addFlash('success', 'Maquinaria agregada con éxito.');
            return $this->redirectToRoute('maquinaria_index');
        }

        return $this->render('Maquinarias/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'maquinaria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maquinaria $maquinaria, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaquinariaType::class, $maquinaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $uploadDir = $this->getParameter('images_directory');

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imagenFilename = uniqid() . '.' . $imagen->guessExtension();
                $imagen->move($uploadDir, $imagenFilename);
                $maquinaria->setImagen($imagenFilename);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Maquinaria editada con éxito.');
            return $this->redirectToRoute('maquinaria_index');
        }

        return $this->render('Maquinarias/edit.html.twig', [
            'form' => $form->createView(),
            'maquinaria' => $maquinaria,
        ]);
    }   

    #[Route('/{id}/delete', name: 'maquinaria_delete', methods: ['POST'])]
    public function delete(Request $request, Maquinaria $maquinaria, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($maquinaria);
            $entityManager->flush();
            $this->addFlash('success', 'Maquinaria eliminada correctamente');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error al eliminar la maquinaria');
        }

        return $this->redirectToRoute('maquinaria_index');
    }
}
<?php

namespace App\Controller;

use App\Entity\Repuestos;
use App\Repository\RepuestosRepository;
use App\Repository\RecetaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/repuestos')]
class RepuestoController extends AbstractController
{
    #[Route('/', name: 'repuestos_index', methods: ['GET'])]
    public function index(RepuestosRepository $repuestosRepository): Response
    {
        return $this->render('repuestos/add_repuestos.html.twig', [
            'repuestos' => $repuestosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'repuestos_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('repuestos/add_repuestos.html.twig');  
    }

    #[Route('/create', name: 'repuestos_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
    $nombre = trim($request->request->get('nombre', ''));
    $descripcion = trim($request->request->get('descripcion', ''));
    $cantidad = $request->request->get('cantidad');
    $stockMinimo = $request->request->get('stock_minimo');

    if (empty($nombre) || strlen($nombre) > 255) {
        $this->addFlash('error', 'Nombre inválido. Debe tener entre 1 y 255 caracteres.');
        return $this->redirectToRoute('repuestos_new');
    }

    if (empty($descripcion)) {
        $this->addFlash('error', 'La descripción es obligatoria.');
        return $this->redirectToRoute('repuestos_new');
    }

    $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    $stockMinimo = filter_var($stockMinimo, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    if ($cantidad === false || $stockMinimo === false) {
        $this->addFlash('error', 'Cantidad y stock mínimo deben ser números no negativos.');
        return $this->redirectToRoute('repuestos_new');
    }

    try {
        $repuesto = new Repuestos();
        $repuesto->setNombre($nombre);
        $repuesto->setDescripcion($descripcion);
        $repuesto->setCantidad($cantidad);
        $repuesto->setStockMinimo($stockMinimo);

        $entityManager->persist($repuesto);
        $entityManager->flush();

        $this->addFlash('repuesto_success', 'Repuesto agregado correctamente.');
        return $this->redirectToRoute('app_view_stock');  // Updated redirection
    } catch (\Exception $e) {
        $this->addFlash('error', 'Error al guardar el repuesto: ' . $e->getMessage());
        return $this->redirectToRoute('repuestos_new');
    }
    }


    #[Route('/{id<\d+>}', name: 'repuestos_show', methods: ['GET'])]
    public function show(RepuestosRepository $repuestosRepository, int $id): Response
    {
        $repuesto = $repuestosRepository->find($id);

        if (!$repuesto) {
            throw $this->createNotFoundException('Repuesto no encontrado.');
        }

        return $this->render('repuestos/show.html.twig', [
            'repuesto' => $repuesto,
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'repuestos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Repuestos $repuesto, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $nombre = $request->request->get('nombre');
            $descripcion = $request->request->get('descripcion');
            $cantidad = (int)$request->request->get('cantidad');

            $repuesto->setNombre($nombre);
            $repuesto->setDescripcion($descripcion);
            $repuesto->setCantidad($cantidad);

            $entityManager->flush();

            return $this->redirectToRoute('repuestos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('repuestos/edit.html.twig', [
            'repuesto' => $repuesto,
        ]);
    }

    #[Route('/{id}/delete', name: 'repuesto_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Repuestos $repuesto,
        RecetaRepository $recetaRepository,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $repuesto->getId(), $request->request->get('_token'))) {

            $recetasConRepuesto = $recetaRepository->findByRepuesto($repuesto);

            foreach ($recetasConRepuesto as $receta) {
                $entityManager->remove($receta);
            }

            $entityManager->remove($repuesto);
            $entityManager->flush();

            $this->addFlash('success', 'Repuesto y sus recetas asociadas eliminados con éxito.');
        }

        return $this->redirectToRoute('repuesto_index');
    }
}
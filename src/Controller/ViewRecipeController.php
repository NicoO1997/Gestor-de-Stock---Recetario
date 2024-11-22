<?php

namespace App\Controller;

use App\Entity\Receta;
use App\Entity\RecetaRepuesto;
use App\Form\RecetaType;
use App\Repository\RecetaRepository;
use App\Repository\MaquinariaRepository;
use App\Repository\RepuestosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/receta')]
class ViewRecipeController extends AbstractController
{
    #[Route('/', name: 'receta_index', methods: ['GET'])]
    public function index(RecetaRepository $recetaRepository): Response
    {
        return $this->render('view_recipe/view_recipe.html.twig', [
            'recetas' => $recetaRepository->findAll(),
        ]);
    }

    #[Route('/repuestos-list', name: 'repuestos_list', methods: ['GET'])]
    public function getRepuestosList(RepuestosRepository $repuestosRepository): JsonResponse
    {
        $repuestos = $repuestosRepository->findAll();
        
        $repuestosData = array_map(function($repuesto) {
            return [
                'id' => $repuesto->getId(),
                'nombre' => $repuesto->getNombre(),
                'stock' => $repuesto->getCantidad()
            ];
        }, $repuestos);

        return new JsonResponse($repuestosData);
    }

    #[Route('/new', name: 'receta_new', methods: ['GET', 'POST'])]
    public function nueva(
        Request $request,
        EntityManagerInterface $entityManager,
        MaquinariaRepository $maquinariaRepository,
        RepuestosRepository $repuestosRepository
    ): Response {
        $receta = new Receta();
        $form = $this->createForm(RecetaType::class, $receta);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $repuestosSeleccionados = $request->request->all('repuestos_selected');
            $repuestosCantidad = $request->request->all('repuestos_cantidad');
    
            foreach ($repuestosSeleccionados as $repuestoId => $value) {
                $repuesto = $repuestosRepository->find($repuestoId);
                if ($repuesto) {
                    $cantidad = isset($repuestosCantidad[$repuestoId]) ? 
                               (int)$repuestosCantidad[$repuestoId] : 1;
                               
                    $receta->addRepuestoConCantidad($repuesto, $cantidad);
                }
            }
    
            $entityManager->persist($receta);
            $entityManager->flush();
    
            $this->addFlash('receta_success', 'Receta creada con éxito.');
            return $this->redirectToRoute('receta_index');
        }
    
        return $this->render('view_recipe/create_recipe.html.twig', [
            'form' => $form->createView(),
            'maquinarias' => $maquinariaRepository->findAll(),
            'repuestos' => $repuestosRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'receta_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Receta $receta, 
        EntityManagerInterface $entityManager,
        MaquinariaRepository $maquinariaRepository, 
        RepuestosRepository $repuestosRepository
    ): Response {
        $form = $this->createForm(RecetaType::class, $receta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $receta->getMaquinarias()->clear(); 
            $maquinariasSeleccionadas = $request->request->all('maquinarias');
            foreach ($maquinariasSeleccionadas as $maquinariaId) {
                $maquinaria = $maquinariaRepository->find($maquinariaId);
                if ($maquinaria) {
                    $receta->addMaquinaria($maquinaria);
                }
            }

            $receta->getRepuestos()->clear();
            $repuestosSeleccionados = $request->request->all('repuestos');
            foreach ($repuestosSeleccionados as $repuestoId) {
                $repuesto = $repuestosRepository->find($repuestoId);
                if ($repuesto) {
                    if ($repuesto->getCantidad() > 0) {
                        $repuesto->setCantidad($repuesto->getCantidad() - 1);
                        $receta->addRepuesto($repuesto);

                        if ($repuesto->necesitaReabastecimiento()) {
                            $this->addFlash('warning', 'El repuesto ' . $repuesto->getNombre() . ' necesita reabastecimiento.');
                        }
                    } else {
                        $this->addFlash('danger', 'No hay suficiente stock del repuesto ' . $repuesto->getNombre() . '.');
                        return $this->redirectToRoute('receta_edit', ['id' => $receta->getId()]);
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Receta actualizada con éxito.');
            return $this->redirectToRoute('receta_index');
        }

        return $this->render('receta/edit.html.twig', [
            'receta' => $receta,
            'form' => $form->createView(),
            'maquinarias' => $maquinariaRepository->findAll(),
            'repuestos' => $repuestosRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'receta_show', methods: ['GET'])]
    public function show(Receta $receta): Response
    {
        return $this->render('receta/show.html.twig', [
            'receta' => $receta,
        ]);
    }

    #[Route('/receta/delete/{id}', name: 'receta_delete', methods: ['POST'])]
    public function delete(Request $request, Receta $receta, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $receta->getId(), $request->request->get('_token'))) {
            $entityManager->remove($receta);
            $entityManager->flush();
        }

        return $this->redirectToRoute('receta_index');
    }

    #[Route('/{id}/update', name: 'receta_update', methods: ['POST', 'OPTIONS'])]
    public function update(
        Request $request, 
        int $id,
        RecetaRepository $recetaRepository,
        EntityManagerInterface $entityManager,
        RepuestosRepository $repuestosRepository
    ): JsonResponse {
        $receta = $recetaRepository->find($id);
        
        if (!$receta) {
            return new JsonResponse(['success' => false, 'message' => 'Receta no encontrada'], 404);
        }

        $submittedToken = $request->headers->get('X-CSRF-TOKEN');
        if (!$this->isCsrfTokenValid('update' . $receta->getId(), $submittedToken)) {
            return new JsonResponse(['success' => false, 'message' => 'Token CSRF inválido'], 403);
        }

        try {
            $data = json_decode($request->getContent(), true);
            if ($data === null) {
                throw new \Exception('JSON inválido');
            }

            $receta->setNombre($data['nombre'] ?? $receta->getNombre());
            $receta->setDescripcion($data['descripcion'] ?? $receta->getDescripcion());

            foreach ($receta->getRecetaRepuestos() as $recetaRepuesto) {
                $entityManager->remove($recetaRepuesto);
            }

            if (isset($data['repuestos']) && is_array($data['repuestos'])) {
                foreach ($data['repuestos'] as $repuestoData) {
                    if (isset($repuestoData['repuestoId'], $repuestoData['cantidad'])) {
                        $repuesto = $repuestosRepository->find($repuestoData['repuestoId']);
                        if ($repuesto) {
                            $recetaRepuesto = new RecetaRepuesto();
                            $recetaRepuesto->setReceta($receta);
                            $recetaRepuesto->setRepuesto($repuesto);
                            $recetaRepuesto->setCantidad($repuestoData['cantidad']);
                            $entityManager->persist($recetaRepuesto);
                        }
                    }
                }
            }

            $entityManager->flush();
            
            return new JsonResponse([
                'success' => true,
                'message' => 'Receta actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Error al actualizar la receta: ' . $e->getMessage()
            ], 500);
        }
    }
}
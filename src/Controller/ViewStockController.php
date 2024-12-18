<?php

namespace App\Controller;

use App\Entity\Repuestos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewStockController extends AbstractController
{
    #[Route('/view-stock', name: 'app_view_stock')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repuestos = $entityManager->getRepository(Repuestos::class)->findAll();
        $repuestosBajoStock = [];

        foreach ($repuestos as $repuesto) {
            if ($repuesto->getCantidad() <= $repuesto->getStockMinimo()) {
                $repuestosBajoStock[] = $repuesto;
            }
        }

        return $this->render('view_stock/view_stock.html.twig', [
            'repuestos' => $repuestos,
            'repuestosBajoStock' => $repuestosBajoStock,
        ]);
    }

    #[Route('/repuestos/new', name: 'repuestos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repuesto = new Repuestos();
        $repuesto->setNombre($request->request->get('nombre'));
        $repuesto->setCantidad((int) $request->request->get('cantidad'));
        $repuesto->setDescripcion($request->request->get('descripcion'));
        $repuesto->setStockMinimo((int) $request->request->get('stock_minimo'));

        $entityManager->persist($repuesto);
        $entityManager->flush();

        return $this->redirectToRoute('app_view_stock');
    }

    #[Route('/repuestos/edit/{id}', name: 'repuestos_edit', methods: ['POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $repuesto = $entityManager->getRepository(Repuestos::class)->find($id);
        
        if (!$repuesto) {
            throw $this->createNotFoundException('No se encontró el repuesto');
        }
        
        if (!$this->isCsrfTokenValid('edit'.$id, $request->request->get('_token'))) {
            return $this->json(['message' => 'Token inválido'], Response::HTTP_FORBIDDEN);
        }
        
        try {
            $originalNombre = $repuesto->getNombre();
            $originalCantidad = $repuesto->getCantidad();
            $originalStockMinimo = $repuesto->getStockMinimo();
            $originalDescripcion = $repuesto->getDescripcion();
            $newNombre = trim($request->request->get('nombre'));
            $newCantidad = (int) $request->request->get('cantidad');
            $newStockMinimo = (int) $request->request->get('stockMinimo');
            $newDescripcion = trim($request->request->get('descripcion'));
            
            if (empty($newNombre)) {
                return $this->json(['message' => 'El nombre no puede estar vacío'], Response::HTTP_BAD_REQUEST);
            }
            
            if (empty($newDescripcion)) {
                return $this->json(['message' => 'La descripción no puede estar vacía'], Response::HTTP_BAD_REQUEST);
            }
            
            if ($newCantidad < 0) {
                return $this->json(['message' => 'La cantidad admite cero o positivos'], Response::HTTP_BAD_REQUEST);
            }
            
            if ($newStockMinimo < 0) {
                return $this->json(['message' => 'El stock mínimo admite cero o positivos'], Response::HTTP_BAD_REQUEST);
            }
            
            if (
                $originalNombre === $newNombre && 
                $originalCantidad === $newCantidad && 
                $originalStockMinimo === $newStockMinimo && 
                $originalDescripcion === $newDescripcion
            ) {
                return $this->json(['message' => 'No se han detectado cambios'], Response::HTTP_OK);
            }
            
            $repuesto->setNombre($newNombre);
            $repuesto->setCantidad($newCantidad);
            $repuesto->setStockMinimo($newStockMinimo);
            $repuesto->setDescripcion($newDescripcion);
            
            $entityManager->flush();
            
            return $this->json(['message' => 'Cambios guardados correctamente']);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/repuestos/delete/{id}', name: 'repuestos_delete', methods: ['POST', 'DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Repuestos $repuesto): Response
    {
        $entityManager->remove($repuesto);
        $entityManager->flush();

        return $this->redirectToRoute('app_view_stock');
    }
}

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
            $repuesto->setNombre($request->request->get('nombre'));
            $repuesto->setCantidad((int) $request->request->get('cantidad'));
            $repuesto->setStockMinimo((int) $request->request->get('stockMinimo'));
            $repuesto->setDescripcion($request->request->get('descripcion'));

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
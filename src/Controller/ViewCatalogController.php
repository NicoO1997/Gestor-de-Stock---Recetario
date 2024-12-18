<?php

namespace App\Controller;

use App\Entity\Maquinaria;
use App\Repository\MaquinariaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ViewCatalogController extends AbstractController
{
    #[Route('/view-catalog', name: 'app_view_catalog')]
    public function viewCatalog(MaquinariaRepository $maquinariaRepository): Response
    {
        $maquinarias = $maquinariaRepository->findAll();

        foreach ($maquinarias as $maquinaria) {
            if ($maquinaria->getImagen()) {
                $imagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/images/' . $maquinaria->getImagen();
                if (file_exists($imagePath)) {
                    $timestamp = filemtime($imagePath);
                    $maquinaria->setImagen($maquinaria->getImagen() . '?v=' . $timestamp);
                }
            }
        }

        return $this->render('view_catalog/view_catalog.html.twig', [
            'maquinarias' => $maquinarias,
        ]);
    }

    #[Route('/maquinaria/edit/{id}', name: 'maquinaria_edit', methods: ['POST'])]
    public function edit(Request $request, Maquinaria $maquinaria, EntityManagerInterface $entityManager): JsonResponse
    {
        $submittedToken = $request->headers->get('X-CSRF-TOKEN');

        if (!$this->isCsrfTokenValid('edit' . $maquinaria->getId(), $submittedToken)) {
            return new JsonResponse(['error' => 'Token CSRF inválido'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $changed = false;

        if (isset($data['nombre']) && $data['nombre'] !== $maquinaria->getNombre()) {
            $maquinaria->setNombre($data['nombre']);
            $changed = true;
        }

        if (isset($data['marca']) && $data['marca'] !== $maquinaria->getMarca()) {
            $maquinaria->setMarca($data['marca']);
            $changed = true;
        }

        if (isset($data['cantidad']) && (int)$data['cantidad'] !== $maquinaria->getCantidad()) {
            $maquinaria->setCantidad((int)$data['cantidad']);
            $changed = true;
        }

        if (isset($data['aniosUso']) && 
        (($data['aniosUso'] === null && $maquinaria->getAniosUso() !== null) || 
        ($data['aniosUso'] !== null && $maquinaria->getAniosUso() !== $data['aniosUso']))) {
        $maquinaria->setAniosUso($data['aniosUso']);
        $changed = true;
        }

        if (isset($data['descripcion']) && $data['descripcion'] !== $maquinaria->getDescripcion()) {
            $maquinaria->setDescripcion($data['descripcion']);
            $changed = true;
        }

        if (isset($data['ultimoService']) && $data['ultimoService'] !== $maquinaria->getUltimoService()?->format('Y-m-d')) {
            $maquinaria->setUltimoService(new \DateTime($data['ultimoService']));
            $changed = true;
        }

        if (isset($data['imagen']) && $data['imagen'] !== '') {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['imagen']));
            $extension = $this->getImageExtension($data['imagen']);
            $filename = uniqid() . '.' . $extension;

            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/images/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (file_put_contents($uploadDir . $filename, $imageData)) {
                if ($maquinaria->getImagen()) {
                    $oldFile = $uploadDir . preg_replace('/\?v=\d+$/', '', $maquinaria->getImagen());
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $timestamp = time();
                $maquinaria->setImagen($filename . '?v=' . $timestamp);
                $changed = true;
            }
        }

        if (!$changed) {
            return new JsonResponse(['message' => 'No se han detectado cambios'], 200);
        }

        try {
            $entityManager->flush();
            return new JsonResponse([
                'message' => 'Maquinaria actualizada correctamente',
                'data' => [
                    'nombre' => $maquinaria->getNombre(),
                    'marca' => $maquinaria->getMarca(),
                    'cantidad' => $maquinaria->getCantidad(),
                    'aniosUso' => $maquinaria->getAniosUso(),
                    'descripcion' => $maquinaria->getDescripcion(),
                    'ultimoService' => $maquinaria->getUltimoService() ? $maquinaria->getUltimoService()->format('Y-m-d') : null,
                    'imagen' => $maquinaria->getImagen() ? '/uploads/images/' . $maquinaria->getImagen() : null
                ]
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al actualizar la maquinaria: ' . $e->getMessage()], 500);
        }
    }

    private function getImageExtension(string $base64Image): string
    {
        $matches = [];
        preg_match('#^data:image/(\w+);base64,#i', $base64Image, $matches);
        return $matches[1] ?? 'jpg';
    }

    #[Route('/maquinaria/delete/{id}', name: 'maquinaria_delete', methods: ['POST'])]
    public function delete(Request $request, Maquinaria $maquinaria, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $maquinaria->getId(), $request->request->get('_token'))) {
            if ($maquinaria->getImagen()) {
                $imagePath = $this->getParameter('kernel.project_dir') . '/public/assets/images/' . 
                            preg_replace('/\?v=\d+$/', '', $maquinaria->getImagen());
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $entityManager->remove($maquinaria);
            $entityManager->flush();
            return $this->redirectToRoute('maquinaria_index');
        }

        return new JsonResponse(['error' => 'Token inválido'], 403);
    }
}
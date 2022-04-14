<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DisciplinesController extends AbstractController
{
    #[Route('/search/disciplines', name: 'disciplines')]
    public function index(Request $request, DisciplineRepository $disciplineRepository)
    {
        return $this->json($disciplineRepository->search($request->query->get('q')));
    }
}
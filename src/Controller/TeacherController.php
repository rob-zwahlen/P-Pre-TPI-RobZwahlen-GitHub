<?php

namespace App\Controller;

use Exception;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    /**
     * @var string $view Correspond à la vue renvoyée sous format "Twig".
     */

    public $view;

    /**
     * @var string $description Correspond à la métadonnée de description.
     */

    public $description;

    /**
     * @var string $title Correspond au titre de l'en-tête.
     */
    
    public $title;

    /**
     * @var array $arguments Correspond au tableau des données supplémentaires renvoyées à la vue.
     */

    public $arguments;

    /**
     * @var int ITEMS_PER_PAGE Correpond au nombre d'éléments visibles sur la page avec KNP.
     */

    public const ITEMS_PER_PAGE = 20;

    /**
     * @param string $view chemin vers le template "twig".
     * @param string $description description générale de la page.
     * @param string $title titre d'en-tête de la page.
     * @param array $arguments tableau contenant les arguments supplémentaires.
     * @return Response
     */

    private function getResponse(string $view, string $description, string $title, $arguments): Response 
    {
        $this->view = $view;
        $this->description = $description;
        $this->title = $title;
        $this->arguments = $arguments;

        $meta = array(
            'meta' => [
                'author' => 'Robin Zwahlen',
                'keywords' => 'ETML, Surnom des enseignants, P_PA',
                'description' => $this->description,
                'reply_to' => 'robin.zwahlen@eduvaud.ch',
                'title' => $this->title
            ],
            'user' => ''
        );

        if($this->getUser()) {
            $meta['user'] = $this->getUser();
        }

        $parameters = array_merge($meta, $this->arguments);

        return $this->render($this->view, $parameters);
    }


    #[Route('/', name: 'app.index', methods: ['GET'])]
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->getResponse('teacher/index.html.twig', 'Page d\'accueil du site.', 'Surnom des enseignants', ['teachers' => $teacherRepository->findAll()]);
    }

    #[Route('/teacher/create', name: 'teacher.insert', methods: ['GET', 'POST'])]
    public function new(Request $request, TeacherRepository $teacherRepository): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher);
            return $this->redirectToRoute('app.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->getResponse('teacher/new.html.twig', 'Page de création d\'un nouveau surnom d\'enseignant', 'Créer un enseignant', ['teacher' => $teacher, 'form' => $form->createView()]);
    }

    #[Route('/teacher/{id}', name: 'teacher.detail', methods: ['GET'])]
    public function show(Teacher $teacher): Response
    {
        return $this->getResponse('teacher/show.html.twig', 'Page de détail d\'un enseignant', $teacher->getUserIdentifier(), ['teacher' => $teacher]);
    }

    #[Route('/teacher/{id}/update', name: 'teacher.update', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher);
            return $this->redirectToRoute('app.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->getResponse('teacher/edit.html.twig', 'Page de modification d\'un enseignant.', $teacher->getUserIdentifier(), ['teacher' => $teacher, 'form' => $form->createView()]);
    }

    #[Route('/teacher/{id}/delete', name: 'teacher.delete', methods: ['POST'])]
    public function delete(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete-teacher', $request->request->get('_csrf_token'))) {
            $teacherRepository->remove($teacher);
        }

        return $this->redirectToRoute('app.index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\EditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Editor;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EditorController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ValidatorInterface $validator)
    {

    }

    #[Route('/editor', name: 'app_editor')]
    public function index(Request $request): Response
    {
        $editor = new Editor("");
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($editor);

            $this->em->persist($editor);
            $this->em->flush();

            $this->addFlash('success', 'Éditeur ajouté avec succès !');
        }

        return $this->render('editor/index.html.twig', [
            'controller_name' => 'EditorController',
            'form' => $form
        ]);
    }
}

<?php

namespace App\Controller;

use App\Form\TextInputType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/text-input')]
final class TextInputController extends AbstractController
{
    #[Route('/', name: 'app_text_input_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(TextInputType::class, []);
        $form->handleRequest($request);
        $submittedText = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $submittedText = $data['text'];
        }
        return $this->render('text_input/index.html.twig', [
            'form' => $form,
            'submittedText' => $submittedText,
        ]);
    }
}

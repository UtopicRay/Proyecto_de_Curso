<?php

namespace App\Controller;

use App\Entity\Cronograma;
use App\Form\CronogramaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CronogramaController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/cronograma', name: 'app_cronograma')]
    public function index(): Response
    {
        return $this->render('cronograma/tabla-eventos.html.twig', [
            'controller_name' => 'CronogramaController',
        ]);
    }

    #[Route('/cronograma/insertar', name: 'cronograma_insert')]
    public function insertar(Request $request): Response
    {
        $cronograma = new Cronograma();
        $form = $this->createForm(CronogramaType::class, $cronograma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cronograma = $form->getData();
            $this->em->persist($cronograma);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('cronograma/insertar.html.twig', [
            'form' => $form
        ]);
    }

}

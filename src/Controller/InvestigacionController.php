<?php

namespace App\Controller;

use App\Entity\Investigacion;
use App\Entity\Usuario;
use App\Form\InvestigacionType;
use App\Service\InvestigacionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class InvestigacionController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/investigacion', name: 'app_investigacion')]
    public function index(): Response
    {

        return $this->render('investigacion/tabla-eventos.html.twig', [
            'controller_name' => 'InvestigacionController'
        ]);
    }


    #[Route('/t_inves', name: 't_inves')]
    public function tablas(): Response
    {
        $inves = $this->em->getRepository(Investigacion::class)->findAll();
        return $this->render('investigacion/tabla-inves.html.twig', [
            'inves' => $inves
        ]);
    }

    #[Route('/inves/{id}', name: 'invesId')]
    public function invesDetallesId($id): Response
    {

        $app = new InvestigacionService();
        $mostrar = $app->MostrarDatostId($this->em, $id);
        $mostrar = $mostrar[0];

        return $this->render('investigacion/detalles.html.twig', [
            'investigacion' => $mostrar
        ]);
    }

    #[Route('/inves/remover/{id}', name: 'inves_remover')]
    public function remove($id)
    {
        $app = new InvestigacionService();
        $app->BorrarId($this->em, $id);
        return $this->redirectToRoute('t_inves');
    }


    #[Route('/publicar_inves', name: 'public_inves')]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        // just set up a fresh $task object (remove the example data)
        /** @var \App\Entity\Usuario $user */
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findBy(['email'=>$user]);
        $investigacion = new Investigacion();
        $form = $this->createForm(InvestigacionType::class, $investigacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('archivo')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception(" Ha ocurrido un error");
                }
                $investigacion->setArchivo($newFilename);
            }
            $investigacion = $form->getData();
            $usuario[0]->addInvestigacion($investigacion);
            $this->em->persist($investigacion);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('investigacion/publicar-inves.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/evaluar_inve/{id}/{q}',name:'eva_inve')]
    public function DarEvaluacion($id,String $q){
        $app=$this->em->getRepository(Investigacion::class)->find($id);
        $app->setPuntuacion($q);
        $this->em->persist($app);
        $this->em->flush();
        return $this->redirectToRoute('t_inves');
    }

    //APis

    #[Route('api/inves', name: 'inves')]
    public function inves(): Response
    {

        $app = new InvestigacionService();
        return new JsonResponse($app->MostrarDatos($this->em));
    }

    #[Route('api/inves/{id}', name: 'apiId')]
    public function invesId($id): Response
    {

        $app = new InvestigacionService();
        $mostrar = $app->MostrarDatostId($this->em, $id);
        $mostrar = $mostrar[0];

        return new JsonResponse($mostrar);
    }


}


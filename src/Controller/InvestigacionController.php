<?php

namespace App\Controller;

use App\Entity\Evento;
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

    #[Route('/t_inves', name: 't_inves')]
    public function tablas(): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email'=>$user]);
        $usu=$usuario;
        $inves = $this->em->getRepository(Investigacion::class)->findAll();
        return $this->render('investigacion/tabla-inves.html.twig', [
            'inves' => $inves,
            'usuario' => $usu,
        ]);
    }
    #[Route('/Mit_inves', name: 'Mit_inves')]
    public function MisInves(): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $usu = $this->em->getRepository(Usuario::class)->findOneBy(['email'=>$user]);
        $inve=$this->em->getRepository(Investigacion::class)->BuscarInvest($usu->getId());
        $inves = $this->em->getRepository(Investigacion::class)->mostrarInvestVarias($inve);

        return $this->render('investigacion/tabla-inves.html.twig', [
            'inves' => $inves,
            'usuario' => $usu,
        ]);
    }
    #[Route('/investigacion/añadirE/{id}', name: 'ana_eventI')]
    public function AñadirIEvento($id): Response
    {
        $usurio = $this->getUser()->getUserIdentifier();
        $usu = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $usurio]);
        $eventos = $this->em->getRepository(Evento::class)->findOneBy(['id' => $id]);
        $inve = $this->em->getRepository(Investigacion::class)->BuscarInvest($usu->getId());
        $inves = $this->em->getRepository(Investigacion::class)->mostrarInvestVarias($inve);

        return $this->render('investigacion/tabla-invesEvent.html.twig', [
            'eventos' => $eventos,
            'inves' => $inves,
            'usuario' => $usu,
        ]);
    }

    #[Route('/investigacion/añadirE/{ide}/{id}', name: 'ana_eventIF')]
    public function AñadirEV($id, $ide): Response
    {
        $investigacion = $this->em->getRepository(Investigacion::class)->findOneBy(['id' => $id]);
        $eventos = $this->em->getRepository(Evento::class)->findOneBy(['id' => $ide]);
        $investigacion->addEvento($eventos);
        $this->em->flush();
        return $this->redirectToRoute('t_evento');
    }

    #[Route('/inves/{id}', name: 'invesId')]
    public function invesDetallesId($id): Response
    {

        $mostrar = $this->em->getRepository(Investigacion::class)->find($id);
        $buscar=$this->em->getRepository(Investigacion::class)->BuscarUsuario($id);
        $usuario=$this->em->getRepository(Usuario::class)->find($buscar[0]);

        return $this->render('investigacion/detallesI.html.twig', [
            'investigacion' => $mostrar,
            'usuario'=>$usuario,
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

        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email'=>$user]);
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
            $usuario->addInvestigacion($investigacion);
            $this->em->persist($investigacion);
            $this->em->flush();
            return $this->redirectToRoute('t_inves');
        }

        return $this->renderForm('investigacion/publicar-inves.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/editar_inves/{id}', name: 'edit_inves')]
    public function Editar(Request $request, SluggerInterface $slugger,$id): Response
    {

       $investigacion=$this->em->getRepository(Investigacion::class)->findOneBy(['id'=>$id]);
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
            $this->em->flush();
            return $this->redirectToRoute('t_inves');
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


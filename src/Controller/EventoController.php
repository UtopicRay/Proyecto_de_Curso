<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Usuario;
use App\Form\EventoType;
use App\Service\EventoService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventoController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface$em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        /** @var \App\Entity\Usuario $user */
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findBy(['email'=>$user]);
        $usu=$usuario[0];
        return $this->render('/base.html.twig', [
            'usuario' => $usu,
        ]);
    }

    #[Route('/publicar_evento', name: 'public_evento')]
    public function new(Request $request): Response
    {
        $evento = new Evento();
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            $this->em->persist($evento);
            $this->em->flush();
            return $this->redirectToRoute('t_evento');
        }

        return $this->renderForm('evento/publicar-evento.html.twig', [
            'controller_name'=>'Publicar Evento',
            'form' => $form,
        ]);
    }
    #[Route('/editar_evento/{id}', name: 'edit_evento')]
    public function EditarEvento(Request $request,$id): Response
    {
        $evento = $this->em->getRepository(Evento::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            $this->em->flush();
            return $this->redirectToRoute('t_evento');
        }

        return $this->renderForm('evento/publicar-evento.html.twig', [
            'controller_name'=>'Editar Evento',
            'form' => $form,
        ]);
    }

    #[Route('/t_evento', name: 't_evento')]
    public function Prueba(): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findBy(['email'=>$user]);
        $usu=$usuario[0];
        $even=$this->em->getRepository(Evento::class)->findAll();
        return $this->render('evento/tabla-eventos.html.twig', [
            'eventos' => $even,
            'usuario' => $usu,
        ]);
    }
    #[Route('/evento/{id}', name: 'eventoId')]
    public function invesDetallesId($id): Response
    {

        $app = new EventoService();
        $mostrar = $app->MostrarDatostId($this->em,$id);
        $mostrar = $mostrar[0];
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findBy(['email'=>$user]);
        $usu=$usuario[0];
        return $this->render('evento/detallesE.html.twig',[
            'evento'=>$mostrar,
            'usuario' => $usu,
        ]);
    }
    #[Route('/evento/remover/{id}', name: 'evento_remover')]
    public function remove($id)
    {
        $app=new EventoService();
        $app->BorrarId($this->em,$id);
        return $this->redirectToRoute('t_evento');
    }


//APIS

    #[Route('/api/evento', name: 'apievento')]
    public function eventoJ(): Response
    {
        $app = new EventoService();
        return new JsonResponse($app->MostrarDatos($this->em));
    }

    #[Route('api/evento/{id}', name: 'apiId')]
    public function EventoId($id): Response
    {

        $app = new EventoService();
        $mostrar = $app->MostrarDatostId($this->em,$id);
        $mostrar = $mostrar[0];

        return new JsonResponse($mostrar);
    }

}



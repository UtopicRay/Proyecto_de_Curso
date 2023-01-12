<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Investigacion;
use App\Entity\Usuario;
use App\Form\EventoType;
use App\Service\EventoService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        /** @var \App\Entity\Usuario $user */
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findBy(['email' => $user]);
        $usu = $usuario[0];
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
            'controller_name' => 'Publicar Evento',
            'form' => $form,
        ]);
    }

    #[Route('/editar_evento/{id}', name: 'edit_evento')]
    public function EditarEvento(Request $request, $id): Response
    {
        $evento = $this->em->getRepository(Evento::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            $this->em->flush();
            return $this->redirectToRoute('t_evento');
        }

        return $this->renderForm('evento/publicar-evento.html.twig', [
            'controller_name' => 'Editar Evento',
            'form' => $form,
        ]);
    }

    #[Route('/t_evento', name: 't_evento')]
    public function PruebaT(PaginatorInterface $paginator, Request $request): Response
    {
        $pila = array();
        $pilaI = array();
        $pilaC = array();
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $user]);
        $dql = "SELECT a FROM App:Evento a Order By a.id";
        $query = $this->em->createQuery($dql);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            14  /*limit per page*/
        );

        for ($i = 0; $i < $pagination->getTotalItemCount(); $i++) {
            $cant = $this->em->getRepository(Evento::class)->ContarUsuario($pagination[$i]->getId());
            array_push($pila, $cant);
            $cantI = $this->em->getRepository(Evento::class)->ContarInvestigacion($pagination[$i]->getId());
            array_push($pilaI, $cantI);
            $cantC = $this->em->getRepository(Evento::class)->ContarCronograma($pagination[$i]->getId());
            array_push($pilaC, $cantC);
        }

        return $this->render('evento/detallesE.html.twig', [
            'eventos' => $pagination,
            'usuario' => $usuario,
            'pila' => $pila,
            'pilaI' => $pilaI,
            'pilaC' => $pilaC
        ]);
    }

    #[Route('/t_eventoAc', name: 't_eventoAc')]
    public function EventosActuales(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $date = date('Y-m-d');
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $user]);
        $query = $this->em->getRepository(Evento::class)->hola($date);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8  /*limit per page*/
        );

        $pila = array();
        $pilaI = array();
        $pilaC = array();
        for ($i = 0; $i < $pagination->getTotalItemCount(); $i++) {
            $cant = $this->em->getRepository(Evento::class)->ContarUsuario($pagination[$i]->getId());
            array_push($pila, $cant);
            $cantI = $this->em->getRepository(Evento::class)->ContarInvestigacion($pagination[$i]->getId());
            array_push($pilaI, $cantI);
            $cantC = $this->em->getRepository(Evento::class)->ContarCronograma($pagination[$i]->getId());
            array_push($pilaC, $cantC);
        }


        return $this->render('evento/tabla-eventosAc.html.twig', [
            'pila' => $pila,
            'pilaC' => $pilaC,
            'eventos' => $pagination,
            'usuario' => $usuario,
            'pilaI' => $pilaI
        ]);
    }
    #[Route('/Mit_evento', name: 'Mit_event')]
    public function MisEventos(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $user]);
        $event=$this->em->getRepository(Usuario::class)->BuscarEvento($usuario->getId());
        $query = $this->em->getRepository(Evento::class)->MisEventos($event );
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8  /*limit per page*/
        );

        $pila = array();
        $pilaI = array();
        $pilaC = array();
        for ($i = 0; $i < $pagination->getTotalItemCount(); $i++) {
            $cant = $this->em->getRepository(Evento::class)->ContarUsuario($pagination[$i]->getId());
            array_push($pila, $cant);
            $cantI = $this->em->getRepository(Evento::class)->ContarInvestigacion($pagination[$i]->getId());
            array_push($pilaI, $cantI);
            $cantC = $this->em->getRepository(Evento::class)->ContarCronograma($pagination[$i]->getId());
            array_push($pilaC, $cantC);
        }


        return $this->render('evento/tabla-eventosMi.html.twig', [
            'pila' => $pila,
            'pilaC' => $pilaC,
            'eventos' => $pagination,
            'usuario' => $usuario,
            'pilaI' => $pilaI
        ]);
    }



    #[Route('/evento_remover/{id}', name: 'evento_remover')]
    public function remove($id)
    {
        $app = new EventoService();
        $app->BorrarId($this->em, $id);
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
        $mostrar = $app->MostrarDatostId($this->em, $id);
        $mostrar = $mostrar[0];

        return new JsonResponse($mostrar);
    }

}



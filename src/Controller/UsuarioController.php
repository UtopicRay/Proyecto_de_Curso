<?php

namespace App\Controller;

use App\Entity\Investigacion;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Service\EventoService;
use App\Service\UsuarioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/crearusuario', name: 'crear_usuario')]
    public function crearUsuario(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasherp = $form->get('password')->getData();
            $hashedpassword = $passwordHasher->hashPassword($usuario, $hasherp);
            $usuario->setPassword($hashedpassword);
            $usuario->setRoles(["concursante"]);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('usuario/crearusuario.html.twig', [
            'controller_name'=>'Registrar Usuario',
            'form' => $form,
        ]);
    }

    #[Route('/crearusuarioJ', name: 'crear_usuarioJ')]
    public function crearUsuarioJ(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasherp = $form->get('password')->getData();
            $hashedpassword = $passwordHasher->hashPassword($usuario, $hasherp);
            $usuario->setPassword($hashedpassword);
            $usuario->setRoles(["ROLE_JURADO"]);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('usuario/crearusuario.html.twig', [
            'controller_name'=>'Registrar Jurado',
            'form' => $form,
        ]);
    }

    #[Route('/crearusuarioAd', name: 'crear_usuarioAd')]
    public function crearUsuarioAd(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasherp = $form->get('password')->getData();
            $hashedpassword = $passwordHasher->hashPassword($usuario, $hasherp);
            $usuario->setPassword($hashedpassword);
            $usuario->setRoles(["ROLE_ADMIN"]);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('usuario/crearusuario.html.twig', [
            'controller_name'=>'Registrar Administrador',
            'form' => $form,
        ]);
    }

#[Route('/editarUsuario/{id}', name: 'edit_usuario')]
    public function EditarUsuario(Request $request, UserPasswordHasherInterface $passwordHasher,$id): Response
    {
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['id'=>$id]);

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hasherp = $form->get('password')->getData();
            $hashedpassword = $passwordHasher->hashPassword($usuario, $hasherp);
            $usuario->setPassword($hashedpassword);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('usuario/crearusuario.html.twig', [
            'controller_name'=>'Editar Usuario',
            'form' => $form,
        ]);
    }


    #[Route('/t_usuario', name: 't_usuario')]
    public function MostrarUsuario(): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $user]);
        $usu = $usuario;
        $app = $this->em->getRepository(Usuario::class)->findAll();
        return $this->render('usuario/tabla-usuario.html.twig', [
            'usuariot' => $app,
            'usuario' => $usu]);
    }

    #[Route('/usuario/{id}', name: 'usuarioId')]
    public function usuarioDetallesId($id): Response
    {

        $mostrar = $this->em->getRepository(Usuario::class)->find($id);
        $invest = $this->em->getRepository(Usuario::class)->BuscarInvestigacion($id);
        $inve = $this->em->getRepository(Investigacion::class)->MostrarInvestVarias($invest);

        return $this->render('usuario/detallesUsuario.html.twig', [
            'usuario' => $mostrar,
            'invest' => $inve,
        ]);
    }



//API
    #[Route('api/usuario', name: 'app_usuario')]
    public function index(): Response
    {
        $service = new UsuarioService();
        return new JsonResponse($service->MostrarUsuario($this->em));
    }

}


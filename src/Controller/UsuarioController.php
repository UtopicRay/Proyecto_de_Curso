<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Service\UsuarioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

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

    #[Route('api/usuario', name: 'app_usuario')]
    public function index(): Response
    {
        $service = new UsuarioService();
        return new JsonResponse($service->MostrarUsuario($this->em));
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
            'form' => $form,
        ]);
    }
}


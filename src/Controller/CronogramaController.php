<?php

namespace App\Controller;

use App\Entity\Cronograma;
use App\Entity\Usuario;
use App\Form\CronogramaType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/t_cronograma', name: 't_cronograma')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $usurio=$this->getUser()->getUserIdentifier();
        $usu=$this->em->getRepository(Usuario::class)->findOneBy(['email'=>$usurio]);
        $dql   = "SELECT a FROM App:Cronograma a";
        $query = $this->em->createQuery($dql);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6  /*limit per page*/
        );
        return $this->render('cronograma/tabla_crono.html.twig', [
            'cronograma' => $pagination,
            'usuario'=>$usu,
        ]);
    }

    #[Route('/cronograma/insertar', name: 'public_cronograma')]
    public function insertar(Request $request): Response
    {
        $cronograma = new Cronograma();
        $form = $this->createForm(CronogramaType::class, $cronograma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cronograma = $form->getData();
            $this->em->persist($cronograma);
            $this->em->flush();
            return $this->redirectToRoute('t_cronograma');
        }

        return $this->renderForm('cronograma/insertar.html.twig', [
            'controller_name'=>'Agregar Cronograma',
            'form' => $form
        ]);
    }
 #[Route('/cronograma/editar/{id}', name: 'edit_cronograma')]
    public function EditarCronograma($id,Request $request): Response
    {
        $cronograma = $this->em->getRepository(Cronograma::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(CronogramaType::class, $cronograma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cronograma = $form->getData();
            $this->em->flush();
            return $this->redirectToRoute('t_cronograma');
        }

        return $this->renderForm('cronograma/insertar.html.twig', [
            'controller_name'=>'Editar Cronograma',
            'form' => $form
        ]);
    }
    #[Route('/cronograma/remover/{id}', name: 'remove_cronograma')]
    public function RemoverCronograma($id): Response
    {
        $cronograma = $this->em->getRepository(Cronograma::class)->findOneBy(['id'=>$id]);
        $this->em->remove($cronograma);
            $this->em->flush();
            return $this->redirectToRoute('t_cronograma');
        }


}

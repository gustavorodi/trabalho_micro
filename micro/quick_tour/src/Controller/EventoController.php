<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Repository\EventoRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @author Dayan Freitas 
* @Route("/evento", name="curso_")
*/

class EventoController extends AbstractController
{

    /**
    * @var EventoRepository
    */
    private $eventoRepository;

    /**
     * @var EntityManagerInterface
    */
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager,EventoRepository $eventoRepository)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $eventoRepository;
    }
    
    
    /**
     * @Route("/", name="listar", methods={"GET"})
     */
    public function listar()
    {
        $eventos = $this->eventoRepository->findAll();
        
        return $this->json([
             'item' => $eventos
        ]);
    }
  
    /**
    * @Route("/", name="criar", methods={"POST"})
    */
    public function criar(Request $request) : Response
    {
        $param = $request->request->all();

        $evento = new Evento();
        $evento->setNome($param['nome']);
        $evento->setDescricao($param['descricao']);
        // $evento->setData($param['data']);

        $this->entityManager->persist($evento);
        $this->entityManager->flush();
        
        return $this->json([
            'item' => $evento
        ]);
    }
}

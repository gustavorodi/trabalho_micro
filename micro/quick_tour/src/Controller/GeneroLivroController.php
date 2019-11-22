<?php

namespace App\Controller;

use App\Entity\GeneroLivro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/genero_livro")
*/
class GeneroLivroController extends AbstractController
{

    /**
    * @var EntityManagerInterface
    */
    private $entityManager;
    

   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

    /**
     * @Route("/", name="criar", methods={"POST"})
     */
    public function criar(Request $request)
    {
        $param = $request->request->all();
        $error = '';

        if ((isset($param['descricao'])===true)&&(empty($param['descricao'])===false)) {    
            
            $genero = new GeneroLivro();
            $genero->setDescricao($param['descricao']);
            
            $this->entityManager->persist($genero);
            $this->entityManager->flush();

            return $this->json([
                'item' => $genero
            ]);
        }else {
            $error = 'Paramentro de descrição não foi passado';
        }
        
        return new Response('',Response::HTTP_CONFLICT, ['erro'=>$error]);
    }
}

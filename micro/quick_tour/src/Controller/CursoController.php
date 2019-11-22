<?php

namespace App\Controller;

use App\Entity\Curso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\CursoFactory;
use App\Repository\CursoRepository;

/**
* @author Dayan Freitas 
* @Route("/curso", name="curso_")
*/
class CursoController extends AbstractController
{
    
    /**
    * @var CursoRepository
    */
    private $cursoRepository;

    /**
     * @var EntityManagerInterface
    */
    private $entityManager;
    
    /**
    * @var CursoFactory
    */
    private $cursoFactory;

    public function __construct(EntityManagerInterface $entityManager,CursoFactory $cursoFactory, CursoRepository $cursoRepository)
    {
        $this->entityManager = $entityManager;
        $this->cursoFactory = $cursoFactory;
        $this->cursoRepository = $cursoRepository;
    }
    
    /**
    * @Route("/", name="listar", methods={"GET"})
    */
    public function listar ()
    {
        $cursos = $this->cursoRepository->findAll();
        $error = false;

        return $this->json([
             'item' => $cursos
        ]);
    }

    /**
    * @Route("/{id}", name="buscar", methods={"GET"})
    */
    public function buscar($id)
    {
        $cursos = $this->buscarCursoPorId($id);

        if(is_null($cursos) === true) {
            return new Response('',Response::HTTP_NO_CONTENT);
        }

        return $this->json([
            'item' => $cursos,
        ]);
    }

    /**
    * @Route("/", name="criar", methods={"POST"})
    */
    public function criar(Request $request) : Response
    {
        $param = $request->request->all();
        $curso = $this->cursoFactory->criar($param);

        $this->entityManager->persist($curso);
        $this->entityManager->flush();

        return $this->json([
            'item' => 'Curso '.$curso->getId().' criado com sucesso!'
        ]);

    }

    /**
     * @Route("/{id}", name="atualizar", methods={"PUT", "PATCH"})
     */
    public function atualizar($id, Request $request)
    {
        $param = $request->request->all();
        $msg = '';

        $cursoORM = $this->cursoRepository->find($id);
        
        if (is_null($cursoORM) === false) {
            if(self::verificaParametrosObrigatorios($param, $msg)) {
                $this->cursoFactory->atualizar($param, $cursoORM);

                $this->entityManager->flush();
                return new Response($cursoORM->getId(), Response::HTTP_NO_CONTENT);
            }
        }else {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

    }

    /**
    * @Route("/{id}", name="remover", methods={"DELETE"})
    */
    public function remover($id): Response
    {
        $curso = $this->buscarCursoPorId($id);
        $this->entityManager->remove($curso);
        $this->entityManager->flush();
        
        return new Response('',Response::HTTP_NO_CONTENT); 
    }

    /**
     * @param int $id  busca curso pelo id
     * 
     * @return Curso|null
     */
    private function buscarCursoPorId ($id)
    {

        $curso = $this
                ->getDoctrine()
                ->getRepository(Curso::class)->find($id);
        
        // $curso = $this
        //         ->entityManager
        //         ->getReference(Curso::class, $id);

        return $curso;
    }

    /**
     * Verificar se os paramentros passados estão preenchidos
     * 
     * @param array $param
     * @param string $msg
     * 
     * @return 
     */
    private function verificaParametrosObrigatorios($param, &$msg) 
    {

        if(self::verificaNomeExite($param,$msg)) {
            if(self::verificaDescricaoExite($param, $msg)) {
                return true;
            }
        }

        return false;
    }

  
    /**
     * @param array $parametros
     * 
     */
    private function verificaDescricaoExite($param, &$msg)
    {
        
        $bDescricao = false;
        if ((isset($param['descricao'])===true)&&(empty($param['descricao'])===false)) {
            $bDescricao = true; 
        }else {
            $msg = "Descrição não passada"; 
        }
        
        return $bDescricao;
    }

    /**
     * @param array $parametros
     * 
     */
    private function verificaNomeExite($param, &$msg)
    {
        
        $bNome = false;
        if ((isset($param['nome']) === true)&&(empty($param['nome'])===false)) {
            $bNome = true; 
        }else {
            $msg = "nome não passado";
        }
        return $bNome;
    }
}

<?php

namespace App\Controller;

use App\Entity\Usuarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/usuarios", name="usuarios_")
*/
class UsuariosController extends AbstractController
{
    /**
    * @Route("/", name="index", methods={"GET"})
    */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(Usuarios::class)->findAll();
        
        return $this->json([
            'item' => $users
        ]);
    }
    
    /**
    * @Route("/{id}", name="buscar", methods={"GET"})
    */
    public function buscar($id) 
    {

        $user = $this->getDoctrine()->getRepository(Usuarios::class)->find($id);
        
        return $this->json([
            'item' => $user
        ]);
    }

    /**
    * @Route("/", name="criar ", methods={"POST"})
    */
    public function criar(Request $request) {
        $param = $request->request->all();

        $usuario = new Usuarios();
        $usuario->setNome($param['nome']);
        
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($usuario);
        $doctrine->flush();

        return $this->json([
            'data' => 'Usuario '.$usuario->getId().' criada com sucesso!'
        ]);

    }
 
    /**
    * @Route("/{id}", name="atualizar", methods={"PUT","PATCH"})
    */
    public function atualizar($id, Request $request) {
        $param = $request->request->all();

        $doctrine = $this->getDoctrine();

        $usuario =  $doctrine->getRepository(Usuarios::class)->find($id);
        
        if ($request->request->has('nome'))
            $usuario->setNome($param['nome']);

        $menager = $doctrine->getManager();
        $menager->flush();

        return $this->json([
            'data' => 'Usuario '.$usuario->getId().' alterado com sucesso!'
        ]);

    }

    /**
    * @Route("/{id}", name="apagar", methods={"DELETE"})
    */
    public function delete($id) {

        $doctrine = $this->getDoctrine();
        
        $usuario = $doctrine->getRepository(Usuarios::class)->find($id);

        
        $menager = $doctrine->getManager();
        $menager->remove($usuario);
        $menager->flush();

        
        return $this->json([
            'data' => 'Usuario '.$usuario->getId().' removido com sucesso!'
        ]);
        
    }
}

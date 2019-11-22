<?php

namespace App\Helper;

use App\Entity\Curso;
use App\Repository\GeneroLivroRepository;

class CursoFactory 
{

    /**
     * @var GeneroLivroRepository
     */ 
    private $generoLivroRepository;

    public function __construct(GeneroLivroRepository $generoLivroRepository)
    {
        $this->generoLivroRepository = $generoLivroRepository;
    }

    public function criar($param): Curso
    {
                
        if ($this->verificarParametrosRelacionamentoObrigatorio($param)) {
            
            $curso = new Curso();

//            $curso->setNome($param[ConstanteParametros::CHAVE_NOME]);
//            $curso->setDescricao($param[ConstanteParametros::CHAVE_DESCRICAO]);
//            $curso->setGenero($param[ConstanteParametros::CHAVE_GENERO]);

            $curso->setNome($param['nome']);
            $curso->setDescricao($param['descricao']);
            $curso->setGenero($param['genero']);

        }

        return $curso;
    }

    public function atualizar ($param, &$cursoORM) 
    {

        if($this->verificarParametrosRelacionamentoObrigatorio($param)) {


            $cursoORM->setNome($param['nome']);
            $cursoORM->setDescricao($param['descricao']);
            $cursoORM->setGenero($param['genero']);
//
//            $cursoORM->setNome($param[ConstanteParametros::CHAVE_NOME]);
//            $cursoORM->setDescricao($param[ConstanteParametros::CHAVE_DESCRICAO]);
//            $cursoORM->setGenero($param[ConstanteParametros::CHAVE_GENERO]);
        }   
        
    }

    private function verificarParametrosRelacionamentoObrigatorio (&$param) 
    {
        if ($this->verificarGeneroExiste($param, $param['genero'])) {

            return true;
        }

        return false;
    }

    private function verificarGeneroExiste (&$param, $chave) 
    {
        $generoORM = $this->generoLivroRepository->find($chave);
        if (is_null($generoORM) === false) {
 
            $param['genero'] = $generoORM;
        }

        return empty($param['genero']) === false;
    }
}
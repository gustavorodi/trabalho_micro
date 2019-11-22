<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CursoRepository")
 */
class Curso implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_criacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GeneroLivro", inversedBy="cursos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genero;

    public function __construct() {
        $this->data_criacao = new \DateTime();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getDataCriacao(): ?\DateTimeInterface
    {
        return $this->data_criacao;
    }

    public function setDataCriacao(\DateTimeInterface $data_criacao): self
    {
        $this->data_criacao = $data_criacao;

        return $this;
    }

    public function getGenero(): ?GeneroLivro
    {
        return $this->genero;
    }

    public function setGenero(?GeneroLivro $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'genero' => $this->getGenero(),
        ];
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GeneroLivroRepository")
 */
class GeneroLivro implements \JsonSerializable
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
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Curso", mappedBy="genero")
     */
    private $cursos;

    public function __construct()
    {
        $this->cursos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Curso[]
     */
    public function getCursos(): Collection
    {
        return $this->cursos;
    }

    public function addCurso(Curso $curso): self
    {
        if (!$this->cursos->contains($curso)) {
            $this->cursos[] = $curso;
            $curso->setGenero($this);
        }

        return $this;
    }

    public function removeCurso(Curso $curso): self
    {
        if ($this->cursos->contains($curso)) {
            $this->cursos->removeElement($curso);
            // set the owning side to null (unless already changed)
            if ($curso->getGenero() === $this) {
                $curso->setGenero(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'descricao' => $this->getDescricao(),
           ];
    }
}

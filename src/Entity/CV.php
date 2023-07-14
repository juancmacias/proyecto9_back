<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $de = null;

    #[ORM\Column(length: 255)]
    private ?string $periodo = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $empresa = null;

    #[ORM\Column(length: 1000)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?bool $logros = null;

    #[ORM\Column(length: 255)]
    private ?string $logro_1 = null;

    #[ORM\Column(length: 255)]
    private ?string $logro_2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDe(): ?string
    {
        return $this->de;
    }

    public function setDe(string $de): static
    {
        $this->de = $de;

        return $this;
    }

    public function getPeriodo(): ?string
    {
        return $this->periodo;
    }

    public function setPeriodo(string $periodo): static
    {
        $this->periodo = $periodo;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getEmpresa(): ?string
    {
        return $this->empresa;
    }

    public function setEmpresa(string $empresa): static
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function isLogros(): ?bool
    {
        return $this->logros;
    }

    public function setLogros(bool $logros): static
    {
        $this->logros = $logros;

        return $this;
    }

    public function getLogro1(): ?string
    {
        return $this->logro_1;
    }

    public function setLogro1(string $logro_1): static
    {
        $this->logro_1 = $logro_1;

        return $this;
    }

    public function getLogro2(): ?string
    {
        return $this->logro_2;
    }

    public function setLogro2(string $logro_2): static
    {
        $this->logro_2 = $logro_2;

        return $this;
    }
}

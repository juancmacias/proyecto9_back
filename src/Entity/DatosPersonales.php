<?php

namespace App\Entity;

use App\Repository\DatosPersonalesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatosPersonalesRepository::class)]
class DatosPersonales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido_uno = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido_dos = null;

    #[ORM\Column(length: 255)]
    private ?string $correo = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $enlace_1 = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $enlace_2 = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $enlace_3 = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $enlace_4 = [];

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $definicion_corta = null;

    #[ORM\Column(length: 1000)]
    private ?string $definicion_larga = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidoUno(): ?string
    {
        return $this->apellido_uno;
    }

    public function setApellidoUno(string $apellido_uno): static
    {
        $this->apellido_uno = $apellido_uno;

        return $this;
    }

    public function getApellidoDos(): ?string
    {
        return $this->apellido_dos;
    }

    public function setApellidoDos(string $apellido_dos): static
    {
        $this->apellido_dos = $apellido_dos;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }

    public function getEnlace1(): array
    {
        return $this->enlace_1;
    }

    public function setEnlace1(array $enlace_1): static
    {
        $this->enlace_1 = $enlace_1;

        return $this;
    }

    public function getEnlace2(): array
    {
        return $this->enlace_2;
    }

    public function setEnlace2(array $enlace_2): static
    {
        $this->enlace_2 = $enlace_2;

        return $this;
    }

    public function getEnlace3(): array
    {
        return $this->enlace_3;
    }

    public function setEnlace3(array $enlace_3): static
    {
        $this->enlace_3 = $enlace_3;

        return $this;
    }

    public function getEnlace4(): array
    {
        return $this->enlace_4;
    }

    public function setEnlace4(array $enlace_4): static
    {
        $this->enlace_4 = $enlace_4;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDefinicionCorta(): ?string
    {
        return $this->definicion_corta;
    }

    public function setDefinicionCorta(string $definicion_corta): static
    {
        $this->definicion_corta = $definicion_corta;

        return $this;
    }

    public function getDefinicionLarga(): ?string
    {
        return $this->definicion_larga;
    }

    public function setDefinicionLarga(string $definicion_larga): static
    {
        $this->definicion_larga = $definicion_larga;

        return $this;
    }
}

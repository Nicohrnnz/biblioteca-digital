<?php

namespace App\Models;

use App\Traits\Auditoria;

// Clase abstracta base para todos los materiales de la biblioteca
abstract class Material
{
    use Auditoria;

    protected bool $disponible = true;

    // Constructor con propiedades promovidas de PHP 8
    public function __construct(
        protected int $id,
        protected string $titol,
        protected string $autor,
        protected int $anyPublicacio
    ) {
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract public function calcularMulta(int $diesRetard): float;
    abstract public function getTipus(): string;

    // Presta el material si está disponible
    public function prestar(): bool
    {
        if ($this->disponible) {
            $this->disponible = false;
            $this->registrarAccio('prestat', "Material prestado con ID: {$this->id}");
            return true;
        }
        return false;
    }

    // Marca el material como devuelto
    public function retornar(): void
    {
        $this->disponible = true;
        $this->registrarAccio('retornat', "Material devuelto con ID: {$this->id}");
    }

    // Representación en string del material
    public function __toString(): string
    {
        $estado = $this->disponible ? 'Disponible' : 'Prestat';
        return "[{$this->getTipus()}] #{$this->id} - {$this->titol} ({$this->autor}, {$this->anyPublicacio}) - {$estado}";
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getTitol(): string
    {
        return $this->titol;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getAnyPublicacio(): int
    {
        return $this->anyPublicacio;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }
}

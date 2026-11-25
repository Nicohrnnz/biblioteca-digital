<?php

namespace App\Models;

use App\Interfaces\Reservable;
use App\Traits\ReservableTrait;
use InvalidArgumentException;

// Clase Libro que hereda de Material e implementa Reservable
class Llibre extends Material implements Reservable
{
    // Usamos el trait para evitar duplicar código de reservas con DVD
    use ReservableTrait;

    private int $numeroPagines;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroPagines
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroPagines($numeroPagines);
    }

    // Multa de 0.50 euros por día de retraso
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 0.50;
    }

    public function getTipus(): string
    {
        return "Llibre";
    }

    public function getNumeroPagines(): int
    {
        return $this->numeroPagines;
    }

    // Validamos que las páginas sean mayores que cero
    public function setNumeroPagines(int $pagines): void
    {
        if ($pagines <= 0) {
            throw new InvalidArgumentException("El número de páginas debe ser mayor que 0");
        }
        $this->numeroPagines = $pagines;
    }
}

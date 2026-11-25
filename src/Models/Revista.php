<?php

namespace App\Models;

use InvalidArgumentException;

// Clase Revista que hereda de Material (las revistas no se pueden reservar)
class Revista extends Material
{
    private int $numeroEdicio;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroEdicio
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroEdicio($numeroEdicio);
    }

    // Multa de 0.25 euros por día de retraso
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 0.25;
    }

    public function getTipus(): string
    {
        return "Revista";
    }

    public function getNumeroEdicio(): int
    {
        return $this->numeroEdicio;
    }

    // Validamos que el número de edición sea mayor que cero
    public function setNumeroEdicio(int $numero): void
    {
        if ($numero <= 0) {
            throw new InvalidArgumentException("El número de edición debe ser mayor que 0");
        }
        $this->numeroEdicio = $numero;
    }
}

<?php

namespace App\Models;

use App\Interfaces\Reservable;
use App\Traits\ReservableTrait;
use InvalidArgumentException;

// Clase DVD que hereda de Material e implementa Reservable
class DVD extends Material implements Reservable
{
    use ReservableTrait;

    private int $duracio; // Duración en minutos

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $duracio
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setDuracio($duracio);
    }

    // Multa de 1.00 euro por día de retraso
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 1.00;
    }

    public function getTipus(): string
    {
        return "DVD";
    }

    public function getDuracio(): int
    {
        return $this->duracio;
    }

    // Validamos que la duración sea positiva
    public function setDuracio(int $minuts): void
    {
        if ($minuts <= 0) {
            throw new InvalidArgumentException("La duración debe ser mayor que 0");
        }
        $this->duracio = $minuts;
    }

    // Convierte los minutos al formato requerido (ej: 150 -> 2h 30min, 45 -> 0h 45min)
    public function getDuracioFormatada(): string
    {
        $horas = intdiv($this->duracio, 60);
        $minutos = $this->duracio % 60;
        return "{$horas}h {$minutos}min";
    }
}

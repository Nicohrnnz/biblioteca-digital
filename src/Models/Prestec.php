<?php

namespace App\Models;

use DateTime;

// Clase Prestec para gestionar el préstamo de un material a un usuario
class Prestec
{
    private DateTime $dataPrestec;
    private ?DateTime $dataRetorn = null;

    // Constructor con propiedades promovidas y parámetro nullable para fechas antiguas
    public function __construct(
        private Material $material,
        private Usuari $usuari,
        private int $diesLimitPrestec = 14,
        ?DateTime $dataPrestec = null
    ) {
        $this->dataPrestec = $dataPrestec ?? new DateTime();
    }

    // Registra la devolución con la fecha actual
    public function retornar(): void
    {
        $this->dataRetorn = new DateTime();
    }

    // Devuelve true si aún no se ha devuelto
    public function estaActiu(): bool
    {
        return $this->dataRetorn === null;
    }

    // Calcula cuántos días han pasado desde la fecha límite
    public function calcularDiesRetard(): int
    {
        $fechaFin = $this->dataRetorn ?? new DateTime();
        $fechaLimite = (clone $this->dataPrestec)->modify("+{$this->diesLimitPrestec} days");

        if ($fechaFin > $fechaLimite) {
            $diff = $fechaLimite->diff($fechaFin);
            return (int) $diff->days;
        }

        return 0;
    }

    // Calcula la multa según el tipo de material y días de retraso
    public function calcularMulta(): float
    {
        $diasRetraso = $this->calcularDiesRetard();
        return $this->material->calcularMulta($diasRetraso);
    }

    // Comprueba si el préstamo está vencido
    public function estaVencut(): bool
    {
        return $this->calcularDiesRetard() > 0;
    }

    // Días que faltan para vencer (negativo si ya venció)
    public function getDiesPendents(): int
    {
        $hoy = new DateTime();
        $fechaLimite = (clone $this->dataPrestec)->modify("+{$this->diesLimitPrestec} days");
        $diff = $hoy->diff($fechaLimite);
        $dias = (int) $diff->days;
        return $diff->invert ? -$dias : $dias;
    }

    // Getters
    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getUsuari(): Usuari
    {
        return $this->usuari;
    }

    public function getDataPrestec(): DateTime
    {
        return $this->dataPrestec;
    }

    public function getDataRetorn(): ?DateTime
    {
        return $this->dataRetorn;
    }

    public function getDiesLimitPrestec(): int
    {
        return $this->diesLimitPrestec;
    }
}

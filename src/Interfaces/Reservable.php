<?php

namespace App\Interfaces;

// Interfaz para los materiales que se pueden reservar (Libro y DVD)
interface Reservable
{
    // Reserva el material para un usuario si no está ya reservado
    public function reservar(string $nomUsuari): bool;

    // Cancela la reserva actual
    public function cancelarReserva(): bool;

    // Comprueba si el material está reservado
    public function estaReservat(): bool;

    // Devuelve el nombre del usuario que lo reservó o null
    public function getUsuariReserva(): ?string;
}

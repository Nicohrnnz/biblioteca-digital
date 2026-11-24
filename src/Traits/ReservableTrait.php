<?php

namespace App\Traits;

// Trait para compartir la lógica de reserva entre Llibre y DVD (mejora opcional para no duplicar código)
trait ReservableTrait
{
    private ?string $usuariReserva = null;

    // Realiza la reserva si el material no está ya reservado
    public function reservar(string $nomUsuari): bool
    {
        if ($this->estaReservat()) {
            return false;
        }

        $this->usuariReserva = $nomUsuari;
        $this->registrarAccio('reservat', "Reservado por: $nomUsuari");
        return true;
    }

    // Cancela la reserva activa
    public function cancelarReserva(): bool
    {
        if (!$this->estaReservat()) {
            return false;
        }

        $anterior = $this->usuariReserva;
        $this->usuariReserva = null;
        $this->registrarAccio('reserva_cancel·lada', "Reserva cancelada de: $anterior");
        return true;
    }

    // Comprueba si está reservado
    public function estaReservat(): bool
    {
        return $this->usuariReserva !== null;
    }

    // Devuelve el usuario que reservó
    public function getUsuariReserva(): ?string
    {
        return $this->usuariReserva;
    }
}

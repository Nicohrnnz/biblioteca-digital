<?php

namespace App\Traits;

// Trait para registrar el historial de acciones de cada material
trait Auditoria
{
    private array $historial = [];

    // Guarda una acción con la fecha y hora actual
    public function registrarAccio(string $accio, string $detalls = ''): void
    {
        $this->historial[] = [
            'data'    => date('Y-m-d H:i:s'),
            'accio'   => $accio,
            'detalls' => $detalls
        ];
    }

    // Devuelve todo el historial
    public function obtenirHistorial(): array
    {
        return $this->historial;
    }

    // Devuelve la última acción registrada o null si está vacío
    public function obtenirUltimaAccio(): ?array
    {
        if (empty($this->historial)) {
            return null;
        }

        return $this->historial[array_key_last($this->historial)];
    }

    // Limpia el historial
    public function netejarHistorial(): void
    {
        $this->historial = [];
    }
}

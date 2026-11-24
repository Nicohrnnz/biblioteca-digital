<?php

namespace App\Exceptions;

use Exception;

// Excepción cuando un material ya está prestado o reservado
class MaterialNoDisponibleException extends Exception
{
    private int $materialId;

    public function __construct(int $materialId, string $message = "Material no disponible")
    {
        $this->materialId = $materialId;
        parent::__construct($message);
    }

    public function getMaterialId(): int
    {
        return $this->materialId;
    }

    // Formateamos el mensaje según pide el enunciado de la práctica
    public function __toString(): string
    {
        return "Error: el material amb ID {$this->materialId} no està disponible. {$this->getMessage()}";
    }
}

<?php

namespace App\Models;

use App\Exceptions\EmailInvalidException;
use DateTime;
use LogicException;

// Clase Usuari para representar los usuarios de la biblioteca
class Usuari
{
    private int $id;
    private string $nom;
    private string $email;
    private array $materialsPrestats = [];
    private DateTime $dataRegistre;
    private array $notificacions = [];

    public function __construct(int $id, string $nom, string $email)
    {
        // Validamos el formato del correo
        if (!$this->validarEmail($email)) {
            throw new EmailInvalidException("El correo proporcionado no es válido: $email");
        }

        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->dataRegistre = new DateTime();
    }

    // Método mágico __get para leer propiedades específicas de solo lectura
    public function __get(string $propietat): mixed
    {
        return match ($propietat) {
            'id'           => $this->id,
            'nom'          => $this->nom,
            'email'        => $this->email,
            'dataRegistre' => $this->dataRegistre,
            default        => null,
        };
    }

    // Método mágico __set: solo permite modificar el email con validación
    public function __set(string $propietat, mixed $valor): void
    {
        if ($propietat === 'email') {
            if (!$this->validarEmail($valor)) {
                throw new EmailInvalidException("El nuevo correo no tiene un formato válido");
            }
            $this->email = $valor;
        } else {
            throw new LogicException("No se permite modificar la propiedad '$propietat'");
        }
    }

    // Método mágico __sleep: serializa todo excepto las notificaciones temporales
    public function __sleep(): array
    {
        return ['id', 'nom', 'email', 'materialsPrestats', 'dataRegistre'];
    }

    // Método mágico __wakeup: reinicia las notificaciones como un array vacío
    public function __wakeup(): void
    {
        $this->notificacions = [];
    }

    // Formato de cadena: Anna Puig <anna@mail.com> - 2 préstecs
    public function __toString(): string
    {
        $total = count($this->materialsPrestats);
        $textoPrestecs = ($total === 1) ? '1 préstec' : "{$total} préstecs";
        return "{$this->nom} <{$this->email}> - {$textoPrestecs}";
    }

    public function afegirPrestec(Material $material): void
    {
        $this->materialsPrestats[$material->getId()] = $material;
    }

    public function eliminarPrestec(int $materialId): void
    {
        unset($this->materialsPrestats[$materialId]);
    }

    public function getMaterialsPrestats(): array
    {
        return array_values($this->materialsPrestats);
    }

    public function getNumeroMaterialsPrestats(): int
    {
        return count($this->materialsPrestats);
    }

    public function afegirNotificacio(string $missatge): void
    {
        $this->notificacions[] = $missatge;
    }

    public function obtenirNotificacions(): array
    {
        $mensajes = $this->notificacions;
        $this->notificacions = [];
        return $mensajes;
    }

    private function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

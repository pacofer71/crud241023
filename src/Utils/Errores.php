<?php

namespace App\Utils;

use App\Db\Usuario;

//session_start();
class Errores
{
    public static function hayErrorEnCampo(string $nombre, int $longitud): bool
    {
        return (strlen($nombre) < $longitud);
    }

    public static function hayErrorEnEmail(string $email, ?int $id = null): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return Usuario::existeEmail($email, $id);
    }

    public static function hayErrorEnProvincia(string $provincia): bool
    {
        return !in_array($provincia, Provincias::$listadoProv) ?  true : false;
    }
    public static function pintarErrores($nombre)
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='mt-2 text-red-700 text-sm italic'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}

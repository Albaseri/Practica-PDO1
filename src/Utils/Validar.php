<?php

namespace App\Utils;

class Validar
{


    //Método para que muestre un mensaje de error (si los hay) en color rojo y cursiva
    public static function mostrarError($error)
    {
        if (isset($_SESSION[$error])) {
            echo "<p class='mt-2 text-red-700 text-sm italic'>{$_SESSION[$error]}</p>";
            unset($_SESSION[$error]);
        }
    }

    public static function errorLongitudCampo($variable,$valor, $longitud): bool
    {
        if (strlen($valor) < $longitud){
            $_SESSION[$variable]="El campo $variable debe contener al menos $longitud caracteres";
            return true;
        }
        return false;
    }

    public static function errorPrecio($variable, $valor, $min,$max): bool
    {
        if (($valor < $min) || $valor >= $max) {
            $_SESSION[$variable] = "El precio oscila entre $min y $max";
            return true;
        }
        return false; // Si la información es válida devuelve false
    }
}

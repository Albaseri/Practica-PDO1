<?php

namespace App\Db;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Conexion
{

    protected static $conexion;

    public function __construct()
    {
        self::setConexion();
    }

    protected static function setConexion()
    {
        //comprobamos si la conexión existe

        if (self::$conexion != null) return;

        // Cargamos datos del dotenv
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        //Pasamos los datos del .env
        $db = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASS'];
        $host = $_ENV['HOST'];

        //dns descriptor
        $dsn = "mysql:dbname=$db;host=$host; charset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];

        try {
            self::$conexion = new PDO($dsn, $user,$pass,$options);
        } catch (PDOException $ex) {
            die("Error en la conexión" . $ex->getMessage());
        }
    }
}

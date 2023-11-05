<?php

// Esta clase controla la conexión a una BD mysql utilizando PDO
namespace App\Db;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Conexion
{
    // Propiedad estática que almacena la conexión a la BD
    protected static $conexion;

    // Constructor de la clase que llama al método setConexión() para establecer a la conexión
    public function __construct()
    {
        self::setConexion();
    }

    protected static function setConexion()
    {
        // Comprobamos si la conexión existe

        if (self::$conexion != null) return;

        // Cargamos datos del dotenv
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        //Pasamos los datos del .env
        $db = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASS'];
        $host = $_ENV['HOST'];

        // Creamos el DSN para conectarnos a una BD
        $dsn = "mysql:dbname=$db;host=$host; charset=utf8mb4";

        // Configuramos opciones de PDO
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        // Creo el objeto tipo PDO con el DSN, usuario, contraseña y opciones. 
        try {
            self::$conexion = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $ex) {
            die("Error en la conexión" . $ex->getMessage()); // Muestro error si hay fallo al conectar
        }
    }
}

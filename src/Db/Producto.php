<?php

// Clase que permite interactuar con la tabla producto
namespace App\Db;

use PDOException;
use PDO;

class Producto extends Conexion
{
    // Atributos que representan los datos de una tabla
    private int $codigo;
    private string $nombre;
    private float $precio;

    // Método constructor que llama al constructor de la clase padre Conexión para establecer la conexión a la BD si no existe
    public function __construct()
    {
        parent::__construct();
    }

    //________________________________________________________________________CRUD__________________________________________________________________________________


    //Pasos a seguir: 
    // 1. Creo la consulta. Parametrizamos con values cuando sea necesario
    // 2. Preparo la consulta con la variable $stmt
    // 3. Ejecuto la consulta. Si hay parámetros, "cada oveja con su pareja"
    // 4. Cierro la conexión

    public function create()
    {
        $q = "insert into producto(nombre, precio) values (:n,:p)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->precio,

            ]);
        } catch (PDOException $ex) {
            die("Error al crear un producto" . $ex->getMessage());
        }
        parent::$conexion = null;
    }

    // Método read que devuelve los registros de la tabla
    public static function read()
    {
        parent::setConexion();

        $q = "select * from producto order by codigo desc";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer producto") . $ex->getMessage();
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Devuelve todos los registros. FETCH_OBJ para la notación de objetos con flechas
    }

    // Método update para actualizar un producto 
    public function update($codigo)
    {

        $q = "update producto set nombre=:n, precio=:p where codigo=:c";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->precio,
                ':c' => $codigo
            ]);
        } catch (PDOException $ex) {
            die("Error al crear un producto" . $ex->getMessage());
        }
        parent::$conexion = null;
    }

    // Método delete para borrar un producto dado su código
    public static function delete($codigo)
    {
        parent::setConexion();

        $q = "delete from producto where codigo=:c";
        $stmt = parent::$conexion->prepare($q);
      
        try {
            $stmt->execute([
                ':c' => $codigo
            ]);
        } catch (PDOException $ex) {
            die("Error al eliminar el producto" . $ex->getMessage());
        }
        parent::$conexion = null;
    }


    //__________________________________________________________________OTROS MÉTODOS_____________________________________________________________________________

    // Método para encontrar un producto dado su código
    public static function encontrarProducto($codigo)
    {
        parent::setConexion();

        $q = "select * from producto where codigo=:c";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ":c" => $codigo
            ]);
        } catch (PDOException $ex) {
            die("Error al encontrar el producto") . $ex->getMessage();
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ); //fetch devuelve la primera fila
    }



    //_______________________________________________________________________SETTERS__________________________________________________________________________________


    /**
     * Set the value of codigo
     */
    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}

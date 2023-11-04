<?php

namespace App\Db;

use PDOException;
use PDO;

class Producto extends Conexion
{
    private int $codigo;
    private string $nombre;
    private float $precio;


    public function __construct()
    {
        parent::__construct();
    }

    //___________________________________CRUD________________________________________________

    public function create()
    {

        $q = "insert into producto(codigo, nombre, precio) values (:c,:n,:p)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':c' => $this->codigo,
                ':n' => $this->nombre,
                ':cp' => $this->precio,

            ]);
        } catch (PDOException $ex) {
            die("Error al crear un producto" . $ex->getMessage());
        }
        parent::$conexion = null;
    }

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
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function update()
    {
    }

    public function delete()
    {
    }


    //___________________OTROS MÉTODOS___________________




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

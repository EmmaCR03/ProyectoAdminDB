<?php
require_once '../Conn/conexion.php';

class Medicamento
{
    /*=============================================
    =            Atributos de la Clase            =
    =============================================*/
    private $idMedicamento = null;  // Cambio de id a idMedicamento
    private $idCategoria = null;
    private $nombre = null;
    private $precio = null;
    private $stock = null;

    /*=============================================
    =            Constructores de la Clase          =
    =============================================*/
    public function __construct()
    {
    }

    /*=============================================
    =            Encapsuladores de la Clase       =
    =============================================*/
    public function getIdMedicamento()
    {
        return $this->idMedicamento;
    }

    public function setIdMedicamento($idMedicamento)
    {
        $this->idMedicamento = (int)$idMedicamento;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = (float)$precio; // Usualmente PARAM_STR para precios
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = (int)$stock;
    }



    /*=============================================
    =            Métodos de la Clase              =
    =============================================*/
    public static function getconexion()
    {
        return Conexion::conectar();
    }

    public function listarTodosDb()
    {
        $query = "SELECT * FROM FIDE_MEDICAMENTO_TB";
        $arr = array();
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
            $resultado->execute();
            foreach ($resultado->fetchAll(PDO::FETCH_ASSOC) as $encontrado) {
                $medicamento = new Medicamento();
                $medicamento->setIdMedicamento($encontrado['IDMEDICAMENTO']);
                $medicamento->setIdCategoria($encontrado['IDCATEGORIA']);
                $medicamento->setNombre($encontrado['NOMBRE']);
                $medicamento->setPrecio($encontrado['PRECIO']);
                $medicamento->setStock($encontrado['STOCK']);
                $arr[] = $medicamento;
            }
            Conexion::desconectar($cnx);
            return $arr;
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function verificarExistenciaDb()
    {
        $query = "SELECT * FROM FIDE_MEDICAMENTO_TB WHERE IDMEDICAMENTO = :idMedicamento";
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
            $idMedicamento = $this->getIdMedicamento();
            $resultado->bindParam(":idMedicamento", $idMedicamento, PDO::PARAM_INT);
            $resultado->execute();
            Conexion::desconectar($cnx);
            return $resultado->rowCount() > 0;
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function guardarEnDb()
    {
        $query = "INSERT INTO FIDE_MEDICAMENTO_TB (IDMEDICAMENTO, IDCATEGORIA, NOMBRE, PRECIO, STOCK, CREATED_AT) VALUES (:idMedicamento, :idCategoria, :nombre, :precio, :stock, SYSDATE)";
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
    
            // Almacena el valor en una variable antes de pasarla a bindParam
            $idMedicamento = $this->getIdMedicamento();
            $idCategoria = $this->getIdCategoria();
            $nombre = strtoupper($this->getNombre());
            $precio = $this->getPrecio();
            $stock = $this->getStock();
    
            $resultado->bindParam(":idMedicamento", $idMedicamento, PDO::PARAM_INT);
            $resultado->bindParam(":idCategoria", $idCategoria, PDO::PARAM_INT);
            $resultado->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $resultado->bindParam(":precio", $precio, PDO::PARAM_STR); // Completo PDO::PARAM_STR
            $resultado->bindParam(":stock", $stock, PDO::PARAM_INT);
    
            $resultado->execute();
            Conexion::desconectar($cnx);
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function actualizar()
    {
        $query = "UPDATE FIDE_MEDICAMENTO_TB SET IDCATEGORIA = :idCategoria, NOMBRE = :nombre, PRECIO = :precio, STOCK = :stock WHERE IDMEDICAMENTO = :idMedicamento";
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
            $resultado->bindParam(":idMedicamento", $this->getIdMedicamento(), PDO::PARAM_INT);
            $resultado->bindParam(":idCategoria", $this->getIdCategoria(), PDO::PARAM_INT);
            $resultado->bindParam(":nombre", strtoupper($this->getNombre()), PDO::PARAM_STR);
            $resultado->bindParam(":precio", $this->getPrecio(), PDO::PARAM_); // Usualmente PARAM_STR para precios
            $resultado->bindParam(":stock", $this->getStock(), PDO::PARAM_INT);
            $resultado->execute();
            Conexion::desconectar($cnx);
            return $resultado->rowCount();
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function activar()
    {
        $query = "UPDATE FIDE_MEDICAMENTO_TB SET STOCK = 1 WHERE IDMEDICAMENTO = :idMedicamento";
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
            $resultado->bindParam(":idMedicamento", $this->getIdMedicamento(), PDO::PARAM_INT);
            $resultado->execute();
            Conexion::desconectar($cnx);
            return $resultado->rowCount();
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }

    public function desactivar()
    {
        $query = "UPDATE FIDE_MEDICAMENTO_TB SET STOCK = 0 WHERE IDMEDICAMENTO = :idMedicamento";
        try {
            $cnx = self::getconexion();
            $resultado = $cnx->prepare($query);
            $resultado->bindParam(":idMedicamento", $this->getIdMedicamento(), PDO::PARAM_INT);
            $resultado->execute();
            Conexion::desconectar($cnx);
            return $resultado->rowCount();
        } catch (PDOException $Exception) {
            Conexion::desconectar($cnx);
            return "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
        }
    }
}
?>

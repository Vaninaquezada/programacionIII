<?php

include_once("AccesoDatos.php");

class Empleados
{
    public $id;
    public $nombre;
    public $sector;
    public $puesto;
    public $estado;
    public $tipo;
    public $apellido;
    public $sueldo;
    public $dni;
    public $fechaIngreso;
    public $fechaEgreso;


    //Da de alta un empleado
    public static function AltaEmpleado($nombre, $sector, $puesto, $apellido,$estado, $sueldo, $tipo, $dni, $clave, $usuario)
    {
        $fecha = date('Y-m-d');
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("
            INSERT INTO empleado
            ( nombre, usuario, clave, estado, dni, sector, puesto, fechaIngreso, tipo, sueldo, apellido) 
            VALUES (:nombre,:usuario,:clave,:estado,:dni,:sector,:puesto,:fechaIngreso,:tipo,:sueldo,:apellido)");

            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_INT);
            $consulta->bindValue(':apellido', $apellido, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_INT);
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_INT);
            $consulta->bindValue(':dni', $dni, PDO::PARAM_INT);
            $consulta->bindValue(':sector', $sector, PDO::PARAM_INT);
            $consulta->bindValue(':puesto', $puesto, PDO::PARAM_INT);
            $consulta->bindValue(':sueldo', $sueldo, PDO::PARAM_INT);
            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_INT);
            $consulta->bindValue(':fechaIngreso', $fecha, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $estado, PDO::PARAM_INT);

            return  $consulta->execute();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    //Modifica un empleado
    public static function ModificarEmpleado($id, $nombre, $sector, $puesto, $apellido, $sueldo, $tipo)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("
                UPDATE empleado 
                SET nombre=:nombre,
                sector=:sector,
                puesto=:puesto,
                tipo=:tipo,
                sueldo=:sueldo,
                apellido=:apellido
                    WHERE id = :id");

            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_INT);
            $consulta->bindValue(':apellido', $apellido, PDO::PARAM_INT);
            $consulta->bindValue(':sector', $sector, PDO::PARAM_INT);
            $consulta->bindValue(':puesto', $puesto, PDO::PARAM_INT);
            $consulta->bindValue(':sueldo', $sueldo, PDO::PARAM_INT);
            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_INT);
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
             $consulta->execute();
         
            return $consulta;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //Eliminar un empleado
    public function EliminarEmpleado()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("
                        delete 
                        from empleado 				
                        WHERE id= :id");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->rowCount();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    //Suspender un empleado
    public  function SuspenderEmpleado()
    {
        $fecha = date('Y-m-d');
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {
            $consulta = $objetoAccesoDato->RetornarConsulta(" UPDATE empleado SET estado=:estado,fechaEgreso= :fechaEgreso WHERE id = :id");
        
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':fechaEgreso', $fecha, PDO::PARAM_INT);
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
            return $consulta->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

        //Suspender un empleado
        public  function InsertarHistoricoEmpleado()
        {
             
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
            try {
                $consulta = $objetoAccesoDato->RetornarConsulta("
                INSERT INTO empleado_historico
                ( idEmpleado,nombre, apellido,  dni, sector, puesto, tipo, sueldo, fechaIngreso,fechaEgreso) 
                VALUES (:idEmpleado,:nombre,:apellido,:dni,:sector,:puesto,:tipo,:sueldo,:fechaIngreso,:fechaEgreso)");
               
                $consulta->bindValue(':idEmpleado', $this->id, PDO::PARAM_INT);
                $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_INT);
                $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_INT);
                $consulta->bindValue(':dni',$this->dni, PDO::PARAM_INT);
                $consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);
                $consulta->bindValue(':puesto', $this->puesto, PDO::PARAM_INT);
                $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
                $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
                $consulta->bindValue(':fechaIngreso', $this->fechaIngreso, PDO::PARAM_INT);
                $consulta->bindValue(':fechaEgreso',$this->fechaEgreso, PDO::PARAM_INT);

           
                return $consulta->execute();
                
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
     //Activar un empleado modificando el estado de S a A
    public  function ActivarEmpleado()
    {
        $fecha = date('Y-m-d');
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("
                UPDATE empleado SET
                fechaEgreso=null,
                fechaIngreso=:fechaIngreso,
                estado=:estado
                WHERE id = :id");

            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':fechaIngreso', $fecha, PDO::PARAM_INT);
            $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    //Consulta un empleado por id
    public function ConsultarEmpleadoId()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {

            $consulta = $objetoAccesoDato->RetornarConsulta("
            SELECT id,nombre,apellido,estado, dni, sector, puesto, fechaIngreso,fechaEgreso, tipo, sueldo
                    FROM empleado
                    WHERE id=:id");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
            $buscado = $consulta->fetchObject();
            return $buscado;

        } catch (Exception $e) {
            return '{"error":{"text":'.$e->getMessage().'}}';
        }
    }
    //Consulta un empleado por dni
    public function ConsultarEmpleadoDNI()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        try {
            
            $consulta = $objetoAccesoDato->RetornarConsulta("
            SELECT id,nombre,apellido,estado, dni, sector, puesto, fechaIngreso,fechaEgreso, tipo, sueldo
                    FROM empleado
                    WHERE dni=:dni");

            $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
            $consulta->execute();
            $buscado =  $consulta->fetchAll(PDO::FETCH_ASSOC);

            return $buscado;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

     //Consulta un empleados por sector
     public function ConsultarEmpleadoSector()
     {
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
 
         try {
             
             $consulta = $objetoAccesoDato->RetornarConsulta("
             SELECT id,nombre,apellido,estado, dni, sector, puesto, fechaIngreso, fechaEgreso,tipo, sueldo
                     FROM empleado
                     WHERE sector=:sector");
 
             $consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);
             $consulta->execute();
             $buscado =  $consulta->fetchAll(PDO::FETCH_ASSOC);
 
             return $buscado;
         } catch (Exception $e) {
             return $e->getMessage();
         }
     }

    //Metodo que lista todos los empleados
    public static function ListarEmpleados()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM empleado  ");
            $consulta->execute();
            
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
           
            return $resultado;
           
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

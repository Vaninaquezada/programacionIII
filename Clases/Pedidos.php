<?php 

include_once("AccesoDatos.php");
class Pedidos
{
    public $;
    public $;
    //Da de alta un empleado
    public static function AltaPedido($nombre, $sector, $puesto, $apellido,$estado, $sueldo, $tipo, $dni, $clave, $usuario)
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


}
?>
<?php 
include_once("AccesoDatos.php");
class Sector
{
    public $id;
    public $nombre;
    public $descripcion;

  //Metodo que lista todos los sectores
  public static function ListarEmpleados()
  {
      $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
      try {
          $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
          $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM sector  ");
          $consulta->execute();
          
          $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
         
          return $resultado;
         
      } catch (PDOException $e) {
          return $e->getMessage();
      }
  }

}
?>
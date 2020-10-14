<?php
include_once './Clases/Empleado.php';

class ApiEmpleados
{
    public static function TraerEmpleados($request, $response)
    {
        $emp = Empleados::ListarEmpleados();
        $newResponse = $response->withJson($emp, 200);

        return $newResponse;
    }

    //Da de alta empleado validando que el dni no exista previamente
    public static function AltaEmpleados($request, $response,  $args)
    {
        $ArrayDeParametros = $request->getParsedBody();

        $sector = $ArrayDeParametros['sector'];
        $nombre = $ArrayDeParametros['nombre'];
        $puesto = $ArrayDeParametros['puesto'];
        $apellido = $ArrayDeParametros['apellido'];
        $sueldo = $ArrayDeParametros['sueldo'];
        $tipo = $ArrayDeParametros['tipo'];
        $dni = $ArrayDeParametros['dni'];
        $clave = $ArrayDeParametros['clave'];
        $usuario = $ArrayDeParametros['usuario'];
        $estado = "A";

        //validar que dni no exista previamente
        $emp = Empleados::AltaEmpleado($nombre, $sector, $puesto, $apellido, $estado, $sueldo, $tipo, $dni, $clave, $usuario);
        if ($emp) {
            $newResponse = $response->withJson("El empleado se dio de alta correctamente", 200);
        } else {
            $newResponse = $response->withJson("No se pudo dar de alta el empleado", 400);
        }

        return $newResponse;
    }

    //Modifica empleados en la base de datos
    public static function ModificarEmpleado($request, $response,  $args)
    {
        $ArrayDeParametros = $request->getParsedBody();

        $sector = $ArrayDeParametros['sector'];
        $nombre = $ArrayDeParametros['nombre'];
        $puesto = $ArrayDeParametros['puesto'];
        $apellido = $ArrayDeParametros['apellido'];
        $sueldo = $ArrayDeParametros['sueldo'];
        $tipo = $ArrayDeParametros['tipo'];
        $id = $ArrayDeParametros['id'];


        //validar que dni no exista previamente
        $emp = Empleados::ModificarEmpleado($id, $nombre, $sector, $puesto, $apellido, $sueldo, $tipo);
       
        if ($emp) {
            $newResponse = $response->withJson("El empleado se modifico correctamente", 200);
        } else {
            $newResponse = $response->withJson("No se pudo modificar el empleado", 400);
        }

        return $newResponse;
    }
    //Suspender empleado en la base de datos
    public static function SuspenderEmpleado($request, $response,  $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $empleado = new Empleados();
        $empleado->id = $ArrayDeParametros['id'];
        $empleado->estado = "S";
        $empleado->fechaEgreso = date('Y-m-d');


        $consulta = $empleado->ConsultarEmpleadoId();
      
      if ($consulta) {
         
            $empleado->puesto = $consulta->puesto;
            $empleado->nombre = $consulta->nombre;
            $empleado->apellido = $consulta->apellido;
            $empleado->dni = $consulta->dni;
            $empleado->sector = $consulta->sector;
            $empleado->tipo = $consulta->tipo;
            $empleado->fechaIngreso = $consulta->fechaIngreso;
           
            $hist = $empleado->InsertarHistoricoEmpleado();
            if ($hist) {
                $emp = $empleado->SuspenderEmpleado();
                echo($emp);
                if ($emp) {
                    $newResponse = $response->withJson("El empleado se suspendio correctamente", 200);
                } else {
                    $newResponse = $response->withJson("No se pudo suspender al empleado", 400);
                }
            }else{
                $newResponse = $response->withJson("No se pudo cargar el historico ni suspender al empleado", 400);

            }
        }else{
            $newResponse = $response->withJson("No se encontro un empleado con ese id", 400);

        }


    return $newResponse;
    }
    //Activar empleados en la base de datos
    public static function ActivarEmpleado($request, $response,  $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $empleado = new Empleados();
        $empleado->id = $ArrayDeParametros['id'];
        $empleado->estado = "A";

        $emp = $empleado->ActivarEmpleado();

        if ($emp) {
            $newResponse = $response->withJson("El empleado se activo correctamente", 200);
        } else {
            $newResponse = $response->withJson("No se pudo activo el empleado", 400);
        }

        return $newResponse;
    }
    //Consulta empleados filtrando por id
    public static function TraerEmpleadosPorId($request, $response,  $args)
    {

        $empleado = new Empleados();
        $empleado->id = $args['id'];

        $resultado = $empleado->ConsultarEmpleadoId();
        
        if (!$resultado) {
            $newResponse = $response->withJson("No se encontro empleado con ese id", 204);
        } 
        $newResponse = $response->withJson($resultado, 200);
        return $newResponse;
    }
    //Borra empleado filtrando por id
    public static function EliminarEmpleadoPorId($request, $response,  $args)
    {

        $empleado = new Empleados();
        $empleado->id = $args['id'];

        $resultado = $empleado->EliminarEmpleado();
        $newResponse = $response->withJson($resultado, 200);
        
        if (!$resultado) {
            $newResponse = $response->withJson("No se encontro empleado con ese id", 204);
        } 
       
        return $newResponse;
    }

    //consulta empleados filtrando por dni
    public static function TraerEmpleadosPorDNI($request, $response,  $args)
    {

        $empleado = new Empleados();
        $empleado->dni = $args['dni'];

        $resultado = $empleado->ConsultarEmpleadoDNI();
        $newResponse = $response->withJson($resultado, 200);
        if (!$resultado) {
            $newResponse = $response->withJson("No se encontro empleado con ese dni", 204);
        } 
        return $newResponse;
    }
    //consulta empleados filtrando por sector
    public static function TraerEmpleadosPorSector($request, $response,  $args)
    {

        $empleado = new Empleados();
        $empleado->sector = $args['sector'];

        $resultado = $empleado->ConsultarEmpleadoSector();
        $newResponse = $response->withJson($resultado, 200);

        if (!$resultado) {
            $newResponse = $response->withJson("No se encontro empleado con ese sector", 204);
        } 
        return $newResponse;
    }
}

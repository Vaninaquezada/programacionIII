<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
include_once './Apis/ApiEmpleados.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);
/*
$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});
*/

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->get('/empleado', function (Request $request, Response $response) {    
  $response->getBody()->write("GET => Empleado");
  return $response;

});



//$app->get('/empleados', \ApiEmpleados::class . ':TraerEmpleados');

$app->group('/empleados', function () {
 
    $this->get('[/]', \ApiEmpleados::class . ':TraerEmpleados');
    $this->get('/consultarid/{id}', \ApiEmpleados::class . ':TraerEmpleadosPorId');
    $this->get('/consultardni/{dni}', \ApiEmpleados::class . ':TraerEmpleadosPorDNI');
    $this->get('/consultarsector/{sector}', \ApiEmpleados::class . ':TraerEmpleadosPorSector');
    $this->post('/altaEmpleado', \ApiEmpleados::class . ':AltaEmpleados');
    $this->put('/modificarEmpleado', \ApiEmpleados::class . ':ModificarEmpleado');
    $this->patch('/suspenderempleado', \ApiEmpleados::class . ':SuspenderEmpleado');
    $this->patch('/activarempleado', \ApiEmpleados::class . ':ActivarEmpleado');
    $this->delete('/borrarempleado/{id}', \ApiEmpleados::class . ':EliminarEmpleadoPorId');

  

});



$app->run();



?>


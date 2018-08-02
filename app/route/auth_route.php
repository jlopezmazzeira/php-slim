<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\EmpleadoValidation,
    App\Middleware\AuthMiddleware;

$app->group('/empleado/', function () {
    $this->get('', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'text/html')
                   ->write('Soy una ruta de prueba');
    });
    
    $this->post('autenticar', function ($req, $res, $args) {

        $parametros = $req->getParsedBody();

        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->auth->auth($parametros['Correo'], $parametros['Password'])));
    });
});
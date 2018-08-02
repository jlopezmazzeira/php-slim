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
    
    $this->get('listar/{l}/{p}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->empleado->listar($args['l'], $args['p'])));
    });
    
    $this->get('obtener/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->empleado->obtener($args['id'])));
    });

    $this->post('registrar', function ($req, $res, $args) {

        $r = EmpleadoValidation::validate($req->getParsedBody());
        
        if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));            
        }

        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->empleado->registrar($req->getParsedBody())));
    });

    $this->put('actualizar/{id}', function ($req, $res, $args) {

        $r = EmpleadoValidation::validate($req->getParsedBody());
        
        if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));            
        }

        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->empleado->actualizar($req->getParsedBody(), $args['id'])));
    });

    $this->delete('eliminar/{di}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->empleado->eliminar($args['id'])));
    });
    
    /*$this->post('valida', function ($req, $res, $args) {
        $r = TestValidation::validate($req->getParsedBody());
        
        if(!$r->response){
            return $res->withHeader('Content-type', 'application/json')
                       ->withStatus(422)
                       ->write(json_encode($r->errors));            
        }
        
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->test->getAll()));
    });
    
    $this->get('auth', function ($req, $res, $args) {
        $token = Auth::SignIn([
            'Nombre' => 'Eduardo',
            'Correo' => 'eduardo@anexsoft.com',
            'Imagen' => null
        ]);
        
        $res->write($token);
    });
    
    $this->get('auth/validate', function ($req, $res, $args) {
        $res->write('OK');
    })->add(new AuthMiddleware($this));*/
})->add(new AuthMiddleware($app));
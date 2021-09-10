<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }

        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->error("No existe ninguna instancia de {$model} con el id especificado",404);
        }

        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }

        if($exception instanceof AuthorizationException){
            return $this->error('No posee permisos para ejecutar esta acción',403);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->error('No se encontró la URL especificada',404);
        }

        if($exception instanceof MethodNotAllowedException){
            return $this->error('El método especificado en la petición no es válido',405);
        }

        if($exception instanceof HttpException){
            return $this->error($exception->getMessage(),$exception->getSattusCode());
        }

        if($exception instanceof  QueryException){
            $code = $exception->errorInfo[1];

            if($code == 1451){
                return $this->error('No se puede elminar de forma permanente el recurso por que esta relacionado con otro',409);
            }
        }

        if($exception instanceof InvalidArgumentException){
            return $this->error('No autenticado.', 401);
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }

        return $this->error('Falla inesperada. Intente Despues',500);
//        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->error('No autenticado.', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->error($errors,422);
    }
}

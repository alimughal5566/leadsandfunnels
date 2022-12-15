<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Redirect;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //Note: Customizing Request Handler to redirect on home route for methods not allowed to access by GET (Jaz)
        if ($exception instanceof MethodNotAllowedHttpException || $exception instanceof TokenMismatchException){
            if($request->ajax()){
                $response = array('code'=>$exception->getCode(), 'error'=>$exception->getMessage());
                if(!Auth::user() && $exception instanceof TokenMismatchException) {
                    $response['redirect'] = route('login');
                }
                return response()->json($response, 400);
            }
            else{
                return redirect()->route('dashboard');
            }
        }
        return parent::render($request, $exception);
    }
}

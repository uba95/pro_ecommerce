<?php

namespace App\Exceptions;

use Exception;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        if ($exception instanceof ModelNotFoundException) {

            $model = camelToTitle(class_basename($exception->getModel()));

            if ($request->expectsJson()) {

                return Request::routeIs('admin.*') && Auth::guard('admin')->check() 
                ? Response::json(toastNotification($model, 'not_found')) 
                : Response::json(['error' => "$model Is Not Found"]);
            } else {

                return Request::routeIs('admin.*') && Auth::guard('admin')->check() 
                ? redirect()->route('admin.home')->with(toastNotification($model, 'not_found')) 
                : redirect()->route('pages.landing_page.index')->with(toastNotification($model, 'not_found'));
            }
        }
        
        return parent::render($request, $exception);
    }
}

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) use ($exceptions) {
            if ($response->getStatusCode() === 403) {
                $content = json_decode($response->getContent(), true);
                return response()->json(
                    [
                        'errors' => [
                            'status' => $response->getStatusCode(),
                            'title'  => 'Action not authorized',
                            'detail' => $content['message'] ?? 'Enter valid credentials or contact the system administrator.',
                        ],
                    ],
                    $response->getStatusCode()
                );
            }

            if ($response->getStatusCode() === 404) {
                return response()->json(
                    [
                        'errors' => [
                            'status' => $response->getStatusCode(),
                            'title'  => 'Not Found',
                        ],
                    ],
                    $response->getStatusCode()
                );
            }

            if ($response->getStatusCode() === 422) {
                $array = json_decode($response->getContent(), true);
                $array['status'] = $response->getStatusCode();
                return response()->json(
                    $array,
                    $response->getStatusCode()
                );
            }
            if ($response->getStatusCode() === 500) {
                return response()->json(
                    [
                        'errors' => [
                            'status' => $response->getStatusCode(),
                            'title'  => 'Internal Server Error',
                        ],
                    ],
                    $response->getStatusCode()
                );
            }

            return $response;
        });
    })->create();

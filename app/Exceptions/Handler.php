<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler
{
    /**
     * Convenience method to register the exception format handler with Laravel 11.0 and up
     * @param Exceptions $exceptions
     * @param string $wildcard
     * @return void
     */
    public static function handles(Exceptions $exceptions, string $wildcard): void
    {
        $exceptions->render(function (Exception $exception, Request $request) use ($wildcard) {
            $resultArray = [];

            if (!($exception instanceof ValidationException)) {
                if ($request->is($wildcard)) {
                    $resultArray['message'] = $localizedText ?? $exception->getMessage();
                    $resultArray['type'] = $type ?? collect(explode('\\', get_class($exception)))->last();

                    if (config('app.debug')) {
                        $resultArray['debug'] = array_merge($resultArray, [
                            'exception' => get_class($exception),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                            'trace' => collect($exception->getTrace())->map(fn($trace) => Arr::except($trace, ['args']))->all(),
                        ]);
                    }

                    return response()->json($resultArray, $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500);
                }
            }
        });
    }
}

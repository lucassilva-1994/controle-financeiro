<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FormatValidatorsErrors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response->exception instanceof ValidationException) {
            $errors = $response->exception->validator->errors()->messages();

            throw new HttpResponseException(
                response()->json([
                    'message' => 'Os dados fornecidos são inválidos.',
                    'errors' => collect($errors)->map(function ($messages) {
                        return implode('<br>', $messages);
                    }),
                ], 422)
            );
        }
        return $response;
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomNotAuthorizationException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(
            [
                'message' => $this->getMessage(),
            ],
            $this->getCode()
        );
    }
}

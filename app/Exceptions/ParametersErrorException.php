<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ParametersErrorException extends Exception
{
    public function render()
    {
        $message = $this->getMessage() ?? 'Bad request';

        return response()->json(
            [
                'message' => $message,
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}

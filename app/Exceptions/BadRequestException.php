<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BadRequestException extends Exception
{
    protected $_error = [
        'message' => '',
        'errors' => []
    ];

    public function __construct(string $message = "", array $errors = [], int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->_error['message'] = empty($this->message) ? 'UPS! Something went wrong!' : $this->message;
        $this->_error['errors'] = $errors;
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => $this->_error
        ], 400);
    }
}

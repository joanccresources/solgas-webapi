<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\v1\Helpers;

use App\Exceptions\ApiResponse\InvalidBuild;
use App\Exceptions\ApiResponse\InvalidStatusCode;
use Illuminate\Http\JsonResponse;

final class ApiResponse
{
    private array $errors;
    private $data;
    private string $message;
    private int $status_code = 200;

    protected function __construct($message = '', $status_code = 200)
    {
        $this
            ->withMessage($message)
            ->withStatusCode($status_code);
    }

    public static function createResponse()
    {
        return new static();
    }

    public function build(): JsonResponse
    {
        if (!$this->isValid()) {
            //throw new InvalidBuild('No data, errors or message field in the response.');
            $this->message = "Error";
        }

        return $this->buildResponse();
    }

    private function isValid(): bool
    {
        if (empty($this->data) && empty($this->errors) && empty($this->message)) {
            return false;
        }

        if (!empty($this->data) && !empty($this->errors)) {
            return false;
        }

        return true;
    }

    public function withData($data = null): self
    {
        $this->data = $data;

        return $this;
    }

    public function withErrors($errors = []): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function withMessage(string $message = ''): self
    {
        $this->message = $message;

        return $this;
    }

    public function withStatusCode(int $status_code = 200): self
    {
        if (!is_int($status_code)) {
            throw new InvalidStatusCode('Status code must be an integer');
        }
        $this->status_code = $status_code;

        return $this;
    }

    private function buildResponse(): JsonResponse
    {
        $response = [];
        $response['message'] = $this->message;

        if (!empty($this->data)) {
            $response['data'] = $this->data;
        }

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->status_code);
    }
}

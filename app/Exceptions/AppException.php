<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class AppException extends Exception
{
    protected array $meta    = [];
    protected array $headers = [];

    public function __construct(int $httpCode, string $message, ?array $meta = [])
    {
        $this->meta = $meta ?? [];

        parent::__construct($message, $httpCode);
    }

    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getMeta(?string $key = null): mixed
    {
        if ($key) {
            return Arr::get($this->meta, $key);
        }

        return $this->meta;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders(?string $key = null): mixed
    {
        if ($key) {
            return Arr::get($this->headers, $key);
        }

        return $this->headers;
    }

    public function render(): JsonResponse
    {
        $statusCode = $this->getCode();
        $error      = ['message' => $this->getMessage()];

        if (!is_null($meta = $this->getMeta())) {
            $error['meta'] = $meta;
        }

        return response()->json(['errors' => [$error]], $statusCode, $this->headers);
    }
}

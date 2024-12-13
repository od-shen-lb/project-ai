<?php

namespace App\Data;

final class Token
{
    public function __construct(
        public readonly string $token,
    ) {
    }
}

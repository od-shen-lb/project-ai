<?php

namespace App\Enums;

use ArchTech\Enums\Names;
use ArchTech\Enums\Values;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'HashAlgosEnum',
    description: '密碼雜湊類型',
    type: 'string',
)]
enum HashAlgos: string
{
    use Names;
    use Values;

    case SHA256   = 'sha256';
    case SHA3_512 = 'sha3-512';
}

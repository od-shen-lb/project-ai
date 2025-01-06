<?php

namespace App\Enums;

enum AgentStatusEnum: int
{
    case WAIT_TO_UPLOAD = 1;
    case PROCESSING = 2;
    case UPLOADED = 3;
    case FAILED = 4;

    public function label(): string
    {
        return match ($this) {
            self::WAIT_TO_UPLOAD => '待處理',
            self::PROCESSING => '處理中',
            self::UPLOADED => '已處理',
            self::FAILED => '處理失敗',
        };
    }
}

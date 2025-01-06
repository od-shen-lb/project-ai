<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdmins extends ListRecords
{
    protected static ?string $title = '管理員清單';

    protected static ?string $breadcrumb = '管理員清單';

    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('新增管理員'),
        ];
    }
}

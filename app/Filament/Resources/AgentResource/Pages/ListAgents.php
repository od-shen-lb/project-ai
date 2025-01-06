<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use App\Models\Agent;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAgents extends ListRecords
{
    protected static ?string $title = '機器人清單';

    protected static ?string $breadcrumb = '機器人清單';

    protected static string $resource = AgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('新增Agent')
                ->visible(fn () => $this->canCreate()),
        ];
    }

    protected function canCreate(): bool
    {
        return Agent::where('is_enabled', true)->count() < config('app.agent_upper_limit');
    }
}

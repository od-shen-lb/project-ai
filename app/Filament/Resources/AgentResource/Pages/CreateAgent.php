<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use App\Models\Agent;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Lang;

class CreateAgent extends CreateRecord
{
    protected static string $resource = AgentResource::class;

    protected static ?string $title = '新增機器人';
    protected static bool $canCreateAnother = false;

    protected static ?string $breadcrumb = '新增機器人';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!Agent::where('is_enabled', true)->count() < config('app.agent_upper_limit')) {
            throw new \Exception(Lang::get('agent.create.exception', ['count' => config('app.agent_upper_limit')]));
        }//end if

        return $data;
    }

    protected function getCreatedNotificationTitle(): string
    {
        return '新增機器人成功。';
    }

    protected function afterSave(): void
    {
        $medias = $this->record->getMedia('agent_files');

        if ($medias) {
            // TODO: 建立LLM知識庫job
        }//end if
    }
}

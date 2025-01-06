<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Lang;

class EditAgent extends EditRecord
{
    protected static string $resource = AgentResource::class;

    protected static ?string $title = '編輯機器人';

    protected static ?string $breadcrumb = '編輯機器人';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!($data['is_enabled'] ?? $this->record->is_enabled)) {
            throw new \Exception(Lang::get('agent.edit.exception'));
        }//end if

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): string
    {
        return '編輯機器人成功。';
    }

    protected function afterSave(): void
    {
        $medias = $this->record->getMedia('agent_files');

        if ($medias) {
            // TODO: 異動LLM知識庫job
        }//end if
    }
}

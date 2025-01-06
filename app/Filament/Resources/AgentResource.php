<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Models\Agent;
use App\Models\AgentType;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-server';

    protected static ?string $navigationLabel = 'Agent管理';

    protected static ?string $breadcrumb = 'Agent管理';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make()
                ->steps([
                    // 基本設定
                    Wizard\Step::make(Lang::get('agent.step.basic'))
                        ->schema([
                            TextInput::make('name')
                                ->label(Lang::get('agent.column.name'))
                                ->required()
                                ->maxLength(15),
                            Select::make('model_id')
                                ->label(Lang::get('agent.column.model'))
                                ->required()
                                ->relationship('model', 'name')
                                ->preload(),
                            Select::make('type_id')
                                ->label(Lang::get('agent.column.type'))
                                ->required()
                                ->relationship('type', 'name')
                                ->preload()
                                ->reactive()
                                ->helperText(fn($get) => AgentType::find($get('type_id'))->description ?? ''),
                        ])->columns(),
                    // 知識庫設定
                    Wizard\Step::make(Lang::get('agent.step.knowledge'))
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('agent_file')
                                ->label(Lang::get('agent.column.upload_files', ['limit' => config('app.agent_upload_files_limit')]))
                                ->multiple()
                                ->maxFiles(config('app.agent_upload_files_limit'))
                                ->rules(['max:7168'])
                                ->collection('agent_files')
                                ->preserveFilenames()
                                ->acceptedFileTypes([
                                    'application/pdf',
                                    'text/txt',
                                ])
                                ->getUploadedFileNameForStorageUsing(static function (BaseFileUpload $component, TemporaryUploadedFile $file) {
                                    $fileName      = $file->getClientOriginalName();
                                    $fileExtension = $file->extension();

                                    if (empty($fileExtension)) {
                                        return $fileName . $file->guessClientExtension();
                                    }// end if

                                    return $fileName;
                                })
                                ->downloadable()
                                ->openable()
                                ->previewable(false)
                                ->reactive(),

                            Card::make()
                                ->schema([
                                    Placeholder::make('uploaded_files')
                                        ->label(Lang::get('agent.column.uploaded_files'))
                                        ->content(function ($get) {
                                            $agent = Agent::find($get('id'));
                                            $files = $agent ? collect($agent->media) : collect();

                                            return view('filament.resources.agent_uploaded_files', compact('files'));
                                        }),
                                ]),
                        ]),
                ])
                ->nextAction(
                    fn(Action $action) => $action->label(Lang::get('agent.next_action')),
                )
                ->previousAction(
                    fn(Action $action) => $action->label(Lang::get('agent.previous_action')),
                ),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(Lang::get('agent.column.name')),
                TextColumn::make('created_at')->label(Lang::get('column.created_at'))->dateTime('Y/m/d H:i')->sortable(),
                TextColumn::make('updated_at')->label(Lang::get('column.updated_at'))->dateTime('Y/m/d H:i')->sortable(),
                TextColumn::make('message_count')->default('0' . '/' . config('app.message_upper_limit'))->formatStateUsing(function ($state) {
                    return $state ?? 0 . '/' . config('app.message_upper_limit');
                })->label(Lang::get('agent.column.message')),
                TextColumn::make('file_count')->default('0' . '/' . config('app.knowledge_upper_limit'))->formatStateUsing(function ($state) {
                    return $state ?? 0 . '/' . config('app.knowledge_upper_limit');
                })->label(Lang::get('agent.column.knowledge')),
                ToggleColumn::make('is_enabled')
                    ->label(Lang::get('agent.column.is_enabled'))
                    ->onColor('success')
                    ->offColor('gray')
                    ->action(function ($record, $livewire) {
                        $record->update([
                            'is_enabled' => !$record->is_enabled,
                        ]);
                        $record->touch();
                        // TODO: 開關機器人
                    })
                    ->disabled(function ($record) {
                        return !$record->is_enabled && Agent::where('is_enabled', true)->count() >= config('app.agent_upper_limit');
                    })
                    ->tooltip(function ($record) {
                        if (!$record->is_enabled && Agent::where('is_enabled', true)->count() >= config('app.agent_upper_limit')) {
                            return Lang::get('agent.upper.limit.warning', ['count' => config('app.agent_upper_limit')]);
                        }// end if

                        return null;
                    }),
            ])
            ->filters([

            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->disabled(function ($record) {
                    return !$record->is_enabled;
                }),
                TableAction::make('test')
                    ->label(Lang::get('agent.test_action'))
                    ->action(function ($record) {
                        // TODO: 測試機器人
                    })
                    ->color('success')
                    ->icon('heroicon-o-play')
                    ->disabled(function ($record) {
                        return !$record->is_enabled;
                    }),
            ])
            ->headerActions([
                TableAction::make('plan_info')
                    ->label(function () {
                        $labelAry = [
                            Lang::get('agent.purchased.plan', [
                                'plan_name' => config('app.purchased_plan_name'),
                            ]),
                            Lang::get('agent.purchased.description', [
                                'agent_upper_limit' => config('app.agent_upper_limit'),
                                'message_upper_limit' => config('app.message_upper_limit'),
                                'knowledge_upper_limit' => config('app.knowledge_upper_limit'),
                            ]),
                        ];
                        return implode('，', $labelAry);
                    })
                    ->color('secondary')
                    ->disabled(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit'   => Pages\EditAgent::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('agent.model.label');
    }
}

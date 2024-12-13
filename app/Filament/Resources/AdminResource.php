<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\Pages\CreateAdmin;
use App\Models\Admin;
use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = '管理員管理';

    protected static ?string $breadcrumb = '管理員管理';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('姓名')->required()->maxLength(255),
                TextInput::make('email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('密碼（請填寫8碼英數字以上）')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(Page $livewire) => ($livewire instanceof CreateAdmin))
                    ->alphaNum()
                    ->minLength(8)
                    ->maxLength(255),

                Select::make('roles')
                    ->label('角色')
                    ->relationship('roles', 'name')
                    ->options(function () {
                        if (auth()->user()->hasRole('AI管理員')) {
                            return Role::where('name', '!=', '系統管理員')->pluck('name', 'id');
                        }//end if

                        return Role::all()->pluck('name', 'id');
                    })
                    ->disabled(auth()->user()->hasRole('AI管理員'))
                    ->default(function () {
                        if (auth()->user()->hasRole('AI管理員')) {
                            return 2;
                        }//end if
                    })
                    ->saveRelationshipsWhenDisabled(true) // Enable saving relationships when disabled
                    ->preload(),

                Toggle::make('is_activated')
                    ->label('帳號啟用')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('roles.name')->label('角色')->sortable(),
                TextColumn::make('name')->label('姓名')->searchable(),
                TextColumn::make('email')->searchable(),
                IconColumn::make('is_activated')->label('帳號啟用')->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('created_at')->label('建立時間')->dateTime('Y年m月d日')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit'   => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('AI管理員')) {
            return parent::getEloquentQuery()->role('AI管理員');
        }//end if

        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}

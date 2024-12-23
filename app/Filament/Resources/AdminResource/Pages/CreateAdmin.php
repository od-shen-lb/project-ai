<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\Admin;
use App\Notifications\SetPasswordNotification;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Password;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected static ?string $title = '新增管理員';

    protected static bool $canCreateAnother = false;

    protected static ?string $breadcrumb = '新增管理員';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return '新增管理員設定成功。';
    }

    protected function afterCreate(): void
    {
        /** @var Admin $admin */
        $admin = $this->record;

        Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
            ['email' => $admin->email],
            function (CanResetPassword $admin, string $token): void {
                if (! method_exists($admin, 'notify')) {
                    $adminClass = $admin::class;

                    throw new \Exception("Model [{$adminClass}] does not have a [notify()] method.");
                }//end if

                $notification = new SetPasswordNotification($token);
                $admin->notify($notification);
            },
        );
    }
}

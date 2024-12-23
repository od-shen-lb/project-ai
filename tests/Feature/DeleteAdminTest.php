<?php

use App\Filament\Resources\AdminResource\Pages\ListAdmins;
use App\Models\Admin;
use Filament\Tables\Actions\DeleteBulkAction;

use function Pest\Livewire\livewire;

it('admin can delete all kinds of admins with bulk delete', function () {
    $admins = Admin::get();
    $this->actingAs(Admin::where('email', 'admin1@test.com')->first());

    livewire(ListAdmins::class)
        ->assertTableActionDoesNotExist('delete')
        ->callTableBulkAction(DeleteBulkAction::class, $admins)
        ->assertHasNoTableActionErrors();

    foreach ($admins as $admin) {
        $this->assertSoftDeleted($admin);
    }//end foreach
});

<?php

namespace Tests\Feature;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\AdminResource\Pages\ListAdmins;
use App\Models\Admin;

use function Pest\Livewire\livewire;

it('admin can see all admins', function () {
    $this->actingAs(Admin::where('email', 'admin1@test.com')->first());
    $this->get(AdminResource::getUrl('index'))->assertSuccessful();

    $admins          = Admin::get();
    $firstTenRecords = $admins->take(10);

    livewire(ListAdmins::class)
        ->assertTableActionExists('edit')
        ->assertCountTableRecords(2)
        ->assertCanSeeTableRecords($firstTenRecords);
});

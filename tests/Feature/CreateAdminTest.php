<?php

namespace Tests\Feature;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\AdminResource\Pages\CreateAdmin;
use App\Models\Admin;

use function Pest\Livewire\livewire;

it('admin can create all kinds of admins', function (
    string $name,
    string $email,
    array $roles
) {
    $this->actingAs(Admin::where('email', 'admin1@test.com')->first());
    $this->get(AdminResource::getUrl('create'))->assertSuccessful();

    livewire(CreateAdmin::class)
        ->assertFormSet([
            'is_activated' => true,
        ])
        ->fillForm([
            'name'     => $name,
            'email'    => $email,
            'roles'    => $roles,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = Admin::where('email', $email)->first();

    $this->assertDatabaseHas('model_has_roles', [
        'role_id'  => $roles[0],
        'model_id' => $user->id,
    ]);

    $this->assertDatabaseHas('admins', [
        'name'  => $name,
        'email' => $email,
    ]);
})->with([
    'ai-admin' => [
        'ai-admin',
        'ai-admin@mail.com',
        [1],
    ],
    'admin'    => [
        'admin',
        'admin@mail.com',
        [2],
    ],
]);

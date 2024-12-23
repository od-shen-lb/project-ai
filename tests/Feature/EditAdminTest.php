<?php

namespace Tests\Feature;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\AdminResource\Pages\EditAdmin;
use App\Models\Admin;

use function Pest\Livewire\livewire;

it('admin can edit all kinds of admins', function (
    string $name,
    string $email,
    array $roles
) {
    $this->actingAs(Admin::where('email', 'admin1@test.com')->first());
    $admin = Admin::factory()->create();

    $this->get(AdminResource::getUrl('edit', [
        'record' => $admin,
    ]))->assertSuccessful();

    livewire(EditAdmin::class, [
        'record' => $admin->getRouteKey(),
    ])
        ->fillForm([
            'name'     => $name,
            'email'    => $email,
            'roles'    => $roles,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($admin->refresh())
        ->name->toBe($name)
        ->email->toBe($email);

    $this->assertDatabaseHas('admins', [
        'name'        => $name,
        'email'       => $email,
    ]);

    $this->assertDatabaseHas('model_has_roles', [
        'role_id'  => $roles[0],
        'model_id' => $admin->id,
    ]);
})->with([
    'admin'    => [
        'admin1',
        'admin@mail.com',
        [1],
    ],
]);

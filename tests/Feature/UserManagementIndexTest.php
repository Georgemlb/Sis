<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

test('users index exposes formatted created and updated timestamps', function () {
    $admin = User::factory()->create([
        'username' => 'zzz_admin',
        'account_type' => 'admin',
    ]);

    User::factory()->create([
        'username' => 'aaa_user',
        'account_type' => 'staff',
        'created_on' => '2026-04-21 10:11:12',
        'updated_on' => '2026-04-22 12:13:14',
    ]);

    $response = $this->actingAs($admin)->get(route('users.index'));

    $response
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/Index')
            ->where('users.0.username', 'aaa_user')
            ->where('users.0.created_on', '2026/04/21 10:11')
            ->where('users.0.updated_on', '2026/04/22 12:13'),
        );
});

<?php

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('staff can create a subject without selecting a program', function () {
    $staff = User::factory()->create([
        'account_type' => 'staff',
    ]);

    $response = $this->actingAs($staff)->post(route('subjects.store'), [
        'code' => 'IT201',
        'title' => 'Web Development',
        'unit' => 3,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('subjects.index'));

    $subject = Subject::query()->where('code', 'IT201')->first();

    expect($subject)->not->toBeNull();
    $this->assertDatabaseHas('subject', [
        'code' => 'IT201',
        'title' => 'Web Development',
        'unit' => 3,
    ]);
});

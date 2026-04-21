<?php

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

test('guest users are redirected to login on protected catalog pages', function () {
    $this->get('/programs')->assertRedirect('/login');
    $this->get('/subjects')->assertRedirect('/login');
    $this->get('/users')->assertRedirect('/login');
});

test('admin can access user management pages', function () {
    $admin = User::factory()->create([
        'account_type' => 'admin',
    ]);

    $this->actingAs($admin)->get('/users')->assertOk();
    $this->actingAs($admin)->get('/users/create')->assertOk();
});

test('staff can edit catalog but cannot access user management', function () {
    $staff = User::factory()->create([
        'account_type' => 'staff',
    ]);

    $subject = Subject::query()->create([
        'code' => 'IT101',
        'title' => 'Introduction to Computing',
        'unit' => 3,
    ]);

    $this->actingAs($staff)->get('/programs/create')->assertOk();
    $this->actingAs($staff)->get("/subjects/{$subject->subject_id}/edit")->assertOk();
    $this->actingAs($staff)->get('/users')->assertForbidden();
});

test('teacher can view catalog but cannot edit catalog or users', function () {
    $teacher = User::factory()->create([
        'account_type' => 'teacher',
    ]);

    $subject = Subject::query()->create([
        'code' => 'CS102',
        'title' => 'Data Structures',
        'unit' => 3,
    ]);

    $this->actingAs($teacher)->get('/programs')->assertOk();
    $this->actingAs($teacher)->get('/subjects')->assertOk();
    $this->actingAs($teacher)->get('/programs/create')->assertForbidden();
    $this->actingAs($teacher)->get("/subjects/{$subject->subject_id}/edit")->assertForbidden();
    $this->actingAs($teacher)->get('/users')->assertForbidden();
});

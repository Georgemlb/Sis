<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

test('staff can manage programs and subjects through policies', function () {
    $staff = User::factory()->create([
        'account_type' => 'staff',
    ]);

    expect(Gate::forUser($staff)->allows('create', Program::class))->toBeTrue();
    expect(Gate::forUser($staff)->allows('update', new Program))->toBeTrue();
    expect(Gate::forUser($staff)->allows('create', Subject::class))->toBeTrue();
    expect(Gate::forUser($staff)->allows('update', new Subject))->toBeTrue();
});

test('teacher cannot manage programs subjects or users', function () {
    $teacher = User::factory()->create([
        'account_type' => 'teacher',
    ]);

    expect(Gate::forUser($teacher)->allows('create', Program::class))->toBeFalse();
    expect(Gate::forUser($teacher)->allows('update', new Program))->toBeFalse();
    expect(Gate::forUser($teacher)->allows('create', Subject::class))->toBeFalse();
    expect(Gate::forUser($teacher)->allows('update', new Subject))->toBeFalse();
    expect(Gate::forUser($teacher)->allows('create', User::class))->toBeFalse();
});

test('admin can manage users but cannot delete their own account', function () {
    $admin = User::factory()->create([
        'account_type' => 'admin',
    ]);

    $otherUser = User::factory()->create();

    expect(Gate::forUser($admin)->allows('viewAny', User::class))->toBeTrue();
    expect(Gate::forUser($admin)->allows('create', User::class))->toBeTrue();
    expect(Gate::forUser($admin)->allows('update', $otherUser))->toBeTrue();
    expect(Gate::forUser($admin)->allows('delete', $otherUser))->toBeTrue();
    expect(Gate::forUser($admin)->allows('delete', $admin))->toBeFalse();
});

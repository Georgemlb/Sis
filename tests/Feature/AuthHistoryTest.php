<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the login page sends no-store cache headers', function () {
    $response = $this->get('/login');

    $cacheControl = $response->headers->get('Cache-Control');

    $response
        ->assertOk()
        ->assertHeader('Pragma', 'no-cache');

    expect($cacheControl)->toContain('no-store');
    expect($cacheControl)->toContain('no-cache');
    expect($cacheControl)->toContain('must-revalidate');
    expect($cacheControl)->toContain('max-age=0');
});

test('authenticated users are redirected away from the login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/login')
        ->assertRedirect(route('dashboard'));
});

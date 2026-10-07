<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests visiting admin are redirected to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('login'))->assertOk()->assertSee('Admin Login');
});

test('authenticated users can view the dashboard and skip the login page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertOk()->assertViewIs('admin.dashboard.index');
    $this->get(route('login'))->assertRedirect(route('admin.dashboard'));
});

test('users can log in and return to the dashboard', function () {
    $user = User::factory()->create(['password' => 'correct-password']);

    $this->get(route('admin.dashboard'));
    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'correct-password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

test('incorrect passwords do not authenticate users', function () {
    $user = User::factory()->create();

    $this->from(route('login'))->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'incorrect-password',
    ])->assertRedirect(route('login'))->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('users can log out and their session is cleared', function () {
    $this->actingAs(User::factory()->create())->withSession(['dashboard_state' => 'private']);

    $this->post(route('logout'))
        ->assertRedirect(route('login'))
        ->assertSessionMissing('dashboard_state');

    $this->assertGuest();
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('guests attempting to log out are redirected to login', function () {
    $this->post(route('logout'))->assertRedirect(route('login'));
});

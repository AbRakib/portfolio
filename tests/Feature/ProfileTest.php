<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('guests cannot edit or save the portfolio', function () {
    $this->get(route('admin.portfolio.edit'))->assertRedirect(route('login'));
    $this->put(route('admin.portfolio.update'), [])->assertRedirect(route('login'));
});

test('dashboard links to the portfolio edit form', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertSee(route('admin.portfolio.edit'));
    $this->get(route('admin.portfolio.edit'))->assertOk()->assertViewIs('admin.portfolio.edit');
});

test('the edit page displays the existing profile', function () {
    $profile = Profile::factory()->create(['date_of_birth' => '1990-01-15']);
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.portfolio.edit'))->assertSee($profile->name)->assertSee($profile->email)->assertSee('1990-01-15');
});

test('saving creates the first profile and updates it on subsequent saves', function () {
    $this->actingAs(User::factory()->create());
    $data = ['name' => 'Rakib', 'email' => 'rakib@example.com', 'phone' => '0123456789', 'address' => 'Dhaka', 'date_of_birth' => '1990-01-15', 'facebook_url' => 'https://facebook.com/rakib', 'youtube_url' => 'https://youtube.com/@rakib', 'instagram_url' => 'https://instagram.com/rakib', 'twitter_url' => 'https://twitter.com/rakib', 'linkedin_url' => 'https://linkedin.com/in/rakib'];

    $this->put(route('admin.portfolio.update'), $data)->assertRedirect(route('admin.portfolio.edit'))->assertSessionHas('status');
    $this->assertDatabaseHas('profiles', $data);

    $data['name'] = 'Updated Rakib';
    $this->put(route('admin.portfolio.update'), $data)->assertSessionHasNoErrors();
    $this->assertDatabaseCount('profiles', 1);
    $this->assertDatabaseHas('profiles', $data);
});

test('invalid profile data is rejected without saving', function () {
    $this->actingAs(User::factory()->create());

    $this->put(route('admin.portfolio.update'), ['name' => '', 'email' => 'invalid', 'facebook_url' => 'invalid', 'date_of_birth' => 'not-a-date'])->assertSessionHasErrors(['name', 'email', 'facebook_url', 'date_of_birth']);
    $this->assertDatabaseCount('profiles', 0);
});

test('a photo can be uploaded and retained without a replacement', function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
    $data = ['name' => 'Rakib', 'email' => 'rakib@example.com'];

    $this->put(route('admin.portfolio.update'), [...$data, 'photo' => UploadedFile::fake()->image('photo.jpg')])->assertSessionHasNoErrors();
    $photo = Profile::query()->firstOrFail()->photo;
    Storage::disk('public')->assertExists($photo);

    $this->put(route('admin.portfolio.update'), $data)->assertSessionHasNoErrors();
    $this->assertDatabaseHas('profiles', ['photo' => $photo]);
});

<?php

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot manage blogs', function () {
    $blog = Blog::factory()->create();

    $this->get(route('admin.blogs.index'))->assertRedirect(route('login'));
    $this->get(route('admin.blogs.create'))->assertRedirect(route('login'));
    $this->post(route('admin.blogs.store'), [])->assertRedirect(route('login'));
    $this->get(route('admin.blogs.edit', $blog))->assertRedirect(route('login'));
    $this->put(route('admin.blogs.update', $blog), [])->assertRedirect(route('login'));
    $this->delete(route('admin.blogs.destroy', $blog))->assertRedirect(route('login'));
});

test('blogs are listed from the sidebar menu', function () {
    $blog = Blog::factory()->create(['title' => 'My First Blog']);
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.dashboard'))->assertSee(route('admin.blogs.index'));
    $this->get(route('admin.blogs.index'))
        ->assertOk()
        ->assertViewIs('admin.blogs.index')
        ->assertSee($blog->title);
});

test('an authenticated user can create a blog', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('admin.blogs.store'), [
        'title' => 'Launch Notes',
        'excerpt' => 'A quick summary.',
        'content' => 'The full blog body.',
        'is_published' => '1',
        'published_at' => '2026-10-11 10:00:00',
    ])->assertRedirect(route('admin.blogs.index'))->assertSessionHas('status');

    $this->assertDatabaseHas('blogs', [
        'title' => 'Launch Notes',
        'slug' => 'launch-notes',
        'is_published' => true,
    ]);
});

test('an authenticated user can update and unpublish a blog', function () {
    $blog = Blog::factory()->create(['is_published' => true]);
    $this->actingAs(User::factory()->create());

    $this->put(route('admin.blogs.update', $blog), [
        'title' => 'Updated Blog',
        'is_published' => '0',
        'excerpt' => '',
        'content' => 'Updated content.',
        'published_at' => '',
    ])->assertRedirect(route('admin.blogs.index'))->assertSessionHas('status');

    $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'title' => 'Updated Blog',
        'slug' => 'updated-blog',
        'is_published' => false,
    ]);
});

test('invalid blog data is rejected', function () {
    $this->actingAs(User::factory()->create());

    $this->post(route('admin.blogs.store'), [
        'title' => '',
        'content' => '',
    ])->assertSessionHasErrors(['title', 'content']);
});

test('repeated blog titles receive a unique generated slug', function () {
    Blog::factory()->create(['slug' => 'launch-notes']);
    $this->actingAs(User::factory()->create());

    $this->post(route('admin.blogs.store'), [
        'title' => 'Launch Notes',
        'slug' => 'client-provided-slug',
        'content' => 'Another launch.',
    ])->assertRedirect(route('admin.blogs.index'))->assertSessionHasNoErrors();

    $this->assertDatabaseHas('blogs', [
        'title' => 'Launch Notes',
        'slug' => 'launch-notes-2',
    ]);
});

test('an authenticated user can delete a blog', function () {
    $blog = Blog::factory()->create();
    $this->actingAs(User::factory()->create());

    $this->delete(route('admin.blogs.destroy', $blog))->assertRedirect(route('admin.blogs.index'))->assertSessionHas('status');

    $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
});

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('admin.blogs.index', [
            'blogs' => Blog::query()->latest()->paginate(10),
            'pageTitle' => 'Blogs',
        ]);
    }

    public function create(): View
    {
        return view('admin.blogs.create', [
            'blog' => new Blog,
            'pageTitle' => 'Create Blog',
        ]);
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateSlug($data['title']);

        Blog::query()->create($data);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog created successfully.');
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'pageTitle' => 'Edit Blog',
        ]);
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateSlug($data['title'], $blog);
        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('status', 'Blog deleted successfully.');
    }

    private function generateSlug(string $title, ?Blog $blog = null): string
    {
        $baseSlug = substr(Str::slug($title), 0, 240) ?: 'blog';
        $slug = $baseSlug;
        $suffix = 2;

        while (Blog::query()->where('slug', $slug)->when($blog !== null, fn ($query) => $query->where('id', '!=', $blog->id))->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        return $slug;
    }
}

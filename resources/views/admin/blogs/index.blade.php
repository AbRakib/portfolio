@extends('admin.layouts.app')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-3 pb-7.5">
            <h1 class="text-xl font-medium text-mono">Blogs</h1>
            <button class="kt-btn kt-btn-primary" id="add_blog_button" data-kt-modal-toggle="#create_blog_modal" type="button" aria-haspopup="dialog" aria-controls="create_blog_modal"><i class="ki-filled ki-plus"></i> Add Blog</button>
        </div>

        @if (session('status'))
            <p class="text-sm text-success pb-5" role="status">{{ session('status') }}</p>
        @endif

        <div class="overflow-x-auto border border-border rounded-lg">
            <table class="table-auto w-full text-sm text-left">
                <thead class="bg-muted text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-medium">Title</th>
                        <th class="px-4 py-3 font-medium">Slug</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Published</th>
                        <th class="px-4 py-3 font-medium text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($blogs as $blog)
                        <tr>
                            <td class="px-4 py-3 font-medium text-foreground">{{ $blog->title }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $blog->slug }}</td>
                            <td class="px-4 py-3">
                                <span class="kt-badge {{ $blog->is_published ? 'kt-badge-success' : 'kt-badge-secondary' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span>
                            </td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $blog->published_at?->format('M d, Y H:i') ?? 'Not set' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <button class="kt-btn kt-btn-sm kt-btn-outline" type="button" data-kt-modal-toggle="#create_blog_modal" data-blog-edit data-blog="{{ json_encode(['id' => $blog->id, 'title' => $blog->title, 'excerpt' => $blog->excerpt, 'content' => $blog->content, 'url' => route('admin.blogs.update', $blog)]) }}" aria-haspopup="dialog" aria-controls="create_blog_modal"><i class="ki-filled ki-pencil"></i> Edit</button>
                                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="kt-btn kt-btn-sm kt-btn-destructive" type="submit"><i class="ki-filled ki-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-8 text-center text-muted-foreground" colspan="5">No blogs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-5">
            {{ $blogs->links() }}
        </div>
    </div>

    <div class="kt-modal" data-kt-modal="true" id="create_blog_modal" role="dialog" aria-modal="true" aria-labelledby="create_blog_modal_title" tabindex="-1">
        <div class="kt-modal-content top-5" style="width: 700px; max-width: calc(100vw - 32px);">
            <div class="kt-modal-header">
                <h2 class="kt-modal-title" id="create_blog_modal_title">Add Blog</h2>
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true" type="button" aria-label="Close add blog" title="Close">
                    <i class="ki-filled ki-cross" aria-hidden="true"></i>
                </button>
            </div>
            <form action="{{ route('admin.blogs.store') }}" method="POST" class="kt-modal-body flex flex-col gap-5" style="max-height: 75vh; overflow-y: auto;">
                <input type="hidden" name="_method" id="blog_form_method" value="{{ old('_method', 'POST') }}">
                <input type="hidden" name="editing_blog_id" id="editing_blog_id" value="{{ old('editing_blog_id') }}">
                @include('admin.blogs._form', ['blog' => new \App\Models\Blog, 'inModal' => true])
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addButton = document.getElementById('add_blog_button');
            const form = document.getElementById('blog_form_method').form;
            const heading = document.getElementById('create_blog_modal_title');
            const content = document.getElementById('blog_content');

            function configureForm(blog = null, keepValues = false) {
                form.action = blog ? blog.url : @json(route('admin.blogs.store'));
                heading.textContent = blog ? 'Edit Blog' : 'Add Blog';
                document.getElementById('blog_form_method').value = blog ? 'PUT' : 'POST';
                document.getElementById('editing_blog_id').value = blog ? blog.id : '';
                if (!keepValues) {
                    for (const field of ['title', 'excerpt', 'content']) {
                        form.elements.namedItem(field).value = blog?.[field] ?? '';
                    }
                    content.dispatchEvent(new Event('blog-content-reset'));
                    form.querySelectorAll('[role="alert"]').forEach(error => error.hidden = true);
                }
            }

            addButton.addEventListener('click', () => configureForm());
            document.querySelectorAll('[data-blog-edit]').forEach(button => {
                button.addEventListener('click', () => configureForm(JSON.parse(button.dataset.blog)));
            });

            @if ($errors->any())
                window.addEventListener('load', () => {
                    const editingId = document.getElementById('editing_blog_id').value;
                    const blog = editingId ? {id: editingId, url: @json(url('/admin/blogs')) + '/' + encodeURIComponent(editingId)} : null;
                    const values = Object.fromEntries(['title', 'excerpt', 'content'].map(field => [field, form.elements.namedItem(field).value]));
                    addButton.click();
                    configureForm(blog, true);
                    for (const [field, value] of Object.entries(values)) form.elements.namedItem(field).value = value;
                    content.dispatchEvent(new Event('blog-content-reset'));
                    form.querySelectorAll('[role="alert"]').forEach(error => error.hidden = false);
                });
            @endif
        });
    </script>
@endsection

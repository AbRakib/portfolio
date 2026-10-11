@csrf

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="flex flex-col gap-2 min-w-0">
        <label class="kt-form-label" for="title">Title</label>
        <input class="kt-input w-full" id="title" name="title" type="text" value="{{ old('title', $blog->title) }}" maxlength="255" required>
        @error('title')
            <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="flex flex-col gap-2">
    <label class="kt-form-label" for="excerpt">Excerpt</label>
    <textarea class="kt-textarea w-full" id="excerpt" name="excerpt" rows="3" maxlength="1000">{{ old('excerpt', $blog->excerpt) }}</textarea>
    @error('excerpt')
        <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
    @enderror
</div>

<div class="flex flex-col gap-2">
    <label class="kt-form-label" id="content_label" for="blog_content">Content</label>
    <div id="content_editor_wrapper" hidden>
        <div class="flex flex-wrap gap-2 pb-2" role="toolbar" aria-label="Content formatting">
            @foreach (['bold' => ['ki-text-bold', 'Bold'], 'italic' => ['ki-text-italic', 'Italic'], 'underline' => ['ki-text-underline', 'Underline'], 'insertUnorderedList' => ['ki-element-8', 'Bullet list'], 'insertOrderedList' => ['ki-menu', 'Numbered list'], 'undo' => ['ki-arrow-left', 'Undo'], 'redo' => ['ki-arrow-right', 'Redo']] as $command => [$icon, $label])
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" type="button" data-editor-command="{{ $command }}" title="{{ $label }}" aria-label="{{ $label }}"><i class="ki-filled {{ $icon }}" aria-hidden="true"></i></button>
            @endforeach
        </div>
        <div id="content_editor" class="kt-textarea w-full" contenteditable="true" role="textbox" aria-multiline="true" aria-required="true" aria-labelledby="content_label" style="min-height: 220px; max-height: 400px; overflow-y: auto; white-space: pre-wrap;"></div>
    </div>
    <textarea class="kt-textarea w-full" id="blog_content" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
    @error('content')
        <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
    @enderror
</div>

@if (! ($inModal ?? false))
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <label class="flex items-center gap-2 text-sm font-medium text-foreground">
        <input class="kt-checkbox" name="is_published" type="checkbox" value="1" @checked(old('is_published', $blog->is_published))>
        Published
    </label>

    <div class="flex flex-col gap-2 min-w-0">
        <label class="kt-form-label" for="published_at">Published At</label>
        <input class="kt-input w-full" id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
        @error('published_at')
            <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
        @enderror
    </div>
</div>
@endif

<div class="flex flex-wrap gap-3">
    <button class="kt-btn kt-btn-primary" type="submit"><i class="ki-filled ki-check"></i> Save Blog</button>
    @if ($inModal ?? false)
        <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true" type="button">Cancel</button>
    @else
        <a class="kt-btn kt-btn-outline" href="{{ route('admin.blogs.index') }}">Cancel</a>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const textarea = document.getElementById('blog_content');
        const editor = document.getElementById('content_editor');
        const parsed = new DOMParser().parseFromString(textarea.value, 'text/html');
        const allowedTags = new Set(['P', 'BR', 'DIV', 'STRONG', 'B', 'EM', 'I', 'U', 'UL', 'OL', 'LI']);

        function copyContent(source, target) {
            for (const node of source.childNodes) {
                if (node.nodeType === Node.TEXT_NODE) {
                    target.append(document.createTextNode(node.textContent));
                } else if (node.nodeType === Node.ELEMENT_NODE && !['SCRIPT', 'STYLE'].includes(node.tagName)) {
                    const element = allowedTags.has(node.tagName) ? document.createElement(node.tagName) : document.createDocumentFragment();
                    copyContent(node, element);
                    target.append(element);
                }
            }
        }

        copyContent(parsed.body, editor);
        textarea.addEventListener('blog-content-reset', () => {
            editor.replaceChildren();
            copyContent(new DOMParser().parseFromString(textarea.value, 'text/html').body, editor);
        });
        textarea.hidden = true;
        textarea.required = false;
        document.getElementById('content_editor_wrapper').hidden = false;
        document.getElementById('content_label').htmlFor = 'content_editor';

        document.querySelectorAll('[data-editor-command]').forEach(button => {
            button.addEventListener('mousedown', event => event.preventDefault());
            button.addEventListener('click', () => {
                editor.focus();
                document.execCommand(button.dataset.editorCommand);
            });
        });

        editor.addEventListener('paste', event => {
            event.preventDefault();
            document.execCommand('insertText', false, event.clipboardData.getData('text/plain'));
        });

        textarea.form.addEventListener('submit', event => {
            if (!editor.textContent.trim()) {
                event.preventDefault();
                editor.focus();
                return;
            }
            const cleanContent = document.createElement('div');
            copyContent(editor, cleanContent);
            textarea.value = cleanContent.innerHTML;
        });
    });
</script>

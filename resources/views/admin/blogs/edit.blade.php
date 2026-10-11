@extends('admin.layouts.app')

@section('content')
    <div class="kt-container-fixed">
        <h1 class="text-xl font-medium text-mono pb-7.5">Edit Blog</h1>
        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" class="flex flex-col gap-5 pb-7.5">
            @method('PUT')
            @include('admin.blogs._form')
        </form>
    </div>
@endsection

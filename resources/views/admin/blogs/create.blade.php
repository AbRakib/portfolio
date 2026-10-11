@extends('admin.layouts.app')

@section('content')
    <div class="kt-container-fixed">
        <h1 class="text-xl font-medium text-mono pb-7.5">Create Blog</h1>
        <form action="{{ route('admin.blogs.store') }}" method="POST" class="flex flex-col gap-5 pb-7.5">
            @include('admin.blogs._form')
        </form>
    </div>
@endsection

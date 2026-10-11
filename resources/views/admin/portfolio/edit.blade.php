@extends('admin.layouts.app')

@section('content')
    <div class="kt-container-fixed">
        <h1 class="text-xl font-medium text-mono pb-7.5">Edit Portfolio</h1>
        @if (session('status'))
            <p class="text-sm text-success pb-5" role="status">{{ session('status') }}</p>
        @endif
        <form action="{{ route('admin.portfolio.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5 pb-7.5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach (['name' => ['Name', 'text'], 'email' => ['Email', 'email'], 'phone' => ['Phone', 'tel'], 'date_of_birth' => ['Date of Birth', 'date'], 'facebook_url' => ['Facebook URL', 'url'], 'youtube_url' => ['YouTube URL', 'url'], 'instagram_url' => ['Instagram URL', 'url'], 'twitter_url' => ['Twitter URL', 'url'], 'linkedin_url' => ['LinkedIn URL', 'url']] as $field => [$label, $type])
                    <div class="flex flex-col gap-2 min-w-0">
                        <label class="kt-form-label" for="{{ $field }}">{{ $label }}</label>
                        <input class="kt-input w-full" id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field, $field === 'date_of_birth' ? $profile->date_of_birth?->format('Y-m-d') : $profile->{$field}) }}" @required(in_array($field, ['name', 'email'])) @if ($type !== 'date') maxlength="255" @else max="{{ now()->toDateString() }}" @endif>
                        @error($field)
                            <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col gap-2">
                <label class="kt-form-label" for="address">Address</label>
                <textarea class="kt-textarea w-full" id="address" name="address" rows="3" maxlength="10000">{{ old('address', $profile->address) }}</textarea>
                @error('address')
                    <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label class="kt-form-label" for="photo">Photo</label>
                @if ($profile->photo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile->photo) }}" alt="Profile photo" class="size-20 rounded object-cover" width="80" height="80">
                @endif
                <input class="kt-input w-full" id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp">
                @error('photo')
                    <p class="text-sm text-destructive" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="kt-btn kt-btn-primary" type="submit"><i class="ki-filled ki-check"></i> Save Changes</button>
                <a class="kt-btn kt-btn-outline" href="{{ route('admin.dashboard') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection

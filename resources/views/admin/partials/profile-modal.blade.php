<div class="kt-modal" data-kt-modal="true" id="profile_modal" role="dialog" aria-modal="true" aria-labelledby="profile_modal_title" tabindex="-1">
    <div class="kt-modal-content max-w-[500px] top-5 lg:top-[10%]">
        <div class="kt-modal-header">
            <h2 class="kt-modal-title" id="profile_modal_title">Profile Details</h2>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true" type="button" aria-label="Close profile details" title="Close">
                <i class="ki-filled ki-cross" aria-hidden="true"></i>
            </button>
        </div>
        <div class="kt-modal-body flex flex-col gap-5" style="max-height: 70vh; overflow-y: auto;">
            @if ($portfolioProfile)
                <div class="flex items-center gap-4">
                    @if ($portfolioProfile->photo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($portfolioProfile->photo) }}" alt="{{ $portfolioProfile->name }}" class="size-20 rounded object-cover shrink-0" width="80" height="80">
                    @endif
                    <h3 class="text-lg font-semibold text-mono" style="overflow-wrap: anywhere;">{{ $portfolioProfile->name }}</h3>
                </div>
                <dl class="flex flex-col gap-4">
                    @foreach (['email' => 'Email', 'phone' => 'Phone', 'address' => 'Address', 'date_of_birth' => 'Date of Birth', 'facebook_url' => 'Facebook URL', 'youtube_url' => 'YouTube URL', 'instagram_url' => 'Instagram URL', 'twitter_url' => 'Twitter URL', 'linkedin_url' => 'LinkedIn URL'] as $field => $label)
                        <div class="flex flex-col gap-1">
                            <dt class="text-xs text-secondary-foreground">{{ $label }}</dt>
                            <dd class="text-sm text-foreground" style="overflow-wrap: anywhere; white-space: pre-line;">{{ $field === 'date_of_birth' ? ($portfolioProfile->date_of_birth?->format('M j, Y') ?? 'Not provided') : ($portfolioProfile->{$field} ?: 'Not provided') }}</dd>
                        </div>
                    @endforeach
                </dl>
            @else
                <p class="text-sm text-secondary-foreground">No profile details have been saved yet.</p>
            @endif
        </div>
        <div class="kt-modal-footer flex flex-wrap justify-end gap-3">
            <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true" type="button">Close</button>
            <a class="kt-btn kt-btn-primary" href="{{ route('admin.portfolio.edit') }}"><i class="ki-filled ki-user-edit" aria-hidden="true"></i> Edit Profile</a>
        </div>
    </div>
</div>

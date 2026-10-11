<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.portfolio.edit', [
            'pageTitle' => 'Edit Portfolio',
            'profile' => Profile::query()->orderBy('id')->first() ?? new Profile,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = Profile::query()->orderBy('id')->first() ?? new Profile;
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $profile->fill($data)->save();

        return redirect()->route('admin.portfolio.edit')->with('status', 'Profile saved successfully.');
    }
}

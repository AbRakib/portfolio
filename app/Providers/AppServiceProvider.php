<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as BladeView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.partials.profile-modal', function (BladeView $view): void {
            $view->with('portfolioProfile', Profile::query()->orderBy('id')->first());
        });
    }
}

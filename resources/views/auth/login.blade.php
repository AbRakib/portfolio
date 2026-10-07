@php
    $metronicAssetPath = 'metronic-html-full/dist/assets';
@endphp

<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <link rel="shortcut icon" href="{{ asset($metronicAssetPath . '/media/app/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset($metronicAssetPath . '/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset($metronicAssetPath . '/css/styles.css') }}" rel="stylesheet">
    <style>
        .page-bg {
            min-height: 100vh;
            min-height: 100dvh;
            background-image: url('{{ asset($metronicAssetPath . '/media/images/2600x1200/bg-10.png') }}');
        }
        .dark .page-bg { background-image: url('{{ asset($metronicAssetPath . '/media/images/2600x1200/bg-10-dark.png') }}'); }
    </style>
</head>
<body class="antialiased flex min-h-screen text-base text-foreground bg-background">
    <script>
        let themeMode = localStorage.getItem('kt-theme') || 'light';
        if (themeMode === 'system') {
            themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.classList.add(themeMode);
    </script>

    <main class="flex items-center justify-center grow bg-center bg-no-repeat page-bg p-5">
        <div class="kt-card max-w-[370px] w-full">
            <form class="kt-card-content flex flex-col gap-5 p-10" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="text-center mb-2.5">
                    <img class="h-8 mx-auto mb-5" src="{{ asset($metronicAssetPath . '/media/app/mini-logo.svg') }}" alt="Admin Panel">
                    <h1 class="text-lg font-medium text-mono leading-none mb-2.5">Admin Login</h1>
                    <p class="text-sm text-secondary-foreground">Sign in to your account</p>
                </div>
                @if ($errors->any())
                    <p class="text-sm text-destructive" role="alert">{{ $errors->first() }}</p>
                @endif
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono" for="email">Email</label>
                    <input class="kt-input" id="email" name="email" type="email" placeholder="email@email.com" value="{{ old('email') }}" autocomplete="username" required autofocus>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono" for="password">Password</label>
                    <div class="kt-input" data-kt-toggle-password="true">
                        <input id="password" name="password" type="password" placeholder="Enter Password" autocomplete="current-password" required>
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon" data-kt-toggle-password-trigger="true" type="button" aria-label="Toggle password visibility" title="Toggle password visibility">
                            <span class="kt-toggle-password-active:hidden"><i class="ki-filled ki-eye text-muted-foreground"></i></span>
                            <span class="hidden kt-toggle-password-active:block"><i class="ki-filled ki-eye-slash text-muted-foreground"></i></span>
                        </button>
                    </div>
                </div>
                <button class="kt-btn kt-btn-primary flex justify-center" type="submit">Sign In</button>
            </form>
        </div>
    </main>
    <script src="{{ asset($metronicAssetPath . '/js/core.bundle.js') }}"></script>
    <script src="{{ asset($metronicAssetPath . '/vendors/ktui/ktui.min.js') }}"></script>
</body>
</html>

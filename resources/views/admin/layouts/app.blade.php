@php
    $metronicAssetPath = 'metronic-html-full/dist/assets';
@endphp

<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Admin Panel' }} - Admin Panel</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($metronicAssetPath . '/media/app/apple-touch-icon.png') }}">
    <link rel="icon" sizes="32x32" type="image/png" href="{{ asset($metronicAssetPath . '/media/app/favicon-32x32.png') }}">
    <link rel="icon" sizes="16x16" type="image/png" href="{{ asset($metronicAssetPath . '/media/app/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset($metronicAssetPath . '/media/app/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset($metronicAssetPath . '/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet">
    <link href="{{ asset($metronicAssetPath . '/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset($metronicAssetPath . '/css/styles.css') }}" rel="stylesheet">
</head>

<body class="antialiased flex h-full text-base text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed">
    <script>
        const defaultThemeMode = 'light';
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>

    <div class="flex grow">
        @include('admin.partials.sidebar', ['metronicAssetPath' => $metronicAssetPath])

        <div class="kt-wrapper flex grow flex-col">
            @include('admin.partials.topbar', ['metronicAssetPath' => $metronicAssetPath])

            <main class="grow pt-5" id="content" role="content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset($metronicAssetPath . '/js/core.bundle.js') }}"></script>
    <script src="{{ asset($metronicAssetPath . '/vendors/ktui/ktui.min.js') }}"></script>
    <script src="{{ asset($metronicAssetPath . '/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset($metronicAssetPath . '/js/widgets/general.js') }}"></script>
    <script src="{{ asset($metronicAssetPath . '/js/layouts/demo1.js') }}"></script>
</body>

</html>

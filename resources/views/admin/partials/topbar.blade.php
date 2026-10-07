<header class="kt-header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-background" data-kt-sticky="true" data-kt-sticky-class="border-b border-border" data-kt-sticky-name="header" id="header">
    <div class="kt-container-fixed flex justify-between items-stretch lg:gap-4" id="headerContainer">
        <div class="flex gap-2.5 lg:hidden items-center -ms-1">
            <a class="shrink-0" href="{{ route('admin.dashboard') }}">
                <img class="max-h-[25px] w-full" src="{{ asset($metronicAssetPath . '/media/app/mini-logo.svg') }}" alt="Admin Panel">
            </a>
            <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#sidebar" type="button">
                <i class="ki-filled ki-menu"></i>
            </button>
        </div>

        <div class="hidden lg:flex items-center gap-2">
            <span class="kt-badge kt-badge-outline kt-badge-primary kt-badge-sm">Backend</span>
            <span class="text-sm text-secondary-foreground">Admin workspace</span>
        </div>

        <div class="flex items-center gap-2 lg:gap-3.5">
            <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-theme-switch-toggle="true" type="button">
                <i class="ki-filled ki-night-day"></i>
            </button>

            <div class="kt-menu" data-kt-menu="true">
                <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-end" data-kt-menu-item-toggle="dropdown" data-kt-menu-item-trigger="click">
                    <button class="kt-menu-toggle kt-btn kt-btn-ghost flex items-center gap-2 px-2" type="button">
                        <span class="inline-flex items-center justify-center rounded-full bg-primary text-primary-foreground size-8 text-xs font-semibold">AR</span>
                        <span class="hidden sm:block text-sm font-medium text-foreground">Abdur Rakib</span>
                        <i class="ki-filled ki-down text-xs text-muted-foreground"></i>
                    </button>
                    <div class="kt-menu-dropdown kt-menu-default w-full max-w-[220px]">
                        <div class="px-3 py-2">
                            <div class="text-sm font-semibold text-mono">Abdur Rakib</div>
                            <div class="text-xs text-secondary-foreground">Administrator</div>
                        </div>
                        <div class="kt-menu-separator"></div>
                        <div class="kt-menu-item">
                            <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-profile-circle"></i>
                                </span>
                                <span class="kt-menu-title">Profile</span>
                            </a>
                        </div>
                        <div class="kt-menu-item">
                            <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-setting-3"></i>
                                </span>
                                <span class="kt-menu-title">Settings</span>
                            </a>
                        </div>
                        <div class="kt-menu-separator"></div>
                        <form class="kt-menu-item" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="kt-menu-link w-full" type="submit">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-exit-right"></i>
                                </span>
                                <span class="kt-menu-title">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

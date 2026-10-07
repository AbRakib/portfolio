@extends('admin.layouts.app')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $pageTitle ?? 'Dashboard' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Manage portfolio content, services, and visitor messages.
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ url('/') }}">
                    <i class="ki-filled ki-eye"></i>
                    View Website
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-5 lg:gap-7.5">
                @foreach ($stats as $stat)
                    <article class="kt-card">
                        <div class="kt-card-content flex flex-col gap-3 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-medium text-secondary-foreground">{{ $stat['label'] }}</span>
                                <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">{{ $stat['change'] }}</span>
                            </div>
                            <strong class="text-3xl font-semibold text-mono">{{ $stat['value'] }}</strong>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
                <section class="kt-card lg:col-span-2">
                    <div class="kt-card-header">
                        <h2 class="kt-card-title">Recent Activity</h2>
                        <a class="kt-link kt-link-underlined kt-link-dashed" href="#">View all</a>
                    </div>
                    <div class="kt-card-content p-5 lg:p-7.5">
                        <div class="flex flex-col gap-5">
                            <div class="flex items-start gap-3">
                                <span class="kt-badge kt-badge-dot kt-badge-primary mt-2"></span>
                                <div class="flex flex-col gap-1">
                                    <strong class="text-sm font-semibold text-mono">Portfolio section updated</strong>
                                    <span class="text-sm text-secondary-foreground">Homepage content is ready for review.</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="kt-badge kt-badge-dot kt-badge-success mt-2"></span>
                                <div class="flex flex-col gap-1">
                                    <strong class="text-sm font-semibold text-mono">New message received</strong>
                                    <span class="text-sm text-secondary-foreground">A visitor submitted a project inquiry.</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="kt-badge kt-badge-dot kt-badge-warning mt-2"></span>
                                <div class="flex flex-col gap-1">
                                    <strong class="text-sm font-semibold text-mono">Service list checked</strong>
                                    <span class="text-sm text-secondary-foreground">All active services are visible on the website.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="kt-card">
                    <div class="kt-card-header">
                        <h2 class="kt-card-title">Quick Actions</h2>
                    </div>
                    <div class="kt-card-content p-5 lg:p-7.5">
                        <div class="grid gap-3">
                            <a class="kt-btn kt-btn-primary justify-start" href="#">
                                <i class="ki-filled ki-plus"></i>
                                Add Project
                            </a>
                            <a class="kt-btn kt-btn-outline justify-start" href="#">
                                <i class="ki-filled ki-user-edit"></i>
                                Edit Profile
                            </a>
                            <a class="kt-btn kt-btn-outline justify-start" href="#">
                                <i class="ki-filled ki-sms"></i>
                                Read Messages
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

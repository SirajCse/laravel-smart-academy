<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@if(session('theme') === 'dark') dark @endif">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Login')) — {{ config('app.name') }}</title>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com/3.4.16"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            border: 'hsl(214.3 31.8% 91.4%)', input: 'hsl(214.3 31.8% 91.4%)',
                            ring: 'hsl(222.2 84% 4.9%)', background: 'hsl(0 0% 100%)',
                            foreground: 'hsl(222.2 84% 4.9%)',
                            primary: { DEFAULT: 'hsl(222.2 47.4% 11.2%)', foreground: 'hsl(210 40% 98%)' },
                            secondary: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(222.2 47.4% 11.2%)' },
                            muted: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(215.4 16.3% 46.9%)' },
                            accent: { DEFAULT: 'hsl(210 40% 96.1%)', foreground: 'hsl(222.2 47.4% 11.2%)' },
                            destructive: { DEFAULT: 'hsl(0 84.2% 60.2%)', foreground: 'hsl(210 40% 98%)' },
                            card: { DEFAULT: 'hsl(0 0% 100%)', foreground: 'hsl(222.2 84% 4.9%)' },
                        },
                    },
                },
                darkMode: 'class',
            };
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script>
            (function () {
                const saved = localStorage.getItem('theme');
                if (saved === 'dark') document.documentElement.classList.add('dark');
            })();
        </script>
    @endif

    @stack('styles')
</head>
<body class="min-h-screen bg-background">
    <div class="flex min-h-screen">
        {{-- Left side: branding panel --}}
        <div class="hidden lg:flex lg:flex-1 bg-primary items-center justify-center p-12">
            <div class="max-w-md text-primary-foreground">
                <div class="mb-8 flex items-center gap-3">
                    <img src="{{ $schoolLogo ?? asset('backend/dist/img/logo.png') }}"
                         alt="" class="h-12 w-12 rounded-md bg-white p-2" onerror="this.style.display='none'">
                    <span class="text-2xl font-semibold">{{ $schoolName ?? config('app.name') }}</span>
                </div>
                <h1 class="mb-4 text-4xl font-bold leading-tight">
                    Smart School Management System
                </h1>
                <p class="text-primary-foreground/80">
                    Complete administration for students, staff, fees, attendance,
                    exams, library, transport, hostel & more — built on Laravel 12
                    with Shadcn UI.
                </p>
                <div class="mt-12 grid grid-cols-2 gap-4">
                    <div class="rounded-lg bg-white/10 p-4 backdrop-blur">
                        <div class="text-3xl font-bold">100+</div>
                        <div class="text-sm text-primary-foreground/70">Admin Modules</div>
                    </div>
                    <div class="rounded-lg bg-white/10 p-4 backdrop-blur">
                        <div class="text-3xl font-bold">882</div>
                        <div class="text-sm text-primary-foreground/70">Routes</div>
                    </div>
                    <div class="rounded-lg bg-white/10 p-4 backdrop-blur">
                        <div class="text-3xl font-bold">9</div>
                        <div class="text-sm text-primary-foreground/70">Languages</div>
                    </div>
                    <div class="rounded-lg bg-white/10 p-4 backdrop-blur">
                        <div class="text-3xl font-bold">8</div>
                        <div class="text-sm text-primary-foreground/70">Front Themes</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right side: login form --}}
        <div class="flex flex-1 items-center justify-center p-6">
            <div class="w-full max-w-md">
                {{-- Mobile-only logo --}}
                <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                    <img src="{{ $schoolLogo ?? asset('backend/dist/img/logo.png') }}"
                         alt="" class="h-10 w-10 rounded-md" onerror="this.style.display='none'">
                    <span class="text-xl font-semibold">{{ $schoolName ?? config('app.name') }}</span>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

@stack('scripts')
</body>
</html>

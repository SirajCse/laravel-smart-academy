@extends('layouts.auth')

@section('title', __('Admin Login'))

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold tracking-tight">{{ __('Welcome back') }}</h2>
    <p class="mt-1 text-sm text-muted-foreground">{{ __('Sign in to your admin account to continue') }}</p>
</div>

@if (session('success'))
    <div class="mb-4 flex items-center gap-3 rounded-md border border-success/30 bg-success/10 px-4 py-3 text-sm">
        <i class="fa fa-check-circle text-success"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif
@if (session('error'))
    <div class="mb-4 flex items-center gap-3 rounded-md border border-destructive/30 bg-destructive/10 px-4 py-3 text-sm">
        <i class="fa fa-times-circle text-destructive"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('admin.login') }}">
    @csrf

    <div class="space-y-4">
        <x-form-field label="{{ __('Username or Email') }}" required>
            <x-input name="username" type="text" placeholder="admin@smart-academy.local" :value="old('username')" required autofocus />
            @error('username')
                <p class="text-xs text-destructive">{{ $message }}</p>
            @enderror
        </x-form-field>

        <x-form-field label="{{ __('Password') }}" required>
            <div class="relative">
                <x-input name="password" type="password" placeholder="••••••••" required />
                <button type="button" onclick="const i=this.previousElementSibling;i.type=i.type==='password'?'text':'password';this.querySelector('i').className=i.type==='password'?'fa fa-eye':'fa fa-eye-slash'"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-destructive">{{ $message }}</p>
            @enderror
        </x-form-field>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                       class="rounded border-input text-primary focus:ring-ring" />
                <span>{{ __('Remember me') }}</span>
            </label>
            <a href="{{ route('admin.password.request') }}" class="text-sm text-primary hover:underline">
                {{ __('Forgot password?') }}
            </a>
        </div>

        <x-button type="submit" class="w-full" size="lg">
            <i class="fa fa-sign-in"></i>
            {{ __('Sign in') }}
        </x-button>
    </div>
</form>

<div class="mt-6 text-center text-sm text-muted-foreground">
    {{ __('Student/Parent?') }}
    <a href="{{ route('student.login') }}" class="text-primary hover:underline">{{ __('Login here') }}</a>
</div>

<div class="mt-8 rounded-md border bg-muted/30 p-4 text-xs text-muted-foreground">
    <div class="mb-1 font-semibold text-foreground">Default Admin Credentials</div>
    <div>Username: <code class="rounded bg-muted px-1.5 py-0.5">admin@smart-academy.local</code></div>
    <div>Password: <code class="rounded bg-muted px-1.5 py-0.5">admin123</code></div>
</div>
@endsection

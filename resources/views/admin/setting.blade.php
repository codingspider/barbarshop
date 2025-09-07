@extends('admin.layouts.app')
@section('title', 'Application Setting')
@section('content')

<div class="container">
    
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="mb-4 text-center">Website Settings</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- If using RESTful update -->

                <!-- Site Name -->
                <div class="mb-3">
                    <label for="site_name" class="form-label">{{ __('messages.site_name') }}</label>
                    <input type="text" name="site_name" class="form-control" id="site_name"
                        value="{{ old('site_name', $settings->site_name ?? '') }}" required>
                </div>

                <!-- Logo -->
                <div class="mb-3">
                    <label for="logo" class="form-label">{{ __('messages.logo') }}</label>
                    <input type="file" name="logo" class="form-control" id="logo" accept="image/*">
                    @if(!empty($settings->logo))
                    <img src="{{ asset('storage/'.$settings->logo) }}" alt="Logo" class="mt-2" width="120">
                    @endif
                </div>

                <!-- Favicon -->
                <div class="mb-3">
                    <label for="favicon" class="form-label">{{ __('messages.favicon') }}</label>
                    <input type="file" name="favicon" class="form-control" id="favicon" accept="image/*">
                    @if(!empty($settings->favicon))
                    <img src="{{ asset('storage/'.$settings->favicon) }}" alt="Favicon" class="mt-2" width="32">
                    @endif
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
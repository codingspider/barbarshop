@extends('admin.layouts.app')
@section('title', 'User Create')
@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('messages.users') }}</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">{{ __('messages.list') }}</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
                method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="mb-3">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name ?? old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.password') }}</label>
                    <input type="password" name="password" class="form-control"
                        value="{{ $user->password ?? old('password') }}">
                </div>


                <button type="submit" class="btn btn-success">{{ isset($user) ? __('messages.update') : __('messages.create') }}</button>
            </form>

        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.container -->
@endsection
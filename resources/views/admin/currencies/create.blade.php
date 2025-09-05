@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('messages.currencies') }}</h3>
            <a href="{{ route('admin.currencies.index') }}" class="btn btn-primary">{{ __('messages.list') }}</a>
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

            <form action="{{ isset($currency) ? route('admin.currencies.update', $currency) : route('admin.currencies.store') }}"
                method="POST">
                @csrf
                @if(isset($currency)) @method('PUT') @endif

                <div class="mb-3">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $currency->name ?? old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.code') }}</label>
                    <input type="text" name="code" class="form-control" value="{{ $currency->code ?? old('code') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.symbol') }}</label>
                    <input type="text" name="symbol" class="form-control"
                        value="{{ $currency->symbol ?? old('symbol') }}">
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                        value="1" {{ (isset($currency) && $currency->is_default) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">{{ __('messages.default') }}</label>
                </div>


                <button type="submit" class="btn btn-success">{{ isset($currency) ? __('messages.update') : __('messages.create') }}</button>
            </form>

        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.container -->
@endsection
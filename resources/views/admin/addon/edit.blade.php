@extends('admin.layouts.app')
@section('title', 'Update Service')
@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ __('messages.addons') }}</h3>
            <a href="{{ route('admin.services.index') }}" class="btn btn-primary">{{ __('messages.list') }}</a>
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

            <form action="{{ route('admin.addons.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $service->name ?? old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.price') }}</label>
                    <input type="text" name="price" class="form-control" value="{{ $service->price ?? old('price') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>{{ __('messages.image') }}</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="active" name="active"
                        value="1" {{ (isset($service) && $service->active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ __('messages.status') }}</label>
                </div>


                <button type="submit" class="btn btn-success">{{ isset($service) ? __('messages.update') : __('messages.create') }}</button>
            </form>

        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.container -->
@endsection
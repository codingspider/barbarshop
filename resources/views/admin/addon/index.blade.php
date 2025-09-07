@extends('admin.layouts.app')
@section('title', 'All Addons')
@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{__('messages.addons') }}</h3>
            <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">{{ __('messages.add') }}</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('messages.id') }}</th>
                            <th>{{ __('messages.image') }}</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>
                                    <img src="{{ Storage::url($service->image) }}" alt="" height="40" width="50" srcset="">
                                </td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->price }}</td>
                                <td>{{ $service->active ? 'Yes' : 'No' }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.addons.edit', $service->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                                    <form action="{{ route('admin.addons.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this currency?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {!! $services->links('pagination::bootstrap-5') !!}
            </div> <!-- /.table-responsive -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.container -->
@endsection

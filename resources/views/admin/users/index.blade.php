@extends('admin.layouts.app')
@section('title', 'Users List')
@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{__('messages.users')}}</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{__('messages.add')}}</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{__('messages.id')}}</th>
                            <th>{{__('messages.image')}}</th>
                            <th>{{__('messages.name')}}</th>
                            <th>{{__('messages.email')}}</th>
                            <th>{{__('messages.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <img src="{{ $user->image }}" alt="" srcset="">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">{{__('messages.edit')}}</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this currency?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">{{__('messages.delete')}}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.container -->
@endsection

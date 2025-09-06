@extends('user.layouts.app')
@section('title', 'Home')
@section('content')
<div class="container">

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('messages.id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.ticket_no') }}</th>
                    <th>{{ __('messages.requested_at') }}</th>
                    <th>{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->customer?->name }}</td>
                    <td>{{ $ticket->ticket_no }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{!! $ticket->statusBadge() !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        @if(isset($tickets))
        {!! $tickets->links() !!}
        @endif
    </div>
</div>


@endsection
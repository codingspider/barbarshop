@extends('user.layouts.app')
@section('title', __('messages.in_service'))
@section('content')
<div class="container">
    <h2 class="mb-4">{{  __('messages.in_service') }}</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('messages.id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.barber') }}</th>
                    <th>{{ __('messages.ticket_no') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th>{{ __('messages.requested_at') }}</th>
                    <th>{{ __('messages.started_at') }}</th>
                    <th>{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->customer?->name }}</td>
                    <td>{{ $ticket->barber?->name }}</td>
                    <td>{{ $ticket->ticket_no }}</td>
                    <td>{{ humanDateTime($ticket->created_at) }}</td>
                    <td>{{ humanDateTime($ticket->requested_at) }}</td>
                    <td>{{ humanDateTime($ticket->started_at) }}</td>
                    <td>{!! $ticket->statusBadge() !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {!! $tickets->links() !!}
    </div>
</div>
@endsection
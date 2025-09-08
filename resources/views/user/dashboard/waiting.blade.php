@extends('user.layouts.app')
@section('title', __('messages.waiting_ticket'))
@section('content')
<div class="container">
    <h2 class="mb-4">{{  __('messages.waiting_ticket') }}</h2>
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
                    <th>{{ __('messages.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    @php
                        $modalId = 'assignBarberModal-' . $ticket->id;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->customer?->name }}</td>
                        <td>{{ $ticket->barber?->name }}</td>
                        <td>{{ $ticket->ticket_no }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>{{ $ticket->requested_at }}</td>
                        <td>{!! $ticket->statusBadge() !!}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div>
        {!! $tickets->links() !!}
    </div>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

</div>
@endsection

@push('extra_js')

@endpush
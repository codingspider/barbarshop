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
                    <th>{{ __('messages.ticket_no') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
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
                        <td>{{ $ticket->ticket_no }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>{!! $ticket->statusBadge() !!}</td>
                        <td>
                            <!-- Button -->
                            <button 
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#{{ $modalId }}">
                                Assign Barber
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('user.tickets.assign') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{ $modalId }}Label">{{ __('messages.barber') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                <div class="mb-3">
                                                    <select name="barber_id" class="form-select" required>
                                                        <option value="">-- {{ __('messages.select') }} --</option>
                                                        @foreach($barbers as $barber)
                                                            <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">{{ __('messages.assign') }}</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
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
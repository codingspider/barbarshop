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
                    <td>{{ $ticket->barber?->name }}</td>
                    <td>{{ $ticket->ticket_no }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{{ $ticket->requested_at }}</td>
                    <td>{!! $ticket->statusBadge() !!}</td>
                    <td>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{$modalId}}">
                            {{ __('messages.actions') }}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$modalId}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <!-- centered vertically -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.actions')}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('user.barber.action') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- Name -->
                                             <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">{{ __('messages.status')}}</label>
                                                <select class="form-select" id="status" name="status" required>
                                                <option value="" disabled selected>Select Status</option>
                                                    <option value="open">{{ __('messages.accept') }}</option>
                                                    <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
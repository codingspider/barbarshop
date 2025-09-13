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
                    <th>{{ __('messages.finished_at') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    @if($status == 'in_service')
                    <th>{{ __('messages.actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                @php
                $modalId = 'assignBarberModal-' . $ticket->id;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->customer?->name }}</td>
                    <td>{{ $ticket->ticket_no }}</td>
                    <td>{{ $ticket->requested_at }}</td>
                    <td>{{ $ticket->finished_at }}</td>
                    <td>{!! $ticket->statusBadge() !!}</td>
                    @if($status == 'in_service')
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
                                                <option value="" disabled selected>{{ __('messages.select') }}</option>
                                                    <option value="completed">{{ __('messages.completed') }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5">{{ __('messages.data_not_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>
        @if(isset($tickets) && $status != 'in_service')
        {!! $tickets->links() !!}
        @endif
    </div>
</div>


@endsection
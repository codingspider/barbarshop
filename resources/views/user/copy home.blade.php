@extends('user.layouts.app')
@section('title', 'Home')
@section('content')

@if(\Auth::guard('user')->user()?->user_type == 'user')
<div class="col-md-8 col-lg-8">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3" id="products-container">
        <!-- 1 -->
    </div>
</div>

<!-- right column (fixed width) -->
<div class="col-md-4 col-lg-3">
    <div class="d-flex flex-column gap-3">
        <form action="#" id="cartForm">
        <!-- queue card -->
        <div class="small-ghost text-center">
            <div style="font-size:34px;font-weight:700"><span id="ahead_people">0</span></div>
            <div style="margin-top:6px;color:#6b7280;font-size:14px"><strong>{{ __('messages.people') }}</strong> {{ __('messages.ahead') }}</div>
            <div style="margin-top:12px;color:#9ca3af">{{ __('approx') }}, 25 min</div>
        </div>

        <!-- order summary -->
        <div class="small-ghost mt-3">
            <div class="d-flex justify-content-between small text-muted mb-1">
                <table class="table table-bordered" id="cart-table">
                    <tbody>
                    </tbody>
                </table>
            </div>

            
            <div class="d-flex justify-content-between small text-muted mb-1">
                <div>{{ __('messages.subtotal') }}</div>
                <div><span class="cart-subtotal">0</span></div>
            </div>

            <hr>
            <div class="d-flex justify-content-between fw-semibold">
                <div>{{ __('messages.total') }}</div>
                <div><span class="cart-total">0</span></div>
            </div>
        </div>

        <!-- checkout box -->
        @if(\Auth::guard('user')->user())
        <div class="small-ghost text-center mt-3">
            <button type="submit" id="submitCartBtn" class="btn btn-success w-100">Checkout</button>
        </div>
        @endif
        </form>

    </div>
</div>
@elseif(\Auth::guard('user')->user()?->user_type == 'barber')
@php 
$tickets = getBarberTickets();
@endphp 
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
                    <th>{{ __('messages.actions') }}</th>
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
                        <td>
                            @php
                                $modalId = 'assignBarberModal-' . $ticket->id;
                            @endphp

                            <button 
                                class="btn btn-sm btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#{{ $modalId }}">
                                {{ __('messages.actions') }}
                            </button>

                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('user.barber.action') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{ $modalId }}Label">{{ __('messages.actions') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                <div class="mb-3">
                                                    <select name="status" class="form-select" required>
                                                    <option value="">-- {{ __('messages.select') }} --</option>

                                                    @if($ticket->status !== 'open')
                                                        <option value="open">{{ __('messages.open') }}</option>
                                                    @endif

                                                    @if($ticket->status !== 'done')
                                                        <option value="done">{{ __('messages.done') }}</option>
                                                    @endif

                                                    @if($ticket->status !== 'cancelled')
                                                        <option value="cancelled">{{ __('messages.cancelled') }}</option>
                                                    @endif
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
        @if(isset($tickets))
        {!! $tickets->links() !!}
        @endif
    </div>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@else

@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

</div>
@endif
@endsection
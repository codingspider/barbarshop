@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="d-flex">
                            <img class="avatar rounded-circle" src="assets/images/profile_av.svg" alt="profile">
                            <div class="flex-fill ms-3">
                                <p class="mb-0"><span class="font-weight-bold">{{ Auth::guard('admin')->user()->name }}</span></p>
                                <small class="">{{ Auth::guard('admin')->user()->email }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="d-flex flex-column">
                            <span class="mb-1 color-price-up">{{ __("messages.today_total_sales")}}</span>
                            <span class="small flex-fill text-truncate color-price-up">{{ formatPrice($payments) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Row End -->

<div class="row g-3 mb-3 row-cols-1 row-cols-md-2 row-cols-lg-4">
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">{{ __('messages.open_tickets') }}</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="small text-muted px-2">{{ $data['openTickets'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">{{ __('messages.completed') }}</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold color-price-up">{{ $data['doneTickets'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">{{ __('messages.pending_tickets') }}</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="small text-muted px-2">{{ $data['pendingTickets']}}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="flex-fill text-truncate">
                    <span class="text-muted small text-uppercase">{{ __('messages.cancelled') }}</span>
                    <div class="d-flex flex-column">
                        <div class="price-block">
                            <span class="fs-6 fw-bold color-price-down">{{ $data['cancelledTickets'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Row End -->

<div class="row g-3 mb-3 row-deck">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="mb-0 fw-bold">{{ __('messages.tickets') }}</h6>
            </div>
            <div class="card-body">
                <table id="ordertabthree"
                    class="priceTable table table-hover custom-table-2 table-bordered align-middle mb-0"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.barber') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.requested_at') }}</th>
                            <th>{{ __('messages.started_at') }}</th>
                            <th>{{ __('messages.finished_at') }}</th>
                            <th>{{ __('messages.total') }}</th>
                            <th>{{ __('messages.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['tickets'] as $ticket)
                        <tr>
                            <td>{{ $ticket->customer?->name }}</td>
                            <td>{{ $ticket->barber?->name }}</td>
                            <td>{{ humanDateTime($ticket->created_at) }}</td>
                            <td>{{ humanDateTime($ticket->requested_at) }}</td>
                            <td>{{ humanDateTime($ticket->started_at) }}</td>
                            <td>{{ humanDateTime($ticket->finished_at) }}</td>
                            <td>{{ $ticket->order?->total }}</td>
                            <td>{!! $ticket->statusBadge() !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- Row End -->
@endsection
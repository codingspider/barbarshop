@extends('user.layouts.app')

@section('title', __('messages.ticket_report'))

@section('content')
<div class="container my-4">

    <!-- Report Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ __('messages.ticket_report') }} - {{ now()->format('F j, Y') }}</h2>
    </div>

    <!-- Summary Cards -->
    <div id="report-section">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card border-start border-primary shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('messages.open_tickets') }}</h6>
                        <h3 class="fw-bold text-primary">{{ $openTickets }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-success shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('messages.done_tickets') }}</h6>
                        <h3 class="fw-bold text-success">{{ $doneTickets }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-warning shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('messages.pending_tickets') }}</h6>
                        <h3 class="fw-bold text-warning">{{ $pendingTickets }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-danger shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('messages.cancelled_tickets') }}</h6>
                        <h3 class="fw-bold text-danger">{{ $cancelledTickets }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Report Table -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ __('messages.ticket_details') }}</h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.ticket_no') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ticket->ticket_no }}</td>
                                <td>{{ $ticket->customer?->name }}</td>
                                <td>{!! $ticket->statusBadge() !!}</td>
                                <td>{{ $ticket->created_at->format('F j, Y g:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('messages.no_tickets_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Print Script -->

@endsection
@push('extra_js')
<script>
function printReport() {
    let printContents = $('#report-section').html();
    let originalContents = $('body').html();

    $('body').html(printContents);
    window.print();
    $('body').html(originalContents);
    location.reload();
}
</script>

@endpush
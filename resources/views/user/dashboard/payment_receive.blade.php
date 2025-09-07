@extends('user.layouts.app')
@section('title', 'Payment Receive')
@section('content')
 <div class="container">
        <h2 class="mb-4 text-center">Receive Payment</h2>

        <!-- Payment Form -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form action="{{ route('user.make-payment') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="payerName" class="form-label">{{ __('messages.ticket_no') }}</label>
                            <select name="ticket_id" id="ticket_id" class="form-control select2">
                                <option value="0">{{ __('messages.select') }}</option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->ticket_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="paymentDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="paymentDate" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="paymentAmount" class="form-label">Amount</label>
                            <input type="number" readonly class="form-control" id="paymentAmount" placeholder="Enter amount"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-select" id="paymentMethod" name="method" required>
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="cash">{{ __('messages.cash') }}</option>
                                <option value="card">{{ __('messages.card') }}</option>
                                <option value="mobile">{{ __('messages.mobile') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('messages.payment_receive')}}</button>
                    </div>
                </form>
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
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
        </div>

        <!-- Payment Records Table -->
        <h4 class="mb-3">Payment Records</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Payer Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                    </tr>
                </thead>
                <tbody id="paymentTableBody">
                    <!-- Dynamic rows will appear here -->
                    @forelse ($ticket_payments as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->customer?->name }}</td>
                        <td>
                            @foreach ($ticket->order?->payments ?? [] as $payment)
                                {{ $payment->payment_date }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($ticket->order?->payments ?? [] as $payment)
                                {{ $payment->amount }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($ticket->order?->payments ?? [] as $payment)
                                {{ $payment->method }}<br>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4">No payments found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extra_js')
<script>
    $(document).ready(function () {
        $(document).on('change', '#ticket_id', function (e) {
            e.preventDefault();
            var ticketId = $(this).val();
            if (ticketId) {
                $.ajax({
                    url: '/user/get-ticket-details/' + ticketId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $('#paymentAmount').val(response.total);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#ticket-details').empty();
            }
        });
    });
</script>
@endpush
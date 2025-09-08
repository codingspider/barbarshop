<div class="row">
    <div class="col-12 col-md-6 text-center text-md-start">
        <h1 class="display-1 fw-bold">{{ $datas['waiting']}}</h1>
        <p class="fs-4">people ahead<br>of you</p>
        <p class="fs-5 text-muted">{{ __('messages.approx') }}. {{ $datas['time']}} {{ __('messages.min')}}</p>
        <a href="{{ route('user.cancell-ticket', $ticket->id) }}" class="btn btn-success btn-lg w-100 mt-4 rounded-3">{{ __('messages.cancel')}}</a>
    </div>

    <div class="col-12 col-md-6 mt-4 mt-md-0">
        @foreach ($tickets as $ticket)
        <div class="card mb-3 rounded-4 border-0 shadow-sm">
            <div class="row g-0">
                <div class="col-4">
                    <img src="{{ Storage::url($ticket->service?->image) }}" class="img-fluid rounded-start rounded-4" alt="Stylist 1">
                </div>
                <div class="col-8 d-flex align-items-center justify-content-center">
                    <span class="fs-4 fw-bold">{{ $ticket->service?->duration_minutes }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
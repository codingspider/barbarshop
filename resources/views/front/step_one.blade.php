<div class="container">
    <div class="row">
    @foreach($users as $user)
    @php 
    $datas = getBarberSchedule($user->id);
    @endphp
        <div class="col-md-4 col-sm-4 mb-4">
            <div class="service-card"
                style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; position: relative; z-index: 1;">
                <img src="{{ Storage::URL($user->image) }}" alt="{{ $user->name }}">
                <div class="d-flex align-items-center mt-2" style="margin: 2px">
                    <h6 class="fw-bold mb-0 me-3">{{ $user->name }}</h6>
                    <p class="mb-0 me-3">{{ $datas['waiting'] }} {{ __('messages.waiting') }}</p>
                    <small>~ {{ $datas['time'] }} {{ __('messages.min') }}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Button -->
<div class="mt-4">
    <button class="order-btn">{{ __('messages.order') }}</button>
</div>
</div>
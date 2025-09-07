<h3 class="text-center">{{ __('messages.barbers') }}</h3>
<div class="row">
    @foreach($users as $user)
    <div class="col-md-4 col-sm-4 mb-4">
        <div class="service-card choose_barber" data-id="{{ $user->id }}"
            style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; position: relative; z-index: 1;">
            <img src="{{ Storage::URL($user->image) }}" alt="{{ $user->name }}">
            <div class="d-flex align-items-center mt-2" style="margin: 2px">
                <h6 class="fw-bold mb-0 me-3">{{ $user->name }}</h6>
                <p class="mb-0 me-3">1 waiting</p>
                <small>~8 min</small>
            </div>
        </div>
    </div>
    @endforeach
</div>
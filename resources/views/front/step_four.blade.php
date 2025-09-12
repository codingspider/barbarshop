<h3 class="text-center">{{ __('messages.addons') }}</h3>
<div class="row">
    @foreach($products as $service)
    @php
        $name = addonName($service->id);
    @endphp
        <div class="col-md-4 col-sm-4 mb-4">
            <div class="service-card choose_addon"
                 data-id="{{ $service->id }}"
                 style="border: 2px solid black; cursor: pointer; position: relative; transition: all 0.2s ease;">

                <img src="{{ $service->image }}"
                    alt="{{ $name }}"
                    style="width: 100%; pointer-events: none;">

                <div class="service-body mt-2">
                    <div class="service-title">{{ $name }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="service-price mb-0">{{ formatPrice($service->price) }}</div>
                        <button class="btn btn-sm btn-danger remove-btn d-none">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-4 d-flex gap-2">
    <button class="next showcartsummery">{{ __('messages.next') }}</button>
</div>
<h3 class="text-center">{{ __('messages.services') }}</h3>
<div class="row">
    @foreach($services as $service)
        <div class="col-md-4 col-sm-4 mb-4">
            <div class="service-card btn-add-to-cart" style="border: 5px solid black"
                data-id="{{ $service->id }}"
                data-name="{{ $service->name }}"
                data-price="{{ $service->price }}"
                data-qty="1"
                style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; position: relative; z-index: 1;">

                <img src="{{ $service->image }}"
                     alt="{{ $service->name }}"
                     style="width: 100%; pointer-events: none;">

                <div class="service-body mt-2">
                    @if($currentLocale == 'en')
                    <div class="service-title">{{ $service->name }}</div>
                    @elseif ($currentLocale == 'fr')
                    <div class="service-title">{{ $service->name_fr}}</div>
                    @else
                    <div class="service-title">{{ $service->name_ar }}</div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="service-price mb-0">{{ formatPrice($service->price) }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>




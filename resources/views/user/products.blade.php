        <style>
        .service-card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
        }

        .service-card:hover {
            transform: scale(1.03); 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
        }
        </style>
        @foreach($services as $service)
        <div class="col">
            <div class="service-card btn-add-to-cart"
                data-id="{{ $service->id }}" 
                data-name="{{ $service->name }}"
                data-price="{{ $service->price }}" 
                data-qty="1">
                
                <img src="{{ Storage::URL($service->image) }}" alt="{{ $service->name }}">

                <div class="service-body">
                    <div class="service-title">{{ $service->name }}</div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="service-price mb-0">{{ formatPrice($service->price) }}</div>

                        @php
                        $inCart = Cart::content()->where('id', $service->id)->first();
                        @endphp

                        <button
                            class="btn btn-sm {{ $inCart ? 'btn-danger' : 'btn-primary btn-add-to-cart' }}"
                            data-id="{{ $service->id }}" 
                            data-name="{{ $service->name }}"
                            data-price="{{ $service->price }}" 
                            data-qty="1">
                            {{ $inCart ? __('added') : __('select') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
<div class="container">
 <div class="row">
    @foreach($users as $user)
        @php $datas = getBarberSchedule($user->id); @endphp
        <div class="col-md-4 col-sm-4 mb-4">
            <div class="service-card order-btn" style="cursor:pointer; border: 5px solid black">
                <img src="{{ $user->image }}" alt="{{ $user->name }}">
                <div class="d-flex align-items-center mt-2" style="margin:2px">
                    <h6 class="fw-bold mb-0 me-3">{{ $user->name }}</h6>
                    <p class="mb-0 me-3">
                        <span id="waiting-{{ $user->id }}">{{ $datas['waiting'] }}</span>
                        <span class="waitingCustomer">{{ __('messages.waiting') }}</span>
                    </p>
                    <small>
                        ~ <span id="time-{{ $user->id }}">{{ $datas['time'] }}</span>
                        <span class="minuteRemaining">{{ __('messages.min') }}</span>
                    </small>
                    
                </div>
                <p>
                    <ul class="list-unstyled d-flex flex-wrap gap-2">
                        <li class="me-2">{{ __('messages.next_customer') }}</li>
                        <div class="w-100" style="font-size: 10px"></div> {{-- forces line break --}}
                        @foreach($user->tickets as $ticket)
                            <li>
                                <span class="badge bg-primary p-2" style="font-size: 10px">
                                    {{ $loop->iteration }} . {{ $ticket->ticket_no }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                </p>
            </div>
            
        </div>
    @endforeach
</div>


    <!-- Button -->
    <div class="mt-4">
        <button class="order-btn">{{ __('messages.order') }}</button>
    </div>
</div>
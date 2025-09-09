<div class="mt-4">
        <ul class="nav justify-content-center flex-wrap" style="border-bottom:1px solid #eee">
          @if(\Auth::guard('user')->user()?->user_type == 'customer')
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" style="margin-right: 10px">
                    {{ __('messages.dashboard') }}
                  </a>
              </li>
          @elseif(\Auth::guard('user')->user()?->user_type == 'user')
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" style="margin-right: 10px">
                    {{ __('messages.dashboard') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/ticket-waiting') ? 'active' : '' }}" href="{{ route('user.ticket-waiting') }}" style="margin-right: 10px">
                      {{ __('messages.appointments') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/in-service') ? 'active' : '' }}" href="{{ url('user/in-service') }}" style="margin-right: 10px">
                      {{ __('messages.in_service') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/completed') ? 'active' : '' }}" href="{{ url('user/completed') }}" style="margin-right: 10px">
                      {{ __('messages.completed') }}
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/ticket/report') ? 'active' : '' }}" href="{{ url('user/ticket/report') }}" style="margin-right: 10px">
                      {{ __('messages.ticket_report') }}
                  </a>
              </li>
          @elseif(\Auth::guard('user')->user()?->user_type == 'barber')
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{ url('user/dashboard') }}" style="margin-right: 10px">
                      {{ __('messages.assigned_ticket') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/status/in_service') ? 'active' : '' }}" href="{{ url('user/status/in_service') }}" style="margin-right: 10px">
                      {{ __('messages.in_service') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/status/completed') ? 'active' : '' }}" href="{{ url('user/status/completed') }}" style="margin-right: 10px">
                      {{ __('messages.completed') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/status/cancelled') ? 'active' : '' }}" href="{{ url('user/status/cancelled') }}" style="margin-right: 10px">
                      {{ __('messages.cancelled') }}
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link px-0 pb-2 text-muted {{ request()->is('user/all/services') ? 'active' : '' }}" href="{{ url('user/all/services') }}" style="margin-right: 10px">
                      {{ __('messages.all_services') }}
                  </a>
              </li>
          @endif
        </ul>
      </div>
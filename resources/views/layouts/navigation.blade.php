<nav class="navbar navbar-light bg-light flex-column">
    <div class="container-fluid">
        <ul class="navbar-nav flex-column">
            {{-- Common Links --}}
          

            @auth
                {{-- Manager Links --}}
                @if(auth()->user()->role === 'manager')
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('users.index') }}">View All Users</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('manager.users.create') }}">Create User</a>
                    </li>
                @endif

                {{-- Driver Links --}}
@if(auth()->user()->role === 'driver')
    <li class="nav-item mb-2">
        <a class="nav-link" href="{{ route('driver.dashboard') }}">Driver Dashboard</a>
    </li>
    <li class="nav-item mb-2">
        <a class="nav-link" href="{{ route('driver.pickup.create') }}">Create Pickup Request</a>
    </li>
  
@endif


                {{-- Warehouse Staff Links --}}
                @if(auth()->user()->role === 'warehouse_staff')
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('warehouse.dashboard') }}">Warehouse Dashboard</a>
                    </li>
                @endif

                {{-- Customer Links --}}
                @if(auth()->user()->role === 'customer')
                <li class="nav-item mb-2">
                <a class="nav-link" href="{{ route('pickup-requests.schedule') }}">Pick-up Schedule</a>
            </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('pickup-requests.create') }}">Request Package Pickup</a>
                    </li>
                @endif

                {{-- Common Authenticated Links --}}
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('profile.show') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @else
                {{-- Guest Links --}}
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

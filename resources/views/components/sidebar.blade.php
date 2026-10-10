<aside class="sidebar" id="sidebar">
    <div>
        <div class="title">
            <img src="/images/fire-shield.svg" alt="logo" style="height:60px">
            <div style="padding-left: 15px;">
                <h1>Gas Leak</h1>
                <p>Monitoring System</p>
            </div>
        </div>
        {{-- <hr style="width:100%; height:1px; color:blue;"> --}}
    </div>

    <nav>
        <a href="{{ route('dashboard') }}"
            wire:navigate
            wire:current="active">
            <div class="icon-box">
                <i data-lucide="house"></i>
            </div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('devices') }}" wire:navigate wire:current="active">
            <div class="icon-box">
                <i data-lucide="cpu"></i>
            </div>
            <span>Devices</span>
        </a>

        <a href="#dashboard">
            <div class="icon-box">
                <i data-lucide="triangle-alert"></i>
            </div>
            <span>Alerts</span>
        </a>

        <a href="{{ route('thresholds') }}" wire:navigate wire:current="active">
            <div class="icon-box">
                <i data-lucide="sliders-horizontal"></i>
            </div>
            <span>Threshold</span>
        </a>
        @if (auth()->user()?->role === 'admin')
            <a href="{{ route('users') }}" wire:navigate wire:current="active">
            <div class="icon-box">
                <i data-lucide="user"></i>
            </div>
            <span>Users</span>
        </a>
        @endif
        

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="icon-box">
                <i data-lucide="log-out"></i>
            </div>
            <span>Logout</span>
        </a>
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>



</aside>
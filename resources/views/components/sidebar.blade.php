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
        <a href="#dashboard">
            <div class="icon-box">
                <i data-lucide="house"></i>
            </div>
            <span>Dashboard</span>
        </a>

        <a href="#dashboard">
            <div class="icon-box">
                <i data-lucide="rotate-ccw-clock"></i>
            </div>
            <span>History</span>
        </a>

        <a href="#dashboard">
            <div class="icon-box">
                <i data-lucide="triangle-alert"></i>
            </div>
            <span>Alerts</span>
        </a>

        <a href="#dashboard">
            <div class="icon-box">
                <i data-lucide="shield-user"></i>
            </div>
            <span>Admin</span>
        </a>

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
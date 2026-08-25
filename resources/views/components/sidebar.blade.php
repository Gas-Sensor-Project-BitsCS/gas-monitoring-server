<aside class="sidebar">
    <div>
    
    <span class="text-dark brand">Navigation Menu</span>
        
    <hr style="width:100%; height:2px; color:blue;">
    </div>

    <a href="#dashboard">
        <div class="icon-box">
            <i data-lucide="layout-dashboard"></i>
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

</aside>
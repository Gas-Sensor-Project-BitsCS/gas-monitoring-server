<div class="header shadow-s" style="display:flex; justify-content: space-between; align-items: center; flex-direction: row; width:100%; text-align: left; border-bottom: 1px solid gray;">
    <div style="display: flex; flex-direction: row; gap:20px">
        <div>
            <button id="menu" class="btn"><i data-lucide="menu" ></i></button>
        </div>
        <div>
            <h3>Dashboard</h3>
            <p class="title-para">Home</p3>
        </div>
    </div>
    <div style="display:flex; flex-direction: row; gap:10px; align-items: center;">
        <button class=" btn shadow-s" id="theme">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="power-icon"
        >
          <path d="M12 2v10" />
          <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
        </svg>
        </button>
        <i data-lucide="calendar-days"></i>
        <p id="clock"></p>
        <div class="icon-box">
            <i data-lucide="circle-user-round"></i>
        </div>
        
    </div>
</div>

@push('scripts')
    @vite('resources/js/header.js')
@endpush


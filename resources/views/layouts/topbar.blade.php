<nav class="navbar navbar-expand px-4 py-3">
    <form action="#" class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <span id="page-title" >@yield('page-title')</span>
        </div>
    </form>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mt-1 me-3">
                <span class="navbar-custom">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
            </li>
            <button  onclick="location.reload();" class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                    <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z"></path>
                </svg>
            </button>
            <a href="{{ route('notifications.index') }}" class="btn border-2 position-relative" data-bs-toggle="tooltip" data-bs-placement="left" title="Bildirimler">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M16.668 14.1667H18.3346V15.8334H1.66797V14.1667H3.33464V8.33335C3.33464 4.65145 6.3194 1.66669 10.0013 1.66669C13.6832 1.66669 16.668 4.65145 16.668 8.33335V14.1667ZM15.0013 14.1667V8.33335C15.0013 5.57193 12.7627 3.33335 10.0013 3.33335C7.23988 3.33335 5.0013 5.57193 5.0013 8.33335V14.1667H15.0013ZM7.5013 17.5H12.5013V19.1667H7.5013V17.5Z"
                        fill="#1A1A1A" />
                </svg>
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="position-absolute translate-middle badge rounded-pill bg-danger" 
                        style="top: 10px; right: -5px; font-size: 0.65rem; padding: 0.25em 0.5em; min-width: 18px; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        {{ $unreadNotificationsCount }}
                    </span>
                @endif
            </a>
            <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Çıkış Yap">
            <a href="{{route('panel-logout')}}" >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" fill="black" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"
                          stroke="black" stroke-width="0.75"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"
                          stroke="black" stroke-width="0.75"/>
                </svg>
            </a>
            </button>

        </ul>
    </div>
</nav>

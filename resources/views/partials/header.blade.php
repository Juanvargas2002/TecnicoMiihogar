<div class="navbar-brand">
    <a class="navbar-item my-aside-toggle">
        <span class="icon"><i class="mdi mdi-menu mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <a href="{{ route('welcome')}}"><x-application-logo class="w-20 h-full fill-current" /></a>
    </div>
</div>
<div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
        <div class="navbar-item desktop-only">
            <ul>
                <li>{{ Auth::user()->rol }}</li>
            </ul>
        </div>
        <div class="navbar-item dropdown has-divider has-user-avatar">
            <a class="navbar-link">
                <div class="user-avatar">
                    <img src="https://api.dicebear.com/9.x/pixel-art/svg" alt="John Doe" class="rounded-full">
                </div>
                <div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
                <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
            </a>
            <div class="navbar-dropdown">
                <a href="{{ route('profile.edit') }}" class="navbar-item">
                    <span class="icon"><i class="mdi mdi-account"></i></span>
                    <span>Mi perfil</span>
                </a>
                <hr>
                <a class="navbar-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon"><i class="mdi mdi-logout"></i></span>
                    <span>Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

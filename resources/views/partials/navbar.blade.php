<div class="aside-tools">
    <div>
      Mi <b class="font-black">Hogar</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <a href="{{route('dashboard')}}">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Panel</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Infraestructura</p>
    <ul class="menu-list">
      @if (auth()->check())
      @if (auth()->user()->rol === 'Administrador')
      <li class="--set-active-usuarios">
        <a href="{{route('usuarios.index')}}">
          <span class="icon"><i class="mdi mdi-account"></i></span>
          <span class="menu-item-label">Usuarios</span>
        </a>
      </li>
      @endif
      @if (auth()->user()->rol === 'Administrador' || auth()->user()->rol === 'Recepcionista')
      <li class="--set-active-clientes">
        <a href="{{route('clientes.index')}}">
            <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          <span class="menu-item-label">Clientes</span>
        </a>
      </li>
      <li class="--set-active-equipos">
        <a href="{{route('equipos.index')}}">
          <span class="icon"><i class="mdi mdi-laptop"></i></span>
          <span class="menu-item-label">Equipos</span>
        </a>
      </li>
      @endif
      <li class="--set-active-ordenes">
        <a href="{{route('ordenes.index')}}">
          <span class="icon"><i class="mdi mdi-file-document-box-multiple"></i></span>
          <span class="menu-item-label">Órdenes de Servicio</span>
        </a>
      </li>
      <li class="--set-active-profile">
        <a href="{{route('profile.edit')}}">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Perfil</span>
        </a>
      </li>
      @endif
    </ul>
  </div>
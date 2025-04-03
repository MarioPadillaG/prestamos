@if(Auth::check())
    <nav class="sidebar nav flex-column pt-5">
        <a href="{{ url('/catalogo/puestos') }}" class="nav-link text-white">Puestos</a>
        <a href="{{ url('/catalogo/empleados') }}" class="nav-link text-white">Empleados</a>
        <a href="{{ url('/movimientos/prestamos') }}" class="nav-link text-white">Préstamos</a>
        <a href="{{ url('/reportes/') }}" class="nav-link text-white">Reportes</a>

        <!-- Botón de salida -->
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-white">Salir</a>

        <!-- Formulario de logout (Laravel necesita esto para CSRF) -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
@endif

<div class="container-fluid ps-4 pe-4 pt-1">
    <nav class="navbar navbar-expand-lg mb-0 pb-0">
        <div class="container-fluid mb-0 pb-0">
            {{-- <a class="navbar-brand" href="{{route('dashboard')}}">
                <img style="width: 70px;" src="{{asset('general/icono.png')}}" alt="Temazcal Maranatha">
            </a> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item me-2 p-1" id="menu-dashboard">
                        <a class="nav-link" aria-current="page" href="{{route('dashboard')}}">
                            <i class="fa-solid fa-house-chimney"></i>
                            <span class="ms-2 me-2">INICIO </span>
                            {{-- <i class="fa-solid fa-chevron-down"></i> --}}
                        </a>
                    </li>
                    @foreach ($menu as $m)
                        <li class="nav-item me-2 p-1 dropdown" id="menu-{{strtolower($m->name)}}">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(!empty($m->icon)) <i class="{{$m->icon}}"></i> @endif
                                <span class="ms-2 me-2">{{{$m->name}}}</span>
                            </a>
                            @if (sizeof($m->subModules) > 0)
                                <ul class="dropdown-menu">
                                    @foreach ($m->subModules as $sm)
                                        @if (!empty($sm->target))
                                            <li><a class="dropdown-item" href="{{route($sm->target)}}">{{$sm->name}}</a></li>
                                        @else
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" href="#">{{$sm->name}}</a>
                                                <ul class="dropdown-menu">
                                                    @foreach ($sm->subModules as $smTwo)
                                                        <li><a class="dropdown-item" href="{{route($smTwo->target)}}">{{$smTwo->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>                            
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    {{-- <li class="nav-item me-2 p-1 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gear"></i> 
                            <span class="ms-2 me-2">Configuración</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="">Menú</a></li>
                            <li><a class="dropdown-item" href="">Permisos</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <span class="navbar-brand text-white top-negative">
                    <i class="fa-solid fa-user-shield"></i>
                    {{auth()->user()->name}}
                </span>
                <form class="navbar-brand ps-1 text-color background-personalized" method="POST" action="{{ route('logout') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Cerrar sesión">
                    @csrf

                    <x-responsive-nav-link class="text-color" :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </nav>
</div>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome6.5.1/css/all.css')}}">
    <link rel="shortcut icon" href="{{asset('general/icono2.png')}}" type="image/x-icon">
    <style>
        body {
            background-color: #56077E;
            /* background-image: url(../media/bg/bg-7.jpg); */
            background-image: url(../general/bg-7.jpg);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-size: 13px !important;
            font-weight: 400;
            font-family: Poppins, Helvetica, "sans-serif";
        }
        .nav-item {
            border-top-left-radius: 0.42rem !important;
            border-top-right-radius: 0.42rem !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            align-items: stretch !important;
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        .nav-link {
            color: #e5eaee !important;
            font-weight: 600 !important;
            font-size: 0.8rem !important;
            text-transform: uppercase !important;
        }
        .content {
            min-height: 78vh !important;
            /* border-radius: 5px; */
            background-color: #ebedf6 !important;
        }
        .radius-top {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .radius-bottom {
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .text-color {
            color: #e5eaee;
        }
        .bold {
            font-weight: bold;
        }
        .pointer {
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        .background-personalized {
            border-radius: 0.42rem !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            align-items: stretch !important;
            margin-top: -10px;
        }
        .navbar-brand:hover {
            color: white !important;
        }
        .top-negative {
            margin-top: -10px;
        }
        .active {
            background-color: white !important;
        }
        .active:hover {
            background-color: white !important;
        }
        .active a {
            color: black !important;
        }
        .absolute {
            position: absolute;
        }
        .relative {
            position: relative;
        }
        .right {
            right: 0;
        }
        /* .content div {
            height: fit-content !important;
        } */
        .btn-success {
            color: #ffffff !important;
            background-color: #1BC5BD !important;
            border-color: #1BC5BD !important;
        }
        .btn-info {
            color: #FFFFFF !important;
            background-color: #6993FF !important;
            border-color: #6993FF !important;
        }
        .btn-primary {
            color: #FFFFFF !important;
            background-color: #8950FC !important;
            border-color: #8950FC !important;
        }
        .btn-danger {
            color: #ffffff !important;
            background-color: #F64E60 !important;
            border-color: #F64E60 !important;
        }
        .custom-tooltip {
            --bs-tooltip-bg: #692ce5;
            --bs-tooltip-color: #fcfcfc;
            --bs-tooltip-font-size: 0.7rem;
        }
        table td {
            color: #464E5F !important;
        }
        table {
            --bs-table-bg: unset !important;
            --bs-table-striped-bg: #f9f9f9 !important;
        }

        .selection-disable {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        
        .dropdown-submenu {
            position: relative;
        }
        
        .dropdown-submenu>.dropdown-menu {
            top: 10px;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 6px 6px 6px 6px;
            -moz-border-radius: 6px 6px 6px;
            border-radius: 6px 6px 6px 6px;
        }
        
        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }
        
        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }
        
        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }
        
        .dropdown-submenu.pull-left {
            float: none;
        }
        
        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }
        .img-footer {
            width: 80px;
        }
        .badge {
            font-size: 0.7rem !important;
        }
        .fs-normal {
            font-size: 1rem;
        }
        .fs-small {
            font-size: 0.8rem !important;
        }
        .bg-danger {
            background-color: #fdc0bd !important;
        }
        .bg-success {
            background-color: #d1ffd7 !important;
        }
        .my-dropzone {
            min-height: 150px !important;
            border: 3px #79afff dashed;
            cursor: pointer;
        }
        .pencil-edit {
            top: 20px;
            position: absolute;
            font-size: 1rem;
            cursor: pointer;
        }
        .dz-image img {
            border-radius: 50% !important;
        }
        .dz-success-mark {
            display: none;
        }
        .dz-error-mark {
            display: none;
        }
        .w-10 {
            width: 10%;
        }
        .w-15 {
            width: 15%;
        }
        .w-20 {
            width: 20%;
        }
        .card-warning {
            color: #FFA800;
            background-color: #FFF4DE;
            border-color: transparent;
            cursor: pointer;
            border-radius: 15px;
        }
        .card-warning:hover {
            background-color: #FFA800;
            color: white;
        }
        .card-danger {
            color: #F64E60;
            background-color: #FFE2E5;
            border-color: transparent;
            cursor: pointer;
            border-radius: 15px;
        }
        .card-danger:hover {
            background-color: #F64E60;
            color: white;
        }
        .card-info {
            color: #8950FC;
            background-color: #EEE5FF;
            border-color: transparent;
            cursor: pointer;
            border-radius: 15px;
        }
        .card-info:hover {
            background-color: #8950FC;
            color: white;
        }
        .card-success {
            color: #1BC5BD;
            background-color: #C9F7F5;
            border-color: transparent;
            cursor: pointer;
            border-radius: 15px;
        }
        .card-success:hover {
            background-color: #1BC5BD;
            color: white;
        }
        .add-number {
            cursor: pointer;
            padding: 3px;
            background: #E1E9FF;
            color: #6993FF;
            border-radius: 0.3rem;
        }
        .modal-xxl {
            --bs-modal-width: 95%;
        }
        .datepicker {
            width: 100% !important;
        }
        .datepicker table {
            width: 100% !important;
        }
        .datepicker table .active {
            color: #F64E60 !important;
            background-color: #FFE2E5 !important;
            border-color: transparent !important;
        }
        .bg-gray {
            background-color: rgb(243 243 243) !important;
        }
        .ui-autocomplete {
            z-index: 9999 !important;
        }
        .shadow {
            box-shadow: 0px 0px 9px 2px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0px 0px 9px 2px rgba(0,0,0,0.5);
            -moz-box-shadow: 0px 0px 9px 2px rgba(0,0,0,0.5);
        }
    </style>
    @yield('heads')
</head>
<body>
    <input type="hidden" id="URL" value="{{asset('')}}">
    <input type="hidden" id="_token" value="{{csrf_token()}}">
    @include('menu')
    <div class="container-fluid ps-4 pe-4 pb-1">
        <div class="row p-4 bg-white radius-top">
            @if (isset($modulo))
                <h5 class="mb-0">{{$modulo->dad->name}} - {{$modulo->name}}</h5>
            @else
                <h5 class="mb-0">Inicio</h5>
            @endif
        </div>
        <div class="row p-0 content radius-bottom">
            @yield('content')
        </div>
        <div class="row">
            <div class="col-xl-4 pt-3 pb-3">
                <span class="text-color bold">{{date('Y')}}© Temazcal Maranatha</span>
            </div>
            <div class="col-xl-4 text-center justify-content-center">
                <img class="mt-2 img-footer" src="{{asset('general/icono3.png')}}" alt="Temazcal Maranatha">
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    {{-- <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('js/dateEs.js')}}"></script>
    @yield('scripts')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        var moduleActive = '#menu-'+@json(strtolower(isset($modulo->dad->name) ? isset($modulo->dad->dad->name) ? $modulo->dad->dad->name : $modulo->dad->name : 'dashboard'));
        $('.nav-item').removeClass('active');
        $(moduleActive).addClass('active');
    </script>
</body>
</html>
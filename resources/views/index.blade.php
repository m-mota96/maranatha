<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome6.5.1/css/all.css')}}">
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
        .content div {
            height: fit-content !important;
        }
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
            --bs-table-striped-bg: #f9f9f9 !important;
        }
    </style>
    @yield('heads')
</head>
<body>
    <input type="hidden" id="URL" value="{{asset('')}}">
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
            <div class="col-xl-12 pt-3 pb-3">
                <span class="text-color bold">{{date('Y')}}© Temazcal Maranatha</span>
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    {{-- <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    @yield('scripts')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        var moduleActive = '#menu-'+@json(strtolower(isset($modulo->dad->name) ? $modulo->dad->name : 'dashboard'));
        $('.nav-item').removeClass('active');
        $(moduleActive).addClass('active');
    </script>
</body>
</html>
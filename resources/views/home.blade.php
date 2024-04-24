@extends('index')
@section('heads')
    <title>{{auth()->user()->name}} | Inicio</title>
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css" rel="stylesheet"/> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> --}}
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row">
            <div class="col-xl-9">
                <div class="row pe-4">
                    <div class="col-xl-12 bg-white p-3 radius-top radius-bottom">

                    </div>
                </div>
            </div>
            <div class="col-xl-3 bg-white p-3 radius-top radius-bottom">
                <div class="row">
                    <div class="col-xl-6 ps-3 pe-3 pt-2 pb-2 text-center" onclick="openModalQuotes()">
                        <div class="col-xl-12 p-4 card-warning">
                            <h1><i class="fa-solid fa-clipboard-list"></i></h1>
                            <p>Nueva cita</p>
                        </div>
                    </div>
                    <div class="col-xl-6 ps-3 pe-3 pt-2 pb-2 text-center">
                        <div class="col-xl-12 p-4 card-danger">
                            <h1><i class="fa-solid fa-dollar-sign"></i></h1>
                            <p>Nueva venta</p>
                        </div>
                    </div>
                    <div class="col-xl-6 ps-3 pe-3 pt-2 pb-2 text-center">
                        <div class="col-xl-12 p-4 card-info">
                            <h1><i class="fa-solid fa-user-plus"></i></h1>
                            <p>Nuevo miembro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modalQuotes')
@endsection

@section('scripts')
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script> --}}
    {{-- <script src="{{asset('js/moment.min.js')}}"></script> --}}
    {{-- <script src='http://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.min.js'></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    {{-- <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.1/i18n/jquery.ui.datepicker-es.min.js" crossorigin="anonymous"></script> --}}
    <script>
        var calendar = '';

        $(document).ready(()=> {
            $("#modalQuotes #calendar").datepicker({
                language: "es",
                todayHighlight:true,
                daysOfWeekDisabled: "0",
                daysOfWeekHighlighted: "0",
                showDropdowns: true,
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                // monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                // monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                // dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                // dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                // dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                // datesDisabled: fechasInhabilitadas
            });
            // var calendarEl = document.getElementById('calendar');
            // calendar = new FullCalendar.Calendar(calendarEl, {
            //     showNonCurrentDates: true,
            //     locale: 'es',
            //     selectable: true,
            //     editable: true,
            //     eventColor: 'red',
            //     eventTextColor: '#fff',
            //     height: 'auto',
            //     buttonText: {
            //         today: 'Hoy',
            //     },
            //     header:{
            //         left:'Mes anterior',
            //         center:'Hoy',
            //         right:'Mes siguiente'
            //     },
            //     eventOverlap: false,
            //     dateClick: function (info) {
            //         // Obtiene la fecha seleccionada en el calendario
            //         var fechaSeleccionada = info.dateStr;
            //         // Actualiza el valor del campo de entrada con la fecha seleccionada
            //         $("#fechaCita").val(fechaSeleccionada);
            //     },
            //     dayCellContent: function (info) {
            //         info.dayNumberText = info.dayNumberText.replace(/^0+/,
            //             ''); // Eliminar ceros a la izquierda
            //         return {
            //             html: '<span class="fc-day-number">' + info.dayNumberText + '</span>'
            //         };
            //     },
            //     dayCellDidMount: function (info) {
            //         var el = info.el;
            //         var num = el.querySelector('.fc-day-number');
            //         if (num) {
            //             num.style.color = '#000'; // Cambiar color del número a negro
            //         }
            //         el.style.backgroundColor = '#fff'; // Cambiar fondo del día a blanco
            //     },
            //     dayHeaderContent: function (info) {
            //         return {
            //             html: "<span style='color: black'>" + info.text + "</span>"
            //         };
            //     },
            // });
        });

        function openModalQuotes() {
            // $('#modalQuotes .fc-today-button').click();
            $('#modalQuotes').modal('show');
            // $('#calendar').fullCalendar({
            //     header: {				
            //         left: 'prev',
            //         center: 'title',
            //         right: 'next,today',			 
            //     },
            //     buttonText: {
            //         today: 'Hoy',
            //         prev: 'Mes anterior',
            //         next: 'Mes aiguiente'
            //     },
            //     height: "auto",
            //     // timeZone: "local",
            //     timeZone: "America/Mexico_City",
            //     initialView: "resourceTimeGridDay",
            //     initialDate: "2024-04-24",
            //     defaultDate: "2024-04-24",
            //     monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            //     monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            //     dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            //     dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            //     dayClick: function(date, jsEvent, view) {
            //         $("#fechaCita").val(date.format());
            //     }
		    // });
        }

        function prueba() {
            // $('#modalQuotes .fc-today-button').click();
            console.log('ENTRE');
        }
    </script>
@endsection
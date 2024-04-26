@extends('index')
@section('heads')
    <title>{{auth()->user()->name}} | Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        const serviceTypes = @json($serviceTypes);

        $.fn.datepicker.dates['es'] = {
			days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		    daysShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		    monthsShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    today: 'Hoy',
		    clear: 'Limpiar',
		    format: 'dd/mm/yy',
		    titleFormat: "MM yyyy", 
		    weekStart: 1
		};

        $(document).ready(()=> {
            $("#modalQuotes #calendar").datepicker({
                language: 'es',
                todayHighlight: true,
                // datesDisabled: fechasInhabilitadas
                onSelect: function (dateText, inst) {
                    console.log(dateText);
                    console.log(inst);
                }
            }).on('changeDate', function(e) {
                $('#modalQuotes #dateQuote').val(e.format(0,"yyyy-mm-dd"));
            });
        });

        function getServices(serviceTypeId) {
            if (serviceTypeId == '' || serviceTypeId == null) {
                return false;
            }

            serviceTypes.forEach(s => {
                if (s.id == parseInt(serviceTypeId)) {
                    cerateDomServices(s.services);
                }
            });
        }

        function cerateDomServices(services) {
            var html = '', bg = '';
            services.forEach(s => {
                bg = (bg != '') ? '' : 'bg-gray';
                html += `
                    <div class="col-xl-12 relative ${bg}" id="divService-${s.id}">
                        <input class="form-check-input fs-normal pointer me-1" type="checkbox" id="service-${s.id}" value="${s.id}" onchange="verifyCheckUncheckService(${s.id})">
                        <label class="pointer selection-disable bold mt-1" for="service-${s.id}">${s.name}</label>
                        <span class="contentNumberService absolute right"></span>
                    </div>
                `;
            });
            $('#modalQuotes #divServices').html(html);
        }

        function createNumberService(serviceId) {
            var html = `
                <i class="fa-solid fa-minus add-number selection-disable fs-small" onclick="addRemoveNumber('remove', ${serviceId})"></i>
                <span class="selection-disable fs-small bold numberServiceText">1</span>
                <input class="numberServiceInput" type="hidden" value="1">
                <i class="fa-solid fa-plus me-3 add-number selection-disable fs-small" onclick="addRemoveNumber('add', ${serviceId})"></i>
            `;
            return html;
        }

        function verifyCheckUncheckService(serviceId) {
            $(`#modalQuotes #divService-${serviceId} .contentNumberService`).html('');
            if ($(`#modalQuotes #service-${serviceId}`).is(':checked')) {
                $(`#modalQuotes #divService-${serviceId} .contentNumberService`).html(createNumberService(serviceId));
            }
        }

        function addRemoveNumber(action, serviceId) {
            var number = parseInt($(`#modalQuotes #divService-${serviceId} .numberServiceInput`).val());
            if (action == 'add') {
                number = number + 1;
            } else {
                if (number > 1) {
                    number = number - 1;
                }
            }
            $(`#modalQuotes #divService-${serviceId} .numberServiceText`).text(number);
            $(`#modalQuotes #divService-${serviceId} .numberServiceInput`).val(number);
        }

        function openModalQuotes() {
            $('#modalQuotes .form-control').val('');
            $('#modalQuotes #calendar .datepicker .day').removeClass('active');
            $('#modalQuotes').modal('show');
        }
    </script>
@endsection
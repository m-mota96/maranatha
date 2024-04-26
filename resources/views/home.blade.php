@extends('index')
@section('heads')
    <title>{{auth()->user()->name}} | Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="{{asset('jquery-ui-1.13.2/jquery-ui.css')}}">
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
    @include('customers.modals.modalCustomers')
@endsection

@section('scripts')
    <script src="{{asset('jquery-ui-1.13.2/jquery-ui.js')}}"></script>
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
                verifyDateAndServices();
            });
        });

        $("#modalQuotes #customer").autocomplete({
            source:function(request, response) {
                $.ajax({
                    url: $('#URL').val()+'getCustomers',
                    type: "GET",
                    dataType: "json",
                    data:{
                        search: request.term
                    },                    
                    success: (res)=> {
                        response(res.data);
                    }
                });
            },
            select : function(event, ui) {
                $('#modalQuotes #customerId').val(ui.item.id);
            }
        });

        function verifyDateAndServices() {
            var servicesActive = false, pos = 0;
            var arrayServicesActive = [];
            $('#modalQuotes .servicesSelected').each(function(i, s) {
                if ($(this).is(':checked')) {
                    servicesActive = true;
                    arrayServicesActive[pos] = {
                        serviceId: parseInt($(this).val()),
                        serviceTime: $(this).attr('data-time'),
                        servicePrice: $(this).attr('data-price'),
                        serviceName: $(this).attr('data-name'),
                        serviceQuantity: parseInt($('#modalQuotes #numberServiceInput-'+$(this).val()).val())
                    };
                    pos++;
                }
            });
            
            if ($('#modalQuotes #dateQuote').val() != '' && servicesActive) {
                console.log(arrayServicesActive);
            }
        }

        function addService() {
            var domId = countServiceType();
            var available = false;
            var selected = serviceTypeSelected(domId);

            var html = `
                <select class="form-control form-control-sm mb-2 serviceType" id="servicesTypes-${domId}" onchange="getServices(this.value, ${domId})">
                    <option value="">Elija una opcion</option>`;
                    serviceTypes.forEach(s => {
                        if (!selected.includes(s.id.toString())) {
                            available = true;
                            html += `<option value="${s.id}">${s.name}</option>`;
                        }
                    });
                html += `</select>
                <div class="col-xl-12 mb-4 divServices" id="divServices-${domId}">

                </div>`;

            if (available) {
                $('#modalQuotes #contentServices').append(html);
            } else {
                Swal.fire({
                    icon: 'warning',
                    text: 'No hay mas servicios disponibles'
                });
            }
        }

        function serviceTypeSelected(domId) {
            var serviceSelected = [];
            $('#modalQuotes .serviceType').each(function(i, e) {
                if ($(this).val() != '' && i != domId) {
                    serviceSelected[i] = $(this).val();
                }
            });
            return serviceSelected;
        };

        function countServiceType() {
            var count = 0;
            $('#modalQuotes .serviceType').each(function() {
                count++;
            });
            return count;
        }

        function getServices(serviceTypeId, domId) {
            if (serviceTypeId == '' || serviceTypeId == null) {
                $('#modalQuotes #divServices-'+domId).html('');
                return false;
            }
            var selected = serviceTypeSelected(domId);

            if (selected.includes(serviceTypeId)) {
                $('#modalQuotes #servicesTypes-'+domId).val('');
                $('#modalQuotes #divServices-'+domId).html('');
                Swal.fire({
                    icon: 'warning',
                    html: '<p class="text-center">Esta categoría ya esta seleccionada.<br>Por favor elija otra.</p>'
                });
                return false;
            }

            serviceTypes.forEach(s => {
                if (s.id == parseInt(serviceTypeId)) {
                    cerateDomServices(s.services, domId);
                }
            });
        }

        function cerateDomServices(services, domId) {
            var html = '', bg = '';
            services.forEach(s => {
                bg = (bg != '') ? '' : 'bg-gray';
                html += `
                    <div class="col-xl-12 relative ${bg}" id="divService-${s.id}">
                        <input class="form-check-input fs-normal pointer me-1 servicesSelected" type="checkbox" id="service-${s.id}" value="${s.id}" data-time="${s.time}" data-price="${s.price}" data-name="${s.name}" onchange="verifyCheckUncheckService(${s.id})">
                        <label class="pointer selection-disable bold mt-1" for="service-${s.id}">${s.name}</label>
                        <span class="contentNumberService absolute right"></span>
                    </div>
                `;
            });
            $('#modalQuotes #divServices-'+domId).html(html);
        }

        function createNumberService(serviceId) {
            var html = `
                <i class="fa-solid fa-minus add-number selection-disable fs-small" onclick="addRemoveNumber('remove', ${serviceId})"></i>
                <span class="selection-disable fs-small bold numberServiceText">1</span>
                <input class="numberServiceInput" type="hidden" id="numberServiceInput-${serviceId}" value="1">
                <i class="fa-solid fa-plus me-3 add-number selection-disable fs-small" onclick="addRemoveNumber('add', ${serviceId})"></i>
            `;
            return html;
        }

        function verifyCheckUncheckService(serviceId) {
            $(`#modalQuotes #divService-${serviceId} .contentNumberService`).html('');
            if ($(`#modalQuotes #service-${serviceId}`).is(':checked')) {
                $(`#modalQuotes #divService-${serviceId} .contentNumberService`).html(createNumberService(serviceId));
                verifyDateAndServices();
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
            verifyDateAndServices();
        }

        function openModalQuotes() {
            $('#modalQuotes .form-control').val('');
            $('#modalQuotes .serviceType').remove();
            $('#modalQuotes .divServices').remove();
            addService();
            $('#modalQuotes #calendar .datepicker .day').removeClass('active');
            $('#modalQuotes').modal('show');
        }

        function openModalCustomers() {
            $('#modalCustomers .form-control').val('');
            $('#modalCustomers .modal-content').addClass('shadow mt-3');
            $('#modalCustomers').addClass('mt-4');
            $('#modalCustomers').modal('show');
        }

        $('#modalCustomersForm').submit((e) => {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyCustomers',
                method: 'POST',
                data: $('#modalCustomersForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        $('#modalCustomers').modal('hide');
                        $('#modalQuotes #customer').val(res.data.name);
                        $('#modalQuotes #customerId').val(res.data.id);
                        Swal.fire({
                            icon: 'success',
                            html: res.msj
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            html: res.msj
                        });   
                    }
                },
                error: ()=> {
                    $('#modalCustomers').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | {{$modulo->name}}</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tableServices">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo de servicio</th>
                        <th>Servicio</th>
                        <th>Precio</th>
                        <th>Precio especial</th>
                        <th>Duración del servicio<br>(en minutos)</th>
                        <th>
                            {{-- @if (in_array(1, $permissions)) --}}
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Nuevo servicio" onclick="openModal()"><i class="fa-solid fa-circle-plus"></i></button>
                            {{-- @endif --}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    {{-- @if (in_array(1, $permissions) || in_array(2, $permissions)) --}}
        @include('operation.modals.modalServices')
    {{-- @endif --}}
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        var permissions = @json($permissions);
        const formatMxn = new Intl.NumberFormat("en", { style: "currency", "currency": "MXN" });

        $(document).ready(()=> {
            tableServices();
        });

        function tableServices() {
            $('#tableServices').dataTable().fnDestroy();
            $('#tableServices').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getServices',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[2, 'ASC']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'service_type.name', name: 'service_type.name' },
                    { data: 'name', name: 'name' },
                    {
                        name: 'price',
                        className: 'text-center',
                        width: '10%',
                        render: (data, type, row, meta) => {
                            return `<span>${formatMxn.format(row.price).substring(2)}</span>`;
                        }
                    },
                    {
                        name: 'discounted_price',
                        className: 'text-center',
                        width: '10%',
                        render: (data, type, row, meta) => {
                            return `<span>${formatMxn.format(row.discounted_price).substring(2)}</span>`;
                        }
                    },
                    { data: 'time', name: 'time', className: 'text-center' },
                    {
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        // width: '8%',
                        render: (data, type, row, meta) => {
                            var data = JSON.stringify(row);
                            data = data.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                // if (permissions.includes(2)) {
                                    buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar puesto" onclick="openModal(${data})"><i class="fa-solid fa-pen"></i></button>`;
                                // }
                                // if (permissions.includes(3)) {
                                    buttons += `<button class="btn btn-danger btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Desactivar puesto"><i class="fa-solid fa-eye"></i></button>`;
                                // }
                            buttons += '</div>';
                            return buttons;
                        }
                    },
                ],
                drawCallback: function (settings) {
                    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                },
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        }

        function openModal(data = null) {
            $('#modalServices .form-control').val('');
            $('#modalServices #time').val(15);
            $('#modalServices #modalServicesLabel').text('Crear servicio');
            $('#modalServices #btnSave').text('Guardar');
            if (data != null) {
                $('#modalServices #serviceId').val(data.id);
                $('#modalServices #serviceType').val(data.service_type_id);
                $('#modalServices #serviceName').val(data.name);
                $('#modalServices #price').val(data.price);
                $('#modalServices #priceDiscount').val(data.discounted_price);
                $('#modalServices #time').val(data.time);
                $('#modalServices #modalServicesLabel').text('Editar servicio');
                $('#modalServices #btnSave').text('Guardar cambios');
            }
            $('#modalServices').modal('show');
        }

        $('#modalServicesForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyService',
                method: 'POST',
                data: $('#modalServicesForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableServices();
                        $('#modalServices').modal('hide');
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
                    $('#modalServices').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
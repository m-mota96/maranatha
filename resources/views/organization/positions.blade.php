@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | {{$modulo->name}}</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tablePositions">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Puesto</th>
                        <th>Estatus</th>
                        <th>
                            {{-- @if (in_array(1, $permissions)) --}}
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Nuevo puesto" onclick="openModal()"><i class="fa-solid fa-circle-plus"></i></button>
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
        @include('organization.modals.modalPositions')
    {{-- @endif --}}
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        var permissions = @json($permissions);

        $(document).ready(()=> {
            tablePositions();
        });

        function tablePositions() {
            $('#tablePositions').dataTable().fnDestroy();
            $('#tablePositions').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getPositions',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[1, 'ASC']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    {
                        orderable: false,
                        className: 'text-center',
                        render: (data, type, row, meta) => {
                            return `<b>${row.status == 1 ? 'Activo' : 'Inactivo'}</b>`;
                        }
                    },
                    {
                        orderable: false,
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
            $('#modalPositions .form-control').val('');
            $('#modalPositions #modalPositionsLabel').text('Crear puesto');
            $('#modalPositions #btnSave').text('Guardar');
            if (data != null) {
                $('#modalPositions #positionId').val(data.id);
                $('#modalPositions #positionName').val(data.name);
                $('#modalPositions #modalPositionsLabel').text('Editar puesto');
                $('#modalPositions #btnSave').text('Guardar cambios');
            }
            $('#modalPositions').modal('show');
        }

        $('#modalPositionsForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyPosition',
                method: 'POST',
                data: $('#modalPositionsForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tablePositions();
                        $('#modalPositions').modal('hide');
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
                    $('#modalPositions').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
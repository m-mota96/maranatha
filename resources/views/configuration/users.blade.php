@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | Administración</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tableUsers">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Nuevo usuario" onclick="openModal()"><i class="fa-solid fa-circle-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('configuration.modals.modalUsers')
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(()=> {
            tableUsers();
        });

        function tableUsers() {
            $('#tableUsers').dataTable().fnDestroy();
            $('#tableUsers').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getUsers',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[1, 'ASC']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'user', name: 'user' },
                    {
                        orderable: false,
                        className: "text-center",
                        // width: '8%',
                        render: (data, type, row, meta) => {
                            var data = JSON.stringify(row);
                            data = data.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar módulo" onclick="openModal(${data})"><i class="fa-solid fa-pen"></i></button>`;
                                buttons += `<button class="btn btn-danger btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Desactivar módulo"><i class="fa-solid fa-eye"></i></button>`;
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
            $('#modalUsers .form-control').val('');
            $('#modalUsers #modalUsersLabel').text('Crear usuario');
            $('#modalUsers #btnSave').text('Guardar');
            $('#modalUsers #password').attr('required', true);
            $('#modalUsers #passwordTwo').attr('required', true);
            if (data != null) {
                $('#modalUsers #userId').val(data.id);
                $('#modalUsers #nameUser').val(data.name);
                $('#modalUsers #user').val(data.user);
                $('#modalUsers #modalUsersLabel').text('Editar usuario');
                $('#modalUsers #btnSave').text('Guardar cambios');
                $('#modalUsers #password').attr('required', false);
                $('#modalUsers #passwordTwo').attr('required', false);
            }
            $('#modalUsers').modal('show');
        }

        $('#modalUsersForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyUser',
                method: 'POST',
                data: $('#modalUsersForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableUsers();
                        $('#modalUsers').modal('hide');
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
                    $('#modalUsers').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
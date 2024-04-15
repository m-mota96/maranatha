@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | {{$modulo->name}}</title>
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('configuration.modals.modalUsersPermissions')
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        const modules = @json($allModules);

        $(document).ready(()=> {
            tableUsers();
        });

        function tableUsers() {
            $('#tableUsers').dataTable().fnDestroy();
            $('#tableUsers').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                // searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getUsers',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[0, 'DESC']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'user', name: 'user' },
                    {
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        // width: '8%',
                        render: (data, type, row, meta) => {
                            var data = JSON.stringify(row);
                            data = data.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar permisos" onclick="openModal(${data})"><i class="fa-solid fa-pen"></i></button>`;
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
            var html = '';
            html += `<div col-xl-12><ul>`;
                modules.forEach(m => {
                    html += `
                        <input class="form-check-input pointer me-1" type="checkbox" value="" id="${m.id}">
                        <label class="form-check-label pointer" for="${m.id}">${m.name}</label>
                    `;
                    console.log(m);
                    html += `<ul>`;
                        m.submodules.forEach(sm => {
                            html += `
                                <input class="form-check-input pointer me-1" type="checkbox" value="" id="${sm.id}">
                                <label class="form-check-label pointer" for="${sm.id}">${sm.name}</label>
                            `;
                            html += `<ul>`;
                                sm.submodules.forEach(sm2 => {
                                    html += `
                                        <input class="form-check-input pointer me-1" type="checkbox" value="" id="${sm2.id}">
                                        <label class="form-check-label pointer" for="${sm2.id}">${sm2.name}</label>
                                    `;
                                });
                            html += `</ul>`;
                        });
                    html += `</ul>`;
                });
            html += `</ul></div>`;
            $('#contentUsersPermissions').html(html);
            $('#modalUsersPermissions').modal('show');
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
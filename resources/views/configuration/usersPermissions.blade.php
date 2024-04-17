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
        // console.log(modules);

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
                            var data = JSON.stringify(row.modules);
                            data = data.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar permisos" onclick="openModal(${row.id}, ${data})"><i class="fa-solid fa-pen"></i></button>`;
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

        function openModal(userId, data = null) {
            $('#modalUsersPermissions #userId').val(userId);
            var checked = '', cont = 0;
            var html = '';
            html += `<div col-xl-12>`;
                modules.forEach(m => {
                    html += `<ul>`;
                        checked = '';
                        data.forEach(d => {
                            if (d.id == m.id) {
                                checked = 'checked';
                            }
                        });
                        html += `
                            <input class="form-check-input pointer me-1 dad-${m.id}" type="checkbox" name="modulesActive[${cont}]" id="module-${m.id}" value="${m.id}" ${checked} onchange="checkUncheckSons(${m.id})">
                            <label class="form-check-label pointer mb-1 selection-disable" for="module-${m.id}">${m.name}</label>
                        `;
                        html += `<ul>`;
                            m.submodules.forEach(sm => {
                                checked = '';
                                cont++;
                                data.forEach(d => {
                                    if (d.id == sm.id) {
                                        checked = 'checked';
                                    }
                                });
                                html += `
                                    <input class="form-check-input pointer me-1 son-${m.id} dad-${sm.id}" type="checkbox" name="modulesActive[${cont}]" id="module-${sm.id}" value="${sm.id}" ${checked} onchange="checkUncheckDadSon(${m.id}, ${sm.id})">
                                    <label class="form-check-label pointer mb-1 selection-disable" for="module-${sm.id}">${sm.name}</label>
                                `;
                                html += `<ul>`;
                                    sm.submodules.forEach(sm2 => {
                                        checked = '';
                                        cont++;
                                        data.forEach(d => {
                                            if (d.id == sm2.id) {
                                                checked = 'checked';
                                            }
                                        });
                                        html += `
                                            <input class="form-check-input pointer me-1 grandson-${m.id} son-${sm.id}" type="checkbox" name="modulesActive[${cont}]" id="module-${sm2.id}" value="${sm2.id}" ${checked} onchange="checkUncheckDads(${m.id}, ${sm.id}, ${sm2.id})">
                                            <label class="form-check-label pointer mb-1 selection-disable" for="module-${sm2.id}">${sm2.name}</label><br>
                                        `;
                                    });
                                html += `</ul>`;
                            });
                        html += `</ul>`;
                        cont++;
                    html += `</ul>`;
                });
            html += `</div>`;
            $('#contentUsersPermissions').html(html);
            $('#modalUsersPermissions').modal('show');
        }

        $('#modalUsersPermissionsForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'updateUsersPermissions',
                method: 'POST',
                data: $('#modalUsersPermissionsForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableUsers();
                        $('#modalUsersPermissions').modal('hide');
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
                    $('#modalUsersPermissions').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });

        function checkUncheckSons(moduleId) {
            if($("#module-"+moduleId).is(':checked')) { 
                $('.son-'+moduleId).prop('checked', true);
                $('.grandson-'+moduleId).prop('checked', true);
            }else{
                $('.son-'+moduleId).prop('checked', false);
                $('.grandson-'+moduleId).prop('checked', false);
            }
        }

        function checkUncheckDadSon(dadId, moduleId) {
            if($("#module-"+moduleId).is(':checked')) { 
                $('.son-'+moduleId).prop('checked', true);
                $('.dad-'+dadId).prop('checked', true);
            } else {
                $('.son-'+moduleId).prop('checked', false);
                var moduleChecked = false;
                $('.son-'+dadId).each(function(e) {
                    if ($(this).is(':checked')) {
                        moduleChecked = true;
                    }
                });

                if (!moduleChecked) {
                    $('.dad-'+dadId).prop('checked', false);
                }
            }
        }

        function checkUncheckDads(grandfatherId, dadId, moduleId) {
            if($("#module-"+moduleId).is(':checked')) { 
                $('.dad-'+dadId).prop('checked', true);
                $('.dad-'+grandfatherId).prop('checked', true);
            } else {
                var moduleChecked = false;
                $('.son-'+dadId).each(function(e) {
                    if ($(this).is(':checked')) {
                        moduleChecked = true;
                    }
                });

                if (!moduleChecked) {
                    $('.dad-'+dadId).prop('checked', false);
                }

                moduleChecked = false;
                $('.son-'+grandfatherId).each(function(e) {
                    if ($(this).is(':checked')) {
                        moduleChecked = true;
                    }
                });

                if (!moduleChecked) {
                    $('.dad-'+grandfatherId).prop('checked', false);
                }
            }
        }
    </script>
@endsection
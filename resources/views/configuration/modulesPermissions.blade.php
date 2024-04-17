@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | {{$modulo->name}}</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tableModules">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Modulo</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('configuration.modals.modalModulesPermissions')
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(()=> {
            tableModules();
        });

        function tableModules() {
            $('#tableModules').dataTable().fnDestroy();
            $('#tableModules').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                // searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getModules',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[0, 'DESC']],
                columns: [
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'name', name: 'name', width: '20%' },
                    {
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: (data, type, row, meta) => {
                            var html = '';
                            row.permissions.forEach(p => {
                                html += `<span class="badge text-bg-success me-2">${p.name}</span>`;
                            });
                            return html;
                        }
                    },
                    {
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        width: '8%',
                        render: (data, type, row, meta) => {
                            var permissions = JSON.stringify(row.permissions);
                            permissions = permissions.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                // buttons += `<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Agregar permisos" onclick="openModal(${row.id})"><i class="fa-solid fa-plus"></i></button>`;
                                buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar permisos" onclick="openModal(${row.id}, '${row.name}', ${permissions})"><i class="fa-solid fa-pen"></i></button>`;
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

        function openModal(moduleId, moduleName, permissions) {
            var html = '';
            $('#modalModulesPermissions #moduleId').val(moduleId);
            $('#modalModulesPermissions #moduleName').val(moduleName);
            permissions.forEach((p, i) => {
                html += `
                    <tr class="tr" id="tr${i}">
                        <td>
                            <input class="id" type="hidden" name="permissionId[${i}]" value="${p.id}">
                            <input class="form-control form-control-sm name" name="permissionName[${i}]" value="${p.name}" required>
                        </td>
                        <td>
                            <select class="form-control form-control-sm status" name="permissionStatus[${i}]" required>
                                <option value="1" ${p.status == 1 ? 'selected' : ''}>Activo</option>
                                <option value="0" ${p.status == 0 ? 'selected' : ''}>Inactivo</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm eliminar" type="button" data-bs-toggle="tooltipModal" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar permiso" onclick="deletePermission(${i}, ${p.id})"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                `;
            });

            $('#bodyModulesPermissions').html(html);
            if (html == '') {
                addPermission();
            }
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltipModal"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            $('#modalModulesPermissions').modal('show');
        }

        function addPermission() {
            var cont = countElements();
            var html = `
                <tr class="tr" id="tr${cont}">
                    <td>
                        <input class="id" type="hidden" name="permissionId[${cont}]" value="">
                        <input class="form-control form-control-sm name" name="permissionName[${cont}]" required>
                    </td>
                    <td>
                        <select class="form-control form-control-sm status" name="permissionStatus[${cont}]" required>
                            <option value="" selected disabled>Elija una opcion</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm eliminar" type="button" data-bs-toggle="tooltipModal" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar permiso" onclick="deleteTr(0)"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
            $('#bodyModulesPermissions').append(html);
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltipModal"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }

        function deletePermission(domId, permissionId) {
            Swal.fire({
                title: '¿Seguro que desea eliminar el permiso?',
                text: 'Esta acción no se puede revertir',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $('#URL').val()+'deletePermissionUser',
                        method: 'POST',
                        data: {
                            _token: $('#_token').val(),
                            permissionId: permissionId
                        },
                        success: (res) => {
                            tableModules();
                            $('#modalModulesPermissions #tr'+domId).remove();
                            var cont = countElements();
                            if (cont == 0) {
                                addPermission();
                            }
                            Swal.fire({
                                icon: 'success',
                                html: res.msj
                            });
                        },
                        error: ()=> {
                            Swal.fire({
                                icon: 'error',
                                html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                            });
                        }
                    });
                }
            });
        }

        function deleteTr(domId) {
            var cont = countElements();
            if (cont > 1) {
                $('#modalModulesPermissions #tr'+domId).remove();
                reorderElements();
            }
        }

        function reorderElements() {
            var cont = 0;
            $('#modalModulesPermissions .tr').each(function(e) {
                $(this).attr('id', 'tr'+cont);
                $(`#tr${cont} .id`).attr('name', `permissionId[${cont}]`);
                $(`#tr${cont} .name`).attr('name', `permissionName[${cont}]`);
                $(`#tr${cont} .status`).attr('name', `permissionStatus[${cont}]`);
                if ($(`#tr${cont} .id`).val() != '') {
                    $(`#tr${cont} .eliminar`).attr('onclick', `deletePermission(${cont}, ${$(`#tr${cont} .id`).val()})`);
                } else {
                    $(`#tr${cont} .eliminar`).attr('onclick', `deleteTr(${cont})`);
                }
                cont++;
            });
        }

        function countElements() {
            var cont = 0;
            $('#modalModulesPermissions .tr').each(function(e) {
                cont++;
            });
            return cont;
        }

        $('#modalModulesPermissionsForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'updateModulesPermissions',
                method: 'POST',
                data: $('#modalModulesPermissionsForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableModules();
                        $('#modalModulesPermissions').modal('hide');
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
                    $('#modalModulesPermissions').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
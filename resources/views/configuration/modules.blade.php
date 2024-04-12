@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | Administración</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tableModules">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Target</th>
                        <th>Clase</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                        <th>
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Nuevo módulo" onclick="openModal()"><i class="fa-solid fa-circle-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('configuration.modals.modalModules')
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
                searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getModules',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[1, 'ASC']],
                columns: [
                    //{ data: 'idoperacion', name: 'idoperacion', orderable: false, className: "text-center" },
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'icon', name: 'icon' },
                    { data: 'target', name: 'target' },
                    { data: 'class', name: 'class' },
                    { data: 'description', name: 'description' },
                    {
                        orderable: false,
                        className: 'text-center',
                        render: (data, type, row, meta) => {
                            return `<b>${row.status == 1 ? 'Activo' : 'Inactivo'}</b>`;
                        }
                    },
                    // { 
                    //     orderable: false,
                    //     className: "text-center",
                    //     render: (data, type, row, meta) => {
                    //         const formateador = new Intl.NumberFormat("en", { style: "currency", "currency": "MXN" });
                    //         return `<span>${formateador.format(row.importe).substring(2)}</span>`;
                    //     }
                    // },
                    // { data: 'banco.banco', name: 'bancos.banco', orderable: false },
                    // { 
                    //     orderable: false,
                    //     className: "text-center",
                    //     render: (data, type, row, meta) => {
                    //         var fecha = fechaEs(row.fecha_creacion, 1, '/', 1);
                    //         return `<span>${fecha}</span>`;
                    //     }
                    // },
                    // {
                    //     orderable: false,
                    //     className: "text-center",
                    //     width: '15%',
                    //     render: (data, type, row, meta) => {
                    //         if (row.folio_unico != null && row.folio_unico != 0 && row.folio_unico != '') {
                    //             return `
                    //                 <div id="divEC${row.id}">
                    //                     <span>${row.folio_unico}</span>
                    //                     <input type="hidden" id="estado_cuenta${row.id}" value="${row.folio_unico}">
                    //                 </div>
                    //             `;
                    //         }
                    //         return `
                    //             <div id="divEC${row.id}">
                    //                 <input class="form-control form-control-sm" type="text" id="buscadorEC${row.id}" placeholder="Puede buscar por importe" onkeyup="buscaFolio(${row.id}, this.value, ${row.sociedad.idempresa}, '${row.banco.banco}')">
                    //                 <div class="bg-white border divBuscador hidden" style="width: 550px; position: absolute;" id="divBuscador${row.id}">
                                    
                    //                 </div>
                    //             </div>
                    //         `;
                    //     }
                    // },
                    // { 
                    //     orderable: false,
                    //     className: "text-center",
                    //     render: (data, type, row, meta) => {
                    //         var color = 'warning';
                    //         switch (row.status.nombre) {
                    //             case 'Aplicado':
                    //                 color = 'success';
                    //             break;
                    //             case 'Rechazado':
                    //                 color = 'danger';
                    //             break;
                    //         }
                    //         return `<span class="badge badge-${color}">${row.status.nombre}</span>`;
                    //     }
                    // },
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
            $('#modalModules .form-control').val('');
            $('#modalModules #modalModulesLabel').text('Crear módulo');
            $('#modalModules #btnSave').text('Guardar');
            if (data != null) {
                $('#modalModules #moduleId').val(data.id);
                $('#modalModules #dad').val(data.module_id == null ? 0 : data.module_id);
                $('#modalModules #nameModule').val(data.name);
                $('#modalModules #target').val(data.target);
                $('#modalModules #icon').val(data.icon);
                $('#modalModules #class').val(data.class);
                $('#modalModules #description').val(data.description);
                $('#modalModules #modalModulesLabel').text('Editar módulo');
                $('#modalModules #btnSave').text('Guardar cambios');
            }
            $('#modalModules').modal('show');
        }

        $('#modalModulesForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyModule',
                method: 'POST',
                data: $('#modalModulesForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableModules();
                        $('#modalModules').modal('hide');
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
                    $('#modalModules').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
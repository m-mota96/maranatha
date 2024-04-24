@extends('index')

@section('heads')
    <title>{{auth()->user()->name}} | {{$modulo->name}}</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
    <div class="col-xl-12 p-4">
        <div class="row bg-white p-3 radius-top radius-bottom">
            <table class="table table-striped" id="tableStaff">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Fecha de nacimiento</th>
                        <th>Curp</th>
                        <th>Rfc</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Comisión</th>
                        <th>Puesto</th>
                        <th>
                            {{-- @if (in_array(1, $permissions)) --}}
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Nuevo staff" onclick="openModal()"><i class="fa-solid fa-circle-plus"></i></button>
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
        @include('organization.modals.modalStaff')
    {{-- @endif --}}
        @include('organization.modals.modalSchedulesStaff')
        @include('organization.modals.modalImageProfile')
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        var permissions = @json($permissions);
        var myDropzone = '';

        $(document).ready(()=> {
            tableStaff();
            $("#modalImageProfile #imgProfile").dropzone({
                url: $('#URL').val()+'updateImgProfileStaff',
                autoProcessQueue: false,
                maxFilesize: '1000000',
                acceptedFiles: 'image/jpeg, image/png',
                maxFiles: 1,
                init: function() {
                    myDropzone = this;
                    this.on("maxfilesexceeded", file => {
                        Swal.fire({
                            icon: 'error',
                            text: 'Solo puede cargar una imagen a la ves.'
                        });
                        this.removeFile(file);
                        return false;
                    });
                    this.on("addedfile", file => {
                        if (file.size > 1000000) {
                            Swal.fire({
                                icon: 'error',
                                text: 'La imagen debe pesar menos de 1 MB.'
                            });
                            this.removeAllFiles();
                            return false;
                        }
                        if (file.type != 'image/jpeg' && file.type != 'image/png') {
                            Swal.fire({
                                icon: 'error',
                                text: 'Solo se aceptan imagenes con formato JPG o PNG.'
                            });
                            this.removeAllFiles();
                            return false;
                        }
                        $('#modalImageProfile #btnDeletePreview').removeClass('hidden');
                    });
                    this.on('sending', function(file, xhr, formData){
                        formData.append('_token', $('#_token').val());
                        formData.append('staffId', $('#modalStaff #staffId').val());
                    });
                    this.on("success", function(file, request) {
                        if (request.error) {
                            Swal.fire({
                                icon: 'error',
                                text: request.msj
                            });
                            return false;
                        }

                        tableStaff();
                        $('#modalImageProfile').modal('hide');
                        $('#modalStaff #imgProfileStaff').attr('src', $('#URL').val()+'profileStaff/'+request.msj);
                        Swal.fire({
                            icon: 'success',
                            text: 'Laimagen se actualizo correctamente.'
                        });
                    });
                }
            });
        });

        function tableStaff() {
            $('#tableStaff').dataTable().fnDestroy();
            $('#tableStaff').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'Bfrtip',
                // searching: false,
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]],
                ajax: {
                    url: $('#URL').val()+'getStaff',
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json'},
                },
                order: [[1, 'ASC']],
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<span>${row.name} ${row.first_name} ${row.last_name}</span>`;
                        }
                    },
                    {
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<span>${dateEs(row.birthdate)}</span>`;
                        }
                    },
                    { data: 'curp', name: 'curp' },
                    { data: 'rfc', name: 'rfc' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'commission', name: 'commission' },
                    { data: 'position.name', name: 'position.name' },
                    {
                        orderable: false,
                        className: "text-center",
                        // width: '8%',
                        render: (data, type, row, meta) => {
                            var data = JSON.stringify(row);
                            data = data.replace(/['"]+/g, "'");
                            var buttons = `<div class="btn-group">`;
                                // if (permissions.includes(2)) {
                                    buttons += `<button class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar staff" onclick="openModal(${data})"><i class="fa-solid fa-pen"></i></button>`;
                                    var schedulesStaff = JSON.stringify(row.schedules);
                                    schedulesStaff = schedulesStaff.replace(/['"]+/g, "'");
                                    buttons += `<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Horario de staff" onclick="openModalSchedules(${row.id}, '${row.name} ${row.first_name} ${row.last_name}', ${schedulesStaff})"><i class="fa-solid fa-clock"></i></button>`;
                                // }
                                // if (permissions.includes(3)) {
                                    buttons += `<button class="btn btn-danger btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Desactivar staff"><i class="fa-solid fa-eye"></i></button>`;
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

        function openModalSchedules(staffId, staffName, schedulesStaff) {
            $('#modalSchedulesStaff .form-control').val('');
            $(`#modalSchedulesStaff .status`).prop('checked', false);
            $('#modalSchedulesStaff #schedulesStaffId').val(staffId);
            $('#modalSchedulesStaff #schedulesStaffName').text(staffName);
            $(`#modalSchedulesStaff .tr`).removeClass('bg-success');
            $(`#modalSchedulesStaff .tr`).addClass('bg-danger');
            
            if (schedulesStaff.length > 0) {
                schedulesStaff.forEach(s => {
                    $(`#modalSchedulesStaff #tr-${s.day} .startTime`).val(s.start_time);
                    $(`#modalSchedulesStaff #tr-${s.day} .endTime`).val(s.end_time);
                    $(`#modalSchedulesStaff #tr-${s.day} .mealStartTime`).val(s.meal_start_time);
                    $(`#modalSchedulesStaff #tr-${s.day} .mealEndTime`).val(s.meal_end_time);
                    var checked = (s.status == 1) ? true : false;
                    $(`#modalSchedulesStaff #tr-${s.day} .status`).prop('checked', checked);
                    if (checked) {
                        $(`#modalSchedulesStaff #tr-${s.day}`).removeClass('bg-danger');
                        $(`#modalSchedulesStaff #tr-${s.day}`).addClass('bg-success');
                    }
                });
            }

            $('#modalSchedulesStaff').modal('show');
        }

        function openModal(data = null) {
            $('#modalStaff .services').prop('checked', false);
            $('#modalStaff #imgProfileStaff').attr('src', $('#URL').val()+'general/user.jpg');
            $('#modalStaff .form-control').val('');
            $('#modalStaff #modalStaffLabel').text('Crear staff');
            $('#modalStaff #divImgProfile').addClass('hidden');
            $('#modalStaff #btnSave').text('Guardar');
            if (data != null) {
                if (data.services.length > 0) {
                    data.services.forEach(s => {
                        $(`#modalStaff #service-${s.id}`).prop('checked', true);
                    });
                }
                if (data.image_profile != null && data.image_profile != '') {
                    $('#modalStaff #imgProfileStaff').attr('src', $('#URL').val()+'profileStaff/'+data.image_profile);
                }
                $('#modalStaff #divImgProfile').removeClass('hidden');
                $('#modalStaff #staffId').val(data.id);
                $('#modalStaff #position').val(data.position_id);
                $('#modalStaff #staffName').val(data.name);
                $('#modalStaff #firstName').val(data.first_name);
                $('#modalStaff #lastName').val(data.last_name);
                $('#modalStaff #birthdate').val(data.birthdate);
                $('#modalStaff #curp').val(data.curp);
                $('#modalStaff #rfc').val(data.rfc);
                $('#modalStaff #email').val(data.email);
                $('#modalStaff #phone').val(data.phone);
                $('#modalStaff #commission').val(data.commission);
                $('#modalStaff #modalStaffLabel').text('Editar staff');
                $('#modalStaff #btnSave').text('Guardar cambios');
            }
            $('#modalStaff').modal('show');
        }

        function openModalImageProfile() {
            myDropzone.removeAllFiles();
            $('#modalImageProfile #btnDeletePreview').addClass('hidden');
            $('#modalImageProfile').modal('show');
        }

        function deletePreview() {
            $('#modalImageProfile #btnDeletePreview').addClass('hidden');
            myDropzone.removeAllFiles();
        }

        $('#modalImageProfileForm').submit((e)=> {
            e.preventDefault();
            myDropzone.processQueue();
        });

        $('#modalSchedulesStaffForm').submit((e)=> {
            e.preventDefault();
            $(`#modalSchedulesStaff .form-control`).removeClass('border-danger');
            var scheduleActive = false, scheduleIncorrect = false, mealTimeIncorrect = false;
            $('#modalSchedulesStaff .tr').each(function(i, e) {
                if ($(`#modalSchedulesStaff #tr-${i+1} .startTime`).val() != '' && $(`#modalSchedulesStaff #tr-${i+1} .endTime`).val() != '' && $(`#modalSchedulesStaff #tr-${i+1} .status`).is(':checked')) {
                    scheduleActive = true;
                    if ($(`#modalSchedulesStaff #tr-${i+1} .startTime`).val() >= $(`#modalSchedulesStaff #tr-${i+1} .endTime`).val()) {
                        scheduleIncorrect = true;
                        $(`#modalSchedulesStaff #tr-${i+1} .startTime`).addClass('border-danger');
                        $(`#modalSchedulesStaff #tr-${i+1} .endTime`).addClass('border-danger');
                    }
                }
                if ($(`#modalSchedulesStaff #tr-${i+1} .mealStartTime`).val() != '' && $(`#modalSchedulesStaff #tr-${i+1} .mealEndTime`).val() != '') {
                    if ($(`#modalSchedulesStaff #tr-${i+1} .mealStartTime`).val() >= $(`#modalSchedulesStaff #tr-${i+1} .mealEndTime`).val()) {
                        mealTimeIncorrect = true;
                        $(`#modalSchedulesStaff #tr-${i+1} .mealStartTime`).addClass('border-danger');
                        $(`#modalSchedulesStaff #tr-${i+1} .mealEndTime`).addClass('border-danger');
                    }    
                }
            });

            if (!scheduleActive) {
                Swal.fire({
                    icon: 'error',
                    text: 'Debe registrar al menos un día de trabajo para el staff'
                });
                return false;
            }

            if (scheduleIncorrect) {
                Swal.fire({
                    icon: 'error',
                    text: 'La hora de entrada debe ser menor que la hora de salida'
                });
                return false;
            }

            if (mealTimeIncorrect) {
                Swal.fire({
                    icon: 'error',
                    text: 'La hora de entrada de comida debe ser menor que la hora de salida de comida'
                });
                return false;
            }

            $.ajax({
                url: $('#URL').val()+'updateSchedulesStaff',
                method: 'POST',
                data: $('#modalSchedulesStaffForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableStaff();
                        $('#modalSchedulesStaff').modal('hide');
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
                    $('#modalSchedulesStaff').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });

        $('#modalStaffForm').submit((e)=> {
            e.preventDefault();
            $.ajax({
                url: $('#URL').val()+'createModifyStaff',
                method: 'POST',
                data: $('#modalStaffForm').serialize(),
                success:(res) => {
                    if(res.error == false) {
                        tableStaff();
                        $('#modalStaff').modal('hide');
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
                    $('#modalStaff').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        html: 'Lo sentimos, ocurrio un error.<br>Por favor contacte a soporte.'
                    });
                }
            });
        });
    </script>
@endsection
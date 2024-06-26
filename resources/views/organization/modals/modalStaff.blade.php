<!-- Modal -->
<div class="modal fade" id="modalStaff" tabindex="-1" aria-labelledby="modalStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="modal-content" id="modalStaffForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalStaffLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12 mb-4 text-center" id="divImgProfile">
                        <img class="w-15 rounded-circle" src="{{asset('general/user.jpg')}}" alt="Temazcal Marantha" id="imgProfileStaff">
                        <i class="fa-solid fa-pen pencil-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar foto de perfil" onclick="openModalImageProfile()"></i>
                    </div>
                    <div class="col-xl-4" id="divStaffName">
                        <input class="form-control" type="hidden" name="staffId" id="staffId">
                        <label for="staffName">Nombre(s):</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="staffName" id="staffName" autocomplete="off" required>
                    </div>
                    <div class="col-xl-4">
                        <label for="firstName">Apellido paterno:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="firstName" id="firstName" autocomplete="off" required>
                    </div>
                    <div class="col-xl-4">
                        <label for="lastName">Apellido materno:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="lastName" id="lastName" autocomplete="off" required>
                    </div>
                    <div class="col-xl-4">
                        <label for="position">Puesto:</label>
                        <select class="form-control form-control-sm mb-3" type="text" name="position" id="position" required>
                            <option value="">Elija una opción</option>
                            @foreach ($positions as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-4">
                        <label for="birthdate">Fecha de nacimiento:</label>
                        <input class="form-control form-control-sm mb-3" type="date" name="birthdate" id="birthdate">
                    </div>
                    <div class="col-xl-4">
                        <label for="curp">Curp:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="curp" id="curp" autocomplete="off">
                    </div>
                    <div class="col-xl-4">
                        <label for="rfc">Rfc:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="rfc" id="rfc" autocomplete="off">
                    </div>
                    <div class="col-xl-4">
                        <label for="email">Correo electrónico:</label>
                        <input class="form-control form-control-sm mb-3" type="email" name="email" id="email" autocomplete="off">
                    </div>
                    <div class="col-xl-4">
                        <label for="phone">Teléfono:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="phone" id="phone" autocomplete="off">
                    </div>
                    <div class="col-xl-4">
                        <label for="commission">Comisión:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="commission" id="commission" autocomplete="off">
                    </div>
                    <div class="col-xl-12">
                    <label class="mb-1">Servicios que ofrece:</label>
                    <div class="col-xl-12">
                        @foreach ($services as $key => $s)
                            <input class="form-check-input fs-normal pointer me-1 mb-2 services" type="checkbox" name="service[{{$key}}]" id="service-{{$s->id}}" value="{{$s->id}}">
                            <label class="pointer selection-disable me-3 mb-2 bold" for="service-{{$s->id}}">{{$s->name}}</label>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btnSave"></button>
            </div>
        </form>
    </div>
</div>
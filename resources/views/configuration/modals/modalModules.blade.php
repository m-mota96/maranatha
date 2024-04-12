<!-- Modal -->
<div class="modal fade" id="modalModules" tabindex="-1" aria-labelledby="modalModulesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content modal-lg" id="modalModulesForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalModulesLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <label for="dad">Padre:</label>
                        <select class="form-control form-control-sm mb-3" name="dad" id="dad" required>
                            <option value="" selected disabled>Elija una opción</option>
                            <option value="0">Nuevo módulo</option>
                            @foreach ($menu as $m)
                                <option value="{{$m->id}}">{{$m->name}}</option>
                            @endforeach
                        </select>
                        <input class="form-control" type="hidden" name="moduleId" id="moduleId">
                        <label for="nameModule">Nombre del módulo:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="nameModule" id="nameModule" required>
                        <label for="target">Target:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="target" id="target">
                        <label for="icon">Ícono:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="icon" id="icon">
                        <label for="class">Clase:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="class" id="class">
                        <label for="description">Descripción:</label>
                        <textarea class="form-control mb-3" name="description" id="description" rows="3"></textarea>
                        {{-- <label for="status">Estatus:</label>
                        <select class="form-control form-control-sm mb-3" name="status" id="status">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select> --}}
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
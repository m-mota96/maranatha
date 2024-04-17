<!-- Modal -->
<div class="modal fade" id="modalModulesPermissions" tabindex="-1" aria-labelledby="modalModulesPermissionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="modalModulesPermissionsForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalModulesPermissionsLabel">Permisos de módulos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="moduleId" id="moduleId">
                <div class="row" id="contentModulesPermissions">
                    <div class="col-xl-12">
                        <label for="module">Módulo:</label>
                        <input class="form-control form-control-sm" type="text" id="moduleName" disabled readonly>
                    </div>
                    <div class="col-xl-12">
                        <table class="table table-striped" id="tableModulesPermissions">
                            <thead>
                                <tr>
                                    <th>Permiso</th>
                                    <th>Estatus</th>
                                    <th>
                                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Agregar permiso" onclick="addPermission()"><i class="fa-solid fa-plus"></i></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodyModulesPermissions">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btnSave">Actualizar permisos</button>
            </div>
        </form>
    </div>
</div>
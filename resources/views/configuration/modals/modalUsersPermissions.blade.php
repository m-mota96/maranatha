<!-- Modal -->
<div class="modal fade" id="modalUsersPermissions" tabindex="-1" aria-labelledby="modalUsersPermissionsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalUsersPermissionsForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUsersPermissionsLabel">Permisos de usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="userId" id="userId">
                <div class="row" id="contentUsersPermissions">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                @if (in_array(8, $permissions))
                    <button type="submit" class="btn btn-info" id="btnSave">Actualizar permisos</button>
                @endif
            </div>
        </form>
    </div>
</div>
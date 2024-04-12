<!-- Modal -->
<div class="modal fade" id="modalUsers" tabindex="-1" aria-labelledby="modalUsersLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalUsersForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUsersLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <input class="form-control" type="hidden" name="userId" id="userId">
                        <label for="nameUser">Nombre:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="nameUser" id="nameUser" autocomplete="off" required>
                        <label for="user">Usuario:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="user" id="user" autocomplete="off" required>
                        <label for="password">Contraseña:</label>
                        <input class="form-control form-control-sm mb-3" type="password" name="password" id="password">
                        <label for="passwordTwo">Confirmar contraseña:</label>
                        <input class="form-control form-control-sm mb-3" type="password" name="passwordTwo" id="passwordTwo">
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
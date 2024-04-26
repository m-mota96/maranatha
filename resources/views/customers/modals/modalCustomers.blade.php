<!-- Modal -->
<div class="modal fade" id="modalCustomers" tabindex="-1" aria-labelledby="modalCustomersLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalCustomersForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCustomersLabel">Registrar cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <input class="form-control" type="hidden" name="customerId" id="customerId">
                        <label for="customerName">Nombre completo:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="customerName" id="customerName" autocomplete="off" required>
                    </div>
                    <div class="col-xl-12">
                        <label for="customerEmail">Correo:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="customerEmail" id="customerEmail" autocomplete="off">
                    </div>
                    <div class="col-xl-12">
                        <label for="customerPhone">Teléfono:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="customerPhone" id="customerPhone" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btnSave">Guardar</button>
            </div>
        </form>
    </div>
</div>
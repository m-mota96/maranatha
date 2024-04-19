<!-- Modal -->
<div class="modal fade" id="modalPositions" tabindex="-1" aria-labelledby="modalPositionsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalPositionsForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalPositionsLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <input class="form-control" type="hidden" name="positionId" id="positionId">
                        <label for="positionName">Nombre del puesto:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="positionName" id="positionName" autocomplete="off" required>
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
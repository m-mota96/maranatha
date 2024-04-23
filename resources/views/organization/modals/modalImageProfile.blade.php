<!-- Modal -->
<div class="modal fade mt-5" id="modalImageProfile" tabindex="-1" aria-labelledby="modalImageProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalImageProfileForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalImageProfileLabel">Cambiar foto de perfil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row p-4">
                    <div class="col-xl-12 my-dropzone text-center pt-2" id="imgProfile">
                        <div class="dz-message mt-5" data-dz-message><h6 class="text-secondary">Arrastre la imagen o haga click en el recuadro</h6></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info" id="btnSave">Actualizar imagen</button>
            </div>
        </form>
    </div>
</div>
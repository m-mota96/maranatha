<!-- Modal -->
<div class="modal fade" id="modalQuotes" tabindex="-1" aria-labelledby="modalQuotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalQuotesLabel">Nueva cita</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-2">
                        <label for="dateQuote">Cliente:</label>
                        <input class="form-control form-control-sm mb-3" type="text" onkeyup="prueba()">
                        <label for="dateQuote">Fecha de la cita:</label>
                        {{-- <input class="form-control form-control-sm mb-3" type="date"> --}}
                        <input type="text" id="fechaCita" value="{{date('Y-m-d')}}">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
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
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <label>Fecha de la cita:</label>
                                <input class="form-control" type="hidden" id="dateQuote" value="">
                                <div id='calendar'></div>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label for="horary">Hora:</label>
                                <input class="form-control form-control-sm" type="time" id="horary">
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label for="customer">Cliente:</label>
                                <input class="form-control form-control-sm" type="text" id="customer">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label for="servicesTypes">Servicios:</label>
                        <select class="form-control form-control-sm mb-2" id="servicesTypes" onchange="getServices(this.value)">
                            <option value="">Elija una opcion</option>
                            @foreach ($serviceTypes as $key => $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                        <div class="col-xl-12" id="divServices">

                        </div>
                    </div>
                    <div class="col-xl-7">

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
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
                                <p class="relative mb-0">
                                    <label class="bold" for="customer">Cliente:</label>
                                    <i class="fa-solid fa-plus add-number selection-disable fs-small absolute right" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Nuevo cliente" onclick="openModalCustomers()"></i>
                                </p>
                                <input class="form-control form-control-sm ui-autocomplete-input" type="text" id="customer">
                                <input class="form-control" type="hidden" id="customerId">
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="bold">Fecha de la cita:</label>
                                <input class="form-control" type="hidden" id="dateQuote" value="">
                                <div id='calendar'></div>
                            </div>
                            <div class="col-xl-12 mb-3" id="divHorary">
                                <label class="bold horary hidden" for="horary">Hora:</label>
                                <input class="form-control form-control-sm horary hidden" type="time" id="horary" onchange="searchStaff()">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3" id="contentServices">
                        <p class="relative mb-0">
                            <label class="bold">Servicios:</label>
                            <i class="fa-solid fa-plus add-number selection-disable fs-small absolute right" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Añadir servicios" onclick="addService()"></i>
                        </p>
                        <select class="form-control form-control-sm mb-2 serviceType" id="servicesTypes-0" onchange="getServices(this.value, 0)">
                            <option value="">Elija una opcion</option>
                            @foreach ($serviceTypes as $key => $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                        <div class="col-xl-12 mb-4 divServices" id="divServices-0">

                        </div>
                    </div>
                    <div class="col-xl-7">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Confirmar cita</button>
            </div>
        </div>
    </div>
</div>
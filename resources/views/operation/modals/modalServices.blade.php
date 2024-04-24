<!-- Modal -->
<div class="modal fade" id="modalServices" tabindex="-1" aria-labelledby="modalServicesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="modalServicesForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalServicesLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <label for="serviceType">Tipo de servicio:</label>
                        <select class="form-control form-control-sm mb-3" type="text" name="serviceType" id="serviceType" required>
                            <option value="">Elija una opción</option>
                            @foreach ($serviceTypes as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-12">
                        <input class="form-control" type="hidden" name="serviceId" id="serviceId">
                        <label for="staffName">Servicio:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="serviceName" id="serviceName" autocomplete="off" required>
                    </div>
                    <div class="col-xl-12">
                        <label for="price">Precio:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="price" id="price" autocomplete="off" required>
                    </div>
                    <div class="col-xl-12">
                        <label for="priceDiscount">Precio de descuento:</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="priceDiscount" id="priceDiscount" autocomplete="off">
                    </div>
                    <div class="col-xl-12">
                        <label for="time">Duración del servicio (en minutos):</label>
                        <select class="form-control form-control-sm mb-3" name="time" id="time" required>
                            @for ($i = 15; $i <= 240; $i+=15)
                                <option value="{{$i}}">{{$i}} minutos @if(($i % 60) == 0) - {{($i / 60) == 1 ? ($i / 60).' hora' : ($i / 60).' horas'}}@endif</option>
                            @endfor
                        </select>
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
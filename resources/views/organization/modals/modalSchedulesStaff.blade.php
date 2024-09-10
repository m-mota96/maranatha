<!-- Modal -->
<div class="modal fade" id="modalSchedulesStaff" tabindex="-1" aria-labelledby="modalSchedulesStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="modal-content" id="modalSchedulesStaffForm">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalSchedulesStaffLabel">Horario de staff</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <input class="form-control" type="hidden" name="schedulesStaffId" id="schedulesStaffId">
                    <div class="col-cl-12 mb-3 text-center">
                        <h5>Staff: <b id="schedulesStaffName"></b></h5>
                    </div>
                    <div class="col-xl-12 mb-3">
                        <span class="fs-normal">¿Maneja el mismo horario todos los días?</span>
                        {{-- <div class="form-check"> --}}
                            <input class="form-check-input pointer fs-normal ms-2" type="radio" name="checkSchedules" id="noSchedules" value="NO" onchange="showHideChedules()" checked>
                            <label class="form-check-label pointer fs-normal" for="noSchedules">
                                No
                            </label>
                        {{-- </div>
                        <div class="form-check"> --}}
                            <input class="form-check-input pointer fs-normal ms-2" type="radio" name="checkSchedules" id="yesSchedules" value="YES" onchange="showHideChedules()">
                            <label class="form-check-label pointer fs-normal" for="yesSchedules">
                                Si
                            </label>
                        {{-- </div> --}}
                    </div>
                    <div class="col-xl-12 hidden" id="divChedulesGeneral">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Día</th>
                                    <th class="text-center">Hora de entrada</th>
                                    <th class="text-center">Horario de comida</th>
                                    <th class="text-center">Hora de salida</th>
                                    <th class="text-center">¿Trabaja este día?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center pt-3 w-10">-----</td>
                                    <td>
                                        <input class="form-control" type="time" id="startTime" onchange="setHour(this.value, 'startTime')">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">De:</span>
                                                <input class="form-control" type="time" id="mealStartTime" onchange="setHour(this.value, 'mealStartTime')">
                                            <span class="input-group-text">A:</span>
                                                <input class="form-control" type="time" id="mealEndTime" onchange="setHour(this.value, 'mealEndTime')">
                                        </div>
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" id="endTime" onchange="setHour(this.value, 'endTime')">
                                    </td>
                                    <td class="text-center pt-3">-----</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-12">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Día</th>
                                    <th class="text-center">Hora de entrada</th>
                                    <th class="text-center">Horario de comida</th>
                                    <th class="text-center">Hora de salida</th>
                                    <th class="text-center">¿Trabaja este día?</th>
                                </tr>
                            </thead>
                            <tbody id="bodySchedulesStaff">
                                @for ($i = 0; $i < sizeof($days); $i++)
                                    <tr class="tr" id="tr-{{$i+1}}">
                                        <td class="text-center w-10" valign="middle">
                                            <input type="hidden" name="day[{{$i}}]" value="{{$i+1}}">
                                            <b>{{$days[$i]}}</b>
                                        </td>
                                        <td>
                                            <input class="form-control startTime" type="time" name="startTime[{{$i}}]" id="startTime-{{$i}}">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">De:</span>
                                                    <input class="form-control mealStartTime" type="time" name="mealStartTime[{{$i}}]" id="mealStartTime-{{$i}}">
                                                <span class="input-group-text">A:</span>
                                                    <input class="form-control mealEndTime" type="time" name="mealEndTime[{{$i}}]" id="mealEndTime-{{$i}}">
                                            </div>
                                        </td>
                                        <td>
                                            <input class="form-control endTime" type="time" name="endTime[{{$i}}]" id="endTime-{{$i}}">
                                        </td>
                                        <td class="text-center" valign="middle">
                                            <input class="form-check-input fs-normal border border-dark pointer status" type="checkbox" name="activeDay[{{$i}}]" id="activeDay-{{$i}}">
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-info">Actualizar horarios</button>
            </div>
        </form>
    </div>
</div>
<?php

namespace App\Traits;

trait DateFormatEs {

    public static function dateEs($date, $abr = null, $separator = null, $time = null) {
        $separator = $separator == null ? ' de ' : $separator;
        $time = $time == null ? '' : substr($newDate, 10, 6);
        $mes = substr($date, 5, 2);
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $mesesCortos = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $mes = ($abr == false) ? $meses[intval($mes) - 1] : $mesesCortos[intval($mes) - 1];
        $newDate = substr($date, 8, 2). $separator . $mes . $separator .substr($date, 0, 4);
        return $newDate . $time;
    }

    public static function nameDay($date, $abr = false) { // Esta función de usa dentro de los controller para saber el nombre del día de la semana
        $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $diasCortos = ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'];
        $dia = ($abr == false) ? $dias[date('w', strtotime($date))] : $diasCortos[date('w', strtotime($date))];
        return $dia;
    }

    public static function nameMonth($date, $abr = false) { // Esta función de usa dentro de los controller para saber el nombre del mes
        $mes = substr($date, 5, 2);
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $mesesCortos = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $mes = ($abr == false) ? $meses[intval($mes) - 1] : $mesesCortos[intval($mes) - 1];
        return $mes;
    }
}
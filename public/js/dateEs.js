function dateEs(date, separator = null, abr = null, time = null) {
    separator       = separator == null ? '/' : ' ' + separator + ' ';
    time            = time == null ? '' : date.substring(11, 16);
    const months    = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const monthsAbr = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    return date.substring(8, 10) + separator + ((abr == null) ? months[parseInt(date.substring(5, 7)) - 1] : monthsAbr[parseInt(date.substring(5, 7)) - 1]) + separator + date.substring(0,4) + time;
}
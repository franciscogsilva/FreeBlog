function multiDelete(){
	$('.btn-fgs-delete').hide();
	$('#multipleDelete').hide();
	$('#cancel_multipleDelete').show();
	$('#multiDeleteAction').show();
	$('.multi_input_delete').show();
}

function cancel_multipleDelete(){
	$('.btn-fgs-delete').show();
	$('#multipleDelete').show();
	$('#cancel_multipleDelete').hide();
	$('#multiDeleteAction').hide();
	$('.multi_input_delete').hide();
}

$('.datepicker').pickadate({
	selectMonths: true, // Creates a dropdown to control month
	selectYears: 15, // Creates a dropdown of 15 years to control year,
	labelMonthNext: 'Siguiente mes',
	labelMonthPrev: 'Anterior mes',
	labelMonthSelect: 'Seleccionar un mes',
	labelYearSelect: 'Seleccionar un año',
	monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
	monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
	weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado' ],
	weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vier', 'Sab' ],
	weekdaysLetter: [ 'D', 'L', 'Ma', 'Mi', 'J', 'V', 'S' ],
	today: 'Hoy',
	clear: 'Limpiar',
	close: 'Seleccionar',
	closeOnSelect: false, // Close upon selecting a date,
	format: 'yyyy-mm-dd'
});
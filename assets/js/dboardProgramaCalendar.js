var single_evetns=[];
$(document).ready(function(){
	getPrograms(makeEvents).done(function(){
		for (var ii = 0; ii < 12; ii++) {
			initCalendars(ii);
		}
	});
});
var calendarios=[];

function initCalendars(number){
	var calendarEl = document.getElementById('calendar'+number);

		calendarios[number] = new FullCalendar.Calendar(calendarEl, {
		  plugins: [ 'dayGrid' ],
		  locale: 'es',
		  events: single_evetns,
		  defaultDate: new Date(2019, number, 1),
		eventColor: '#378006',
		header: {
				  // title, prev, next, prevYear, nextYear, today
				  left: 'prev',
				  center: 'title today',
				  //right: 'year month agendaWeek agendaDay next',
				  right: 'year,month,basicWeek,basicDay,next',
				  defaultView: 'month'
			  },
		dayClick: function(day) {
		   alert(day);
		},
		eventClick:function(event){
		  alert(event.event.title);
		},
		buttonText: {
				  prevYear: 'Año prev',  // <<
				  nextYear: '&>>;', // >>
				  today:    'Hoy dia',
				  month:    'Mes',
				  week:     'Semana',
				  day:      'Dia'
			  },
				// Meses
			  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', '7Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			  // Meses cortos
			  monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sept', 'Oct', 'Nov', 'Dic'],
			  // Dias
			  dayNames: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
			  // Dias cortos
			  dayNamesShort: ['L', 'Ma', 'Mi', 'J', 'V', 'S', 'D'],
			  // Selecion
			  selectable: true,
			  selectHelper: true,
        });

		calendarios[number].render();
	/*	
		

	*/
}


function getPrograms(callback){
	return $.ajax({
		type: "get",
		url: "/public/api/programas",
		data: "",
		dataType: "json",
		success: callback
	}).promise();
}


var colors=[];
function getNextColor(){
  return '#'+getNumberHexRamdom()+getNumberHexRamdom()+getNumberHexRamdom();
}
function getNumberHexRamdom(){
  hexString = Math.floor((Math.random() * 255) + 1).toString(16);
  if (hexString.length % 2) {
	hexString = '0' + hexString.toUpperCase();
  }
  return hexString;
}

function makeEvent(programa){
	return {
		title  : programa["nombre"],
		start  : programa["fecha_inicio"],
		end    : programa["fecha_final"],
		color	:getNextColor()
	  }
}

function makeEvents(response){
	single_evetns=[];
	for (var i = 0; i < response.length; i++) {
		single_evetns.push(makeEvent(response[i]));
	}
}

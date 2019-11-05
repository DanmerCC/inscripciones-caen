<div class="modal fade" tabindex="-1" role="dialog" id="mdl_entrevistas_calendar">
	<div class="modal-dialog modal-lg" style="display: block; padding-right: 17px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Entrevista</h4>
			</div>
			<div class="modal-body">
				<div class="panel-body" id="mdl_body_entrevistas_calendar">
					<div class="row">
						<div id="calendar-entrevistas">

						</div>
					</div>
					
				</div>
				<div id="mdl-id" data-idinscripcion=""></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	var single_evetns = [];
	$(document).ready(function() {
		getEntrevistas(makeEvents).done(function() {
			initCalendars()
		});
	});
	var calendarios = [];

	function initCalendars() {
		var calendarEl = document.getElementById('calendar-entrevistas');

		calendario = new FullCalendar.Calendar(calendarEl, {
			plugins: ['dayGrid'],
			locale: 'es',
			events: single_evetns,
			defaultDate: new Date(),
			eventColor: '#378006',
			header: {
				// title, prev, next, prevYear, nextYear, today
				left: 'prev',
				center: 'title today',
				//right: 'year month agendaWeek agendaDay next',
				right: 'year,month,basicWeek,basicDay,next',
				defaultView: 'month'
			},
			dateClick: function(day) {
				alert(day);
			},
			eventClick: function(event) {
				console.log(event)
				alert(event.event.title);
			},
			selectable: true,
			editable:true,
			droppable: true,
			eventDrop :function(event){
				console.log("Drop")
				console.log(event)
			},
			buttonText: {
				prevYear: 'Año prev', // <<
				nextYear: '&>>;', // >>
				today: 'Hoy dia',
				month: 'Mes',
				week: 'Semana',
				day: 'Dia'
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

		calendario.render();
		/*	
			

		*/
	}


	function getEntrevistas(callback) {
		return $.ajax({
			type: "get",
			url: "/admin/entrevistas",
			data: "",
			dataType: "json",
			success: callback
		}).promise();
	}


	var colors = [];

	function getNextColor() {
		return '#' + getNumberHexRamdom() + getNumberHexRamdom() + getNumberHexRamdom();
	}

	function getNumberHexRamdom() {
		hexString = Math.floor((Math.random() * 255) + 1).toString(16);
		if (hexString.length % 2) {
			hexString = '0' + hexString.toUpperCase();
		}
		return hexString;
	}

	function makeEvent(programa) {
		return {
			id:programa.id,
			title: programa["fecha_programado"],
			start: programa["fecha_programado"],
			end: programa["fecha_programado"],
			editable: true,
			color: getNextColor()
		}
	}

	function makeEvents(response) {
		single_evetns = [];
		for (var i = 0; i < response.length; i++) {
			single_evetns.push(makeEvent(response[i]));
		}
	}
</script>

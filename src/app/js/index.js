import { Calendar } from '@fullcalendar/core';
import interactionPlugin,{Draggable} from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import esLocale from '@fullcalendar/core/locales/es';
import { ENOBUFS } from 'constants';
var entrevistas = [];
var calendar;
document.addEventListener('DOMContentLoaded', function () {
	var calendarEl = document.getElementById('calendar');
	
	var draggableEl = document.getElementById('entrevistas-pendientes');

	$("#slct-programs-filter-calendar").change(function(){
        getEntrevistasSugeridas(function(response){
			
			let newItems="	";
			JSON.parse(response).forEach(x=>{
				newItems+=getDraggableItem(x);
			})
			draggableEl.innerHTML=newItems;
		});
	});
	
	loadDataToSelectProgram();

	getEntrevistasSugeridas(function(response){
		
		let newItems="	";
		JSON.parse(response).forEach(x=>{
			newItems+=getDraggableItem(x);
		})
		draggableEl.innerHTML=newItems;
	});
	getEntrevistas(function (response) {
		var calendarEl = document.getElementById('calendar');
		entrevistas=JSON.parse(response);
		//let draggableEl = document.getElementById('entrevistas-pendientes');
		calendar = new Calendar(calendarEl, {
			locale: esLocale,
			plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
			},
			//defaultDate: '2018-01-12',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			droppable: true,
			eventLimit: true, // allow "more" link when too many events
			eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc) {
				
				actualizaFechaEntrevista(event.event.id,formatDate(event.event.start),function(response){

				})
			},
			events: entrevistas.map(x=>{return makeEvent(x)}),
			dateClick: function(date) {
				console.log("Date un click")
				console.log(date)
				$("#virutal").attr('onclick','cargar_modal_detalles_entrevistas()')
				$("#virutal").click();
				//cargar_modal_detalles_entrevistas()
			},
			eventClick:function(infoEvent){
				console.log(infoEvent)
				if(typeof cargar_modal_detalles_entrevistas=='undefined'){
					console.log("Error al llamar a  cargar_modal_detalles_entrevistas ")
				}else{
					cargar_modal_detalles_entrevistas(infoEvent.event.id)
				}
				
			},
			eventDragStop:function(info){
				if(verifyTrashEventsObject(info.jsEvent)){
					eliminarEntrevista(info.event.id,function(response){
						response=JSON.parse(response)
						if(response.status=='OK'){
							
							info.event.remove()
							let select=document.getElementById('slct-programs-filter-calendar')
							//select.onchange();
							var event = new Event('change');
							// Dispatch it.
							select.dispatchEvent(event);
						}
					})
				}
			},
			disableResizing:false,
			eventReceive:function(info){
				console.log(info)
				createEntrevista(info.draggedEl.dataset.idinscripcion,formatDate(info.event.start),function(response){
					//info.event.id=info.draggedEl.dataset.idinscripcion;
					console.log(info.event.id)
					console.log(info.draggedEl.dataset.idinscripcion)
					response=JSON.parse(response)
					if(response.status=='OK'){
						info.draggedEl.remove()
						calendar.addEvent(makeEvent(response.data))
						
						console.log(info.event.remove())
						calendar.render()
					}else{
						alert("Error al intentar crear entrevista")
						console.log("Error al eliminar una entrevistas")
					}
				})
			},
			
			droppable: true
		});

		calendar.render();
		new Draggable(draggableEl,{
			itemSelector:'.item-interview',
			eventData: function(eventEl) {
				
				return {
				  title: eventEl.innerText,
				  duration: '01:00',
				  create:true
				};
			}
		});
	});

	
})



function getEntrevistas(done) {
	var req=new XMLHttpRequest ();
	req.open('GET','/admin/entrevistas');
	req.onload = function () {
		done(req.response);
	};
	req.onerror = function () {
		done(null, req.response);
	};
	req.send();
}

function getEntrevistasSugeridas(done) {
	console.log("select actual en :"+$("#slct-programs-filter-calendar").val());
	let url='/admin/entrevista/buildable';
	if($("#slct-programs-filter-calendar").val()!=null){
		url+='?filter_programa_id='+$("#slct-programs-filter-calendar").val()
	}
	var req=new XMLHttpRequest ();
	req.open('GET',url);
	req.onload = function () {
		done(req.response);
	};
	req.onerror = function () {
		done(null, req.response);
	};
	req.send();
}

function getNextColor(){
	return '#'+getNumberHexRamdom()+getNumberHexRamdom()+getNumberHexRamdom();
  }
  function getNumberHexRamdom(){
	var hexString = Math.floor((Math.random() * 255) + 1).toString(16);
	if (hexString.length % 2) {
	  hexString = '0' + hexString.toUpperCase();
	}
	return hexString;
  }
  
  function makeEvent(entrevista){
	  return {
		  id	:entrevista.id,	
		  title  : entrevista["nombres"]+' '+entrevista["apellido_paterno"],
		  start  : entrevista["fecha_programado"],
		  end    : entrevista["fecha_programado"],
		  color: entrevista["color_estado"]
		}
  }
  
  function makeEvents(response){
	  single_evetns=[];
	  for (var i = 0; i < response.length; i++) {
		  single_evetns.push(makeEvent(response[i]));
	  }
  }

  function actualizaFechaEntrevista(idEntrevista,fecha_programado,done){
	var req=new XMLHttpRequest ();
	req.open('POST','/admin/entrevista/change/date');
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	req.onload = function () {
		done(req.response);
	};
	req.onerror = function () {
		done(null, req.response);
	};
	console.log(prepareData({ "id_entrevista": idEntrevista,"fecha_programado":fecha_programado }))
	req.send(prepareData({ "id_entrevista": idEntrevista, "fecha_programado": fecha_programado }));
  }

  function createEntrevista(idinscripcion,fecha_programado,done){
	var req=new XMLHttpRequest ();
	req.open('POST','/admin/entrevista/create');
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	req.onload = function () {
		done(req.response);
	};
	req.onerror = function () {
		done(null, req.response);
	};
	req.send(prepareData({ "id_inscripcion": idinscripcion, "fecha_programado": fecha_programado }));
  }

  function actualizaFechaEntrevista2(idEntrevista,offSetdays,done){
	fetch('/admin/entrevista/change/date',
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json; charset=utf-8'
          },
          body: JSON.stringify({ "id_entrevista": idEntrevista, "offsetDays": offSetdays })
        }).then(done)
  }


	function eliminarEntrevista(idinscripcion,done){
		var req=new XMLHttpRequest ();
		req.open('POST','/admin/entrevista/delete');
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		req.onload = function () {
			done(req.response);
		};
		req.onerror = function () {
			done(null, req.response);
		};
		req.send(prepareData({ "id_inscripcion": idinscripcion}));
	}

  function objectToQuerystring (obj) {
	return Object.keys(obj).reduce(function (str, key, i) {
	  var delimiter, val;
	  delimiter = (i === 0) ? '' : '&';
	  key = encodeURIComponent(key);
	  val = encodeURIComponent(obj[key]);
	  return [str, delimiter, key, '=', val].join('');
	}, '');
  }

  function prepareData(data){
	return typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	).join('&');
  }

  function getDraggableItem(data){
	  return `
	  	<li class="item-interview item " data-event='${buildableToDataEvent(data)}' data-idinscripcion='${data.id_inscripcion}'>
			<div class="" '>
				<div class="product-img">
					<img src="/dist/img/avatar5.png" alt="${data.nombre_tipo_curso}">
				</div>
				<div class="product-info">
					<a href="javascript:void(0)" class="product-title">${data.nombre_curso}
						<span class="label label-warning pull-right"></span></a>
					<span class="product-description">
						${data.nombres}
					</span>
				</div>
			</div>
		</li>
	  `;
  }

  function buildableToDataEvent(buildable){
	  	let template={ "title": "", "duration": "02:00" ,"inscripcion_id":buildable.id_inscripcion};
		template.title=buildable.nombres+' '+buildable.apellido_paterno+' '+buildable.apellido_materno;
		template.inscripcion_id=buildable.inscripcion_id;
		return JSON.stringify(template);
  }

  function loadDataToSelectProgram(){
    $.ajax({
        type: "get",
        url: "/api/programas/allInscripciones",
        data: "",
        dataType: "json",
        success: function (response) {
			let contentString='';
            response.forEach(program=>{contentString+=programaToLi(program)})
			$("#slct-programs-filter-calendar").html(contentString)
        }
    });
}

function programaToLi(program){
	return `<option value='${program.id_curso}'>${program.numeracion} ${program.tipoNombre} ${program.nombre}</option>`
}

function onChangeProgram(){
	
}

function formatDate(date){
	let dateString=toStringZeroFormat(date.getDate());
	let monthString=toStringZeroFormat(date.getMonth()+1);
	let dformat = [date.getFullYear(),
		monthString,
		dateString].join('-')+' '+
	   [toStringZeroFormat(date.getHours()),
		toStringZeroFormat(date.getMinutes()),
		toStringZeroFormat(date.getSeconds())].join(':');
	return dformat;
}


function toStringZeroFormat(integer){
	return integer<10?'0'+integer:integer;
}

function reloadDataCalendar(success){
	getEntrevistas(function(response){
		entrevistas=JSON.parse(response);
		
		success(entrevistas)
		//calendar.fullCalendar('updateEvents',entrevistas.map(x=>{return makeEvent(x)}) )
	})
}

function verifyTrashEventsObject(jsEvent){
	var trashElement=document.getElementById('box-entrevistas-pendientes')
	var trashEl = jQuery('#box-entrevistas-pendientes');
    var ofs = trashEl.offset();

    var x1 = ofs.left;
    var x2 = ofs.left + trashEl.outerWidth(true);
    var y1 = ofs.top;
    var y2 = ofs.top + trashEl.outerHeight(true);

    if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
        jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
		console.log("Si esta dentro oie si")
		return true;
	}
	return false;
}

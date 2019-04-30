<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="/dist/css/jquery-externs/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" />

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


<?=$mainHeader;?>
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
<?=$mainSidebar;?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3 class>
      Reportes
      </h3>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <br>
    
    <!-- Main content -->
    <section class="content">
    <div class="row">


    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <h4>Participantes</h4>
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3> <?=$canEst ?> </h3>

                <p>Solicitan informacion</p>
            </div>
            
            <div class="icon">
                <i class="ion ion-ios-people"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <h4>Doctorados</h4>
        <div class="small-box bg-green">
            <div class="inner">
            
                <h3><?=$cantDoc ?> </h3>

                <p>Interesados</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <h4>Maestrias</h4>
        <div class="small-box bg-yellow">
            <div class="inner">
            <h3><?=$cantMae ?> </h3>

                <p>Interesados</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <h4>Diplamados</h4>
        <div class="small-box bg-red">
            <div class="inner">
            <h3><?=$cantDiplo ?> </h3>

                <p>Interesados</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-lg-12 col-xs-12">
        <select name="model-chart" id="model-chart">
            <option value="alumno">Alumnos</option>
        </select>
        <select name="datasets-chart" id="datasets-chart"></select>
        <div id="checks">
        </div>
        <button class="btn" onclick="constructChart();">Contruir</button>
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!--<script src="/assets/charts.js"></script>-->



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy;<a href="/">CAEN EPG</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

  <div id="contentModals">

  </div>
</div>


<!-- ./wrapper -->
<?php $this->load->view('adminlte/scriptsFooter');?>

<!-- <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->

<script src="/dist/js/jquery-externs/jquery.dataTables.min.js"></script>
<script src="/dist/js/jquery-externs/bootbox.min.js"></script>
<script src="/dist/js/jquery-externs/dataTables.buttons.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.flash.min.js"></script>
<script src="/dist/js/jquery-externs/jszip.min.js"></script>
<script src="/dist/js/jquery-externs/pdfmake.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.html5.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script>

$(document).ready(function(){
    $("#model-chart").change(function(){
        getColumns($(this).children("option:selected").val(),makeOptionByResponse)
    });
    $("#datasets-chart").change(function (){
        getGroupData($(this).val());
        //getGroupData($("#situacion_militar option:selected").val(),$("#model-chart option:selected").val());
    });
	$("#model-chart").trigger("change");
});
function constructChart(){
    getGroupData($("#datasets-chart option:selected").val(),$("#model-chart option:selected").val());
}
function getGroupData(column,model){
    $.ajax({
        type: "post",
        url: "/chart/alumno/metadata",
        data: {
            "model":model,
            "column":column
        },
        dataType: "json",
        success: function (response) {
            //console.log(response);
            myChart.data.labels=response;
            myChart.update();
        }
    });
    getDataSet(column,model);
}

function getDataSet(column,model){
    $.ajax({
        type: "post",
        url: "/chart/alumno/count",
        data: {
            "model":model,
            "column":column
        },
        dataType: "json",
        success: function (response) {
            //console.log(response);
            //renderChart(response);
            
            var dataset=[];
            response.forEach(obj=>{
                dataset.push(obj.conteo);
            });
            renderChart({data:dataset});
        }
    });
}

function renderChart(dataset){
    myChart.data.datasets=[];
    myChart.data.datasets.push(dataset);
    myChart.update();
}
function getColumns(){
	$.ajax({
		type: "post",
		url: "/chart/alumno",
		data: {
			"model":"alumno"
		},
		dataType: "json",
		success: function (response) {
            $("#datasets-chart").html("");
            response.forEach(element =>{
                $("#datasets-chart").append(makeOption(element,element));
            });
		}
	});
}

function makeOption(text,value){
    return "<option value='"+value+"'>"+text+"</option>"
}

function getDataset(array_column,callback){
    $.ajax({
        type: "post",
        url: "/chart/alumnos/data",
        data: $("#checks input[type=checkbox]:checked").map(
            function(){
                        return $(this).val();
                    }
            ),
        dataType: "json",
        success: function (response) {
            console.log(response);
        }
    });
}

function makeOptionByResponse(response){
    var i=0;
    var content="";
    response.forEach(element => {
        content+=makeCheck(i+"check",element,element);
        i++;
    });

    $("#checks").append("<div class='container'>"+content+"</div>");
}

function makeCheck(id,name,value){
    return '<input type="checkbox" id="'+id+'" value="'+value+'"><label for="'+id+'">'+value+'</label>';
}
/*
function getColumns(model,callback){
    $.ajax({
        type: "post",
        url: "/chart/"+model,
        data: "",
        dataType: "json",
        success: callback
    });
}
*/
function addOptions(select,opciones){
    select.html("");
    opciones.forEach(element => {
        select.append("<option value="+element.value+">"+element.nombre+"</option>");
    });
}

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
/*var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)', 
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});*/
</script>
</body>
</html>

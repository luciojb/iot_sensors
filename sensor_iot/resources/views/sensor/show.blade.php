@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center mb-4">
		<div class="text-center col-md-6">
			<a href="{{route('home')}}" class="btn btn-secondary col-md-2 m-2">{{__('Back')}}</a>
			<button id="cmd" class="btn btn-primary col-md-4 m-2">{{__('Print Report')}}</button>
		</div>
	</div>
	<div id="pdf">
		<div class="row justify-content-center mb-4">
			<h5 class="font-weight-bold">{{__('Reports about the selected Sensor:')}}</h5>
		</div>
	    <div class="row justify-content-center mb-4">
			<div class="col-md-2">
				<b>{{__('Name')}}:</b> {{$sensor->getName()}}
			</div>
			<div class="col-md-2">
				<b>{{__('Humidity')}}:</b> {{$sensor->getLatestData()->getHumidity()}}
			</div>
			<div class="col-md-2">
				<b>{{__('Temperature')}}:</b> {{$sensor->getLatestData()->getTemperature()}}
			</div>
			<div class="col-md-4">
				<b>{{__('Latest data at')}}:</b> {{$sensor->getLatestData()->getReadedAt()->format('d M Y - H:i:s')}}
			</div>
	    </div>

		<div class="justify-content-center">
	        <div id="curve_chart"></div>
	    </div>

	</div>
	<div id="editor"></div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['line']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
	  let data = {!! json_encode($data, JSON_NUMERIC_CHECK) !!};
	  console.log(data);

	  // googleData.sort();
    var gData = new google.visualization.DataTable();
	gData.addColumn('date', 'Data'); // Implicit domain label col.
	gData.addColumn('number', 'Temperatura (ºC)'); // Implicit series 1 data col.
	gData.addColumn('number', 'Umidade (%)'); // Implicit series 1 data col.
	let rows = [];
	for(let i=0; i < data['categories'].length; i++) {
		rows.push([new Date(data['categories'][i]), data['temperatures'][i], data['humidities'][i]]);
	}

	gData.addRows(
	  rows
	);

    var options = {
		title: 'IoT: Últimas Leituras',
		curveType: 'function',
		legend: { position: 'bottom' },
		width: 900,
		height: 600,
		hAxis: {
			format: 'd/M/yyyy H:mm',
		},
    };

	var chart = new google.charts.Line(document.getElementById('curve_chart'));

	chart.draw(gData, google.charts.Line.convertOptions(options));
}
</script>
<script>

	var doc = new jsPDF();

	var specialElementHandlers = {
		'#editor': function (element, renderer) {
			return true;
		}
	};

	$('#cmd').click(function () {
		console.log('test')
		doc.fromHTML($('#content').html(), 15, 15, {
			'width': 170,
				'elementHandlers': specialElementHandlers
		});
		doc.save('sample-file.pdf');
	});

</script>
@endsection

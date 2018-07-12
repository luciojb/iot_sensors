@extends('generic.genericSensorView')

@section('headerButtons')
	<div class="row justify-content-center mb-4">
		<div class="text-center col-md-6">
			<a href="{{route('home')}}" class="btn btn-secondary col-md-2 m-2">{{__('Back')}}</a>
			<a href="#" id="cmd" class="btn btn-primary col-md-4 m-2">{{__('Print Report')}}</a>
		</div>
	</div>
@endsection
@section('extrascripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script>
var doc = new jsPDF();
$(document).ready(function(){
	$('#cmd').click(function(){
		var printContents = document.getElementById("pdf").innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
		location.reload();
	})
})

</script>
@endsection

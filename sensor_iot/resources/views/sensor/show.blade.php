@extends('generic.genericSensorView')

@section('headerButtons')
	<div class="row justify-content-center mb-4">
		<div class="text-center col-md-6">
			<a href="{{route('home')}}" class="btn btn-secondary col-md-2 m-2">{{__('Back')}}</a>
			<a href="{{route('sensor.pdf', $sensor->getId())}}" class="btn btn-primary col-md-4 m-2">{{__('Print Report')}}</a>
		</div>
	</div>
@endsection

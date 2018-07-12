@extends('layouts.app')

@section('content')
<div class="container">
	@if (session()->has('error'))
		<span class="alert alert-danger m-4">
			<strong>{{ session('error') }}</strong>
		</span>
	@endif
	@if (session()->has('msg'))
		<span class="alert alert-success m-4">
			<strong>{{ session('msg') }}</strong>
		</span>
	@endif
	<div class="row justify-content-center">
		<a href="{{ route('sensors.create') }}" class="btn btn-primary col-md-2 mb-4">Add Sensor</a>
	</div>
    <div class="row justify-content-center">
		@foreach($sensors as $s)
			<div class="card col-md-4 m-2">
				<div class="card-header text-center">
					<h4 class="font-weight-bold">{{$s->getName()}}</h4>
				</div>
				<div class="card-body text-center">
					<p class="card-text">Info about the latest registers of the Sensor Activity</p>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item text-center">
						<span class="text-right d-inline-block font-weight-bold">Temperature: </span>
						<span class="text-left d-inline-block">{{$s->getLatestData()->getTemperature()}}</span>
					</li>
					<li class="list-group-item text-center">
						<span class="d-inline-block text-right font-weight-bold">Humidity: </span>
						<span class="d-inline-block text-left">{{$s->getLatestData()->getHumidity()}}</span>
					</li>
					<li class="list-group-item text-center">
						<span class="d-inline-block text-right font-weight-bold">Date: </span>
						<span class="d-inline-block text-left">{{$s->getLatestData()->getReadedAt()->format('d M Y - H:i:s')}}</span>
					</li>
				</ul>
				<div class="card-body text-center">
					<a href="{{route('sensor.show', $s->getId())}}" class="btn btn-info btn-md">View Data</a>
					<a href="{{route('sensor.remove', $s->getId())}}" class="btn btn-danger btn-md">Remove</a>
				</div>
			</div>
		@endforeach
		@if (empty($sensors))
			<h3>There are no sensors registered. Start by adding a known sensor</h3>
		@endif
    </div>


</div>
@endsection

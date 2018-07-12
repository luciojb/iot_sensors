@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="col-md-10">
		<div class="m-4 row justify-content-center">
			<h3>Are you sure you want to remove the
				<b><span id="title">{{$name}}</span></b> Sensor?
			</h3>
		</div>
		<div class="m-4 row justify-content-center">
			<form action="{{action('SensorController@destroy', $id)}}" method="post" >
				@csrf
				<input name="_method" type="hidden" value="DELETE">
				<a href="{{url()->previous()}}" class="btn btn-secondary btn-md">Cancel</a>
				<button class="btn btn-danger btn-md" type="submit">Remove</button>
			</form>
		<div>
    </div>
</div>
@endsection

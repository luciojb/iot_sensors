@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('AddSensor') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('sensors') }}" aria-label="{{ __('AddSensor') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
								<br />
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
								@if ($errors->has('createError'))
									<span class="alert alert-danger">
										<strong>{{ $errors->first('createError') }}</strong>
									</span>
								@endif
                            </div>
                        </div>
						@if (session()->has('msg'))
							<span class="alert alert-success mt-4">
								<strong>{{ session('msg') }}</strong>
							</span>
						@endif
                        <div class="form-group row m-0 justify-content-center">
                            <button type="submit" class="btn btn-primary col-md-2 m-2">
                                {{ __('Add') }}
                            </button>
                            <a href="{{route('home')}}" class="btn btn-secondary col-md-2 m-2">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

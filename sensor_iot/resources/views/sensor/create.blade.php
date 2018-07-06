@extends('layouts.app')

@section('content')
<div class="container">
	@if (session()->has('msg'))
		<span class="alert alert-success">
			<strong>{{ session()->first('msg') }}</strong>
		</span>
	@endif
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

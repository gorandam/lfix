@extends('master')

@section('content')

<div id="page-wrapper">
	<div class="container-fluid fullPage">
		<div class="row">
		    <div class="col-md-4 col-md-offset-1 editUser">
		        {{ Form::open(array('url' => 'user/' . $id, 'method' => 'put')) }}
		        <div class="form-group">
		            {{Form::label('name','Name')}}
		            {{Form::text('name', $name, array('class' => 'form-control'))}}
		        </div>
		        <div class="form-group">
		            {{Form::label('email','Email')}}
		            {{Form::text('email', $email, array('class' => 'form-control'))}}
		        </div>
		        <div class="form-group">
		            {{Form::label('password','Password')}}
		            {{Form::password('password', array('class' => 'form-control'))}}
		        </div>
		        <div class="form-group">
		            {{Form::label('group','Level')}}
		            {{Form::select('group', $groups, $group, array('class' => 'form-control'))}}
		        </div>
		        <div class="form-group">
			        <button type="submit" class="btn btn-primary">Update User</button>
			        <a href="{{ URL::to('profiles') }}" type="button" class="btn btn-info">Back To Users List</a>
		        </div>
		    </div>
		</div>
	</div>
</div>	

@stop
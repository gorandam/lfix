@extends('master')

@section('content')

<div id="page-wrapper">
	<div class="container-fluid fullPage">
		<div class="row">
		    <div class="col-md-6 col-md-offset-1 editJob">
		        {{ Form::open(array('url' => 'jobs/' . $job->id, 'method' => 'put')) }}
			        <div class="form-group">
			            {{Form::label('title','Title')}}
			            {{Form::text('title', $job->title, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('description','Description')}}
			            {{Form::textarea('description', $job->description, array('class' => 'form-control', 'rows' => '4'))}}
			        </div>
			         <div class="form-group">
			            {{Form::label('category','Category')}}
			            {{Form::select('category', $additionalData["categories"], $job->category, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('assigned_to','Assign To')}}
			            {{Form::select('assigned_to', $additionalData["technicians"], $job->technician, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('location','Location')}}
			            {{Form::select('location', $additionalData["locations"], $job->location, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('start','Start Address')}}
			            {{Form::text('start', $job->start, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('address','Customer\'s Address')}}
			            {{Form::text('address', $job->address, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('priority','Priority')}}
			            {{Form::select('priority', $additionalData["priorities"], $job->priority, array('class' => 'form-control'))}}
			        </div>
		        <div class="form-group">
			        <button type="submit" class="btn btn-primary">Update Job</button>
			        <a href="{{ URL::to('jobs') }}" type="button" class="btn btn-info">Back To Jobs List</a>
		        </div>
		    </div>
		</div>
	</div>
</div>	

@stop
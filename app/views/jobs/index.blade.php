@extends('master')

@section('content')
<div id="page-wrapper">

    <div class="container-fluid fullPage">

    	<h2>List of Jobs</h2>
    	@if(!$jobs->isEmpty())
    	<div class="table-responsive jobsTable">
			<table class="table table-hover">
				<tr>
				  	<th>ID</th>
				  	<th>Title</th>
				  	<th>Category</th>
				  	<th>Assigned To</th>
				  	<th>Location</th>
				  	<th>Priority</th>
				  	<th>Status</th>
				  	<th>Details</th>
				  	<th>Created At</th>
				  	@if(!Auth::user()->isTechnician())
				  	<th>Edit</th>
				  	<th>Delete</th>
				  	@endif
				</tr>
			  
			  @foreach($jobs as $job)
			  <tr 
			  @if((date('Y-m-d h:i:s', strtotime("- 10 days")) > $job->created_at))
			  class="danger"
			  @elseif((date('Y-m-d h:i:s', strtotime("- 5 days")) > $job->created_at))
			  class="warning"
			  @else
			  class="active"
			  @endif
			  >
			  	<td>{{$job->id}}</td>
			  	<td>{{$job->title}}</td>
			  	<td>{{$job->category}}</td>
			  	<td>{{User::find($job->assigned_to)->name}}</td>
			  	<td>{{$job->location}}</td>
			  	<td>{{$job->priority}}</td>
			  	<td>
			  		<div class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ucfirst($job->status)}} <span class="caret"></span></a>
			          <ul class="dropdown-menu" role="menu">
			            <li><a href="{{ URL::to('jobs/' . $job->id . '/open') }}">Open</a></li>
			            <li><a href="{{ URL::to('jobs/' . $job->id . '/notpaid') }}">Not paid</a></li>
			            <li><a href="{{ URL::to('jobs/' . $job->id . '/archive') }}">Done/Archive</a></li>
			          </ul>
			        </div>
			  	</td>
			  	<td><a href="{{URL::to('jobs/' . $job->id)}}"><i class="glyphicon glyphicon-list-alt"></i></a></td>
			  	<td>{{ $job->created_at }}</td>
			  	@if(!Auth::user()->isTechnician())
			  	<td><a class="uManage" href="{{ URL::to('jobs/' . $job->id . '/edit') }}"><i class="glyphicon glyphicon-edit manageJobs"></i></a></td>
			  	<td><a class="uManage" data-toggle="modal" data-target="#deleteModal-{{$job->id}}"><i class="glyphicon glyphicon-remove manageJobs"></i></a></td>
			  	@endif
			  </tr>
			  @endforeach
			</table>
    	</div>
    	@else
    	<p>No jobs to display.</p>
    	@endif
    	@if( !Auth::user()->isTechnician() )
    	<button type="button" class="btn btn-info btn-large jobsButton" data-toggle="modal" data-target="#addJob"><i class="glyphicon glyphicon-plus"></i> Add New job</button>
    	<a href="{{ URL::to('view-archive') }}" class="btn btn-default btn-large archiveButton"> Archived Jobs </a>
    	@endif
    	
	</div>

</div>	

<!-- New Job Modal -->
	<div class="modal fade" id="addJob" tabindex="-1" role="dialog" aria-labelledby="addJobLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="addJobLabel">Add New Job</h4>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-md-8 col-md-offset-2">
			        {{ Form::open(array('route' => array('jobs.store'), 'method' => 'post')) }}
			        <div class="form-group">
			            {{Form::label('title','Title')}}
			            {{Form::text('title', null,array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('description','Description')}}
			            {{Form::textarea('description', null,array('class' => 'form-control', 'rows' => '5'))}}
			        </div>
			         <div class="form-group">
			            {{Form::label('category','Category')}}
			            {{Form::select('category', $categories, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('assigned_to','Assign To')}}
			            {{Form::select('assigned_to', $technicians, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('location','Location')}}
			            {{Form::select('location', $locations, array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('start','Start Address')}}
			            {{Form::text('start', null,array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('address','Customer\'s Address')}}
			            {{Form::text('address', null,array('class' => 'form-control'))}}
			        </div>
			        <div class="form-group">
			            {{Form::label('priority','Priority')}}
			            {{Form::select('priority', $priorities, array('class' => 'form-control'))}}
			        </div>
			        
			    </div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save Job</button>
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>  
	<!-- /New Job Modal	 -->

	@foreach($jobs as $job)
	<!-- Delete Job Modal -->
	<div class="modal fade" id="deleteModal-{{$job->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-{{$job->id}}Label" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="deleteModal-{{$job->id}}Label">Delete Job {{$job->title}}</h4>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-md-6">
		        	<strong>Are you sure you want to delete this job?</strong>
		        	<p>Confirm by clicking Delete Job button.</p>
			        {{ Form::open(array('url' => 'jobs/' . $job->id, 'method' => 'delete')) }}
			    </div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-danger">Delete Job</button>
	        {{ Form::close() }}
	      </div>
	    </div>
	  </div>
	</div>  
	<!-- /Delete Job Modal	 -->
	@endforeach
@stop
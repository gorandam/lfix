@extends('master')

@section('content')
<div id="page-wrapper">

    <div class="container-fluid fullPage">

    	<h2>{{ ucfirst($logs[0]->context) }} Log</h2>
    	@if(!$logs->isEmpty())
    	<div class="table-responsive jobsTable">
			<table class="table table-hover">
				<tr>
				  	<th>Type</th>
				  	<th>Message</th>
				  	<th>Timestamp</th>
				</tr>
			  
			  @foreach($logs as $log)
			  <tr>
			  	<td>{{$log->level}}</td>
			  	<td>{{$log->message}}</td>
			  	<td>{{$log->created_at}}</td>
			  </tr>
			  @endforeach
			</table>
    	</div>
    	@else
    	<p>No logs to display.</p>
    	@endif
    	{{$links}}
	</div>

</div>	

@stop
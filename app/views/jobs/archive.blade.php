
<html>
<head>
	<title>Qfix | Jobs Archive</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
	<div id="page-wrapper">

	    <div class="container-fluid">
	    	<a style="margin: 10px;" class="btn btn-small btn-primary" href="{{ URL::to('jobs') }}">Back to Dashboard</a>
	    	<div class="table-responsive jobsTable">
			<table class="table table-hover">
				<tr>
				  	<th>ID</th>
				  	<th>Title</th>
				  	<th>Category</th>
				  	<th>Assigned To</th>
				  	<th>Location</th>
				  	<th>Priority</th>
				  	<th>Details</th>
				</tr>
			  
			  @foreach($jobs as $job)
			  <tr> 
			  	<td>{{$job->id}}</td>
			  	<td>{{$job->title}}</td>
			  	<td>{{$job->category}}</td>
			  	<td>{{User::find($job->assigned_to)->name}}</td>
			  	<td>{{$job->location}}</td>
			  	<td>{{$job->priority}}</td>
			  	<td>{{$job->description}}</i></a></td>
			  </tr>
			  @endforeach
			</table>
    	</div>
			
		</div>	  	
</body>
</html>



<html>
<head>
	<title>Qfix | {{ $job->title }}</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<style>
	    #iframeBody {
	        position: relative;
	        padding-bottom: 50%; // This is the aspect ratio
	        height: 0;
	        overflow: hidden;
	    }
	    #iframeBody iframe {
	        position: absolute;
	        top: 0;
	        left: 0;
	        width: 100% !important;
	        height: 100% !important;
	    }
	</style>
</head>
<body>
	<div id="page-wrapper">

	    <div class="container-fluid jobDetails">
	    	<a class="btn btn-small btn-warning" id="hideShow">Hide details</a>
	    	<a class="btn btn-small btn-primary" href="{{ URL::to('jobs') }}">Back to Dashboard</a>
	    	<a class="btn btn-small btn-success" data-target="#notes" data-toggle="modal">Notes</a>
			<div id="iframeHead"> 

				<h3>{{ $job->title }}</h3>

				<p><strong>Description:</strong> {{ $job->description }}</p>
				<p>
					<span><strong>Assigned To:</strong> {{ User::find($job->assigned_to)->name }} | </span>
					<span><strong>Location:</strong> {{ $job->location }} | </span>
					<span><strong>Start:</strong> {{ $job->start }} | </span>
					<span><strong>Address:</strong> {{ $job->address }} | </span>
					<span><strong>Category:</strong> {{ $job->category }} | </span>
					<span><strong>Priority:</strong> {{ $job->priority }}</span>
				</p>

			</div>
			<div id="iframeBody">
			    <iframe name="mapFrame" id="mapFrame"		
				  width="600"
				  height="450"
				  frameborder="0" style="border:0"
				  src="https://www.google.com/maps/embed/v1/directions?origin={{$job->start}},+{{$job->location}},+Canada&destination={{$job->address}},+{{$job->location}},+Canada&key=AIzaSyDpDBs668w-2HORB25aaEu-tSydv4wdeJQ">
				</iframe>
		  	</div>
		</div>
	</div>
	<!-- Notes Modal -->
	<div class="modal fade" id="notes" tabindex="-1" role="dialog" aria-labelledby="notesabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="addJobLabel">Notes</h4>
	      </div>
	      <div class="modal-body">
	      	@if(!empty($notes))
	      	<div class="row">
	      		<ul>
			      	@foreach($notes as $note) 
			      	<li><span class="label label-primary">{{User::find($note->user_id)->name}}:</span> 
			      		<span>{{ $note->note }}</span>
			      	</li>
			      	@endforeach
	      		</ul>
	      	</div>
	      	@endif
	        <div class="row">
			    <div class="col-md-12">
			        {{ Form::open(array('url' => 'jobs/note', 'method' => 'POST')) }}
			       
			        <div class="form-group">
			            {{ Form::label('note','Add new Note') }}
			            {{ Form::textarea('note', null, array('class' => 'form-control', 'rows' => '2')) }}
			            {{ Form::hidden('job', $job->id) }}
			        </div>
			         
			        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Note</button>

			        {{ Form::close() }}
			    </div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>  

	<div class="container-fluid">
		{{ var_dump($jsonData) }}
	</div>
	<!-- / Notes Modal	 -->
	<script type="text/javascript">

		$(document).ready(function() {

			$('a#hideShow').click(function() {

				if($('div#iframeHead').is(":visible")) {

					$('div#iframeHead').slideUp();
					$(this).text('Show details');

				} else {

					$('div#iframeHead').slideDown();
					$(this).text('Hide details');

				}

			});

		});

	</script>	  	
</body>
</html>


<!DOCTYPE html>
<html>
	<head>
		<title>Qfix | Dashboard</title>
		{{ HTML::style('css/bootstrap/bootstrap.min.css') }}
		{{ HTML::style('css/dashboard.css') }}
		{{ HTML::style('css/profiles.css') }}
		{{ HTML::style('css/font-awesome-4.1.0/css/font-awesome.min.css') }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') }}
		{{ HTML::script('js/bootstrap/bootstrap.min.js') }}
		{{ HTML::script('js/navbar.js') }}
		{{ HTML::script('js/dashboard.js') }}
	</head>
	<body>
		<div id="wrapper">
			<!-- Top navigation bar -->
			<nav class="navbar navbar-inverse navbar-fixed-top topBarNav" role="navigation">
			  	<div class="container-fluid topBarContainer">
			    	<!-- Brand and toggle get grouped for better mobile display -->
			    	<div class="navbar-header">
			      		<a class="navbar-brand" href="{{URL::to('/')}}">Qfix Tech Manager</a>
			    	</div>

			    	<!-- Collect the nav links, forms, and other content for toggling -->
					<ul class="nav navbar-nav">
			      		<li class="active navbar-link" id="appliances"><a href="{{URL::to('jobs/byCategory/appliances')}}">Appliances</a></li>
			      		<li class="navbar-link" id="ducts"><a href="{{URL::to('jobs/byCategory/ducts')}}">Ducts</a></li>
			      		<li class="navbar-link" id="interlock"><a href="{{URL::to('jobs/byCategory/interlock')}}">Interlock</a></li>
			    	</ul> 
			    	<ul class="nav navbar-nav navbar-right">
			    		<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="#">Info</a></li>
				            <li><a href="#">Tutorial</a></li>
				            <li><a href="#">Settings</a></li>
				            <li class="divider"></li>
				            <li><a href="{{ URL::to('logout') }}">Logout</a></li>
				          </ul>
				        </li>
				        @if(Auth::user()->isSuperAdmin())
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logs <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="{{ URL::to('logs/login') }}">Logins</a></li>
				            <li><a href="{{ URL::to('logs/logout') }}">Logouts</a></li>
				            <li><a href="{{ URL::to('logs/users') }}">Users</a></li>
				            <li><a href="{{ URL::to('logs/jobs') }}">Jobs</a></li>
				          </ul>
				        </li>
				        <li class="dropdown">
				          <a href="{{ URL::to('profiles') }}" class="dropdown-toggle">Manage Users</a>
				        </li>
				        @endif
				        <li class="dropdown">
				          <a href="{{ URL::to('jobs') }}" class="dropdown-toggle">Jobs</a>
				        </li>
				        <li class="dropdown">
				          <a href="{{ URL::to('messages') }}" class="dropdown-toggle">Chat</a>
				        </li>
				    </ul>
			  	</div><!-- /.container-fluid -->
			  	<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	            <div class="collapse navbar-collapse navbar-ex1-collapse" style="display:none;">
			        <ul class="nav navbar-nav side-nav" style="display:none;">
			            <li>
		            		<div class="dropdown companyTechs">
							  <button class="btn btn-info cityDropDown" type="button" id="toronto" data-toggle="dropdown" aria-expanded="true">
							    Toronto
							    <span class="caret"></span>
							  </button>
							</div>
			            </li>

			            <li class="techs">
			            	<div class="torontoTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 1
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="torontoTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 2
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="torontoTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 3
			            	</div>	
			            </li>
			           
			            <li>
		            		<div class="dropdown companyTechs">
							  <button class="btn btn-info cityDropDown" type="button" id="calgary" data-toggle="dropdown" aria-expanded="true">
							    Calgary
							    <span class="caret"></span>
							  </button>
							</div>
			            </li>

			            <li class="techs">
			            	<div class="calgaryTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 1
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="calgaryTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 2
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="calgaryTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 3
			            	</div>	
			            </li>
			            
			            <li>
		            		<div class="dropdown companyTechs">
							  <button class="btn btn-info cityDropDown" type="button" id="vancouver" data-toggle="dropdown" aria-expanded="true">
							    Vancouver
							    <span class="caret"></span>
							  </button>
							</div>
			            </li>

			            <li class="techs">
			            	<div class="vancouverTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 1
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="vancouverTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 2
			            	</div>	
			            </li>
			            <li class="techs">
			            	<div class="vancouverTechs companyTechs">
					            <i class="fa fa-user"></i> Techician 3
			            	</div>	
			            </li>
			           
			        </ul>
	            </div>
	            <!-- /.navbar-collapse -->
			</nav>  	
			<!-- /Left Sidebar -->
			<div class="container-fluid">
		        <div class="row">
		            <div class="col-md-4 col-md-offset-4">
		                @if(Session::has('message'))
		                <div class="alert-box success">
		                    <h2>{{ Session::get('message') }}</h2>
		                </div>
		                @endif
		            </div>
		        </div>
		    </div>
		    @foreach ($errors->all() as $message)
		        <div class="row">
		          <div class="col-md-4 col-md-offset-4">
		            {{$message}}
		          </div>
		        </div>  
		    @endforeach
			<!-- Central container -->
			@yield('content')
			<!-- /Central container -->
		</div>

		<!-- Reminder Button -->
		<div class="setReminder">
			<button data-toggle="modal" data-target="#setReminder" class="btn btn-large btn-warning">Set Reminder</button>
		</div>
		<!-- / Reminder Button -->

		<!-- Reminder Modal -->
		<div class="modal fade" id="setReminder" tabindex="-1" role="dialog" aria-labelledby="setReminderLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="setReminderLabel">Set A Reminder For Your Colleague</h4>
		      </div>
		      <div class="modal-body">
		        <div class="row">
				    <div class="col-md-12">
				        {{ Form::open(array('url' => 'setReminder', 'method' => 'POST')) }}
				        <div class="form-group">
				            {{Form::label('to_user','Reminder For:')}}
				            {{Form::select('to_user', $usersForReminder, array('class' => 'form-control'))}}
				        </div>
				        <div class="form-group">
				            {{Form::label('reminder','Reminder Text')}}
				            {{Form::textarea('reminder', null, array('class' => 'form-control col-md-12', 'placeholder' => 'Write a reminder here', 'rows' => '5'))}}
				        </div>
				    </div>
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-warning">Set Reminder</button>
		        {{ Form::close() }}
		      </div>
		    </div>
		  </div>
		</div>  
		<!-- / Reminder Modal -->

		<!-- Reminders Info Modal -->
		<div class="modal fade" id="remindersInfo" tabindex="-1" role="dialog" aria-labelledby="remindersInfoLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="remindersInfoLabel" style="color: red;">Reminders For You</h4>
		      </div>
		      <div class="modal-body">
		        <div class="row">
				    <div class="col-md-12">
			        	@if(!$remindersInfo->isEmpty())
			        		@foreach($remindersInfo as $reminder)
			        		<div id="containerReminder-{{$reminder->id}}">
				        		<p>Reminder from <strong>{{User::find($reminder->by_user)->name}}</strong></p>
				        		<p><strong>{{ $reminder->created_at }}</strong></p>
								<p>{{$reminder->reminder}}</p>
								<button id="reminder-{{ $reminder->id }}" class="btn btn-danger btn-small">Dismiss</button>
								<hr>
			        		</div>
			        		@endforeach
			        	@endif
				    </div>
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>  
		<!-- / Reminders Info Modal -->

		<!-- Body Script -->
		@yield('bodyScript')
		<!-- /Body Script -->
		<script type="text/javascript">
			@if($remindersInfo->isEmpty())
			var remindersExist = false;
			@else
			var remindersExist = true;
			@endif
			$(document).ready(function() {
				@foreach($remindersInfo as $reminder)
				$('button#reminder-{{$reminder->id}}').click(function() {
					$(this).text('Dismissing...');
					$(this).attr('disabled', true);
					$.ajax({
						url: "{{URL::to('reminder/' . $reminder->id)}}",
						method: "GET",
						dataType: 'json'
					}).done(function(data) {
						$('div#containerReminder-{{$reminder->id}}').slideUp();
						console.log('success');
					}).fail(function() {
						console.log('error');
					}).always(function() {
						console.log('completed');
					});
				});
				@endforeach
			});
		</script>  
	</body>
</html>
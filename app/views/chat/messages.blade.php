@extends('master')

@section('content')
<div class="container-fluid fullPage">
	<div class="row">
		<div class="col-md-12">
			<div class="chatWrapper" style="height:350px; overflow-y:auto">
				
				@foreach($messages as $message)
				<div class="media">
					<div class="media-body" style="margin: 13px;">
						@if(Auth::user()->id == $message->user->id)
						<h4 class="media-heading" style="margin: 10px; color: green;">{{ $message->user->name }}</h4>
						@else
						<h4 class="media-heading" style="margin: 10px;">{{ $message->user->name }}</h4>
						@endif
						<p style="margin: 10px;">{{ $message->body }}</p>
					</div>
				</div>
				@endforeach

			</div>
		</div>

		<div class="col-md-12">
			<form action="{{ URL::to('/messages') }}" method="POST" id="chatform">
				<textarea name="message" rows="10" id="textMessage" class="form-control" placeholder="Enter your message"></textarea>
				<button id="chatBtn" style="margin: 10px;" type="submit" class="btn btn-primary">Send</button>
				<button id="refreshBtn" style="margin: 10px;" type="button" class="btn btn-success">Refresh</button>
			</form>
		</div>
	</div>
</div>
@stop

@section('bodyScript')
<script type="text/javascript">
	$(document).ready(function() {
		$('div.chatWrapper').animate({ scrollTop: $('div.chatWrapper div.media:last-child').offset().top }, 'slow');

		$('button#refreshBtn').click(function(e){
			e.preventDefault();
		    window.location.reload(1);
		});

		/*$('button#chatBtn').click(function(e) {
			e.preventDefault();
			var textMessage = $('textarea#textMessage').val();
			$('div.chatWrapper').append(
				'<div class="media">
					<div class="media-body" style="margin: 13px;">
						<h4 class="media-heading" style="margin: 10px; color: green;">{{ Auth::user()->name }}</h4>
						<p style="margin: 10px;">' + textMessage + '</p>
					</div>
				</div>'
			);
		});*/
	});
</script>
@stop
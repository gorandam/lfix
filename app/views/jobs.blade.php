@extends('master')

@section('content')
<div id="page-wrapper">

    <div class="container-fluid jobDetails">
		<div id="iframeHead"> 

			<h3>#1 - Job in Toronto</h3>

			<span>Address: Random street</span>
			<span>Phone: xxxxxxxxx</span>
			<span>Notes: Lorem ipsum dolor sit amet.</span>

		</div>
		<div id="iframeBody">
		    <iframe name="mapFrame" id="mapFrame"		
			  width="600"
			  height="700"
			  frameborder="0" style="border:0"
			  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDpDBs668w-2HORB25aaEu-tSydv4wdeJQ
			    &q=Toronto">
			</iframe>
	  	</div>
	</div>
</div>	  	
@stop

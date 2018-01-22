
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Technicians Management - Dashboard</title>
    {{ HTML::style('css/main.css') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js') }}
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDpDBs668w-2HORB25aaEu-tSydv4wdeJQ"></script>
  </head>
  <body>
    <div>
      <h1 class="title">Technicians Manager</h1>
      <p class="tip">Note: Testing markers (pins) are draggable - try with moving them on the map.</p>
    </div>
    <input id="pac-input" class="controls" type="text" placeholder="Search Address">
    <div id="map-canvas"></div>
    <script type="text/javascript">
      var pinRed = "{{URL::to('img/pin_red.png')}}";
      var pinBlue = "{{URL::to('img/pin_blue.png')}}";
      var pinYellow = "{{URL::to('img/pin_yellow.png')}}";
      var pinBlack = "{{URL::to('img/pin_black.png')}}";
    </script>
    {{ HTML::script('js/main.js') }}
  </body>
</html>
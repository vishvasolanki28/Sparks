<!DOCTYPE html>
<html>
<head>
	<title>VSBBS - @yield('title')</title>
  <link rel="shortcut icon" href="{{asset('Images/bank.svg')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="PHP, HTML, CSS, Bootstrap, Laravel, Javascript, jQuery">
  <link href="{{ asset('css/MyCSS.css') }}" rel="stylesheet">
  <link href="{{ asset('js/MyJS.js') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  @section('header')
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><div class="txt1">VS-BBS</div></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="HomePage">Home</a></li>
      <li><a href="ViewCustomers">View Customers</a></li>
      <li><a href="TransferMoney">Transfer Money</a></li>
      <li><a href="ViewTransactionHistory">View Transaction History</a></li>
    </ul>
  </div>
  </nav>
  @show

  <div class="content">
    @yield('content')
  </div>

  @section('footer')
  <div class="footer">
    <div>Copyright &#169; 2021 VS</div>
    <div>VS Basic Banking System Created by Solanki Vishva</div>
    <div>VS Basic Banking System Powered by The Sparks Foundation</div>
  </div>
  @show
</body>
</html>
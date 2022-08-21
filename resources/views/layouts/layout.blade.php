<!-- Layout of the website -->
<!DOCTYPE html>
<html lang="fr" local="fr">

<head>
    <!-- Parameters -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Font awesome icons -->
    <link href="{{ URL::asset('lib/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- CSS -->
    <!-- ####################################"" -->
    <link href="//cdn.syncfusion.com/ej2/ej2-base/styles/material.css" rel="stylesheet">
    <link href="//cdn.syncfusion.com/ej2/ej2-buttons/styles/material.css" rel="stylesheet">
    <link href="//cdn.syncfusion.com/ej2/ej2-calendars/styles/material.css" rel="stylesheet">
    <script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js" type="text/javascript"></script>
    <!-- ####################################"" -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/fonts.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://cdn.rawgit.com/JacobLett/IfBreakpoint/e9fcd4fd/if-b4-breakpoint.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">

    @yield('extra-js')

    <title>@yield('title')</title>

</head>

<body>
    <!-- Navbar -->
    @include('partials.navbar')


    <!-- Main content -->
    @yield('content')

    <!-- Footer -->
    {{-- @include('partials.footer') --}}
</body>

</html>
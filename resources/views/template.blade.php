<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.header')
    @yield('custom_css')
    <title>MMS</title>
</head>
<body>
    @include('layouts.navigation')
    @yield('content_page')


    @include('layouts.footer')
    @yield('custom_scripts')
    
</body>
</html>
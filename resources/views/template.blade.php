<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.header')
    @yield('custom_css')

    <title>MMS</title>

</head>
<body>

        <div class="dashboard-main-wrapper">
      
            @include('layouts.navigation')
            
            @include('layouts.sidebar')
            
            <div class="dashboard-wrapper">
                    @yield('content_page')
            </div>

        </div>
        @include('layouts.footer')
        @include('layouts.scripts')

        @yield('custom_scripts')
    
</body>
</html>
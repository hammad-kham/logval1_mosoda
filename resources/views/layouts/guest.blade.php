<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    
    <title>{{ env('APP_NAME', 'Homely') }}</title>

    <meta name="description" content="{{ env('APP_NAME', 'Homely') }}">

    <meta name="author" content="{{ env('APP_NAME', 'Homely') }}">

    <meta name="robots" content="noindex, nofollow">    

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset_url('img/favicon.ico') }}" />

    @yield('css_before')
  
    <link rel="stylesheet" href="{{ asset_url('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset_url('bundles/bootstrap-social/bootstrap-social.css') }}">
    
    <link rel="stylesheet" href="{{ asset_url('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset_url('css/components.css') }}">
     
    @yield('css_after')
</head>

<body class="background-image-body">

    <div class="loader"></div>
    
    <div id="app">
    	<section class="section">
            <div class="container mt-5">
                @yield('content')
            </div>
    	</section>
	</div>

    @yield('js_after')
  
</body>
</html>
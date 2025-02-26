<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>    
    	@include('layouts.head')
    	@yield('headerInclude')
</head>
<?php
$body_class = "";
if(Auth::user())
{
	$mode = Auth::user()->mode;
	$sidebar = Auth::user()->sidebar;
	$theme = Auth::user()->theme;
	$menu = Auth::user()->menu;
	
	if($mode == 'dark')
	{
		$body_class = "dark";
	}
	else
	{
		$body_class = "light";
	}
	
	switch($sidebar)
	{
		case 'white':$body_class.= " white-sidebar";break;
		case 'blue':$body_class.= " blue-sidebar";break;
		case 'coral':$body_class.= " coral-sidebar";break;
		case 'purple':$body_class.= " purple-sidebar";break;
		case 'allports':$body_class.= " allports-sidebar";break;
		case 'barossa':$body_class.= " barossa-sidebar";break;
		case 'fancy':$body_class.= " fancy-sidebar";break;			
		default:$body_class.= " purple-sidebar";break;
	}
	
	switch($theme)
	{
		case 'white':$body_class.= " theme-white";break;
		case 'blue':$body_class.= " theme-blue";break;
		case 'coral':$body_class.= " theme-coral";break;
		case 'purple':$body_class.= " theme-purple";break;
		case 'allports':$body_class.= " theme-allports";break;
		case 'barossa':$body_class.= " theme-barossa";break;
		case 'fancy':$body_class.= " theme-fancy";break;			
		default:$body_class.= " theme-white";break;
	}
	
	if($menu == 'on')
	{
		$body_class.= " sidebar-mini";
	}
}
?>
<body class="<?php echo $body_class;?>">

	<div class="loader"></div>
  
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
        
            @include('layouts.header')
        
            @include('layouts.sidebar')
            
      		<div class="main-content">
    
                @yield('content')

				@include('layouts.theme')
    
            </div>
        
            @include('layouts.footer')
        
    	</div>
  	</div>
    
    @include('layouts.foot')
    
    @yield('footerInclude')
    
</body>
</html>
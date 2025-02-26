<?php
if(Auth::user())
{
	$mode = Auth::user()->mode;
	$sidebar = Auth::user()->sidebar;
	$theme = Auth::user()->theme;
	$menu = Auth::user()->menu;
	
	if($mode == 'dark')
	{
		$mode = "dark";
	}
	else
	{
		$mode = "light";
	}
	
	switch($sidebar)
	{
		case 'white':$sidebar = "white";break;
		case 'blue':$sidebar = "blue";break;
		case 'coral':$sidebar = "coral";break;
		case 'purple':$sidebar = "purple";break;
		case 'allports':$sidebar = "allports";break;
		case 'barossa':$sidebar = "barossa";break;
		case 'fancy':$sidebar = "fancy";break;			
		default:$sidebar = "purple";break;
	}
	
	switch($theme)
	{
		case 'white':$theme = "white";break;
		case 'blue':$theme = "blue";break;
		case 'coral':$theme = "coral";break;
		case 'purple':$theme = "purple";break;
		case 'allports':$theme = "allports";break;
		case 'barossa':$theme = "barossa";break;
		case 'fancy':$theme = "fancy";break;			
		default:$theme = "white";break;
	}
	
	$menu_value = '';
	if($menu == 'on')
	{
		$menu = "on";
		$menu_value = 'off';
	}
	else
	{
		$menu = "off";
		$menu_value = 'on';
	}
	?>

    <div class="settingSidebar">
        <a href="javascript:void(0)" class="settingPanelToggle"> 
        	<i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
                <div class="setting-panel-header">Theme Customizer</div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Theme Layout</h6>
                    <div class="selectgroup layout-color w-50">
                        <label> 
                            <span class="control-label p-r-20">Light</span>
                            <input type="radio" name="custom-switch-input" value="1" class="custom-switch-input"<?php if($mode == "light"){?> checked<?php } ?>> 
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="selectgroup layout-color w-50">
                        <label> 
                            <span class="control-label p-r-20">Dark</span>
                            <input type="radio" name="custom-switch-input" value="2" class="custom-switch-input"<?php if($mode == "dark"){?> checked<?php } ?>> 
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Colors</h6>
                <div class="sidebar-setting-options">
                    <ul class="sidebar-color list-unstyled mb-0">
                        <li title="white" <?php if($sidebar == "white"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/white/set-sidebar')}}">
                                <div class="white"></div>
                            </a>
                        </li>
                        <li title="blue" <?php if($sidebar == "blue"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/blue/set-sidebar')}}">
                                <div class="blue"></div>
                            </a>
                        </li>
                        <li title="coral" <?php if($sidebar == "coral"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/coral/set-sidebar')}}">
                                <div class="coral"></div>
                            </a>
                        </li>
                        <li title="purple" <?php if($sidebar == "purple"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/purple/set-sidebar')}}">
                                <div class="purple"></div>
                            </a>
                        </li>
                        <li title="allports" <?php if($sidebar == "allports"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/allports/set-sidebar')}}">
                                <div class="allports"></div>
                            </a>
                        </li>
                        <li title="barossa" <?php if($sidebar == "barossa"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/barossa/set-sidebar')}}">
                                <div class="barossa"></div>
                            </a>
                        </li>
                        <li title="fancy" <?php if($sidebar == "fancy"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/fancy/set-sidebar')}}">
                                <div class="fancy"></div>
                            </a>
                        </li>
                    </ul>
                </div>    
            </div>
            
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Theme Colors</h6>
                <div class="theme-setting-options">
                    <ul class="choose-theme list-unstyled mb-0">
                        <li title="white" <?php if($theme == "white"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/white/set-theme')}}">
                                <div class="white"></div>
                            </a>
                        </li>
                        <li title="blue" <?php if($theme == "blue"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/blue/set-theme')}}">
                                <div class="blue"></div>
                            </a>
                        </li>
                        <li title="coral" <?php if($theme == "coral"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/coral/set-theme')}}">
                                <div class="coral"></div>
                            </a>
                        </li>
                        <li title="purple" <?php if($theme == "purple"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/purple/set-theme')}}">
                                <div class="purple"></div>
                            </a>
                        </li>
                        <li title="allports" <?php if($theme == "allports"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/allports/set-theme')}}">
                                <div class="allports"></div>
                            </a>
                        </li>
                        <li title="barossa" <?php if($theme == "barossa"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/barossa/set-theme')}}">
                                <div class="barossa"></div>
                            </a>
                        </li>
                        <li title="fancy" <?php if($theme == "fancy"){?>class="active"<?php } ?>>
                            <a href="{{url('/users/fancy/set-theme')}}">
                                <div class="fancy"></div>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </div>
            
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Layout Options</h6>
                <div class="theme-setting-options">
                    <label> 
                        <span class="control-label p-r-20">Compact Sidebar Menu</span> 
                        <input type="checkbox" name="custom-switch-checkbox" value="<?php echo $menu_value;?>" class="custom-switch-input" id="mini_sidebar_setting" <?php if($menu == "on"){?> checked<?php } ?>> 
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            </div>
            <div class="mt-3 mb-3 align-center">
                <a href="{{url('/users/set-default')}}" class="btn btn-icon icon-left btn-outline-primary">
                    <i class="fas fa-undo"></i> Restore Default
                </a>
            </div>
        </div>
    </div>
    <?php
}
?>
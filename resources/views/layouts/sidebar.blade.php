<?php
$Auth_User = Auth::user();
?>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{url('/dashboard')}}">
                <img alt="image" src="{{ asset_url('img/logo.png') }}" class="header-logo" />
                <span class="logo-name">{{ env('APP_NAME', 'Homely') }}</span>
            </a>
        </div>
        <ul class="sidebar-menu">

            <?php /*?><li class="dropdown active" style="display: block;">
                <div class="sidebar-profile">
                    <div class="siderbar-profile-pic">
                        <img src="{{ asset_url('img/users/user-6.png') }}" class="profile-img-circle box-center" alt="User Image">
                    </div>
                    <div class="siderbar-profile-details">
                        <div class="siderbar-profile-name"> {{ Auth::user()->name }} </div>
                        <div class="siderbar-profile-position">Manager </div>
                    </div><?php */?>
                     
                    <?php /*?><div class="sidebar-profile-buttons">
                        <a class="tooltips waves-effect waves-block toggled" href="profile.html" data-toggle="tooltip" title="" data-original-title="Profile">
                            <i class="fas fa-user sidebarQuickIcon"></i>
                        </a>
                        <a class="tooltips waves-effect waves-block" href="email-inbox.html" data-toggle="tooltip" title="" data-original-title="Mail">
                            <i class="fas fa-envelope sidebarQuickIcon"></i>
                        </a>
                        <a class="tooltips waves-effect waves-block" href="chat.html" data-toggle="tooltip" title="" data-original-title="Chat">
                            <i class="fas fa-comment-dots  sidebarQuickIcon"></i>
                        </a>
                        <a class="tooltips waves-effect waves-block" href="auth-login.html" data-toggle="tooltip" title="" data-original-title="Logout">
                            <i class="fas fa-share-square sidebarQuickIcon"></i>
                        </a>
                    </div><?php */?>
                    
                <?php /*?></div>
            </li><?php */?>

            <?php /*?><li class="menu-header">Main</li><?php */?>


            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{url('/dashboard')}}">
                    <i class="fas fa-desktop"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
			<?php
            if($Auth_User->user_type == 'admin')
            {
                ?>
                @include('layouts.menu_admin')
                <?php
            }
            elseif($Auth_User->user_type == 'vendor')
            {
                ?>
                @include('layouts.menu_vendor')
                <?php
            }
            elseif($Auth_User->user_type == 'seller')
            {
                ?>
                @include('layouts.menu_seller')
                <?php
            }
            ?>

        </ul>
        <br>
        <br>
    </aside>
</div>
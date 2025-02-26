<?php
$Auth_User = Auth::user();
?>
<div class="navbar-bg"></div>

<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            <li>
                <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                    <i class="fas fa-expand"></i>
                </a>
            </li>

            <?php /*?><li>
                  <div class="search-group">
                    <span class="nav-link nav-link-lg" id="search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="search-control" placeholder="search" aria-label="search" aria-describedby="search">
                  </div>
                </li><?php */?>
        </ul>
    </div>

    <ul class="navbar-nav navbar-right">
        <?php /*?><li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i><span class="notification-count bg-green">4</span></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon l-bg-green text-white">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    5 sales Product
                    <span class="time">8 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon l-bg-orange text-white">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    10 Customers Inquiry 
                    <span class="time">7 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-yellow text-white">
                    <i class="fa fa-server" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Your Subscription Expired
                    <span class="time">10 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-blue text-white">
                    <i class="fas fa-user-edit" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Update Profile
                    <span class="time">9 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-purple text-white">
                    <i class="far fa-envelope" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    10 Email Notifications
                    <span class="time">Yesterday</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li><?php */?>
        <?php /*?><li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-5.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Sophie Walker</span>
                    <span class="time messege-text">Project Planning</span>
                    <span class="time">10 Minutes Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-4.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Ryan Porter</span>
                    <span class="time messege-text">Project Analysis</span>
                    <span class="time">2 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-1.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Robert Nelson</span>
                    <span class="time messege-text">Leave application !!</span>
                    <span class="time">4 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Clara Martin</span>
                    <span class="time messege-text">Client meeting</span>
                    <span class="time">1 Day Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-3.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Kevin Rogers</span>
                    <span class="time messege-text">Discussion about Issues</span>
                    <span class="time">3 Days Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Clara Martin</span>
                    <span class="time messege-text">Team meeting</span>
                    <span class="time text-primary">5 Days Ago</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li><?php */?>

        <?php
        if($Auth_User->user_type != "admin")
        {
        ?>

        <input type="hidden" id="user_id" value="{{$Auth_User->vend_id}}">

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <div class="header-element">
                    <i class="fas fa-bell"></i>

                    {{-- For notification dot--}}
                    <span id="dothdn" class="dot notification-badge " style="display: none"></span>

                    <span class="d-sm-none d-lg-inline-block"></span>
                </div>

            </a>

            <div class="dropdown-menu dropdown-menu-right scrollable-div" style="width: 400px">

                <div id="notification">

                    <div class="notify_id" data-last_id="0"></div>

                    <div id="notificationnone">
                        <a class="dropdown-item has-icon text-center" style="white-space: pre-line;">
                            No Notifications
                        </a>
                    </div>

                </div>

            </div>
        </li>

        <?php
        }
        ?>

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <?php /*?><img alt="image" src="{{ asset_url('img/user.png') }}" class="user-img-radious-style"><?php */?>
                <div class="header-element">
                    <i class="fas fa-cog"></i>
                    <span class="d-sm-none d-lg-inline-block"></span>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>

                <a href="{{ route('users.show', $Auth_User->id) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <a href="{{ route('users.edit', $Auth_User->id) }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Change Password
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

            </div>
        </li>
    </ul>
</nav>

{{--<audio id="play_user_audio" src="{{ get_notification_audio() }}" autoplay></audio>--}}

<button class="hide" id="play_user_audio" onclick="playSound3('{{ get_notification_audio() }}');"></button>
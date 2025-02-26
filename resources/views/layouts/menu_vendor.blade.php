<?php
$Auth_User = Auth::user();
?>

    @if($Auth_User->can('vendors-listing') || $Auth_User->can('all'))
    
        <li class="{{ request()->is('vendors*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('vendors')}}">

                <i class="fab fa-atlassian"></i>

                <span>Profile</span>

            </a>
            
        </li>

    @endif

    @if($Auth_User->can('vendor-categories-listing') || $Auth_User->can('all'))
    
        <li class="{{ request()->is('vendor-categories*') ? 'active' : '' }}">
        
            <a class="nav-link" href="{{url('vendor-categories')}}">

                <i class="fab fa-atlassian"></i>

                <span>Categories</span>

            </a>
            
        </li>

    @endif

    @if($Auth_User->can('vendor-sub-categories-listing') || $Auth_User->can('all'))
    
        <li class="{{ request()->is('vendor-sub-categories*') ? 'active' : '' }}">
        
            <a class="nav-link" href="{{url('vendor-sub-categories')}}">

                <i class="fab fa-atlassian"></i>

                <span>Sub Categories</span>

            </a>
            
        </li>

    @endif

    @if($Auth_User->can('vendor-listing') || $Auth_User->can('all'))

        <li class="{{ request()->is('vendor*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('vendor')}}">

                <i class="fab fa-atlassian"></i>

                <span</span>

            </a>
            
        </li>

    @endif

    @if($Auth_User->can('vendor-products-listing') || $Auth_User->can('all'))

        <li class="{{ request()->is('products*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('products')}}">

                <i class="fab fa-atlassian"></i>

                <span>Products</span>

            </a>
            
        </li>

    @endif
<!-- 
    @if($Auth_User->can('vendor-rewards-listing') || $Auth_User->can('all')) -->

        <li class="{{ request()->is('rewards*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('rewards')}}">

                <i class="fab fa-atlassian"></i>

                <span>Rewards</span>

            </a>
            
        </li>

   <!-- @endif -->

    @if($Auth_User->can('vendor-orders-listing') || $Auth_User->can('all'))

        <li class="{{ request()->is('orders*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('orders')}}">

                <i class="fab fa-atlassian"></i>

                <span>Orders</span>

            </a>
            
        </li>

    @endif

    @if($Auth_User->can('vendor-reviews-listing') || $Auth_User->can('all'))

        <li class="{{ request()->is('reviews*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('reviews')}}">

                <i class="fab fa-atlassian"></i>

                <span>Reviews</span>

            </a>
            
        </li>

    @endif
    
    @if($Auth_User->can('users-listing') || $Auth_User->can('all'))

        <li class="{{ request()->is('users*') ? 'active' : '' }}">

            <a class="nav-link" href="{{url('/users')}}">

                <i class="fab fa-atlassian"></i>

                <span>Users</span>

            </a>
            
        </li>

    @endif
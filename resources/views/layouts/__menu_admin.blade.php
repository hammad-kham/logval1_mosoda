<?php
$Auth_User = Auth::user();
?>

<li class="menu-header">Services On Demand</li>

@if($Auth_User->can('vendors-listing') || $Auth_User->can('vendor-categories-listing') || $Auth_User->can('vendor-coupons-listing') || $Auth_User->can('vendor-sub-categories-listing') || $Auth_User->can('vendor-services-listing') || $Auth_User->can('vendor-products-listing') || $Auth_User->can('vendor-orders-listing') || $Auth_User->can('vendor-reviews-listing') || $Auth_User->can('all'))
	
	<?php
	$toggle = '';
	$style = '';
	$append_class = '';
	
	if(request()->is('service/vendors*') || request()->is('service/vendor-categories*') || request()->is('service/coupon/*') || request()->is('service/coupons*') || request()->is('service/rewards*') || request()->is('service/reward/*') || request()->is('service/vendor-sub-categories*') || request()->is('service/vendor-services*') || request()->is('service/products*') || request()->is('service/reviews*') || request()->is('service/orders*'))
	{
		$append_class = 'open';
		$style = 'style="display:block"';
		$toggle = 'toggle"';
	}
	?>
	<li class="dropdown <?php echo $append_class;?>">
		
		<a href="#" class="nav-link has-dropdown <?php echo $toggle;?>">
			
			<i class="fab fa-atlassian"></i>
			
			<span>Vendors</span>
		
		</a>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendors-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/vendors*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/vendors')}}">
						
						Vendors
					
					</a>
				
				</li>
			
			@endif
		
		
		
		</ul>
		
		{{-- here vendor-categories --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-categories-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/vendor-categories*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/vendor-categories')}}">
						
						Categories
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		
		{{-- here vendor-sub-categories --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-sub-categories-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/vendor-sub-categories*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/vendor-sub-categories')}}">
						
						Sub Categories
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		{{-- here vendor-services --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-services-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/vendor-services*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/vendor-services')}}">
						
						Services
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		
		{{-- here products --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-products-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/products*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/products')}}">
						
						Products
					
					</a>
				
				</li>
			
			@endif
		
		</ul>

		{{-- here rewards--}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-rewards-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/rewards*') || request()->is('service/reward/*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/rewards')}}">
						
						Rewards
					
					</a>
				
				</li>
			
			@endif
		
		</ul>

		{{-- here coupons--}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-coupons-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/coupons*') || request()->is('service/coupon/*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/coupons')}}">
						
						Coupons
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		{{-- here orders --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-orders-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/orders*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/orders')}}">
						
						Orders
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		
		{{-- here reviews --}}
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('vendor-reviews-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/reviews*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/reviews')}}">
						
						Reviews
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
	
	
	
	</li>
@endif

@if($Auth_User->can('categories-listing') || $Auth_User->can('sub-categories-listing') || $Auth_User->can('services-listing') || $Auth_User->can('sub-services-listing') ||  $Auth_User->can('all'))
	
	<?php
	$style = '';
	$append_class = '';
	$toggle = '';
	if(request()->is('service/categories*') || request()->is('service/sub-categories*') || request()->is('service/services*') || request()->is('service/sub-services*'))
	{
		$append_class = 'open';
		$style = 'style="display:block"';
		$toggle = 'toggle"';
	}
	?>
	<li class="dropdown <?php echo $append_class;?> ">
		
		<a href="#" class="nav-link has-dropdown <?php echo $toggle;?>">
			
			<i class="fab fa-atlassian"></i>
			
			<span>Settings</span>
		
		</a>
		
		<ul class="dropdown-menu" <?php echo $style;?> >
			
			@if($Auth_User->can('categories-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/categories*') ? 'active' : '' }}">
					
					<a href="{{url('/service/categories')}}">
						
						Categories
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('sub-categories-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/sub-categories*') ? 'active' : '' }}">
					
					<a href="{{url('/service/sub-categories')}}">
						
						Sub Categories
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('services-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/services*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/services')}}">
						
						Services
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('sub-services-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/sub-services*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/sub-services')}}">
						
						Sub Services
					
					</a>
				
				</li>
			
			@endif

			

			@if($Auth_User->can('reward_type-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('service/reward_types*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/service/reward_types')}}">
						
						Reward Type
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
	
	</li>

@endif












<li class="menu-header">General</li>

@if($Auth_User->can('users-listing') || $Auth_User->can('modules-listing') || $Auth_User->can('roles-listing') || $Auth_User->can('all'))
	
	<?php
	$toggle = '';
	$style = '';
	$append_class = '';
	
	if(request()->is('users*') || request()->is('modules*') || request()->is('roles*'))
	{
		$append_class = 'open';
		$style = 'style="display:block"';
		$toggle = 'toggle"';
	}
	?>
	<li class="dropdown <?php echo $append_class;?>">
		
		<a href="#" class="nav-link has-dropdown <?php echo $toggle;?>">
			
			<i class="fab fa-atlassian"></i>
			
			<span>Users</span>
		
		</a>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('users-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('users*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/users')}}">
						
						All Users
					
					</a>
				
				</li>
			
			@endif
			
			<?php /*?>@if($Auth_User->can('modules-listing') || $Auth_User->can('all'))

                    <li class="{{ request()->is('modules*') ? 'active' : '' }}">

                        <a class="nav-link" href="{{url('/modules')}}">

                            Modules

                        </a>

                    </li>

                @endif<?php */?>
			
			@if($Auth_User->can('roles-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('roles*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/roles')}}">
						
						Roles
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
	
	</li>

@endif

@if($Auth_User->can('app-users-listing') || $Auth_User->can('app-user-queries-listing') || $Auth_User->can('app-improvements-listing') || $Auth_User->can('all'))
	
	<?php
	$toggle = '';
	$style = '';
	$append_class = '';
	if(request()->is('app-users*') || request()->is('app-user-queries*') || request()->is('app-improvements*'))
	{
		$append_class = 'open';
		$style = 'style="display:block"';
		$toggle = 'toggle"';
	}
	?>
	<li class="dropdown <?php echo $append_class;?>">
		
		<a href="#" class="nav-link has-dropdown <?php echo $toggle;?>">
			
			<i class="fab fa-atlassian"></i>
			
			<span>App Users</span>
		
		</a>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('app-users-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-users*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-users')}}">
						
						App Users
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('app-user-queries-queries') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-user-queries*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-user-queries')}}">
						
						App User Queries
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('app-improvements-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-improvements*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-improvements')}}">
						
						App Improvements
					
					</a>
				
				</li>
			
			@endif
		
		</ul>
	
	</li>

@endif

@if( $Auth_User->can('general-settings-listing') || $Auth_User->can('faqs-listing') || $Auth_User->can('faq-topics-listing') || $Auth_User->can('countries-listing') || $Auth_User->can('languages-listing') || $Auth_User->can('app-labels-listing') || $Auth_User->can('app-pages-listing') || $Auth_User->can('app-slides-listing') || $Auth_User->can('bad-words-listing') || $Auth_User->can('banners-listing') || $Auth_User->can('currencies-listing') || $Auth_User->can('contact-details-listing') || $Auth_User->can('flower-colors-listing') || $Auth_User->can('flower-sizes-listing') || $Auth_User->can('flower-types-listing') || $Auth_User->can('home-items-listing') || $Auth_User->can('home-types-listing') || $Auth_User->can('payment-methods-listing') || $Auth_User->can('occasion-types-listing') || $Auth_User->can('room-types-listing') || $Auth_User->can('templates-listing') || $Auth_User->can('all') )
	
	<?php
	$toggle = '';
	$style = '';
	$append_class = '';
	
	if(request()->is('general-settings*') || request()->is('app-labels*') || request()->is('app-pages*') || request()->is('app-slides*') || request()->is('bad-words*') || request()->is('banners*') || request()->is('contact-details*') || request()->is('countries*') || request()->is('currencies*') || request()->is('faqs*') || request()->is('faq-topics*') || request()->is('flower-colors*') || request()->is('flower-sizes*') || request()->is('flower-types*') || request()->is('home-items*') || request()->is('home-types*') || request()->is('languages*') || request()->is('occasion-types*') || request()->is('payment-methods*') || request()->is('room-types*') || request()->is('templates*'))
	{
		$append_class = 'open';
		$style = 'style="display:block"';
		$toggle = 'toggle"';
	}
	?>
	<li class="dropdown <?php echo $append_class;?>">
		
		<a href="#" class="nav-link has-dropdown <?php echo $toggle;?>">
			
			<i class="fab fa-atlassian"></i>
			
			<span>Settings</span>
		
		</a>
		
		<ul class="dropdown-menu" <?php echo $style;?>>
			
			@if($Auth_User->can('app-labels-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-labels*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-labels')}}">
						
						App Labels
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('app-pages-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-pages*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-pages')}}">
						
						App Pages
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('app-slides-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('app-slides*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/app-slides')}}">
						
						App Slides
					
					</a>
				
				</li>
			
			@endif
			
			
			@if($Auth_User->can('bad-words-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('bad-words*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/bad-words')}}">
						
						Bad Words
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('banners-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('banners*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/banners')}}">
						
						Banners
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('countries-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('countries*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/countries')}}">
						
						Countries
					
					</a>
				
				</li>
			
			@endif
			
			
			@if($Auth_User->can('currencies-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('currencies*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/currencies')}}">
						
						Currencies
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('faq-topics-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('faq-topics*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/faq-topics')}}">
						
						FAQ Topics
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('faqs-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('faqs*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/faqs')}}">
						
						FAQs
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('flower-colors-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('flower-colors*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/flower-colors')}}">
						
						Flower Colors
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('flower-sizes-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('flower-sizes*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/flower-sizes')}}">
						
						Flower Sizes
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('flower-types-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('flower-types*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/flower-types')}}">
						
						Flower Types
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('general-settings-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('general-settings*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/general-settings')}}">
						
						General Settings
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('home-items-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('home-items*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/home-items')}}">
						
						Home Items
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('home-types-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('home-types*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/home-types')}}">
						
						Home Types
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('languages-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('languages*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/languages')}}">
						
						Languages
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('payment-methods-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('payment-methods*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/payment-methods')}}">
						
						Payment Methods
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('occasion-types-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('occasion-types*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/occasion-types')}}">
						
						Occasion Types
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('room-types-listing') || $Auth_User->can('all'))
				
				<li class="{{ request()->is('room-types*') ? 'active' : '' }}">
					
					<a class="nav-link" href="{{url('/room-types')}}">
						
						Room Types
					
					</a>
				
				</li>
			
			@endif
			
			@if($Auth_User->can('templates-listing') || $Auth_User->can('all'))

                <li class="{{ request()->is('templates*') ? 'active' : '' }}">

                    <a class="nav-link" href="{{url('/templates')}}">

                        Templates

                    </a>

                </li>

            @endif
		
		</ul>
	
	</li>

@endif
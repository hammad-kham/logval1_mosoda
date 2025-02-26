@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Create New User</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('users.index') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create New
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('users.index') }}">
                        <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                    </a>
                </div>
            </div>
        </div>

        <div class="section-body">
            @include('flash::message')
            @include('coreui-templates::common.errors')
            <div class="row">
                <?php
                if(Auth::user()->user_type == 'admin')
                {
					?>
					<div class="col-lg-4 col-md-4 col-sm-12">
	
						<div class="card">
							<div class="card-header">
								<h4>Create New User</h4>
							</div>
							<div class="card-body">
								<form method="POST" action="{{ route('users.store') }}" autocomplete="off">
									@csrf
                    
                                    <input type="hidden" name="user_type" value="admin" />
                                
									<div class="mt-4 row">
										<div class="col-md-12">
                                        &nbsp;
										</div>
									</div>
                                
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="name">Name</label>
										</div>
										<div class="col-md-9">
											<input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
										</div>
									</div>
                                    
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="phone">Phone</label>
										</div>
										<div class="col-md-9">
											<input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>
										</div>
									</div>
                                    
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="email">Email</label>
										</div>
										<div class="col-md-9">
											<input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
										</div>
									</div>
                                    
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="password">Password</label>
										</div>
										<div class="col-md-9">
											<input id="password" class="form-control" type="password" name="password" required />
										</div>
									</div>
                                    
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="role">Role</label>
										</div>
										<div class="col-md-9">
											<select id="role" class="custom-select" name="role" required>	
												<?php
												foreach ($roles_array as $role)
												{
													if($role->display_to == 0)
													{
														?>
														<option selected value="{{$role->id}}">{{$role->name}}</option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
                                    
									<div class="mt-4 row">
										<div class="col-md-3">
											<label for="status">Status</label>
										</div>
										<div class="col-md-9">
											<select id="status" class="custom-select" name="status" required>
												<option value="0">Inactive</option>
												<option selected value="1">Active</option>
											</select>
										</div>
									</div>
	
									<div class="my-4">
										<input class="btn btn-primary" type="submit" value="Create New User">
										<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
									</div>
								</form>
							</div>
						</div>
	
					</div>

                    <div class="col-lg-4 col-md-4 col-sm-12">
    
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New User for Vendor</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                                    @csrf
                    
                                    <input type="hidden" name="user_type" value="vendor" />
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::label('vend_id', 'Vendor:') !!}
                                        </div>
                                        <div class="col-md-9">
                                            {!! Form::select('vend_id', $vendors_array, null, ['placeholder' => 'select','class' => 'form-control js-select2 form-select rest_select2','required'=>'']) !!}
                                        </div>
                                    </div>
                                        
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="phone">Phone</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="password" class="form-control" type="password" name="password" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="role">Role</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="role" class="custom-select" name="role" required>
    
                                                <?php
                                                foreach ($roles_array as $role)
                                                {
													if($role->display_to == 1)
													{
														?>
														<option selected value="{{$role->id}}">{{$role->name}}</option>
														<?php
													}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="status" class="custom-select" name="status" required>
                                                <option value="0">Inactive</option>
                                                <option selected value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="my-4">
                                        <input class="btn btn-primary" type="submit" value="Create New User">
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
    
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12">
                    
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New User for Seller</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                                    @csrf
                    
                                    <input type="hidden" name="user_type" value="seller" />
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::label('vend_id', 'Seller:') !!}
                                        </div>
                                        <div class="col-md-9">
                                            {!! Form::select('vend_id', $sellers_array, null, ['placeholder' => 'select','class' => 'form-control js-select2 form-select rest_select2','required'=>'']) !!}
                                        </div>
                                    </div>
                                        
                                
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="phone">Phone</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="password" class="form-control" type="password" name="password" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="role">Role</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="role" class="custom-select" name="role" required>
                    
                                                <?php
                                                foreach ($roles_array as $role)
                                                {
													if($role->display_to == 2)
													{
														?>
														<option selected value="{{$role->id}}">{{$role->name}}</option>
														<?php
													}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="status" class="custom-select" name="status" required>
                                                <option value="0">Inactive</option>
                                                <option selected value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
                    
                                    <div class="my-4">
                                        <input class="btn btn-primary" type="submit" value="Create New User">
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    
                    </div>
					<?php
                }
				elseif(Auth::user()->user_type == 'vendor')
				{
					?>
                    <div class="col-lg-12 col-md-12 col-sm-12">
    
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New Vendor User</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                                    @csrf
    
                                    <input type="hidden" name="user_type" value="vendor" />
    
                                    <input type="hidden" name="vend_id" value="<?php echo Auth::user()->vend_id;?>" />
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="phone">Phone</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="password" class="form-control" type="password" name="password" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="role">Role</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="role" class="custom-select" name="role" required>
    
                                                <?php
                                                foreach ($roles_array as $role)
                                                {
													if($role->display_to == 1)
													{
														?>
														<option selected value="{{$role->id}}">{{$role->name}}</option>
														<?php
													}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="status" class="custom-select" name="status" required>
                                                <option value="0">Inactive</option>
                                                <option selected value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="my-4">
                                        <input class="btn btn-primary" type="submit" value="Create New User">
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
    
                    </div>
                    <?php
				}
				elseif(Auth::user()->user_type == 'seller')
				{
					?>
                    <div class="col-lg-12 col-md-12 col-sm-12">
    
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New Seller User</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                                    @csrf
    
                                    <input type="hidden" name="user_type" value="seller" />
                                    
                                    <input type="hidden" name="vend_id" value="<?php echo Auth::user()->vend_id;?>" />
                                
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="phone">Phone</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="phone" class="form-control" type="text" name="phone" value="{{ old('phone') }}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="password" class="form-control" type="password" name="password" required />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="role">Role</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="role" class="custom-select" name="role" required>
    
                                                <?php
                                                foreach ($roles_array as $role)
                                                {
													if($role->display_to == 2)
													{
														?>
														<option selected value="{{$role->id}}">{{$role->name}}</option>
														<?php
													}
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 row">
                                        <div class="col-md-3">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="status" class="custom-select" name="status" required>
                                                <option value="0">Inactive</option>
                                                <option selected value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="my-4">
                                        <input class="btn btn-primary" type="submit" value="Create New User">
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
    
                    </div>
                    <?php
				}
                ?>


            </div>
        </div>
    </section>
@endsection

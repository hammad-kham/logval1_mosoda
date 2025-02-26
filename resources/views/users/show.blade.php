@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>User Details</h1>
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
                                Edit User Details
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
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    <div class="card">
                        <div class="card-header">
                            <h4>User Details</h4>
                        </div>
                        <div class="card-body">

                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label>Company Name</label>
                                </div>
                                <div class="col-md-9">
                                    {{ $company_name }}
                                </div>
                            </div>

                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label>User Name</label>
                                </div>
                                <div class="col-md-9">
                                    {{ $user->name }}
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-9">
                                    {{ $user->phone }}
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-9">
                                    {{ $user->email }}
                                </div>
                            </div>
                            
                            <?php
                            if($role_name != '')
							{
								?>
								<div class="mt-4 row">
									<div class="col-md-3">
										<label>Role</label>
									</div>
									<div class="col-md-9">
										<?php
										echo $role_name;
										?>
									</div>
								</div>
								<?php
                            }
                            ?>
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label>Status</label>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $str = 'Pending';
                                    if($user->status == 1)
                                    {
                                        $str = 'Approved';
                                    }
                                    elseif($user->status == 2)
                                    {
                                        $str = 'Rejected';
                                    }
                                    echo $str;
                                    ?>
                                </div>
                            </div>

                            @if(Auth::user()->id == $user->id || (Auth::user()->can('users-edit') || Auth::user()->can('all')))
                                <div class="row text-right mt-4">
                                    <div class="form-group col-sm-12">
                                        <a href="{{ route('users.edit', $user->id) }}" class='btn btn-primary'>
                                            Edit
                                        </a>
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Cancel</a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
@endsection

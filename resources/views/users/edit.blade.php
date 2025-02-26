@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit User</h1> 
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
                        <h4>Edit User </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update') }}" method="POST" autocomplete="off">
                            @csrf
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label for="name">Company Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{ $company_name }}" readonly="readonly" />
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="name" class="form-control" type="text" name="name" value="{{ $user->name }}" required autofocus />
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label for="phone">Phone</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="phone" class="form-control" type="text" name="phone" value="{{ $user->phone }}"/>
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="email" readonly class="form-control" type="email" name="email" value="{{ $user->email }}" required />
                                </div>
                            </div>
                            
                            <div class="mt-4 row">
                                <div class="col-md-3">
                                    <label for="password">Password</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="password" class="form-control" type="password" name="password" />
                                    <small class="text-muted">Leave it empty to keep it unchanged</small>
                                </div>
                            </div>
        
                            <div class="my-4">
                                <input class="btn btn-primary" type="submit" value="Update User">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

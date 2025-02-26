@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Change Password</h1> 
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
                            Change Password
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
                @if(session()->has('success'))
                <div class="container alert alert-success">
                    <i class="fa fa-check-circle"></i> {{ session()->get('success') }}
                </div>
                @elseif(session()->has('error'))
                <div class="container alert alert-danger">
                    <i class="fa fa-check-circle"></i> {{ session()->get('error') }}
                </div>
                @endif
            
                @include('flash::message')
                @include('coreui-templates::common.errors')
                
                <div class="card">
                    <div class="card-header">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        <form class="bg-light rounded px-4 py-2 mb-4 col-md-6" action="{{ route('users.updatePassword') }}" method="POST">
                            @csrf
                            <div class="my-2">
                                <label for="currentPass">Current Password</label>
                                <input type="text" class="form-control" name="current_password" id="currentPass">
                            </div>
        
                            <div class="my-2">
                                <label for="newPass">New Password</label>
                                <input type="text" class="form-control" name="new_password" id="newPass">
                            </div>
        
                            <div class="mt-2 my-3">
                                <input type="submit" value="Change Password" class="btn btn-secondary">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>
@endsection

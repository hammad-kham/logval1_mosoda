@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit App User: {{ $Model_Data->name }}</h1> 
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
                            <a href="{{ route('app-users.index') }}">App Users</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
            	<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('app-users.index') }}">
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
                        <h4>Edit User Details</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($Model_Data, ['route' => ['app-users.update', $Model_Data->id], 'method' => 'patch' , 'files'=> true]) !!}
    
                        @include('app_users.fields')
    
                        {!! Form::close() !!}
                    </div>
                </div>
                
         	</div>
		</div>
    </div>
</section>


@endsection

@push('scripts')
<style>
.hide{
	display:none;
}
</style>
@endpush
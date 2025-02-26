@extends('layouts.app')

@section('content')

<section class="section">

    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit Bad Word Details:  {{ $Model_Data->badword }}</h1> 
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
                            <a href="{{ route('bad-words.index') }}">BadWords</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
            	<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('bad-words.index') }}">
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
                        <h4>Bad Word Details</h4>
                    </div>
                    <div class="card-body">

                        {!! Form::model($Model_Data, ['route' => ['bad-words.update', $Model_Data->id], 'method' => 'patch','files' => true]) !!}
                        
                        @include('bad_words.fields')

                        {!! Form::close() !!}
                    </div>
                </div>
                    
            </div>
        </div>
    </div>

    <!-- Page Content -->
    {{-- <div class="content">
        
        @include('flash::message')
        @include('coreui-templates::common.errors')
                
        <div class="block block-rounded block-themed">
            <div class="block-header">
                <h3 class="block-title">Edit Bad Word</h3>
            </div>
            <div class="block-content">
              {!! Form::model($Model_Data, ['route' => ['bad-words.update', $Model_Data->id], 'method' => 'patch','files' => true]) !!}

                 @include('bad-words.fields')

              {!! Form::close() !!}
            </div>
        </div>                    
    </div> --}}
    <!-- END Page Content -->
</section>
@endsection
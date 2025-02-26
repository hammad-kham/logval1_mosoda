@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Create New Reward Type 
                </h1>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('reward-types.index') }}">Reward Types</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create New
                        </li>
                    </ol>
                </nav>               
                <a href="{{ route('reward-types.index') }}" class="btn btn-dark btn-return pull-right">
                    <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                </a>
            </div>
            @include('flash::message')
       </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">                
        @include('coreui-templates::common.errors')        
        <div class="block block-rounded block-themed">
            <div class="block-header">
                <h3 class="block-title">Create New Reward Type </h3>
            </div>
            <div class="block-content">
              {!! Form::open(['route' => 'reward-types.store','files' => true]) !!}

                 @include('reward_types.fields')

              {!! Form::close() !!}
            </div>
        </div>                    
    </div>
    <!-- END Page Content -->
@endsection

@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Create New Discount Type</h1>
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
                                <a href="{{ url('/service/reward_discount_types') }}">Reward Discounts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create New
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('/service/reward_discount_types') }}">
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
                            <h4>Create New Discount Type</h4>
                        </div>
                        <div class="card-body">
                        {!! Form::open(['url' => 'reward_discount_type/store','files' => true]) !!}

                        @include('svc.reward_discount_types.fields')

                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- END Page Content -->
@endsection

        
        
        
        
        
        
        
        
        
        
        
        
        
        
       
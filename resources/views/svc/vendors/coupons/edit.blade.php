
@extends('layouts.app')

@section('content')
    
    <section class="section">
        {{-- Header Start --}}
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Vendor Edit Coupons:  {{ $Model_Data->bank_name }}</h1>
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
                                <a href="{{ route('svc_coupons.index') }}">Coupon</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('svc_coupons.index') }}">
                        <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                    </a>
                </div>
            </div>
        </div>
        <!-- Header End -->
        
        <!-- Page Content -->
        
        
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    
                    @include('flash::message')
                    @include('coreui-templates::common.errors')
                    
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Coupon</h4>
                        </div>
                        <div class="card-body">
                            <div class="block-content">
                                {!! Form::model($Model_Data, ['route' => ['svc_coupon_update', $Model_Data->id], 'method' => 'patch','files' => true]) !!}
    
                                @include('svc.vendors.coupons.fields')
    
                                <div class="mt-4 mb-3 row">
                                    <div class="col-sm-12 text-right mt-4 mb-3 pr-5">
                                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                        <a href="{{ route('svc_coupons.index') }}" class="btn btn-outline-dark">Cancel</a>
                                    </div>
                                </div>
                                
                                {!! Form::close() !!}
                            
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    
    </section>
@endsection

@push('scripts')
    <style>
        .hide{
            display:none;
        }
        .radioBtn > .notActive{
            color: #3276b1!important;
            background-color: #fff!important;
        }
    </style>
    <script>
        $(document).ready(function(e) {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
    </script>
    
@endpush
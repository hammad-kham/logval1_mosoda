
@extends('layouts.app')

@section('content')
    
    <section class="section">
        {{-- Header Start --}}
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Vendor Bank Details:  {{ $Model_Data->bank_name }}</h1>
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
                                <a href="{{ route('vendor-bank-details.index') }}">Vendor Bank Details</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                View Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('vendor-bank-details.index') }}">
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
                            <h4>Vendor Bank Details</h4>
                        </div>
                        <div class="card-body">
    
                            @include('svc.vendors.bank_details.show_fields')
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END Page Content -->
    
    </section>
@endsection
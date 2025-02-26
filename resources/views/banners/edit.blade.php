@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Edit Details</h1>
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
                                <a href="{{ route('banners.index') }}">Banners</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('banners.index') }}">
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
                            <h4>Edit Banner </h4>
                        </div>
                        <div class="card-body">
                            {!! Form::model($Model_Data, ['route' => ['banners.update', $Model_Data->id], 'method' => 'patch','files' => true]) !!}

                            @include('banners.fields')

                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>

        $(document).ready(function() {

            var e = $("#type");
            var strUser = e.val();
            if(strUser == 0){
                $("#link_div").css("display","none");
                $("#vend_div").css("display","block");
            }
            else if(strUser == 1){
                $("#link_div").css("display","block");
                $("#vend_div").css("display","none");
            }

        });

    </script>
@endpush
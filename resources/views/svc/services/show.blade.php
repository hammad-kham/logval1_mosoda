@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Service Details:  {{ $Model_Data->title }}</h1>
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
                                <a href="{{ route('services.index') }}">Services</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                View Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('services.index') }}">
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
                            <h4>Service Details</h4>
                        </div>
                        <div class="card-body">
                            @include('svc.services.show_fields')
                        </div>
                    </div>
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
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 float-right">
                                <h4>Attributes </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="block-content">
                                <?php
                                if(count($attributes)>0)
                                {
                                $count = 0;
                                ?>
                                <div class="table-responsive">
                                    <div class="table-container">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr role="row" class="heading">
                                                <th>#</th>
                                                <th>Attribute Name</th>
                                                <th>Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($attributes as $record)
                                                <?php
                                                $count++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        {!! $count !!}
                                                    </td>
                                                    <td>
                                                        {!! $record->name !!}
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $options = $options_array[$record->id];
                                                        $str = "";
                                                        if(!empty($options)){
                                                            foreach($options as $option){
                                                                if($str == ""){
                                                                    $str = $option["name"];
                                                                }
                                                                else{
                                                                    $str = $str."<br>".$option["name"];
                                                                }
                                                            }
                                                            echo $str;
                                                        }
                                                        else{
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 " style="text-align: center">
                                        <p>No records found</p>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
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
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 float-right">
                                <h4>Brands </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="block-content">
                                <?php
                                if(count($brands)>0)
                                {
                                $count = 0;
                                ?>
                                <div class="table-responsive">
                                    <div class="table-container">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr role="row" class="heading">
                                                <th>#</th>
                                                <th>Brand Name</th>
                                                <th>Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($brands as $record)
                                                <?php
                                                $count++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        {!! $count !!}
                                                    </td>
                                                    <td>
                                                        {!! $record->name !!}
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $options = $brand_options_array[$record->id];
                                                        $str = "";
                                                        if(!empty($options)){
                                                            foreach($options as $option){
                                                                if($str == ""){
                                                                    $str = $option["name"];
                                                                }
                                                                else{
                                                                    $str = $str."<br>".$option["name"];
                                                                }
                                                            }
                                                            echo $str;
                                                        }
                                                        else{
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </td>
                                            
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 " style="text-align: center">
                                        <p>No records found</p>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

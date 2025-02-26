@extends('layouts.app')

@section('headerInclude')
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Edit Role Details:  {{ $Model_Data->name }}</h1>
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
                                <a href="{{ route('roles.index') }}">Roles</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('roles.index') }}">
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
                            <h4>Role</h4>
                        </div>
                        <div class="card-body">
                            {{--{!! Form::model($Model_Data, ['route' => ['roles.update', $Model_Data->id], 'method' => 'patch']) !!}

                            @include('roles.fields')

                            {!! Form::close() !!}--}}

                            <div class="row">
                                <div class="row col-sm-6">
                                    <div class="col-sm-4">
                                        {!! Form::label('name', 'Name:') !!}
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{ $Model_Data->name }}</p>
                                    </div>
                                </div>
                                <div class="row col-sm-6">
                                    <div class="col-sm-4">
                                        {!! Form::label('display_to', 'Display To:') !!}
                                    </div>
                                    <div class="col-sm-8">
                                        <p>
                                            <?php
                                            if($Model_Data->display_to == 0){
                                                echo 'For Admin Users Only';
                                            }
                                            elseif($Model_Data->display_to == 1){
                                                echo 'For Vendor Users Only';
                                            }
                                            elseif($Model_Data->display_to == 2){
                                                echo 'For Seller Users Only';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Permissions</h4>
                        </div>
                        <div class="card-body">
                            <div id="display_view">                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Service On Demand Vendors</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_1 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Service On Demand Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_2 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Ecommerce Sellers</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_3 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Ecommerce Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_4 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Classified Products</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_5 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Classified Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_6 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>App Users</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_7 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Users</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_8 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>General Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
        
                                            <div class="table-container">
        
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
        
                                                        @foreach($Modules_9 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $list_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $add_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $edit_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $view_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $status_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                                <td>
                                                                    <?php
                                                                    $status = $delete_array[$Module_id];
            
                                                                    $str='';
                                                                    if($status == 1)
                                                                    {
                                                                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo $str;
                                                                    ?>
                                                                </td>
            
                                                            </tr>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
        
                                            </div>
        
                                        </div>
                                    </div>
                                </div>  
                                
                            </div>

                            {!! Form::open(['route' => ['permissions_update',$Model_Data->id]]) !!}
                            <div id="edit_view" style="display:none;">                                 
                                
        
								<?php

                                $count=0;

                                ?>
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Service On Demand Vendors</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_1 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Service On Demand Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_2 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Ecommerce Sellers</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_3 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Ecommerce Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_4 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Classified Products</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_5 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Classified Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_6 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>App Users</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_7 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Users</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_8 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>General Settings</strong>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">                            
                                        <div class="table-responsive">
                                            <div class="table-container">
                                                <table class="table table-striped table-hover">
        
                                                    <thead>
        
                                                        <tr role="row" class="heading">
            
                                                            <th class="cell_1_width">Module</th>
            
                                                            <th class="cell_2_width">View Listing</th>
            
                                                            <th class="cell_2_width">Add</th>
            
                                                            <th class="cell_2_width">Update</th>
            
                                                            <th class="cell_2_width">View Details</th>
            
                                                            <th class="cell_2_width">Status</th>
            
                                                            <th class="cell_2_width">Delete</th>
            
                                                        </tr>
        
                                                    </thead>
        
                                                    <tbody>
            
                                                        @foreach($Modules_9 as $Module)
            
                                                            <?php
                                                            $Module_id = $Module->id;
                                                            ?>
            
            
                                                            <tr role="row" class="heading">
            
                                                                <td>
            
                                                                    {{ ucwords($Module->module_name) }}
            
                                                                </td>
            
                                                                <td>
            
            
                                                                    <?php
            
                                                                    if($Module->mod_list==1)
            
                                                                    {
                                                                    $is_mod = $list_array[$Module_id];
                                                                    $field = 'id_list_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="list_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_add==1)
            
                                                                    {
                                                                    $is_mod = $add_array[$Module_id];
                                                                    $field = 'id_add_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="add_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_edit==1)
            
            
                                                                    {
                                                                    $is_mod = $edit_array[$Module_id];
                                                                    $field = 'id_edit_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="edit_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_view==1)
            
                                                                    {
                                                                    $is_mod = $view_array[$Module_id];
                                                                    $field = 'id_view_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="view_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_status==1)
            
                                                                    {
                                                                    $is_mod = $status_array[$Module_id];
                                                                    $field = 'id_status_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="status_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                                <td>
            
                                                                    <?php
            
                                                                    if($Module->mod_delete==1)
            
                                                                    {
                                                                    $is_mod = $delete_array[$Module_id];
                                                                    $field = 'id_delete_'.$count;
                                                                    ?>
                                                                    <div class="btn-group radioBtn">
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 1)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1"><i class="fa fa-check fa-lg"></i></a>
            
                                                                        <?php
                                                                        $class = 'notActive';
                                                                        if($is_mod == 0)
                                                                        {
                                                                            $class = 'active';
                                                                        }
                                                                        ?>
                                                                        <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0"><i class="fa fa-times fa-lg"></i></a>
                                                                    </div>
                                                                    <input type="hidden" name="delete_module[<?php echo $count;?>]" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            
                                                                    <?php
            
                                                                    }
            
                                                                    else
            
                                                                    {
            
                                                                    ?>
            
                                                                    -
            
                                                                    <?php
            
                                                                    }
            
                                                                    ?>
            
                                                                </td>
            
                                                            </tr>
            
                                                            <?php
            
                                                            $count++;
            
                                                            ?>
            
                                                        @endforeach
        
                                                    </tbody>
        
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <input type="hidden" name="total_modules" value="<?php echo $count;?>" />

                            </div>



                            <hr/>



                            <div class="form-group row m-t-md">

                                <div class="col-sm-4">

                                </div>

                                <div class="col-sm-4" id="display_buttons">

                                    <button type="button" class="btn btn-primary" onclick="edit_form()">

                                        Edit

                                    </button>

                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">

                                        Cancel

                                    </a>

                                    <br />

                                    <br />

                                </div>

                                <div class="col-sm-4" id="edit_buttons" style="display:none">

                                    <button type="submit" class="btn btn-primary">

                                        Save

                                    </button>

                                    <button type="button" class="btn btn-secondary" onclick="display_form()">

                                        Cancel

                                    </button>

                                    <br />

                                    <br />

                                </div>

                                <div class="col-sm-4">

                                </div>

                            </div>

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

        .radioBtn > .active{
            /*color: #FFF!important;
            background-color: #53e3ae!important;*/
        }

        .radioBtn > .notActive{
            /*color: #3276b1!important;
            background-color: #fff!important;*/
            opacity: 0.15;
        }
		
		.cell_1_width{
			width:28%;
		}
		
		.cell_2_width{
			width:12%;
		}
    </style>
    <script>

        $(document).ready(function(e) {
            $('.radioBtn a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                $('#'+tog).prop('value', sel);

                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
            });
        });

        function edit_form()

        {

            $("#edit_buttons").css('display','block');

            $("#edit_view").css('display','block');



            $("#display_buttons").css('display','none');

            $("#display_view").css('display','none');

        }



        function display_form()

        {

            $("#edit_buttons").css('display','none');

            $("#edit_view").css('display','none');



            $("#display_buttons").css('display','block');

            $("#display_view").css('display','block');

        }

    </script>

@endpush
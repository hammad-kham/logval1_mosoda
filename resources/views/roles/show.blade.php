@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Role Details:  {{ $Model_Data->name }}</h1> 
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
                            View Details
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
                        <h4>Role Details</h4>
                    </div>
                    <div class="card-body">
                        @include('roles.show_fields')
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Role Permissions</h4>
                            </div>
                            <div class="card-body">
                                                   
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
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <style>		
		.cell_1_width{
			width:28%;
		}
		
		.cell_2_width{
			width:12%;
		}
    </style>

@endpush
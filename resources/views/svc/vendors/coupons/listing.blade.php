@extends('layouts.app')


@section('content')
    
    <?php
    $Auth_User = Auth::user();
    ?>
    
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Coupons</h1>
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
                            <li class="breadcrumb-item active" aria-current="page">
                                Coupons
                            </li>
                        </ol>
                    </nav>
                </div>
                
                @if(Auth::user()->can('seller-coupons-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('service/coupons/create') }}">
                            <i class="fa fa-plus-square fa-lg"></i> Add New
                        </a>
                    </div>
                @endif
            
            </div>
        </div>
        
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @include('flash::message')
                    <div class="card">
                        <div class="card-body">
                            
                            @if($records_exists == 1)
                                
                                <form method="post" role="form" id="data-search-form">
                                    
                                    <div class="table-responsive">
                                        
                                        <table class="table table-striped table-hover"  id="myDataTable">
                                            
                                            <thead>
                                            
                                            <tr role="row" class="heading">
                                                @if($Auth_User->user_type == 'admin')
                                                    <td>
                                                        <select class="form-control js-select2 form-select rest_select2" id="s_seller_id">
                                                            <option value="-1">Select</option>
                                                            <?php
                                                            foreach($sellers_array as $key => $value)
                                                            {
                                                            ?>
                                                            <option value="<?php echo $key;?>">
                                                                <?php echo $value;?>
                                                            </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                @endif
                                                
                                                <td>
                                                    <input type="text" class="form-control" id="s_coupon_code" autocomplete="off" placeholder="Coupon Code">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" id="s_title" autocomplete="off" placeholder="Title">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" id="s_min_order_value" autocomplete="off" placeholder="Minimum Order Value">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" id="s_max_discount_value" autocomplete="off" placeholder="Maximum Discount Value">
                                                </td>
                                                
                                                <td>
                                                    <select class="form-control" id="s_status">
                                                        <option value="-1">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                
                                                <td>&nbsp;</td>
                                            
                                            </tr>
                                            <tr role="row" class="heading">.
                                                @if($Auth_User->user_type == 'admin')
                                                    <th>Sellers</th>
                                                @endif
                                                <th>Coupon Code</th>
                                                <th>Title</th>
                                                <th>Minimum Order Value</th>
                                                <th>Maximum Discount Value</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            
                                            </thead>
                                            
                                            <tbody>
                                            
                                            </tbody>
                                        
                                        </table>
                                    
                                    </div>
                                </form>
                            
                            @else
                                
                                <p style="text-align:center; font-weight:bold; padding:50px;">No Records Available</p>
                            
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @endsection
        
        @if($records_exists == 1)
        
        @section('headerInclude')
            @include('datatables.css')
        @endsection
        
        @section('footerInclude')
            @include('datatables.js')
        @endsection
        
        @endif
        
        @push('scripts')
            
            <script>
                
                jQuery(document).ready(function(e) {
                    
                    <?php
                    if($records_exists == 1)
                    {
                    ?>
                    
                    var oTable = $('#myDataTable').DataTable({
                        
                        processing: true,
                        serverSide: true,
                        stateSave: true,
                        searching: false,
                        Filter: true,
                        dom : 'Blfrtip',
                        autoWidth: false,
                        buttons: [
                            /*{
								extend: 'copy',
								exportOptions: {
									columns: ':visible'
								}
							},*/
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            'colvis'
                        ],
                        columnDefs: [ {
                            targets: -1,
                            visible: true
                        }],
                        
                        ajax: {
                            
                            url: "{!! route('svc_coupons_datatable') !!}",
                            data: function (d) {
                                @if($Auth_User->user_type == 'admin')
                                        d.vendor_id = $('#s_seller_id').val();
                                @endif
                                        d.coupon_code = $('#s_coupon_code').val();
                                d.title = $('#s_title').val();
                                d.min_order_value = $('#s_min_order_value').val();
                                d.max_discount_value = $('#s_max_discount_value').val();
                                d.status = $('#s_status').val();
                                
                            }
                            
                        }, columns: [
                                @if($Auth_User->user_type == 'admin')
                            {data: 'seller_id', name: 'seller_id'},
                                @endif
                            {data: 'coupon_code', name: 'coupon_code'},
                            {data: 'title', name: 'title'},
                            {data: 'min_order_value', name: 'min_order_value'},
                            {data: 'max_discount_value', name: 'max_discount_value'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'}
                        ]
                    });
                    
                    $('#data-search-form').on('submit', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    
                    @if($Auth_User->user_type == 'admin')
                    $('#s_seller_id').on('change', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    @endif
                    
                    $('#s_coupon_code').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_title').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_min_order_value').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_max_discount_value').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_status').on('change', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    <?php
                    }
                    ?>
                    
                });
            
            </script>
    
    @endpush
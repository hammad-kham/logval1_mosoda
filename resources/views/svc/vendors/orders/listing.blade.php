<?php
$Auth_User=Auth::User();
?>

@extends('layouts.app')

@section('content')
    
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Orders</h1>
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
                                Orders
                            </li>
                        </ol>
                    </nav>
                </div>
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
                                                        <select class="form-control" id="vendor_id">
                                                            <option value="-1">Select Vendor</option>
                                                            <?php
                                                            foreach($svc_vendor_array as $key => $value)
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
                                                    <select class="form-control" id="s_user_id">
                                                        <option value="-1">Select User</option>
                                                        <?php
                                                        foreach($app_user_data as $key => $value)
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
                                                
                                                <td>
                                                    <select class="form-control" id="s_cat_id">
                                                        <option value="-1">Select Category</option>
                                                        <?php
                                                        foreach($categories as $key => $value)
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
                                                
                                                
                                                <td>
                                                    <input type="number" class="form-control" autocomplete="off" name="price" id="s_price" placeholder="Price">
                                                </td>
                                                
                                                
                                                <td>
                                                    <select class="form-control" id="s_type">
                                                        <option value="-1">Select</option>
                                                        <option value="1">Get A Quote</option>
                                                        <option value="0">Fixed Price</option>
                                                    </select>
                                                </td>


                                                <td>
{{--                                                    <select class="form-control" id="s_status">--}}
{{--                                                        <option value="-1">Select</option>--}}
{{--                                                        <option value="1">Waiting</option>--}}
{{--                                                        <option value="2">Canceled</option>--}}
{{--                                                        <option value="3">Confirmed</option>--}}
{{--                                                        <option value="4">Declined</option>--}}
{{--                                                        <option value="5">Accepted</option>--}}
{{--                                                        <option value="6">Completed</option>--}}
{{--                                                    </select>--}}
                                                </td>
                                                
                                                <td>&nbsp;</td>
                                            
                                            </tr>
                                            
                                            <tr role="row" class="heading">
                                                
                                                @if($Auth_User->user_type == 'admin')
                                                    
                                                    <th>VENDOR</th>
                                                
                                                @endif
                                                
                                                <th>User</th>
                                                
                                                <th>Category</th>
                                                
                                                <th>Order Value</th>
                                                
                                                <th>Type</th>

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
                            
                            url: "{!! route('svc_orders_datatable') !!}",
                            
                            data: function (d) {
                                
                                @if($Auth_User->user_type == 'admin')
                                        d.vendor_name = $('#vendor_id').val();
                                @endif
                                        
                                        d.user_name = $('#s_user_id').val();
                                
                                d.category_title = $('#s_cat_id').val();
                                
                                d.price = $('#s_price').val();
                                
                                d.type = $('#s_type').val();

                                d.status = $('#s_status').val();
                                
                            }
                            
                        }, columns: [
                                
                                @if($Auth_User->user_type == 'admin')
                            {data: 'svc_vendors_name', name: 'svc_vendors_name'},
                                @endif
                            
                            {data: 'app_users_name', name: 'app_users_name'},
                            
                            {data: 'category_title', name: 'category_title'},
                            
                            {data: 'total', name: 'total'},
                            
                            {data: 'type', name: 'type'},

                            {data: 'status', name: 'status'},
                            
                            {data: 'action', name: 'action'}
                        
                        ]
                        
                    });
                    
                    @if($Auth_User->user_type == 'admin')
                    $('#vendor_id').on('change', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    @endif
                    
                    $('#s_user_id').on('change', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    $('#s_cat_id').on('change', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    $('#s_price').on('keyup', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    $('#s_type').on('change', function (e) {
                        
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
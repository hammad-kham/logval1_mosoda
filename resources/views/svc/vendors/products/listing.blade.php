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
                        <h1>Product</h1>
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
                                Products
                            </li>
                        </ol>
                    </nav>
                </div>
                @if(Auth::user()->can('vendor-products-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('products.create') }}">
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
                                                        <select class="form-control" id="s_vend_id">
                                                            <option value="-1">Select Vendor</option>
                                                            <?php
                                                            foreach($vendors as $key => $value)
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
                                                    <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Name">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" id="s_cat_id" autocomplete="off" placeholder="Category">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="s_sub_cat_id" autocomplete="off" placeholder="Sub Category">
                                                </td>
                                                
                                                
                                                <td>
                                                    <select class="form-control" id="s_status">
                                                        <option value="-1">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">In Active</option>
                                                    </select>
                                                </td>
                                                
                                                <td>&nbsp;</td>
                                            
                                            </tr>
                                            
                                            <tr role="row" class="heading">
                                                
                                                @if($Auth_User->user_type == 'admin')
                                                    
                                                    <th>Vendor</th>
                                                
                                                @endif
                                                
                                                <th>Name</th>
                                                
                                                <th>Category</th>
                                                
                                                <th>Sub Category</th>
                                                
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
    
    </section>
    {{-- </div> --}}
    <!-- END Hero -->
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
                    
                    url: "{!! route('svc_products_datatable') !!}",
                    
                    data: function (d) {
                        
                        @if($Auth_User->user_type == 'admin')
                                d.vend_id = $('#s_vend_id').val();
                        @endif
                                
                                d.name = $('#s_name').val();
                        
                        d.cat_id = $('#s_cat_id').val();
                        
                        d.sub_cat_id = $('#s_sub_cat_id').val();
                        
                        d.status = $('#s_status').val();
                        
                    }
                    
                }, columns: [
                        
                        @if($Auth_User->user_type == 'admin')
                    {data: 'vendor_name', name: 'vendor_name'},
                        @endif
                    
                    {data: 'product_name', name: 'product_name'},
                    
                    {data: 'categories_title', name: 'categories_title'},
                    
                    {data: 'sub_categories_title', name: 'sub_categories_title'},
                    
                    {data: 'product_status', name: 'product_status'},
                    
                    {data: 'action', name: 'action'}
                
                ]
                
            });
            
            $('#s_name').on('keyup', function (e) {
                
                oTable.draw();
                
                e.preventDefault();
                
            });
            
            
            $('#s_cat_id').on('keyup', function (e) {
                
                oTable.draw();
                
                e.preventDefault();
                
            });
            
            $('#s_sub_cat_id').on('keyup', function (e) {
                
                oTable.draw();
                
                e.preventDefault();
                
            });
            
            @if($Auth_User->user_type == 'admin')
            $('#s_vend_id').on('change', function (e) {
                
                oTable.draw();
                
                e.preventDefault();
                
            });
            @endif
            
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
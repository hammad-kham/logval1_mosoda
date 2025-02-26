@extends('layouts.app')

@section('content')
    <?php
    $Auth_User = Auth::user();
    ?>
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Vendor Details:  {{ $Model_Data->name }}
                </h1>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('vendors.index') }}">Vendors</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Details
                        </li>
                    </ol>
                </nav>
                
                @if($Auth_User->user_type == 'admin')
                    <a href="{{ route('vendors.index') }}" class="btn btn-primary btn-return pull-right">
                        <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                    </a>
                @endif
            </div>
            @include('flash::message')
        </div>
    </div>
    <!-- END Hero -->
    
    <!-- Page Content -->
    <div class="content">
        @include('coreui-templates::common.errors')
        <div class="block block-rounded block-themed">
            <div class="block-header">
                <div class="card">
                    <div class="card-header">
                        <h4 class="block-title">Basic Details</h4>
                    </div>
                    <div class="card-body">
                        
                        @if(Auth::user()->can('vendors-edit') || Auth::user()->can('all'))
                            <a class="btn btn-primary" href="{{route('vendors.edit',$Model_Data->id)}}" title="Edit Details" style="float: right">
                                Edit details
                            </a>
                            <br><br>
                        @endif
                        
                        <div class="block-content">
                            @include('svc.vendors.show_fields')
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        
        
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="block block-rounded block-themed">
                    
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Contact Details</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
                                @include('svc.vendors.show_contact_details')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-6">
                <div class="block block-rounded block-themed">
                    
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Bank Information</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
    
                                <?php
                                if(isset($BankDetail) && !empty($BankDetail) && count($BankDetail)>0)
                                {
                                ?>
                                @include('svc.vendors.show_bank_details')
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p> No Record Found! </p>
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
        
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="block block-rounded block-themed">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Location</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
                                @include('svc.vendors.show_location_details')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="block block-rounded block-themed">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Orders</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
                                @include('svc.vendors.show_orders')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="block block-rounded block-themed">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Reviews</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
                                @include('svc.vendors.show_reviews')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="block block-rounded block-themed">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="block-title">Availabilities</h4>
                        </div>
                        <div class="card-body">
                            
                            <div class="block-content">
                                <?php
                                if(isset($WorkingHours) && !empty($WorkingHours))
                                {
                                ?>
                                @include('svc.vendors.show_working_hours')
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p> No Record Found! </p>
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
    
    
    </div>
    
    
    
    
    
    <!-- END Page Content -->
@endsection

@section('headerInclude')
    @include('datatables.css')
@endsection

@section('footerInclude')
    @include('datatables.js')
@endsection

@push('scripts')
    
    
    <script>
        
        jQuery(document).ready(function(e) {
            
            <?php
            if($UserOrders_exists == 1)
            {
            ?>
            
            var oTable2 = $('#myDataTable2').DataTable({
                
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
                    url: "{!! route('vendor_order_datatable', $Model_Data->id) !!}",
                    data: function (d) {
                        d.order_no = $('#s_order_no_2').val();
                        d.order_value = $('#s_order_value').val();
                        d.order_status = $('#s_order_status').val();
                    }
                }, columns: [
                    {data: 'order_no', name: 'order_no'},
                    {data: 'order_value', name: 'order_value'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
            
            $('#s_order_no_2').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            
            
            $('#s_order_value').on('keyup', function (e) {
                oTable2.draw();
                e.preventDefault();
            });
            
            
            $('#s_order_status').on('change', function (e) {
                oTable2.draw();
                e.preventDefault();
            });
            <?php
            }
            if($UserReviews_exists == 1)
            {
            ?>
            
            var oTable3 = $('#myDataTable3').DataTable({
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
                    url: "{!! route('vendor_review_datatable', $Model_Data->id) !!}",
                    data: function (d) {
                        d.order_no = $('#s_order_no').val();
                        d.rating = $('#s_rating').val();
                        d.review = $('#s_review').val();
                        d.badword = $('#s_badword').val();
                        d.status = $('#s_status').val();
                    }
                }, columns: [
                    {data: 'order_no', name: 'order_no'},
                    {data: 'rating', name: 'rating'},
                    {data: 'review', name: 'review'},
                    {data: 'badwords_found', name: 'badwords_found'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
            
            $('#s_order_no').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            
            $('#s_rating').on('keyup', function (e) {
                oTable3.draw();
                e.preventDefault();
            });
            
            $('#s_review').on('keyup', function (e) {
                oTable3.draw();
                e.preventDefault();
            });
            
            $('#s_badword').on('change', function (e) {
                oTable3.draw();
                e.preventDefault();
            });
            
            $('#s_status').on('change', function (e) {
                oTable3.draw();
                e.preventDefault();
            });
            <?php
            }
            ?>
        });
    
    </script>


    @include('common.map_js')

@endpush

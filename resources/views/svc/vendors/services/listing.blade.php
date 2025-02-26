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
						<h1>Vendor Services</h1>
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
								Vendor Services
							</li>
						</ol>
					</nav>
				</div>
				@if(Auth::user()->can('vendor-services-add') || Auth::user()->can('all'))
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
						<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('vendor-services.create') }}">
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
															<option value="-1">Select vendor</option>
															<?php
															foreach($vendors_array as $key => $value)
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
													<input type="text" class="form-control" id="s_service_id" autocomplete="off" placeholder="Service">
												</td>
												
												
												<td>
													<input type="text" class="form-control" id="s_sub_service_id" autocomplete="off" placeholder="Sub Service">
												</td>
												
												
												<td>
													<input type="text" class="form-control" id="s_price" autocomplete="off" placeholder="Starting Price">
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
												
												<th>Services</th>
												
												<th>Sub Services</th>
												
												<th>Starting Price</th>
												
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

                            url: "{!! route('svc_vendor_services_datatable') !!}",

                            data: function (d) {
								
								@if($Auth_User->user_type == 'admin')
                                    d.vendor_id = $('#s_vend_id').val();
								@endif

                                    d.service_id = $('#s_service_id').val();

                                d.sub_service_id = $('#s_sub_service_id').val();

                                d.price = $('#s_price').val();

                                d.status = $('#s_status').val();

                            }

                        }, columns: [
								
								@if($Auth_User->user_type == 'admin')
                            {data: 'vend_name', name: 'vend_name'},
								@endif

                            {data: 'service_title', name: 'service_title'},

                            {data: 'sub_services_title', name: 'sub_services_title'},

                            {data: 'vend_ser_price', name: 'vend_ser_price'},

                            {data: 'vendor_services_status', name: 'vendor_services_status'},

                            {data: 'action', name: 'action'}

                        ]

                    });
					
					
					@if($Auth_User->user_type == 'admin')
                    $('#s_vend_id').on('change', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });
					@endif

                    $('#s_service_id').on('keyup', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_sub_service_id').on('keyup', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_price').on('keyup', function (e) {

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
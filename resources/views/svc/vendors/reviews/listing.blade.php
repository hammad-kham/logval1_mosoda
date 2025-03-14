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
						<h1>Review</h1>
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
								Reviews
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
														<select class="form-control" id="s_vendor_id">
															<option value="-1">Select Vendor</option>
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
													<input type="text" class="form-control" id="s_order_no" autocomplete="off" placeholder="Order No.">
												</td>
												
												<td>
													<input type="number" class="form-control" id="s_rating" autocomplete="off" placeholder="Rating">
												</td>
												
												<td>
													<select class="form-control" id="s_badwords">
														<option value="-1">Select</option>
														<option value="1">Found</option>
														<option value="0">Not Found</option>
													</select>
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
												
												<th>Order No.</th>
												
												<th>Rating</th>
												
												<th>Bad Words</th>
												
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

                            url: "{!! route('svc_reviews_datatable') !!}",

                            data: function (d) {
								
								@if($Auth_User->user_type == 'admin')
                                    d.vendor_id = $('#s_vendor_id').val();
								@endif

                                    d.order_no = $('#s_order_no').val();

                                d.search_rating = $('#s_rating').val();

                                d.badwords = $('#s_badwords').val();

                                d.status = $('#s_status').val();

                            }

                        }, columns: [
								
								@if($Auth_User->user_type == 'admin')
                            {data: 'vendor_name', name: 'vendor_name'},
								@endif

                            {data: 'order_no', name: 'order_no'},

                            {data: 'rating', name: 'rating'},

                            {data: 'bad_word', name: 'bad_word'},

                            {data: 'status', name: 'status'},

                            {data: 'action', name: 'action'}

                        ]

                    });
					
					@if($Auth_User->user_type == 'admin')
                    $('#s_vendor_id').on('change', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });
					@endif

                    $('#s_order_no').on('keyup', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_rating').on('keyup', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_badwords').on('change', function (e) {

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
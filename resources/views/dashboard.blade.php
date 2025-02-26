@extends('layouts.app')

@section('content')
	<?php
	$Auth_User=Auth::User();
	?>
	<section class="section">
		<div class="section-header">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					<div class="section-header-breadcrumb-content">
						<h1>Dashboard</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="section-body">
			@include('flash::message')

			@if(($Auth_User->user_type == 'admin' || $Auth_User->user_type == 'vendor') && ($Auth_User->can('vendor-orders-listing') || $Auth_User->can('all')))
				<div class="card">
					<div class="card-header">
						<h4>
							@if($Auth_User->user_type == 'admin')Services on Demand: @endif
							Today's Orders
						</h4>
					</div>
					<div class="card-body">

						<form method="post" role="form" id="data-search-form">

							<div class="table-responsive">

								<table class="table table-striped table-hover"  id="myDataTable_svc_orders">

									<thead>


									<tr role="row" class="heading">


										@if($Auth_User->user_type == 'admin')
											<td>
												<select class="form-control" id="vendor_id_s">
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
											<select class="form-control" id="s_user_id_s">
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
											<select class="form-control" id="s_cat_id_s">
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
											<input type="number" class="form-control" autocomplete="off" name="price_s" id="s_price_s" placeholder="Price">
										</td>

										<td>
											<select class="form-control" id="s_type_s">
												<option value="-1">Select</option>
												<option value="1">Get A Quote</option>
												<option value="0">Fixed Price</option>
											</select>
										</td>

										<td>
											{{--                                            <select class="form-control" id="s_status_s">--}}
											{{--                                                <option value="-1">Select</option>--}}
											{{--                                                <option value="1">Waiting</option>--}}
											{{--                                                <option value="2">Canceled</option>--}}
											{{--                                                <option value="3">Confirmed</option>--}}
											{{--                                                <option value="4">Declined</option>--}}
											{{--                                                <option value="5">Accepted</option>--}}
											{{--                                                <option value="6">Completed</option>--}}
											{{--                                            </select>--}}
										</td>

										<td>&nbsp;</td>

									</tr>

									<tr role="row" class="heading">

										@if($Auth_User->user_type == 'admin')

											<th>VENDOR</th>

										@endif

										<th>USER</th>

										<th>Category</th>

										<th>ORDER VALUE</th>

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

					</div>
				</div>
			@endif

		

			@if(($Auth_User->user_type == 'admin') && ($Auth_User->can('users-listing') || $Auth_User->can('all')))
				<div class="card">
					<div class="card-header">
						<h4>Signup Applications</h4>
					</div>
					<div class="card-body">

						<form method="post" role="form" id="data-search-form">

							<div class="table-responsive">

								<table class="table table-striped table-hover"  id="myDataTable_users">

									<thead>

									<tr role="row" class="heading">

										<td>
											<input type="text" class="form-control" id="s_name_u" autocomplete="off" placeholder="Name">
										</td>

										<td>
											<input type="text" class="form-control" id="s_email_u" autocomplete="off" placeholder="Email">
										</td>

										<td>
											<input type="text" class="form-control" id="s_phone_u" autocomplete="off" placeholder="Phone">
										</td>

										<td>
											<select class="form-control" id="s_status_u">
												<option value="-1">Select</option>
												<option value="0">Inactive</option>
												<option value="1">Active</option>
											</select>
										</td>

										<td>
											<select class="form-control" id="s_application_status_u">
												<option value="-1">Select</option>
												<option value="0">No Application</option>
												<option value="1">Application Received</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="s_approval_status_u">
												<option value="-1">Select</option>
												<option value="0">Pending</option>
												<option value="1">Approved</option>
												<option value="2">Rejected</option>

											</select>
										</td>

										<td>&nbsp;</td>

									</tr>

									<tr role="row" class="heading">

										<th>Name</th>

										<th>Email</th>

										<th>Phone</th>

										<th>Status</th>

										<th>Application</th>

										<th>Approval</th>

										<th>Action</th>

									</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>
						</form>

					</div>
				</div>
			@endif
		</div>
	</section>

@endsection

@section('headerInclude')
	@include('datatables.css')
@endsection

@section('footerInclude')
	@include('datatables.js')
@endsection

@push('scripts')
	<style>
		.form-inline
		{
			display:block;
		}
		.table-responsive> .row
		{
			display:block;
		}
		.dataTables_length{
			float:left;
		}
		.dataTables_filter{
			float:right;
		}
	</style>
	<script>
		jQuery(document).ready(function(e)
		{
			@if(($Auth_User->user_type == 'admin' || $Auth_User->user_type == 'vendor') && ($Auth_User->can('vendor-orders-listing') || $Auth_User->can('all')))

			var oTable = $('#myDataTable_svc_orders').DataTable(
					{
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

							url: "{!! route('svc_orders_dashboard_datatable') !!}",

							data: function (d) {

								@if($Auth_User->user_type == 'admin')
										d.vendor_name = $('#vendor_id_s').val();
								@endif

										d.user_name = $('#s_user_id_s').val();

								d.category_title = $('#s_cat_id_s').val();

								d.price = $('#s_price_s').val();

								d.type = $('#s_type_s').val();

								d.status = $('#s_status_s').val();

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
			$('#vendor_id_s').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});
			@endif

			$('#s_user_id_s').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_cat_id_s').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_price_s').on('keyup', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_type_s').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_status_s').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			@endif











			@if(($Auth_User->user_type == 'admin') && ($Auth_User->can('users-listing') || $Auth_User->can('all')))

			var oTable = $('#myDataTable_users').DataTable(
					{

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

							url: "{!! route('users_dashboard_datatable') !!}",

							data: function (d) {

								d.name = $('#s_name_u').val();

								d.email = $('#s_email_u').val();

								d.phone = $('#s_phone_u').val();

								d.status = $('#s_status_u').val();

								d.application_status = $('#s_application_status_u').val();

								d.approval_status = $('#s_approval_status_u').val();

							}

						}, columns: [

							{data: 'name', name: 'name'},

							{data: 'email', name: 'email'},

							{data: 'phone', name: 'phone'},

							{data: 'status', name: 'status'},

							{data: 'application_status', name: 'application_status'},

							{data: 'approval_status', name: 'approval_status'},

							{data: 'action', name: 'action'}

						]

					});

			$('#s_name_u').on('keyup', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_email_u').on('keyup', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_phone_u').on('keyup', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_status_u').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_application_status_u').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			$('#s_approval_status_u').on('change', function (e) {

				oTable.draw();

				e.preventDefault();

			});

			@endif
		});

	</script>
@endpush

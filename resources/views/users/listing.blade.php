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
                        <h1>Users</h1>
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
                                Users
                            </li>
                        </ol>
                    </nav>
                </div>
    
                @if(Auth::user()->can('users-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a href="{{url('/users/create')}}" class="btn btn-icon icon-left btn-primary pull-right">
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

                                                <td>
                                                    <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Name">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control" id="s_email" autocomplete="off" placeholder="Email">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control" id="s_phone" autocomplete="off" placeholder="Phone">
                                                </td>

                                                <td>
                                                    <select class="form-control" id="s_status">
                                                        <option value="-1">Select</option>
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </td>
													
                                                @if($Auth_User->user_type == 'admin')
                                                <td>
                                                    <select class="form-control" id="s_application_status">
                                                        <option value="-1">Select</option>
                                                        <option value="0">No Application</option>
                                                        <option value="1">Application Received</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="s_approval_status">
                                                        <option value="-1">Select</option>
                                                        <option value="0">Pending</option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Rejected</option>

                                                    </select>
                                                </td>
                                                @endif

                                                <td>&nbsp;</td>

                                            </tr>

                                            <tr role="row" class="heading">

                                                <th>Name</th>

                                                <th>Email</th>

                                                <th>Phone</th>

                                                <th>Status</th>

                                                @if($Auth_User->user_type == 'admin')
                                                    <th>Application</th>
    
                                                    <th>Approval</th>
                                                @endif

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
@endsection

@if($records_exists == 1)

    @section('headerInclude')
        @include('datatables.css')
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

                    url: "{!! route('users_datatable') !!}",

                    data: function (d) {

                        d.name = $('#s_name').val();

                        d.email = $('#s_email').val();

                        d.phone = $('#s_phone').val();

                        d.status = $('#s_status').val();
					
						@if($Auth_User->user_type == 'admin')
                        d.application_status = $('#s_application_status').val();

                        d.approval_status = $('#s_approval_status').val();
						@endif

                    }

                }, columns: [

                    {data: 'name', name: 'name'},

                    {data: 'email', name: 'email'},

                    {data: 'phone', name: 'phone'},

                    {data: 'status', name: 'status'},
					
					@if($Auth_User->user_type == 'admin')
                    {data: 'application_status', name: 'application_status'},

                    {data: 'approval_status', name: 'approval_status'},
					@endif

                    {data: 'action', name: 'action'}

                ]

            });

            $('#data-search-form').on('submit', function (e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_name').on('keyup', function (e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_email').on('keyup', function (e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_phone').on('keyup', function (e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_status').on('change', function (e) {

                oTable.draw();

                e.preventDefault();

            });

			@if($Auth_User->user_type == 'admin')
				$('#s_application_status').on('change', function (e) {
	
					oTable.draw();
	
					e.preventDefault();
	
				});
	
				$('#s_approval_status').on('change', function (e) {
	
					oTable.draw();
	
					e.preventDefault();
	
				});
			@endif

            <?php

            }

            ?>



        });

    </script>
@endpush
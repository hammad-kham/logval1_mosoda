@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Email Templates</h1>
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
                                Email Templates
                            </li>
                        </ol>
                    </nav>
                </div>
                <?php /*?>@if(Auth::user()->can('templates-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('templates.create') }}">
                            <i class="fa fa-plus-square fa-lg"></i> Add New
                        </a>
                    </div>
                @endif<?php */?>
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
                                                    <input type="text" class="form-control" id="s_title" autocomplete="off" placeholder="Title">
                                                </td>

                                                <td>
                                                    <select class="form-control" id="s_type">
                                                        <option value="-1">Select</option>
                                                        <option value="1">SMS</option>
                                                        <option value="2">Email</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <select class="form-control" id="s_type_for">
                                                        <option value="-1">Select</option>
                                                        <option value="1">SoD Fixed Orders</option>
                                                        <option value="2">SoD Request Quotation</option>
                                                        <option value="3">Ecommerce Orders</option>
                                                    </select>
                                                </td>

                                                <td>&nbsp;</td>

                                            </tr>

                                            <tr role="row" class="heading">

                                                <th>Title</th>

                                                <th>Type</th>

                                                <th>For</th>

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

                            url: "{!! route('templates_datatable') !!}",

                            data: function (d) {

                                d.title = $('#s_title').val();

                                d.type = $('#s_type').val();

                                d.type_for = $('#s_type_for').val();

                            }

                        }, columns: [

                            {data: 'title', name: 'title'},

                            {data: 'type', name: 'type'},

                            {data: 'type_for', name: 'type_for'},

                            {data: 'action', name: 'action'}

                        ]

                    });

                    $('#data-search-form').on('submit', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_title').on('keyup', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_type').on('change', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

                    $('#s_type_for').on('change', function (e) {

                        oTable.draw();

                        e.preventDefault();

                    });

				<?php

				}

				?>



			});

		</script>

            <script>

                $(document).on('click', '.btnActive', function()
                {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: '{{url("templates/deactivate")}}/'+id,
                        type: 'GET',
                        success: function (result) {
                            if(result==true)  {
                                location.href = "{{url("templates/index")}}";
                                console.log("true");
                            }

                        }
                    });
                });
                $(document).on('click', '.btnInActive', function()
                {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: '{{url("templates/activate")}}/'+id,
                        type: 'GET',
                        success: function (result) {
                            //console.log();
                            if(result==true)  {
                                console.log("true");
                            }
                        }
                    });

                });
                /*
                $( document ).ready(function() {
                    //var id = $(this).attr("id");
                    var table=$("#templates-table").DataTable();
                    table.column(3).visible( true );


                });
                */
            </script>
            <script>
                jQuery(document).ready(function(e) {
                    if(jQuery('.btn_close_modal'))
                    {
                        jQuery('.btn_close_modal').click(function(e) {
                            $('#createModal').modal('hide');
                        });
                    }
                });
            </script>
    @endpush
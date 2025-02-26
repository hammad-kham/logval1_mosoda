@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>App User Queries</h1>
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
                                App User Queries
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

                                                <td>
                                                    <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Name">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control" id="s_subject" autocomplete="off" placeholder="Subject">
                                                </td>

                                                <td>
                                                    <select class="form-control" id="s_status">
                                                        <option value="-1">Select</option>
                                                        <option value="1">Replied</option>
                                                        <option value="0">Pending</option>
                                                    </select>
                                                </td>

                                                <td>&nbsp;</td>

                                            </tr>

                                            <tr role="row" class="heading">

                                                <th>Name</th>

                                                <th>Subject</th>

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

                            url: "{!! route('app_user_queries_datatable') !!}",

                            data: function (d) {

                                d.name = $('#s_name').val();

                                d.subject = $('#s_subject').val();

                                d.status = $('#s_status').val();

                            }

                        }, columns: [

                            {data: 'name', name: 'name'},

                            {data: 'subject', name: 'subject'},

                            {data: 'status', name: 'status'},

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

                    $('#s_subject').on('keyup', function (e) {

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

            <script>

                $(document).on('click', '.btnActive', function()
                {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: '{{url("app-pages/deactivate")}}/'+id,
                        type: 'GET',
                        success: function (result) {
                            if(result==true)  {
                                location.href = "{{url("app_pages/index")}}";
                                console.log("true");
                            }

                        }
                    });
                });
                $(document).on('click', '.btnInActive', function()
                {
                    var id = $(this).attr("id");

                    $.ajax({
                        url: '{{url("app-pages/activate")}}/'+id,
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
                    var table=$("#app_pages-table").DataTable();
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
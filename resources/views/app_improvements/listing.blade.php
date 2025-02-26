@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>App Improvements</h1>
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
                                AppImprovements
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
                                                    <input type="text" class="form-control" id="s_user" autocomplete="off" placeholder="User">
                                                </td>

                                                <td>
                                                    <select class="form-control" id="s_status">
                                                        <option value="-1">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </td>                                    

                                                <td>&nbsp;</td>

                                            </tr>

                                            <tr role="row" class="heading">

                                                <th>User</th>

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

                        url: "{!! route('app_improvements_datatable') !!}",

                        data: function (d) {

                            d.user = $('#s_user').val();

                            d.status = $('#s_status').val();                          

                        }

                    }, columns: [

                        {data: 'user_name', name: 'user_name'},

                        {data: 'status', name: 'status'},

                        {data: 'action', name: 'action'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    oTable.draw();

                    e.preventDefault();

                });

                $('#s_user').on('keyup', function (e) {

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
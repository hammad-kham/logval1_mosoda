@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>App Labels</h1>
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
                                App Labels
                            </li>
                        </ol>
                    </nav>
                </div>
                @if(Auth::user()->can('app-labels-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="#" data-toggle="modal" data-target="#createModal">
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
                                                    <input type="text" class="form-control" id="s_title" autocomplete="off" placeholder="Title">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control" id="s_ar_title" autocomplete="off" placeholder="Title">
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

                                                <th>Title [En]</th>

                                                <th>Title [Ar]</th>

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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
         aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content card card-primary">
                <div class="card-header">
                    <h4>Add New</h4>
                    <div class="card-header-action">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => 'app-labels.store','files' => true]) !!}

                    <div class="block-content fs-sm">
                        @include('app_labels.fields')

                        <div class="row">
                            <div class=" form-group col-12 text-right">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </div>


                    </div>

                    {!! Form::close() !!}

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

                    url: "{!! route('app_labels_datatable') !!}",

                    data: function (d) {

                        d.title = $('#s_title').val();

                        d.ar_title = $('#s_ar_title').val();

                        d.status = $('#s_status').val();

                    }

                }, columns: [

                    {data: 'title', name: 'title'},

                    {data: 'ar_title', name: 'ar_title'},

                    {data: 'status', name: 'status'},

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

            $('#s_ar_title').on('keyup', function (e) {

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
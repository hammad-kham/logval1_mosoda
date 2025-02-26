@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Vendors
                </h1>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Vendors
                        </li>
                    </ol>
                </nav>
{{--                @if(Auth::user()->can('vendors-add') || Auth::user()->can('all'))--}}
{{--                    <a href="{{ route('vendors.create') }}" class="btn btn-primary btn-add-new pull-right">--}}
{{--                        <i class="fa fa-plus-square fa-lg"></i> Add New--}}
{{--                    </a>--}}
{{--                @endif--}}
            </div>
            @include('flash::message')
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded block-themed">
            <div class="block-content">

                <div class="card">
                    <div class="card-body">
                        @if($records_exists == 1)

                            <form method="post" role="form" id="data-search-form">

                                <div class="table-responsive">

                                    <table class="table table-striped table-hover" id="myDataTable">

                                        <thead>

                                        <tr role="row" class="heading">

                                            <td>
                                                <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Name">
                                            </td>

                                            <td>
                                                <select class="form-control" id="s_status">
                                                    <option value="-1">Select</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </td>

                                            <td>
                                                <select class="form-control" id="s_is_featured">
                                                    <option value="-1">Select</option>
                                                    <option value="1">Is Featured</option>
                                                    <option value="0">Not Featured</option>
                                                </select>
                                            </td>

                                            <td>&nbsp;</td>

                                        </tr>

                                        <tr role="row" class="heading">

                                            <th>Name</th>

                                            <th>Status</th>

                                            <th>Is Featured</th>

                                            <th>Actions</th>

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
    <!-- END Page Content -->
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
    <style>
        .btn-sm {
            margin-left: 35%;
        }

    </style>

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

                dom: 'Blfrtip',

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

                    url: "{!! route('svc_vendors_datatable') !!}",

                    data: function(d) {

                        d.name = $('#s_name').val();

                        d.status = $('#s_status').val();

                        d.is_featured = $('#s_is_featured').val();

                    }

                },
                columns: [

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'is_featured',
                        name: 'is_featured'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }

                ]

            });

            $('#data-search-form').on('submit', function(e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_name').on('keyup', function(e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_status').on('change', function(e) {

                oTable.draw();

                e.preventDefault();

            });

            $('#s_is_featured').on('change', function(e) {

                oTable.draw();

                e.preventDefault();

            });

            <?php

            }

            ?>



        });

    </script>
    

@endpush

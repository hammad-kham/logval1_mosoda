@extends('layouts.app')

@section('content')
<?php
$AUTH_USER = Auth::user();
?>
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Reward Discount Types</h1>
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
                            Reward Discount Types
                        </li>
                    </ol>
                </nav>
            </div>
            @if(Auth::user()->can('categories-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('/service/reward_discount_type/create') }}">
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
                                    <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Name [En]">
                                    </td>                                                 

                                    <td>
                                    <input type="text" class="form-control" id="s_name_ar" autocomplete="off" placeholder="Name [Ar]">
                                    </td>
                                    
                                    <td>&nbsp;</td>

                                </tr>

                                <tr role="row" class="heading">

                                    <th>Name [En]</th>

                                    <th>Name [Ar]</th>

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

                url: "{!! url('reward-discount-types/datatable') !!}",

                data: function (d) {  

                    d.name = $('#s_name').val(); 

                    d.name_ar = $('#s_name_ar').val(); 
                    
                }

            }, columns: [

                {data: 'name', name: 'name'},

                {data: 'name_ar', name: 'name_ar'},

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

        $('#s_name_ar').on('keyup', function (e) {

            oTable.draw();

            e.preventDefault();

        });

    <?php

}

?>

    if(jQuery('.btn_close_modal'))
    {
        jQuery('.btn_close_modal').click(function(e) {
            $('#createModal').modal('hide');
        });
    }
});
</script>

@endpush
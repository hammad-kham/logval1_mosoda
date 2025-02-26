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
                    <h1>Rewards</h1>
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
                            Rewards
                        </li>
                    </ol>
                </nav>
            </div>
            @if(Auth::user()->can('rewards-add') || Auth::user()->can('all'))
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('service/rewards/create') }}">
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

                                <table class="table table-striped table-hover" id="myDataTable">

                                    <thead>
                                        @if($AUTH_USER->vendor_id==0)
                                        <tr role="row" class="heading">
                                          
                                         

                                            
                                            <td>
                                                <input type="number" class="form-control" id="s_silver" autocomplete="off" placeholder="Silver Punches">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="s_golden" autocomplete="off" placeholder="Golden Punches">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="s_platinum" autocomplete="off" placeholder="Platinum Punches">
                                            </td>
                                           
                                                    
                                            <td>
                                                <input type="number" class="form-control" id="s_min_order_value" autocomplete="off" placeholder="Min Order Value">
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
                                            <th>Silver Punches</th>
                                            
                                            <th>Golden Punches</th>
                                            
                                            <th>Platinum Punches</th>
                                            
                                           
                                            <th>Min Order Value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>

                                        @elseif($AUTH_USER->vendor_id>0)
                                        <tr role="row" class="heading">

                                            <td>
                                                <select class="form-control" id="s_type">
                                                    <option value="-1">Select</option>
                                                    <?php
                                                    foreach ($reward_types as $key => $value) {
                                                    ?>
                                                        <option value="<?php echo $key; ?>">
                                                            <?php echo $value; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>


                                            <td>
                                                <input type="number" class="form-control" id="s_silver" autocomplete="off" placeholder="Min Punches">
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="number" class="form-control" id="s_min_order_value" autocomplete="off" placeholder="Min Punch Value">
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
                                            <th>Reward</th>
                                            <th>Min Punches</th>
                                            <th>Min Punch Value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @endif
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

        if ($records_exists == 1) {
            if ($AUTH_USER->vendor_id == 0) {
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
                    columnDefs: [{
                        targets: -1,
                        visible: true
                    }],

                    ajax: {

                        url: "{!! route('rewards_datatable') !!}",
                        data: function(d) {
                            d.vendor_id = $('#s_vendor_id').val();
                           // d.discount_type = $('#s_discount_type_id').val();
                           // d.type = $('#s_type').val();
                            d.silver_punches = $('#s_silver').val();
                            d.golden_punches = $('#s_golden').val();
                            d.platinum_punches = $('#s_platinum').val();
                            d.min_order_value = $('#s_min_order_value').val();
                           // d.discount_type = $('#s_discount_type_id').val();
                            <?php /*?>d.approval = $('#s_approval').val();<?php */ ?>
                            d.status = $('#s_status').val();
                        }
                    },
                    columns: [
                        
                        {
                            data: 'silver_punches',
                            name: 'silver_punches'
                        },
                      
                        {
                            data: 'golden_punches',
                            name: 'golden_punches'
                        },
                        
                        {
                            data: 'platinum_punches',
                            name: 'platinum_punches'
                        },
                       
                        {
                            data: 'min_order_value',
                            name: 'min_order_value'
                        },
                      
                        {
                            data: 'status',
                            name: 'status'
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

                // $('#s_vendor_id').on('change', function(e) {
                //     oTable.draw();
                //     e.preventDefault();
                // });
              

                // $('#s_type').on('change', function(e) {
                //     oTable.draw();
                //     e.preventDefault();
                // });

                <?php /*?>$('#s_approval').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });<?php */ ?>

                $('#s_status').on('change', function(e) {
                    oTable.draw();
                    e.preventDefault();
                });



                $('#s_min_order_value').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });
                $('#s_silver').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });
                $('#s_golden').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });
                $('#s_platinum').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });
            <?php  } elseif ($AUTH_USER->vendor_id > 0) {
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
                    columnDefs: [{
                        targets: -1,
                        visible: true
                    }],

                    ajax: {
                        url: "{!! route('rewards_datatable') !!}",
                        data: function(d) {

                            d.type = $('#s_type').val();
                            d.min_order = $('#s_min_order').val();
                            d.min_order_value = $('#s_min_order_value').val();
                            d.status = $('#s_status').val();
                        }
                    },
                    columns: [{
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'min_no_of_punches',
                            name: 'min_no_of_punches'
                        },
                        {
                            data: 'min_order_value',
                            name: 'min_order_value'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });

                $('#data-search-form').on('submit', function(e) {
                    oTable.draw();
                    e.preventDefault();
                });

                $('#s_type').on('change', function(e) {
                    oTable.draw();
                    e.preventDefault();
                });


                $('#s_min_order').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });


                $('#s_min_order_value').on('keyup', function(e) {

                    oTable.draw();

                    e.preventDefault();

                });

                $('#s_status').on('change', function(e) {
                    oTable.draw();
                    e.preventDefault();
                });

        <?php
            }
        }
        ?>
    });
</script>

@endpush
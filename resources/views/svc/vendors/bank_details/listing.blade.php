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
                        <h1>Vendor Bank Details</h1>
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
                                Vendor Bank Details
                            </li>
                        </ol>
                    </nav>
                </div>
                
                @if(Auth::user()->can('vendor-bank-details-add') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('vendor-bank-details.create') }}">
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
                                            @if($Auth_User->user_type == 'admin')
                                                <tr role="row" class="heading">
                                                    <td>
                                                        <select class="form-control js-select2 form-select rest_select2" id="s_vend_id">
                                                            <option value="-1">Select</option>
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
                                                    <?php /*?><td>
                                <input type="text" class="form-control" id="s_company_name" autocomplete="off" placeholder="Company Name">
                            </td><?php */?>
                                                    <td>
                                                        <input type="text" class="form-control" id="s_bank_name" autocomplete="off" placeholder="Bank">
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="text" class="form-control" id="s_account_no" autocomplete="off" placeholder="Account#">
                                                    </td>
                                                    <?php /*?><td>&nbsp;</td><?php */?>
                                                    <td>
                                                        <select class="form-control" id="s_status">
                                                            <option value="-1">Select</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </td>
                                                    <?php /*?><td>
                                <select class="form-control" id="s_approval">
                                    <option value="-1">Select</option>
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            </td><?php */?>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr role="row" class="heading">
                                                    <th>Vendors</th>
                                                    <?php /*?><th>Company Name</th><?php */?>
                                                    <th>Bank</th>
                                                    <?php /*?><th>Tax Reg#</th><?php */?>
                                                    <th>Account#</th>
                                                    <?php /*?><th>Address</th>
                            <th>Swift Code</th>
                            <th>Iban</th><?php */?>
                                                    <th>Status</th>
                                                    <?php /*?><th>Approval</th><?php */?>
                                                    <th>Action</th>
                                                </tr>
                                            @elseif($Auth_User->user_type == 'vendor')
                                                <tr role="row" class="heading">
                                                    <td>
                                                        <input type="text" class="form-control" id="s_company_name" autocomplete="off" placeholder="Company Name">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="s_bank_name" autocomplete="off" placeholder="Bank">
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="text" class="form-control" id="s_account_no" autocomplete="off" placeholder="Account#">
                                                    </td>
                                                    <?php /*?> <td>&nbsp;</td><?php */?>
                                                    <td>
                                                        <select class="form-control" id="s_status">
                                                            <option value="-1">Select</option>
                                                            <option value="1">Default Account</option>
                                                            <option value="0">Others</option>
                                                        </select>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr role="row" class="heading">
                                                    <th>Company Name</th>
                                                    <th>Bank</th>
                                                    <?php /*?><th>Tax Reg#</th><?php */?>
                                                    <th>Account#</th>
                                                    <?php /*?><th>Address</th>
                            <th>Swift Code</th>
                            <th>Iban</th><?php */?>
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
                    if($Auth_User->user_type == 'admin'){
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
                            
                            url: "{!! route('svc_vendor_bank_details_datatable') !!}",
                            data: function (d) {
                                d.vend_id = $('#s_vend_id').val();
                                d.bank_name = $('#s_bank_name').val();
                                <?php /*?>d.company_name = $('#s_company_name').val();<?php */?>
                                        d.account_number = $('#s_account_no').val();  //change    no to number on first
                                d.status = $('#s_status').val();
                                <?php /*?> d.approval = $('#s_approval').val();<?php */?>
                                
                            }
                            
                        }, columns: [
                            {data: 'vend_id', name: 'vend_id'},
                                <?php /*?>{data: 'company_name', name: 'company_name'},<?php */?>
                            {data: 'bank_name', name: 'bank_name'},
                                <?php /*?>{data: 'tax_reg_no', name: 'tax_reg_no'},<?php */?>
                            {data: 'account_number', name: 'account_number'},
                                <?php /*?>{data: 'address', name: 'address'},
            {data: 'iban', name: 'iban'},
             {data: 'swift_code', name: 'swift_code'},<?php */?>
                            {data: 'status', name: 'status'},
                                <?php /*?>{data: 'approval', name: 'approval'},<?php */?>
                            {data: 'action', name: 'action'}
                        ]
                    });
                    
                    $('#data-search-form').on('submit', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    <?php /*?>$('#s_company_name').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });<?php */?>
                    
                    $('#s_bank_name').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_account_no').on('keyup', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_vend_id').on('change', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    $('#s_status').on('change', function (e) {
                        oTable.draw();
                        e.preventDefault();
                    });
                    
                    <?php /*?>$('#s_approval').on('change', function (e) {

                oTable.draw();

                e.preventDefault();

            });<?php */?>
                    <?php
                    }
                    elseif($Auth_User->user_type == 'vendor')
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
                            
                            url: "{!! route('svc_vendor_bank_details_datatable') !!}",
                            
                            data: function (d) {
                                d.company_name = $('#s_company_name').val();
                                
                                d.bank_name = $('#s_bank_name').val();
                                
                                d.account_number = $('#s_account_no').val();     //change first       no to number
                                
                                d.status = $('#s_status').val();
                            }
                            
                        }, columns: [
                            
                            {data: 'company_name', name: 'company_name'},
                            {data: 'bank_name', name: 'bank_name'},
                                <?php /*?>{data: 'tax_reg_no', name: 'tax_reg_no'},<?php */?>
                            {data: 'account_number', name: 'account_number'},
                                <?php /*?>{data: 'address', name: 'address'},
              {data: 'iban', name: 'iban'},
               {data: 'swift_code', name: 'swift_code'},<?php */?>
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action'}
                        ]
                        
                    });
                    
                    $('#data-search-form').on('submit', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    $('#s_company_name').on('keyup', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    $('#s_bank_name').on('keyup', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    
                    
                    $('#s_account_no').on('keyup', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    $('#s_status').on('change', function (e) {
                        
                        oTable.draw();
                        
                        e.preventDefault();
                        
                    });
                    
                    <?php /*?>$('#s_approval').on('change', function (e) {

                oTable.draw();

                e.preventDefault();

            });<?php */?>
                    
                    <?php
                    }
                    }
                    
                    ?>
                    
                });
            
            </script>
    
    @endpush
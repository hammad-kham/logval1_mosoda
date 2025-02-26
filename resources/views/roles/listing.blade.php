@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Roles</h1> 
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
                            Roles
                        </li>
                    </ol>
                </nav>
            </div>
    
            @if(Auth::user()->can('roles-add') || Auth::user()->can('all'))
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
                                                <select class="form-control" id="s_display_to">
                                                    <option value="-1">Select</option>
                                                    <option value="0">For Admin Users Only</option>
                                                    <option value="1">For Vendor Users Only</option>
                                                    <option value="2">For Seller Users Only</option>
                                                </select>
                                            </td>
                                            
                                            <td>&nbsp;</td>

                                        </tr>

                                        <tr role="row" class="heading">

                                            <th>Title</th>

                                            <th>Display To</th>

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

<div class="modal" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Add New</h3>
                        <div class="block-options d-none">
                        <button type="button" class="btn-block-option btn_close_modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                    </div>
                    
                    {!! Form::open(['route' => 'roles.store','files' => true]) !!}
                    
                        <div class="block-content fs-sm">
                            @include('roles.fields')

                            <div class="row">
                                <div class=" form-group col-11 text-right">
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

                url: "{!! route('roles_datatable') !!}",

                data: function (d) {  

                    d.title = $('#s_title').val();

                    d.display_to = $('#s_display_to').val();

                }

            }, columns: [

                {data: 'title', name: 'title'},

                {data: 'display_to', name: 'display_to'},

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

        $('#s_display_to').on('change', function (e) {

            oTable.draw();

            e.preventDefault();

        });

	<?php

}

?>

        

    });

 </script>
@endpush
@extends('layouts.app')

@section('content')
    
<section class="section">

    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Bad Words</h1>
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
                            BadWords
                        </li>
                    </ol>
                </nav>
            </div>
            @if(Auth::user()->can('bad-words-add') || Auth::user()->can('all'))
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="#" data-toggle="modal" data-target="#createModal">
                        <i class="fa fa-plus-square fa-lg"></i> Add New
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
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
                                        <input type="text" class="form-control" id="s_name" autocomplete="off" placeholder="Bad Word">
                                    </td>

                                    <td>
                                        <select class="form-control" id="s_status">
                                            <option value="-1">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">In Active</option>
                                        </select>
                                    </td>
                                    
                                    <td>&nbsp;</td>

                                </tr>

                                <tr role="row" class="heading">

                                    <th>Bad Word</th>

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
    <!-- END Page Content -->
    @if(Auth::user()->can('bad-words-add') || Auth::user()->can('all'))
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

                    {!! Form::open(['route' => 'bad-words.store','files' => true]) !!}

                    <div class="block-content fs-sm">
                       
                        @include('bad_words.fields')

                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    @endif
    
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
				'copy', 'excel', 'pdf'                  
			],

            ajax: {

                url: "{!! route('bad_words_datatable') !!}",

                data: function (d) {  

                    d.badword = $('#s_name').val(); 

                    d.status = $('#s_status').val(); 
					
                }

            }, columns: [

                {data: 'badword', name: 'badword'},

                {data: 'status', name: 'status'},

				{data: 'action', name: 'action'}

            ]

        });


        $('#s_name').on('keyup', function (e) {

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
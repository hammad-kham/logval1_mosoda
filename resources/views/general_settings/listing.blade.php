@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>General Settings</h1>
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
                                General Settings
                            </li>
                        </ol>
                    </nav>
                </div>
                @if(Auth::user()->can('general-settings-edit') || Auth::user()->can('all'))
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                        <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('general_settings_edit_Settings') }}">
                            Edit Settings
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
                            
                            <?php /*?><div class="row mt-2">
                                <div class="col-sm-12">
                                    <?php
                                    if(!empty($Ramadan))
                                    {
                                        if($Ramadan->value == 0)
                                        {
                                            ?>
                                            <a href="{{ route('general_settings-startRamadan') }}" href="#" class="btn btn-primary btn-add-new pull-right">
                                                Start Ramadan
                                            </a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="{{ route('general_settings-endRamadan') }}" class="btn btn-primary btn-add-new pull-right">
                                                End Ramadan
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div><?php */?>                   

                            <form method="post" role="form" id="data-search-form">
            
                                <div class="table-responsive">
                                
                                    <table class="table table-striped table-hover"  id="myDataTable">
            
                                        <thead>
            
                                            <tr role="row" class="heading">                                                 
            
                                                <td>
                                                <input type="text" class="form-control" id="s_title" autocomplete="off" placeholder="Title">
                                                </td>
                                                
                                                <td>
                                                <input type="text" class="form-control" id="s_value" autocomplete="off" placeholder="Value">
                                                </td>
            
                                            </tr>
            
                                            <tr role="row" class="heading">
            
                                                <th>Title</th>
            
                                                <th>Value</th>                                                    
            
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

                url: "{!! route('general_settings_datatable') !!}",

                data: function (d) {  

                    d.title = $('#s_title').val(); 

                    d.s_value = $('#s_value').val();
					
                }

            }, columns: [

                {data: 'title', name: 'title'},

                {data: 'value', name: 'value'}

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

        $('#s_value').on('keyup', function (e) {

            oTable.draw();

            e.preventDefault();

        });

	<?php

}

?>

        

    });

 </script> 
@endpush
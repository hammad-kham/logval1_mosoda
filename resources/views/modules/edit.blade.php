@extends('layouts.app')

@section('headerInclude')
    <link href="{{ asset_url('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit Module Details:  {{ $Model_Data->name }}</h1> 
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('modules.index') }}">Modules</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
            	<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('modules.index') }}">
                    <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                </a>
            </div>
       	</div>
    </div>
    
    <div class="section-body">
    	<div class="row">
    		<div class="col-lg-12 col-md-12 col-sm-12">
                
                    @include('flash::message')
                    @include('coreui-templates::common.errors')
                    
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Module</h4>
                                </div>
                                <div class="card-body">
                                  {!! Form::model($Model_Data, ['route' => ['modules.update', $Model_Data->id], 'method' => 'patch']) !!}
    
                                  @include('modules.fields')
    
                                  {!! Form::close() !!}
                                </div>
                            </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts') 
<style>
.hide{
	display:none;
}

.radioBtn > .notActive{
    color: #3276b1!important;
    background-color: #fff!important;
}
</style>
<script>
  
  $(document).ready(function(e) {
	$('.radioBtn a').on('click', function(){
		var sel = $(this).data('title');
		var tog = $(this).data('toggle');
		$('#'+tog).prop('value', sel);
		
		$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
		$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
	});
});
</script>
@endpush
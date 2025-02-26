@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Create New Flower Colors</h1> 
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
                        	<a href="{{ route('flower-colors.index') }}">Flower Colors</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                        	Create New
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
            	<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('flower-colors.index') }}">
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
                        <h4>Create New Flower Colors</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'flower-colors.store','files' => true]) !!}
        
                        @include('flower_colors.fields')
        
                        {!! Form::close() !!}
                    </div>
                </div>
          	</div>
        </div>
	</div>
</section>
@endsection

@section('headerInclude')
  <link rel="stylesheet" href="{{ asset_url('bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@endsection

@section('footerInclude')
  <script src="{{ asset_url('bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
@endsection

@push('scripts')
<script>
jQuery(document).ready(function(e) {

/*$("#colorpicker1").colorpicker({
  format: 'hex',
  component: '.input-group-append',
});*/
	 $('#colorpicker1').colorpicker();
});
</script>
@endpush
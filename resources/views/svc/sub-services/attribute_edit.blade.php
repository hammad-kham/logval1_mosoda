@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Attribute Details</h1>
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
                                <a href="{{ route('sub-services.index') }}">Sub Services</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('sub-services.edit', $Model_Data->attributable_id) }}">Sub Service Details</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Attribute
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('sub-services.edit', $Model_Data->attributable_id) }}">
                        <i class="fa fa-chevron-left mr-2"></i> Back
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
                            <h4>Attribute</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-4">
                                    {!! Form::label('name', 'Attribute Name:') !!}
                                </div>
                                <div class="col-sm-8">
                                    <p>{{ $Model_Data->name }}</p>
                                </div>
                            </div>


{{--                            {!! Form::model($Model_Data, ['route' => ['update_svc_sub_service_attribute', $Model_Data->id], 'method' => 'post']) !!}--}}
{{--                            <div class="form-group row">--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    {!! Form::label('name', 'Attribute Name:') !!}--}}
{{--                                    {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class=" form-group col-12 text-right">--}}
{{--                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}--}}
{{--                                    <a href="{{ route('sub-services.index') }}" class="btn btn-secondary">Cancel</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            {!! Form::close() !!}--}}
                        </div>
                    </div>
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
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 float-right">
                                <h4>Attribute Options </h4>
                            </div>
{{--                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">--}}
{{--                                <a class="btn btn-icon icon-left btn-primary pull-right" href="#" data-toggle="modal" data-target="#createModal">--}}
{{--                                    <i class="fa fa-plus-square fa-lg"></i> Add New--}}
{{--                                </a>--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-body">
                            <div class="block-content">
                                <?php
                                if(count($options_array)>0)
                                {
                                $count = 0;
                                ?>
                                <div class="table-responsive">
                                    <div class="table-container">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr role="row" class="heading">
                                                <th>#</th>
                                                <th>Attribute Name</th>
                                                <th>Mandatory</th>
                                                <th>Field Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($options_array as $record)
                                                <?php
                                                $count++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        {!! $count !!}
                                                    </td>
                                                    <td>
                                                        {!! $record["name"] !!}
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($record['is_mandatory'] == 1){
                                                            echo "YES";
                                                        }
                                                        else{
                                                            echo "No";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($record['num_field'] == 1){
                                                            echo "Number";
                                                        }
                                                        elseif($record['text_field'] == 1){
                                                            echo "Text";
                                                        }
                                                        ?>
                                                    </td>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 " style="text-align: center">
                                        <p>No records found</p>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    $types = array();
    $types['0'] = 'Number';
    $types['1'] = 'Text';
    ?>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
         aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content card card-primary">
                <div class="card-header">
                    <h4>Add New Attribute</h4>
                    <div class="card-header-action">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'store_svc_sub_service_attribute_option']) !!}
                    <div class="block-content fs-sm">

                        <input type="hidden" value="{{$Model_Data->id}}" name="attribute_id">

                        <div class="col-sm-12">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="col-sm-12">
                            {!! Form::label('type', 'Type:') !!}
                            {!! Form::select('type', $types, null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px">
                            <input id="is_mandatory" name="is_mandatory" type="checkbox" checked>
                            {!! Form::label('is_mandatory', 'Mandatory') !!}
                        </div>

                        <div class="row">
                            <div class=" form-group col-12 text-right">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <a href="{{ route('edit_svc_sub_service_attribute', $Model_Data->id) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <style>
        .variations{
            border:1px solid #999;
            margin-bottom:20px;
        }
    </style>
    <script >

        $(document).ready(function() {

            $("#chk_variations").change(function(){
                if($(this).prop('checked'))
                {
                    $("#variation_div").show();
                    if($("#variation_div").children().length == 0 )
                    {
                        var html = $("#variation_data").html();

                        $("#variation_div").append(html);
                    }
                    call_addrem_addons();
                }
                else
                {
                    $("#variation_div").hide();
                }
            });


            call_addrem_addons();

        });

        function call_addrem_addons()
        {

            $(".add_variations").off();
            $(".add_variations").click(function()
            {
                var html = $(".clone").html();

                $("#variation_div").append(html);
                call_addrem_addons();
            });


            $("body").on("click",".btn-rem-var",function(){
                $(this).parent().parent().parents(".variationrow").remove();
            });

        }
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
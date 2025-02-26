@extends('layouts.app')

@section('content')

    <?php
    $Auth_User=Auth::User();
    ?>

    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Review Details</h1>
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
                                <a href="{{ route('reviews.index') }}">Reviews</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                View Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('reviews.index') }}">
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
                            <h4>Reviews Details</h4>
                        </div>
                        <div class="card-body">
                            @include('svc.vendors.reviews.show_fields')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    @if($Model_Data->is_reported == 0)

        <div class="modal fade" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="report_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content card card-primary">
                    <div class="card-header">
                        <h4>Do You want to Report?</h4>
                    </div>
                    <div class="card-body" id="report_response">

                        <div class="row form-group">
                            <div class="col-sm-12 text-muted">
                                <textarea class="form-control" id="report_reason" rows="5" placeholder="Reason"></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-12">
                                <a class="btn btn-primary" id="report_review">Submit</a>
                            </div>
                        </div>

                        <input type="hidden" id="review_id" value="<?php echo $Model_Data->id;?>" />

                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection


@push('scripts')
    <style>
        .star_checked{
            color: orange;
        }

        .badred{
            color:#F00;
        }
    </style>
    @if($Model_Data->is_reported == 0)
        <script>

            jQuery(document).ready(function(e)
            {
                call_events();
            });

            function call_events()
            {
                if($('#report_review'))
                {
                    $('#report_review').off();
                    $('#report_review').click(function(e) {
                        var review_id = $("#review_id").val();
                        report_review(review_id);
                    });
                }
            }

            function report_review(review_id)
            {
                var report_reason = $("#report_reason").val();
                var url = '{{ route("svc_report_review") }}';
                $.ajax({
                    url: url,
                    type: 'post',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id: review_id,
                        reason: report_reason,
                    },
                    success: function (data) {
                        $("#report_response").html(data);
                        console.log(data);
                        if(data == 'Review successfully reported')
                        {
                            $('#report_modal').modal('toggle');
                            $("#report_status").html('<i class="fas fa-flag"></i> Review Reported');
                        }
                    }
                });
            }


        </script>
    @endif
@endpush
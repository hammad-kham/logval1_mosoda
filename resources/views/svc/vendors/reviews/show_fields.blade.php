
<div class="row form-group">

    <div class="col-sm-12 row">

        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Status :') !!}
            </div>
            <div class="col-sm-8">
                <?php
                $status = $Model_Data->status;
                if($Auth_User->can('vendor-reviews-status') || $Auth_User->can('all'))
                {
                    if($status == 1)
                    {
                        $str = '<a href="'.route('svc_reviews_deactivate',$Model_Data->id).'" class="btn btn-success btn-sm"  title="Make Review Inactive">
                        <span class="fa fa-power-off "> Active</span>
                        </a>';
                    }
                    else
                    {
                        $str = '<a href="'.route('svc_reviews_activate',$Model_Data->id).'" class="btn btn-danger btn-sm" title="Make Review Active">
                        <span class="fa fa-power-off"> InActive</span>
                        </a>';
                    }
                }
                else
                {
                    if($status == 1)
                    {
                        $str = '<a class="btn btn-success btn-sm">
                        <span class="fa fa-power-off "> Active</span>
                        </a>';
                    }
                    else
                    {
                        $str = '<a class="btn btn-danger btn-sm">
                        <span class="fa fa-power-off"> InActive</span>
                        </a>';
                    }
                }
                echo $str;
                ?>

                @if($Model_Data->is_reported == 0)
                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#report_modal" ui-toggle-class="bounce" ui-target="#report_animate"><span id="report_status"><i class="fas fa-flag"></i> Report Review</span></a>
                @else
                    <a class="btn btn-danger btn-sm" href="#"><span id="report_status"><i class="fas fa-flag"></i> Review Reported</span></a>
                @endif
            </div>
        </div>

        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Rating :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->rating }}</p>
            </div>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('badwordsfound', 'Badwords Found :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ badwords_found($Model_Data->id) }}</p>
            </div>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('totalbadwords', 'Total Badwords :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ total_badwords_found($Model_Data->id) }}</p>
            </div>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('badwords', 'Badwords :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ badwords_names($Model_Data->id) }}</p>
            </div>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('vendorname', 'Vendor Name :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $vendor_array->name }}</p>
            </div>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('user', 'User Name :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $user_array->name }}</p>
            </div>
        </div>


        <div class="col-sm-6 row">
            <div class="col-sm-4">
                {!! Form::label('review', 'Review :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->review }}</p>
            </div>
        </div>
    </div>
</div>

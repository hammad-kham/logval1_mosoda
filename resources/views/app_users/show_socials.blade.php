
<?php
$record = 0;
if(!empty($app_user_socials) || count($app_user_socials) > 0){
    $record = 1;
}
?>

<?php
if($record == 1){
$record = 0;
?>

    <?php
    if($app_user_socials->google_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('google', 'Google:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->google !!} </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if($app_user_socials->facebook_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('facebook', 'Facebook:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->facebook !!} </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if($app_user_socials->instagram_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('instagram', 'Instagram:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->instagram !!} </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if($app_user_socials->pinterest_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('pinterest', 'Pinterest:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->pinterest !!} </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if($app_user_socials->twitter_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('twitter', 'Twitter:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->twitter !!} </p>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if($app_user_socials->apple_status == 1){
        $record = 1;

    ?>
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('apple', 'Apple:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $app_user_socials->apple !!} </p>
            </div>
        </div>
    <?php
    }
    ?>
<?php
}
?>


@if($record == 0)
    <div class="row">
        <div class="col-md-12">
            <p> No Record Found! </p>
        </div>
    </div>
@endif

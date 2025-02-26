<?php
$Auth_User = Auth::user();
?>
<style>
    .dot {
        height: 10px;
        width: 10px;
        background-color: red;
        border-radius: 50%;
        display: inline-block;
    }
    .notification-badge{
        position: absolute;
        top: 0px;
        right: 0px;
    }
    .header-element{
        position: relative;
        width: 22px
    }
    .child {
        position: absolute;
        bottom: 30px;
    }
    .scrollable-div {
        overflow:scroll;
    }
</style>

<script src="{{ asset_url('js/app.min.js') }}"></script>

<script src="{{ asset_url('bundles/echart/echarts.js') }}"></script>

<script src="{{ asset_url('bundles/chartjs/chart.min.js') }}"></script>
<script src="{{ asset_url('bundles/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ asset_url('js/page/index.js') }}"></script>

<script src="{{ asset_url('js/scripts.js') }}"></script>
<script src="{{ asset_url('bundles/jquery.sparkline.min.js') }}"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    jQuery(document).ready(function(e) {

        if($('.ecom_cat_select'))
        {
            $('.ecom_cat_select').select2({
                width: '100%',
                placeholder: "Select a Category",
                allowClear: true
            });
        }

        if($('.ecom_sub_cat_select'))
        {
            $('.ecom_sub_cat_select').select2({
                width: '100%',
                placeholder: "Select a Sub Category",
                allowClear: true
            });
        }

        if(jQuery('.custom-switch-input-'))
        {
            jQuery('.custom-switch-input').click(function(e) {
                //alert(this.value);
                if(this.value == '1')
                {
                    window.location.href = "{{url('/users/light/set-mode')}}";
                }
                else if(this.value == '2')
                {
                    window.location.href = "{{url('/users/dark/set-mode')}}";
                }
                else if(this.value == 'on')
                {
                    window.location.href = "{{url('/users/on/set-menu')}}";
                }
                else if(this.value == 'off')
                {
                    window.location.href = "{{url('/users/off/set-menu')}}";
                }
            });
        }

    });
</script>




<?php
if($Auth_User->user_type != "admin")
{
?>

<script>

    $(document).ready(function()
    {
        fetchdata();
        setInterval(fetchdata,6000);
    });

    function fetchdata()
    {
        var vend_id = $("#user_id").val();
        var last_notification_id = $('#notification div.notify_id:last').data("last_id");

        <?php
        if($Auth_User->user_type == "vendor"){
        ?>

        var url = '{{ route("get_svc_notifications", ["notification_id"=>":notification_id","vend_id"=>":vend_id","module"=>"sod"]) }}';
        url = url.replace(":notification_id", last_notification_id);
        url = url.replace(":vend_id", vend_id);

        <?php
        }
        elseif($Auth_User->user_type == "seller"){
        ?>

        var url = '{{ route("get_ecom_notifications", ["notification_id"=>":notification_id","vend_id"=>":vend_id","module"=>"ecom"]) }}';
        url = url.replace(":notification_id", last_notification_id);
        url = url.replace(":vend_id", vend_id);

        <?php
        }
        ?>


        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {

                if(data!=0)
                {
                    // var notifications_div = $("#notification div");
                    // if(notifications_div.length > 2 ){
                    //     $("#notification").append('<div class="dropdown-divider"></div>');
                    // }
                    $("#notification").append(data);

                    $("#play_user_audio").click();
                    if(!(data))
                    {
                        $('#notification').css("display","none");
                        $('#dothdn').css("display","none");
                        $('#notificationnone').css("display","inline");
                    }
                    else
                    {
                        $('#notificationnone').css("display","none");
                        $('#notification').css("display","inline");
                        $('#dothdn').css("display","inline");
                    }
                }
            }
        });
    }

    function mark_as_read(id){

        <?php
        if($Auth_User->user_type == "vendor"){
        ?>

        var url = '{{ route("read_svc_notifications", ["id"=>":id"]) }}';
        url = url.replace(":id", id);

        <?php
        }
        elseif($Auth_User->user_type == "seller"){
        ?>

        var url = '{{ route("read_ecom_notifications", ["id"=>":id"]) }}';
        url = url.replace(":id", id);

        <?php
        }
        ?>



        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {

                if(data!=0)
                {
                    $('#'+id).parent().remove();
                    var notifications_div = $("#notification div");
                    if(!(notifications_div.length > 2 )){
                        $('#dothdn').css("display","none");
                        $('#notificationnone').css("display","inline");
                    }
                }
            }
        });
    }

    function playSound3(url)
    {
        const audio3 = new Audio(url);
        // audio3.muted = true;
        audio3.play();
    }

</script>


<?php
}
?>

@yield('js_after')

@stack('scripts')

    
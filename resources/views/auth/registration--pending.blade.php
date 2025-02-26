@extends('layouts.guest')

@section('content')


    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        
            <?php /*?><div class="login-brand login-brand-color d-none">
                <img alt="image" src="assets/img/logo.png" />
                {{ env('APP_NAME', 'Homely') }}
            </div><?php */?>
            
            <div class="card card-auth">
            
                <div class="card-header card-header-auth">
                    <h4>Please Verify your Email</h4>
                </div>
                
                <div class="card-body">

                    <i class="far fa-check-circle display-2 my-3 text-success"></i>
                    <h4>Registration Request received.</h4>
                    <p>Dear seller, thank you for showing interest and signing up on our platform. Your request has been received and is currently under review. One of our executives will contact you soon for onboarding.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
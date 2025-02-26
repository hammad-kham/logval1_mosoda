@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    User Details
                </h1>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('users.index') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit User Details
                        </li>
                    </ol>
                </nav>
                <a href="{{ route('users.index') }}" class="btn btn-dark btn-return pull-right">
                    <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                </a>
            </div>
            @include('flash::message')
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        @include('coreui-templates::common.errors')

        <div class="card">
            <div class="card-header">
                <h4>User Details</h4>
            </div>
            <div class="card-body">

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Company Trading Name</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->name }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>License No.</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->license_no }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Valid Till</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->license_expiry }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Business Activities</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->activities }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Principal Place of Business</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->principal_place }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Business Address</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->address }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Manager Name</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->name }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Email</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->email }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Phone</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->phone }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Website</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->website }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Additional Comments</label>
                    </div>
                    <div class="col-md-9">
                        {{ $user->comments }}
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Categories</label>
                    </div>
                    <div class="col-md-9">

                        <?php
                        $exists = 0;
                        $user_categories = $user->categories;
                        $user_categories = explode(',',$user_categories);
                        foreach($categories_array as $id => $title)
                        {
                        if(in_array($id , $user_categories))
                        {
                        $exists++;
                        ?>

                        <div class="col-6">
                            <label>
                                <?php echo $exists;?>. <?php echo $title;?>
                            </label>
                        </div>
                        <?php
                        }
                        }
                        if($exists == 0)
                        {
                        ?>
                        No Category Selected
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="mt-4 row">
                    <div class="col-md-3">
                        <label>Status</label>
                    </div>
                    <div class="col-md-9">
                        <?php
                        if($user->status == 0)
                        {
                            $str = 'Active';
                        }
                        elseif($user->status == 1)
                        {
                            $str = 'Inactive';
                        }
                        echo $str;
                        ?>
                    </div>
                </div>

                <div class="row text-right mt-4">
                    <div class="form-group col-sm-12">
                        <?php
                        if($user->approval_status == 0)
                        {
                        ?>
                        <a href="{{ route('users.approve', ['user_id' => $user->id]) }}" class="btn btn-success">Approve</a>
                        <a href="{{ route('users.reject', ['user_id' => $user->id]) }}" class="btn btn-danger">Reject</a>
                        <?php
                        }
                        ?>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Cancel</a>
                    </div>
                </div>

            </div>
        </div>

    </div>


    @include('common.map_js')

@endsection

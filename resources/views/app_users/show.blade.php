@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>App User Details:  {{ $Model_Data->name }}</h1> 
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
                            <a href="{{ route('app-users.index') }}">App Users</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
            	<a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('app-users.index') }}">
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
                        <h4>App User Details</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.show_fields')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="block block-rounded block-themed">

                            <div class="card">
                                <div class="card-header">
                                    <h4>Settings</h4>
                                </div>
                                <div class="card-body">

                                    <div class="block-content">
                                        @include('app_users.show_settings')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="block block-rounded block-themed">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="block-title">Socials</h4>
                                </div>
                                <div class="card-body">
                                    <div class="block-content">

                                        @include('app_users.show_socials')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Follows</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.to_follow_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Followers</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.from_follow_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Products</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.product_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Favourites</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.favourite_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Reported Products</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.reported_product_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>App User Reviews</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.to_review_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Reviewed Users</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.classified.from_review_show_fields')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Reports</h4>
                    </div>
                    <div class="card-body">
                        @include('app_users.show_reports')
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>
@endsection

@if($to_follow_exists == 1 || $from_follow_exists == 1 || $product_exists == 1 || $to_review_exists == 1 || $from_review_exists == 1 || $favourite_exists == 1 || $reported_product_exists == 1 || $reports_exists == 1)

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

            //to follow start
            <?php
            if($to_follow_exists == 1)
            {
            ?>
                var ToFollow = $('#toFollow').DataTable({

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

                        url: "{!! route('app_users_to_follow_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.seller = $('#s_to_follow').val();

                            d.follow_time_to = $('#s_follow_time_to').val();

                        }

                    }, columns: [

                        {data: 'seller_name', name: 'seller_name'},

                        {data: 'follow_time', name: 'follow_time'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    ToFollow.draw();

                    e.preventDefault();

                });

                $('#s_to_follow').on('keyup', function (e) {

                    ToFollow.draw();

                    e.preventDefault();

                });

                $('#s_follow_time_to').on('change', function (e) {

                    ToFollow.draw();

                    e.preventDefault();

                });

            <?php
            }
            ?>
            //to follow end


            //from follow start
            <?php
            if($from_follow_exists == 1)
            {
            ?>
                var FromFollow = $('#fromFollow').DataTable({

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

                        url: "{!! route('app_users_from_follow_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.buyer = $('#s_from_follow').val();

                            d.follow_time_to = $('#s_follow_time_to_1').val();

                        }

                    }, columns: [

                        {data: 'buyer_name', name: 'buyer_name'},

                        {data: 'follow_time', name: 'follow_time'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    FromFollow.draw();

                    e.preventDefault();

                });

                $('#s_from_follow').on('keyup', function (e) {

                    FromFollow.draw();

                    e.preventDefault();

                });

                $('#s_follow_time_to_1').on('change', function (e) {

                    FromFollow.draw();

                    e.preventDefault();

                });

            <?php
            }
            ?>
            //from follow end

            //product start
            <?php
            if($product_exists == 1)
            {
            ?>
                var Product = $('#productDataTable').DataTable({

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

                        url: "{!! route('app_users_product_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.title = $('#s_title').val();

                            d.price = $('#s_price').val();

                            d.product_type = $('#s_product_type').val();

                            d.condition_type = $('#s_condition_type').val();

                            d.is_sold = $('#s_is_sold').val();

                            d.status = $('#s_status').val();                           
                            
                        }

                    }, columns: [

                        {data: 'title', name: 'title'},

                        {data: 'price', name: 'price'},

                        {data: 'product_types_title', name: 'product_types_title'},

                        {data: 'condition_types_title', name: 'condition_types_title'},

                        {data: 'is_sold', name: 'is_sold'},

                        {data: 'status', name: 'status'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    Product.draw();

                    e.preventDefault();

                });

                $('#s_title').on('keyup', function (e) {

                    Product.draw();

                    e.preventDefault();

                });

                $('#s_price').on('keyup', function (e) {

                    Product.draw();

                    e.preventDefault();

                });

                $('#s_product_type').on('keyup', function (e) {

                    Product.draw();

                    e.preventDefault();

                });

                $('#s_condition_type').on('keyup', function (e) {

                    Product.draw();

                    e.preventDefault();

                }); 
                
                $('#s_is_sold').on('change', function (e) {

                    Product.draw();

                    e.preventDefault();

                }); 

                $('#s_status').on('change', function (e) {

                    Product.draw();

                    e.preventDefault();

                }); 

            <?php
            }
            ?>
            //product end

            //to review start
            <?php
            if($to_review_exists == 1)
            {
            ?>
                var ToReview = $('#toReview').DataTable({

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

                        url: "{!! route('app_users_to_review_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.to_review = $('#s_to_review').val();

                            d.review_2 = $('#s2_review').val();

                            d.rating_2 = $('#s2_rating').val();

                            d.badword_2 = $('#s2_badword').val();
                            
                        }

                    }, columns: [

                        {data: 'seller_user_name', name: 'seller_user_name'},

                        {data: 'review', name: 'review'},

                        {data: 'rating', name: 'rating'},

                        {data: 'has_badwords', name: 'has_badwords'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    ToReview.draw();

                    e.preventDefault();

                });

                $('#s_to_review').on('keyup', function (e) {

                    ToReview.draw();

                    e.preventDefault();

                });

                $('#s2_review').on('keyup', function (e) {

                    ToReview.draw();

                    e.preventDefault();

                });

                $('#s2_rating').on('keyup', function (e) {

                    ToReview.draw();

                    e.preventDefault();

                });

                $('#s2_badword').on('change', function (e) {

                    ToReview.draw();

                    e.preventDefault();

                });              

            <?php
            }
            ?>
            //to review end


            //from review start
            <?php
            if($from_review_exists == 1)
            {
            ?>
                var FromReview = $('#fromReview').DataTable({

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

                        url: "{!! route('app_users_from_review_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.from_review = $('#s_from_review').val();

                            d.review = $('#s_review').val();

                            d.rating = $('#s_rating').val();

                            d.badword = $('#s_badword').val();
                            
                        }

                    }, columns: [

                        {data: 'user_name', name: 'user_name'},

                        {data: 'review', name: 'review'},

                        {data: 'rating', name: 'rating'},

                        {data: 'has_badwords', name: 'has_badwords'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    FromReview.draw();

                    e.preventDefault();

                });

                $('#s_from_review').on('keyup', function (e) {

                    FromReview.draw();

                    e.preventDefault();

                });

                $('#s_review').on('keyup', function (e) {

                    FromReview.draw();

                    e.preventDefault();

                });

                $('#s_rating').on('keyup', function (e) {

                    FromReview.draw();

                    e.preventDefault();

                });

                $('#s_badword').on('change', function (e) {

                    FromReview.draw();

                    e.preventDefault();

                });              

            <?php
            }
            ?>
            //from review end


            //favourite start
            <?php
            if($favourite_exists == 1)
            {
            ?>
                var Favourite = $('#favouriteDataTable').DataTable({

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

                        url: "{!! route('app_users_favourite_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.title = $('#s_title_1').val();

                            d.price = $('#s_price_1').val();

                            d.product_type = $('#s_product_type_1').val();

                            d.condition_type = $('#s_condition_type_1').val();

                            d.is_sold = $('#s_is_sold_1').val();

                            d.status = $('#s_status_1').val();
                            
                        }

                    }, columns: [

                        {data: 'product_title', name: 'product_title'},

                        {data: 'product_price', name: 'product_price'},

                        {data: 'product_types_title', name: 'product_types_title'},

                        {data: 'condition_types_title', name: 'condition_types_title'},

                        {data: 'is_sold', name: 'is_sold'},

                        {data: 'status', name: 'status'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

                $('#s_title_1').on('keyup', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

                $('#s_price_1').on('keyup', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

                $('#s_product_type_1').on('keyup', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

                $('#s_condition_type_1').on('keyup', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                }); 
                
                $('#s_is_sold_1').on('change', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                }); 

                $('#s_status_1').on('change', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

            <?php
            }
            ?>
            //favourite end


            //reported product start
            <?php
            if($favourite_exists == 1)
            {
            ?>
                var ReportedProduct = $('#reportedProduct').DataTable({

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

                        url: "{!! route('app_users_reported_product_datatable', $Model_Data->id) !!}",

                        data: function (d) {

                            d.title = $('#s_title_2').val();

                            d.price = $('#s_price_2').val();

                            d.product_type = $('#s_product_type_2').val();

                            d.condition_type = $('#s_condition_type_2').val();

                            d.is_sold = $('#s_is_sold_2').val();

                            d.status = $('#s_status_2').val();

                            d.reason = $('#s_reason').val();

                            d.report_time = $('#s_report_time').val();
                            
                        }

                    }, columns: [

                        {data: 'product_title', name: 'product_title'},

                        {data: 'product_price', name: 'product_price'},

                        {data: 'product_types_title', name: 'product_types_title'},

                        {data: 'condition_types_title', name: 'condition_types_title'},

                        {data: 'is_sold', name: 'is_sold'},

                        {data: 'status', name: 'status'},

                        {data: 'reason', name: 'reason'},

                        {data: 'report_time', name: 'report_time'}

                    ]

                });

                $('#data-search-form').on('submit', function (e) {

                    Favourite.draw();

                    e.preventDefault();

                });

                $('#s_title_2').on('keyup', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                });

                $('#s_price_2').on('keyup', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                });

                $('#s_product_type_2').on('keyup', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                });

                $('#s_condition_type_2').on('keyup', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                }); 
                
                $('#s_is_sold_2').on('change', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                }); 

                $('#s_status_2').on('change', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                });

                $('#s_reason').on('keyup', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                }); 

                $('#s_report_time').on('change', function (e) {

                    ReportedProduct.draw();

                    e.preventDefault();

                });

            <?php
            }
            ?>
            //reported product end


            //reports start
            <?php
            if($reports_exists == 1)
            {
            ?>

            var oTable6 = $('#myDataTable6').DataTable({

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

                    url: "{!! route('app_user_report_datatable', $Model_Data->id) !!}",

                    data: function (d) {

                        d.user_id = $('#s_user_id_6').val();

                        d.type = $('#s_type_6').val();

                        d.reason = $('#s_reason_6').val();

                    }

                }, columns: [

                    {data: 'user_name', name: 'user_name'},

                    {data: 'type', name: 'type'},

                    {data: 'reason', name: 'reason'},

                    {data: 'action', name: 'action'}

                ]

            });

            $('#s_user_id_6').on('change', function (e) {

                oTable6.draw();

                e.preventDefault();

            });

            $('#s_type_6').on('change', function (e) {

                oTable6.draw();

                e.preventDefault();
            });


            $('#s_reason_6').on('keyup', function (e) {

                oTable6.draw();

                e.preventDefault();

            });
            <?php
            }
            ?>
            //reports end

        });

    </script>
@endpush

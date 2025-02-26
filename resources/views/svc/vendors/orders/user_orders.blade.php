@extends('layouts.app')

@section('content')
<?php 
$total_order_val=0;
?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                User  :  {{ $Model_Data[0]->u_name }} 
            </h1>
        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('orders.index') }}">Orders</a>
                    </li>   <li class="breadcrumb-item">
                        <a class="link-fx" href="#">Details</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        View Details
                    </li>
                </ol>
            </nav>               
            <a  href="{{ route('orders.index') }}" class="btn btn-dark btn-return pull-right">
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
 <div class="block block-rounded block-themed">
        <div class="block-header">
            <h3 class="block-title">User Details</h3>
        </div>
        <div class="block-content">
         
<div class="row form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data[0]->u_name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('phone', 'Phone') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data[0]->u_phone }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data[0]->u_emai }}</p>
            </div>
        </div>
         <div class="row">
            <div class="col-sm-4">
                {!! Form::label('order_count', 'Total Order') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $order_count }}</p>
            </div>
        </div>

    </div>
 
</div>
        </div>
    </div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="block block-rounded block-themed">
            <div class="block-header">
                <h3 class="block-title">Order Details</h3>
            </div>
            <div class="block-content">
              
                  <div class="block-content">                   
        <?php
        if(count($Model_Data)>0)
        {
            $count = 0;

            ?>        
            <div class="table-responsive"> 

                <div class="table-container">

                    <table class="table table-striped table-hover">

                        <thead>

                            <tr role="row" class="heading">

                                <th>#</th>  
                                <th>Order ID</th>  
                                <th>Restaurant</th> 
                                <th>Promo</th>
                                <th>Promo Value</th>                 
                                <th>Order Value</th>
                                <th>Total Value</th>
                                <th>Order Date</th>       
                                   
                            </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($Model_Data as $record)
                                        <?php
                                        $count++;
                                        ?>

                                        <tr>

                                            <td>

                                                {!! $count !!}

                                            </td>
                                             <td>

                                                {!! $record->o_id !!}

                                            </td>

                                            <td>

                                                {!! $record->r_name !!}

                                            </td>

                                            <td>

                                               {{ ( $record->p_id!=null ) ? $record->p_name : 'N/A'}}

                                            </td>

                                        <td>

                                         ${{ ( $record->p_id!=null ) ? $record->promo_value : 0}}

                                     </td>

                                     <td>

                                         ${!!  $record->order_value !!}

                                     </td> 

                                     <td>

                                         ${!!  $record->total_value  !!}
                                         <?php
                                         $total_order_val=floatval($total_order_val)+  floatVal($record->total_value);
                                         ?>

                                     </td>
                                        <td>

                                         {!!  $record->created_at  !!}

                                     </td>

                                </tr>

                                @endforeach
                                <tr class="bg-muted text-light">
                                    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total=</td>
                                    <td>${{$total_order_val}}</td><td>&nbsp;</td>
                                </tr>

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
                    <div class="col-sm-12">
                        No records found
                    </div>
                </div>
                <?php
            }
            ?> 
        </div>
 
    <!-- add categories table ends here -->


            </div>
        </div>
    </div>
</div> 

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="block block-rounded block-themed">
            <div class="block-header">
                <h3 class="block-title">Order Addons</h3>
            </div>
            <div class="block-content">
                @include('restaurants.orders.show_order_details')
            </div>
        </div>
    </div>
</div>


    </div>
@endsection

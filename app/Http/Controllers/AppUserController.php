<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AppUserSetting;
use App\Models\AppUserSocial;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Auth;
use File;
use Flash;
use Response;
use Attribute;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

use App\Models\AppUser;

use App\Models\PaymentMethod;
use App\Models\AppUserPaymentMethod;

use App\Models\CaFavourite;
use App\Models\CaFollow;
use App\Models\CaProduct;
use App\Models\CaReport;
use App\Models\CaReview;

use App\Models\Report;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AppUserController extends Controller
{
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/app_users";

    private $views_path = "app_users";

    private $dashboard_route = "dashboard";

    private $home_route = "app-users.index";
    private $create_route = "app-users.create";
    private $edit_route = "app-users.edit";
    private $view_route = "app-users.show";
    private $delete_route = "app-users.destroy";

    private $msg_created = "App user added successfully.";
    private $msg_updated = "App user updated successfully.";
    private $msg_deleted = "App user deleted successfully.";
    private $msg_not_found = "App user not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists With Same Email";

    private $list_permission = "app-users-listing";
    private $add_permission = "app-users-add";
    private $edit_permission = "app-users-edit";
    private $view_permission = "app-users-view";
    private $status_permission = "app-users-status";
    private $delete_permission = "app-users-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of App users. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add App user. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update App user. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View App user details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of App user. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete App user. Please Contact Administrator.";
	
	
	/**
	* Display a listing of the Model.
	*
	* 
	* @return Response
	*/
    public function index()
    {      
		app_users_status_update();
		
		$Auth_User = Auth::user();		
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
            $records_exists = 0;
            $records = AppUser::select(['id'])->where('id', '>=', 1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists"));
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function datatable(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = AppUser::select(['app_users.id', 'app_users.name', 'app_users.email', 'app_users.phone', 'app_users.is_reported', 'app_users.status']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) 
				{
                    if ($request->has('name') && !empty($request->name))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('name')}%");
                    }

                    if ($request->has('email') && !empty($request->email))
                    {
                        $query->where('app_users.email', 'like', "%{$request->get('email')}%");
                    }

                    if ($request->has('phone') && !empty($request->phone))
                    {
                        $query->where('app_users.phone', 'like', "%{$request->get('phone')}%");
                    }
					
					if ($request->has('is_reported') && $request->get('is_reported') != -1)
					{
						$query->where('app_users.is_reported', '=', "{$request->get('is_reported')}");
					}
					
					if ($request->has('status') && $request->get('status') != -1)
					{
						$query->where('app_users.status', '=', "{$request->get('status')}");
					}
                })
				
                ->addColumn('is_reported', function ($Records) 
				{
                    $record_id = $Records->id;
                    $is_reported = $Records->is_reported;
					
					$title = '<span class="btn btn-success btn-sm">No</span>';
					if($is_reported == 1)
					{
						$title = '<span class="btn btn-danger btn-sm">Reported</span>';
					}

                    return  $title;
                })

				->addColumn('status', function ($Records) {
					$record_id = $Records->id;
					$status = $Records->status;
					$Auth_User = Auth::user();
	
					$str = '';
					if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
					{
						if($status == 1)
						{
                        	$str = '<div class="dropdown">
							  <a href="#" class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="fa fa-power-off "></span> Active
							  </a>
							  <div class="dropdown-menu" x-placement="bottom-start">
								<a class="dropdown-item" href="'.route('app_users_deactivate',$record_id).'"  title="Make User InActive">InActive</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 1]).'"  title="Make User Suspend for 1 Day">Suspend for 1 Day</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 3]).'"  title="Make User Suspend for 3 Days">Suspend for 3 Days</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 7]).'"  title="Make User Suspend for 7 Days">Suspend for 7 Days</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 14]).'"  title="Make User Suspend for 2 Weeks">Suspend for 2 Weeks</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 30]).'"  title="Make User Suspend for 1 Month">Suspend for 1 Month</a>
								
								<a class="dropdown-item" href="'.route('app_users-suspend-days',[$record_id, 60]).'"  title="Make User Suspend for 2 Months">Suspend for 2 Months</a>
							  </div>
							</div>';
						}
						elseif($status == 2)
						{
                        	$str = '<div class="dropdown">
							  <a href="#" class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="fa fa-power-off "></span> Suspended
							  </a>
							  <div class="dropdown-menu" x-placement="bottom-start">
								<a class="dropdown-item" href="'.route('app_users_deactivate',$record_id).'"  title="Make User InActive">InActive</a>
								
								<a class="dropdown-item" href="'.route('app_users_activate',$record_id).'"  title="Make User Active">Active</a>
							  </div>
							</div>';
						}
						else
						{
                        	$str = '<div class="dropdown">
							  <a href="#" class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="fa fa-power-off "></span> Inactive
							  </a>
							  <div class="dropdown-menu" x-placement="bottom-start">
								<a class="dropdown-item" href="'.route('app_users_activate',$record_id).'"  title="Make User Active">Active</a>
							  </div>
							</div>';
						}
					}
					else
					{
						if($status == 1)
						{
							$str = '<a class="btn btn-success btn-sm" title="Active">
								<span class="fa fa-power-off "></span> Active
								</a>';
						}
						elseif($status == 2)
						{
							$str = '<a class="btn btn-warning btn-sm" title="Suspended">
								<span class="fa fa-power-off "></span> Suspended
								</a>';
						}
						else
						{
							$str = '<a class="btn btn-danger btn-sm" title="Inactive">
								<span class="fa fa-power-off"></span> Inactive
								</a>';
						}
					}
	
					return  $str;
				})
				
                ->addColumn('action', function ($Records) 
				{
                    $record_id = $Records->id;

                    $str = "<div class='btn-group'>";

                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';

                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';

                    /*{
                        $str.= ' <a href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
                                <i class="fa fa-trash"></i>
                                </a>';

                        {
                            $str.='<div id="m-'.$record_id.'" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog" id="animate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm delete following record</h5>
                                                </div>
                                                <div class="modal-body text-center p-lg">
                                                    <p>
                                                        Are you sure to delete this record?
                                                        <br>
                                                        <strong>[ '.$Records->name.' ]</strong>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                    <a href="'.route($this->delete_route, $record_id).'" class="btn btn-danger">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }*/

                    $str.= "</div>";
                    return $str;

                })
                ->rawColumns(['is_reported', 'status','action'])
				
                ->setRowId(function($Records) 
				{
                    return 'myDtRow' . $Records->id;
                })
				
                ->make(true);
				
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function to_follow_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaFollow::leftJoin('app_users', 'ca_follows.seller_id', '=', 'app_users.id')
                ->select(['ca_follows.id', 'ca_follows.buyer_id', 'ca_follows.seller_id', 'ca_follows.follow_time', 'app_users.name as seller_name'])
                ->where(['ca_follows.buyer_id'=>$id, 'ca_follows.status'=>1]);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('seller') && !empty($request->seller))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('seller')}%");
                    }
                    if ($request->has('follow_time_to') && !empty($request->follow_time_to)) {

                        $follow_time_to = $request->get('follow_time_to');
                        $follow_time_to .= " 23:59:59";
                        $follow_time_to = strtotime($follow_time_to);

                        $query->where('ca_follows.follow_time', '<=', $follow_time_to);
                    }
                })
                ->addColumn('seller_name', function ($Records) {
                    $record_id = $Records->id;
                    $seller_name = $Records->seller_name;

                    return  $seller_name;
                })
                ->addColumn('follow_time', function ($Records) {
                    $record_id = $Records->id;
                    $follow_time = date('m-d-Y',$Records->follow_time);

                    return  $follow_time;
                })
                ->rawColumns(['seller_name', 'follow_time'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function from_follow_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaFollow::leftJoin('app_users', 'ca_follows.buyer_id', '=', 'app_users.id')
                ->select(['ca_follows.id', 'ca_follows.buyer_id', 'ca_follows.seller_id', 'ca_follows.follow_time', 'app_users.name as buyer_name'])
                ->where(['ca_follows.seller_id'=>$id, 'ca_follows.status'=>1]);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('buyer') && !empty($request->buyer))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('buyer')}%");
                    }

                    if ($request->has('follow_time_to') && !empty($request->follow_time_to)) {
                        $follow_time_to = $request->get('follow_time_to');
                        $follow_time_to .= " 23:59:59";
                        $follow_time_to = strtotime($follow_time_to);
                        $query->where('ca_follows.follow_time', '<=', $follow_time_to);
                    }
                })
                ->addColumn('buyer_name', function ($Records) {
                    $record_id = $Records->id;
                    $buyer_name = $Records->buyer_name;

                    return  $buyer_name;
                })
                ->addColumn('follow_time', function ($Records) {
                    $record_id = $Records->id;
                    $follow_time = date('m-d-Y',$Records->follow_time);

                    return  $follow_time;
                })
                ->rawColumns(['buyer_name', 'follow_time'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function product_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaProduct::leftJoin('ca_product_types', 'ca_products.type_id', '=', 'ca_product_types.id')
                ->leftJoin('ca_condition_types', 'ca_products.condition_id', '=', 'ca_condition_types.id')
                ->select(['ca_products.id', 'ca_products.title', 'ca_products.price', 'ca_products.is_sold', 'ca_products.status', 'ca_product_types.title as product_types_title', 'ca_condition_types.title as condition_types_title'])
                ->where('ca_products.user_id', '=', $id);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('ca_products.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('price') && !empty($request->price))
                    {
                        $query->where('ca_products.price', '>=', "{$request->get('price')}");
                    }
                    if ($request->has('product_type') && !empty($request->product_type))
                    {
                        $query->where('ca_product_types.title', 'like', "%{$request->get('product_type')}%");
                    }
                    if ($request->has('condition_type') && !empty($request->condition_type))
                    {
                        $query->where('ca_condition_types.title', 'like', "%{$request->get('condition_type')}%");
                    }
                    if ($request->has('is_sold') && $request->get('is_sold') != -1)
                    {
                        $query->where('ca_products.is_sold', '=', "{$request->get('is_sold')}");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('ca_products.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('title', function ($Records) {
                    $record_id = $Records->id;
                    $title = $Records->title;

                    return  $title;
                })
                ->addColumn('price', function ($Records) {
                    $record_id = $Records->id;
                    $price = $Records->price;

                    return  $price;
                })
                ->addColumn('product_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $product_types_title = $Records->product_types_title;

                    return  $product_types_title;
                })
                ->addColumn('condition_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $condition_types_title = $Records->condition_types_title;

                    return  $condition_types_title;
                })
                ->addColumn('is_sold', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->is_sold == 1)
                    {
                        $is_sold = "Sold";
                    }
                    elseif($Records->is_sold == 0)
                    {
                        $is_sold = "UnSold";
                    }

                    return  $is_sold;
                })
                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->status == 1)
                    {
                        $status = "Active";
                    }
                    elseif($Records->status == 0)
                    {
                        $status = "In Active";
                    }

                    return  $status;
                })
                ->rawColumns(['title', 'price', 'product_types_title', 'condition_types_title', 'is_sold', 'status'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function to_review_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaReview::leftJoin('app_users', 'ca_reviews.seller_id', '=', 'app_users.id')
                ->select(['ca_reviews.id', 'ca_reviews.review', 'ca_reviews.rating', 'ca_reviews.has_badwords', 'app_users.name as seller_user_name'])
                ->where(['ca_reviews.user_id'=>$id, 'ca_reviews.status'=>1]);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('to_review') && !empty($request->to_review))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('to_review')}%");
                    }
                    if ($request->has('review_2') && !empty($request->review_2))
                    {
                        $query->where('ca_reviews.review', 'like', "%{$request->get('review_2')}%");
                    }
                    if ($request->has('rating_2') && !empty($request->rating_2))
                    {
                        $query->where('ca_reviews.rating', '=', "{$request->get('rating_2')}");
                    }
                    if ($request->has('badword_2') && $request->get('badword_2') != -1)
                    {
                        $query->where('ca_reviews.has_badwords', '=', "{$request->get('badword_2')}");
                    }
                })
                ->addColumn('seller_user_name', function ($Records) {
                    $record_id = $Records->id;
                    $seller_user_name = $Records->seller_user_name;

                    return  $seller_user_name;
                })
                ->addColumn('review', function ($Records) {
                    $record_id = $Records->id;
                    $review = $Records->review;

                    return $review;
                })
                ->addColumn('rating', function ($Records) {
                    $record_id = $Records->id;
                    $rating = $Records->rating;

                    return $rating;
                })
                ->addColumn('has_badwords', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->has_badwords == 1)
                    {
                        $has_badwords = "Found";
                    }
                    elseif($Records->has_badwords == 0)
                    {
                        $has_badwords = "Not Found";
                    }

                    return $has_badwords;
                })

                ->rawColumns(['seller_user_name', 'review', 'rating', 'has_badwords'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function from_review_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaReview::leftJoin('app_users', 'ca_reviews.user_id', '=', 'app_users.id')
                ->select(['ca_reviews.id', 'ca_reviews.review', 'ca_reviews.rating', 'ca_reviews.has_badwords', 'app_users.name as user_name'])
                ->where(['ca_reviews.seller_id'=>$id, 'ca_reviews.status'=>1]);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('from_review') && !empty($request->from_review))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('from_review')}%");
                    }
                    if ($request->has('review') && !empty($request->review))
                    {
                        $query->where('ca_reviews.review', 'like', "%{$request->get('review')}%");
                    }
                    if ($request->has('rating') && !empty($request->rating))
                    {
                        $query->where('ca_reviews.rating', '=', "{$request->get('rating')}");
                    }
                    if ($request->has('badword') && $request->get('badword') != -1)
                    {
                        $query->where('ca_reviews.has_badwords', '=', "{$request->get('badword')}");
                    }
                })
                ->addColumn('user_name', function ($Records) {
                    $record_id = $Records->id;
                    $user_name = $Records->user_name;

                    return  $user_name;
                })
                ->addColumn('review', function ($Records) {
                    $record_id = $Records->id;
                    $review = $Records->review;

                    return $review;
                })
                ->addColumn('rating', function ($Records) {
                    $record_id = $Records->id;
                    $rating = $Records->rating;

                    return $rating;
                })
                ->addColumn('has_badwords', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->has_badwords == 1)
                    {
                        $has_badwords = "Found";
                    }
                    elseif($Records->has_badwords == 0)
                    {
                        $has_badwords = "Not Found";
                    }

                    return $has_badwords;
                })

                ->rawColumns(['user_name', 'review', 'rating', 'has_badwords'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function favourite_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaFavourite::leftJoin('ca_products', 'ca_favourites.product_id', '=', 'ca_products.id')
                ->leftJoin('ca_product_types', 'ca_products.type_id', '=', 'ca_product_types.id')
                ->leftJoin('ca_condition_types', 'ca_products.condition_id', '=', 'ca_condition_types.id')
                ->select(['ca_favourites.id', 'ca_favourites.product_id', 'ca_products.title as product_title', 'ca_products.price as product_price', 'ca_products.is_sold as product_is_sold', 'ca_products.status as product_status', 'ca_product_types.title as product_types_title', 'ca_condition_types.title as condition_types_title'])
                ->where('ca_favourites.user_id', '=', $id);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('ca_products.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('price') && !empty($request->price))
                    {
                        $query->where('ca_products.price', '>=', "{$request->get('price')}");
                    }
                    if ($request->has('product_type') && !empty($request->product_type))
                    {
                        $query->where('ca_product_types.title', 'like', "%{$request->get('product_type')}%");
                    }
                    if ($request->has('condition_type') && !empty($request->condition_type))
                    {
                        $query->where('ca_condition_types.title', 'like', "%{$request->get('condition_type')}%");
                    }
                    if ($request->has('is_sold') && $request->get('is_sold') != -1)
                    {
                        $query->where('ca_products.is_sold', '=', "{$request->get('is_sold')}");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('ca_products.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('product_title', function ($Records) {
                    $record_id = $Records->id;
                    $product_title = $Records->product_title;

                    return  $product_title;
                })
                ->addColumn('product_price', function ($Records) {
                    $record_id = $Records->id;
                    $product_price = $Records->product_price;

                    return  $product_price;
                })
                ->addColumn('product_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $product_types_title = $Records->product_types_title;

                    return  $product_types_title;
                })
                ->addColumn('condition_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $condition_types_title = $Records->condition_types_title;

                    return  $condition_types_title;
                })
                ->addColumn('is_sold', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->product_is_sold == 1)
                    {
                        $product_is_sold = "Sold";
                    }
                    elseif($Records->product_is_sold == 0)
                    {
                        $product_is_sold = "UnSold";
                    }

                    return  $product_is_sold;
                })
                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->product_status == 1)
                    {
                        $product_status = "Active";
                    }
                    elseif($Records->product_status == 0)
                    {
                        $product_status = "In Active";
                    }

                    return  $product_status;
                })
                ->rawColumns(['product_title', 'product_price', 'product_types_title', 'condition_types_title', 'is_sold', 'status'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function reported_product_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = CaReport::leftJoin('ca_products', 'ca_reports.product_id', '=', 'ca_products.id')
                ->leftJoin('ca_product_types', 'ca_products.type_id', '=', 'ca_product_types.id')
                ->leftJoin('ca_condition_types', 'ca_products.condition_id', '=', 'ca_condition_types.id')
                ->select(['ca_reports.id', 'ca_reports.product_id', 'ca_reports.reason', 'ca_reports.report_time', 'ca_products.title as product_title', 'ca_products.price as product_price', 'ca_products.is_sold as product_is_sold', 'ca_products.status as product_status', 'ca_product_types.title as product_types_title', 'ca_condition_types.title as condition_types_title'])
                ->where('ca_products.status', 1)
                ->where('ca_reports.reported_by', '=', $id);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('ca_products.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('price') && !empty($request->price))
                    {
                        $query->where('ca_products.price', '>=', "{$request->get('price')}");
                    }
                    if ($request->has('product_type') && !empty($request->product_type))
                    {
                        $query->where('ca_product_types.title', 'like', "%{$request->get('product_type')}%");
                    }
                    if ($request->has('condition_type') && !empty($request->condition_type))
                    {
                        $query->where('ca_condition_types.title', 'like', "%{$request->get('condition_type')}%");
                    }
                    if ($request->has('is_sold') && $request->get('is_sold') != -1)
                    {
                        $query->where('ca_products.is_sold', '=', "{$request->get('is_sold')}");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('ca_products.status', '=', "{$request->get('status')}");
                    }
                    if ($request->has('reason') && !empty($request->reason))
                    {
                        $query->where('ca_reports.reason', 'like', "%{$request->get('reason')}%");
                    }
                    if ($request->has('report_time') && !empty($request->report_time)) {
                        $report_time = $request->get('report_time');
                        $report_time .= " 23:59:59";
                        $report_time = strtotime($report_time);

                        $query->where('ca_reports.report_time', '<=', $report_time);
                    }
                })
                ->addColumn('product_title', function ($Records) {
                    $record_id = $Records->id;
                    $product_title = $Records->product_title;

                    return  $product_title;
                })
                ->addColumn('product_price', function ($Records) {
                    $record_id = $Records->id;
                    $product_price = $Records->product_price;

                    return  $product_price;
                })
                ->addColumn('product_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $product_types_title = $Records->product_types_title;

                    return  $product_types_title;
                })
                ->addColumn('condition_types_title', function ($Records) {
                    $record_id = $Records->id;
                    $condition_types_title = $Records->condition_types_title;

                    return  $condition_types_title;
                })
                ->addColumn('is_sold', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->product_is_sold == 1)
                    {
                        $product_is_sold = "Sold";
                    }
                    elseif($Records->product_is_sold == 0)
                    {
                        $product_is_sold = "UnSold";
                    }

                    return  $product_is_sold;
                })
                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    if($Records->product_status == 1)
                    {
                        $product_status = "Active";
                    }
                    elseif($Records->product_status == 0)
                    {
                        $product_status = "In Active";
                    }

                    return  $product_status;
                })
                ->addColumn('reason', function ($Records) {
                    $record_id = $Records->id;
                    $reason = $Records->reason;

                    return  $reason;
                })
                ->addColumn('report_time', function ($Records) {
                    $record_id = $Records->id;
                    $report_time = date('m-d-Y',$Records->report_time);

                    return  $report_time;
                })
                ->rawColumns(['product_title', 'product_price', 'product_types_title', 'condition_types_title', 'is_sold', 'status', 'reason', 'report_time'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function report_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();

        $Records = Report::leftjoin('app_users', 'reports.user_id', '=', 'app_users.id')
            ->leftjoin('users', 'reports.user_id', '=', 'users.id')
            ->where(['reports.app_user_id'=>$id])
            ->select(['reports.*','app_users.name as app_user_name','users.name as user_name']);

        $response= Datatables::of($Records)
            ->filter(function ($query) use ($request) {
                if ($request->has('user_id') && $request->get('user_id') != -1)
                {
                    $query->where('reports.user_id', '=', "{$request->get('user_id')}");
                }

                if ($request->has('type') && $request->get('type') != -1)
                {
                    $query->where('reports.ref_type', 'like', "%{$request->get('type')}%");
                }

                if ($request->has('reason') && !empty($request->reason))
                {
                    $query->where('reports.reason', '=', "{$request->get('reason')}");
                }
            })

            ->addColumn('type', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->ref_type;

                return  $title;
            })

            ->addColumn('action', function ($Records) {
                $record_id = $Records->ref_id;
                $ref_type = $Records->ref_type;
                $Auth_User = Auth::user();

                $str = "";

                if($ref_type == 'Ecommerce Product Review')
                {
                    if($Auth_User->can("seller-reviews-view") || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route('ecommerce-reviews.show', $record_id) . '" title="View Details" target="_blank">
								<i class="fa fa-eye"></i>
								</a>';
                    }
                }
                elseif($ref_type == 'Services Review')
                {
                    if($Auth_User->can("vendor-reviews-view") || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route('reviews.show', $record_id) . '" title="View Details" target="_blank">
								<i class="fa fa-eye"></i>
								</a>';
                    }
                }
                else
                {
                    if($Auth_User->can("reviews-view") || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route('reviews.show', $record_id) . '" title="View Details" target="_blank">
								<i class="fa fa-eye"></i>
								</a>';
                    }
                }

                return $str;

            })
            ->rawColumns(['type', 'action'])
            ->setRowId(function($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;
    }
	
	private function create_uploads_directory()
	{
		$uploads_path = $this->uploads_path;
		if(!is_dir($uploads_path))
		{
			mkdir($uploads_path);
			$uploads_root = $this->uploads_root;
			$src_file = $uploads_root."/index.html";
			$dest_file = $uploads_path."/index.html";
			copy($src_file,$dest_file);
		}
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
    public function create()
    {   
		$Auth_User = Auth::user();    
		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{
            return view($this->views_path.'.create');
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
    public function store(Request $request)
    {	
		$Auth_User = Auth::user();      
		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{	
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048'
            ]);

            $name = ltrim(rtrim($request->name));
            $phone = ltrim(rtrim($request->phone));
            $email = ltrim(rtrim($request->email));
            if($name != '' && $phone != '' && $email != '')
            {
                $bool=0;

                $Model_Results = AppUser::where('phone', '=', $name)->orWhere('email', '=', $email)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = new AppUser();

                    $Model_Data->name = $name;
                    $Model_Data->phone = $phone;
                    $Model_Data->email = $email;

                    $image = '';
                    if (isset($request->image) && $request->image != null)
                    {
                        $file_uploaded = $request->file('image');
                        $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

						$this->create_uploads_directory();
						
						$uploads_path = $this->uploads_path;
						$file_uploaded->move($uploads_path, $image);
                    }
                    $Model_Data->photo = $image;

					$Model_Data->created_by = $Auth_User->id;
					$Model_Data->save();

                    Flash::success($this->msg_created);
                    return redirect()->route($this->home_route);
                }
                else
                {
                    Flash::error($this->msg_exists);
                    return redirect()->route($this->create_route);
                }
            }
            else
            {
                Flash::error($this->msg_required);

                return redirect()->route($this->create_route);
            }
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Display the specified resource.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function show($id)
    {  
		$Auth_User = Auth::user();    
		if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
		{
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $app_user = AppUser::select(['id', 'name'])->where('id', '>=', 1)->pluck('name', 'id');

            $app_user_socials = AppUserSocial::where('user_id', '=', $id)->first();

            $app_user_settings = AppUserSetting::where('user_id', '=', $id)->first();

            $country = Country::find($app_user_settings->country);
            $currency = Currency::find($app_user_settings->currency);
            $language = Language::find($app_user_settings->language);

            $to_follow_exists = 0;
            $to_follow_records = CaFollow::select(['id'])->where('id', '>=', 1)->where('buyer_id', $Model_Data->id)->limit(1)->get();
            foreach($to_follow_records as $record)
            {
                $to_follow_exists = 1;
            }

            $from_follow_exists  = 0;
            $from_follow_records = CaFollow::select(['id'])->where('id', '>=', 1)->where('seller_id', $Model_Data->id)->limit(1)->get();
            foreach($from_follow_records as $record)
            {
                $from_follow_exists  = 1;
            }

            $product_exists = 0;
            $product_records = CaProduct::select(['id'])->where('id', '>=', 1)->where('user_id', $Model_Data->id)->limit(1)->get();
            foreach($product_records as $record)
            {
                $product_exists = 1;
            }

            $to_review_exists = 0;
            $to_review_records = CaReview::select(['id'])->where('id', '>=', 1)->where('user_id', $Model_Data->id)->limit(1)->get();
            foreach($to_review_records as $record)
            {
                $to_review_exists = 1;
            }

            $from_review_exists = 0;
            $from_review_records = CaReview::select(['id'])->where('id', '>=', 1)->where('seller_id', $Model_Data->id)->limit(1)->get();
            foreach($from_review_records as $record)
            {
                $from_review_exists = 1;
            }

            $favourite_exists = 0;
            $favourite_records = CaFavourite::select(['id'])->where('id', '>=', 1)->where('user_id', $Model_Data->id)->limit(1)->get();
            foreach($favourite_records as $record)
            {
                $favourite_exists = 1;
            }

            $reported_product_exists = 0;
            $reported_product_records = CaReport::select(['id'])->where('id', '>=', 1)->where('reported_by', $Model_Data->id)->limit(1)->get();
            foreach($reported_product_records as $record)
            {
                $reported_product_exists = 1;
            }

            $reports_exists = 0;
            $reports_records = Report::select(['id'])->where('app_user_id', '=', $id)->limit(1)->get();
            foreach($reports_records as $record)
            {
                $reports_exists = 1;
            }

            $payment_methods_array = PaymentMethod::select(['id','name'])->where('id', '>=', 1)->orderby('name', 'asc')->pluck('name','id');

            $users = User::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');


            return view($this->views_path.'.show', compact("Model_Data", "users","app_user_socials","currency","language","country","payment_methods_array", "app_user", "to_follow_exists", "from_follow_exists", "product_exists", "to_review_exists", "from_review_exists", "favourite_exists", "reported_product_exists", "reports_exists"));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function edit($id)
    {   
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		{ 
            $Model_Data= AppUser::find($id);

            if (empty( $Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $payment_methods_array = PaymentMethod::select(['id','name'])->where('id', '>=', 1)->orderby('name', 'asc')->pluck('name','id');

            return view($this->views_path.'.edit',compact("Model_Data", "payment_methods_array"));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Update the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
    public function update($id, Request $request)
    {   
		$Auth_User = Auth::user();   
		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		{ 
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }			
			
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048'
            ]);

            $name = ltrim(rtrim($request->name));
            $phone = ltrim(rtrim($request->phone));
            $email = ltrim(rtrim($request->email));

            $Model_Data->name = $name;
            $Model_Data->phone = $phone;
            $Model_Data->email = $email;


            $image = $Model_Data->photo;
            if(isset($request->image) && $request->image != null)
            {
                $file_uploaded = $request->file('image');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

				$this->create_uploads_directory();
				
                $uploads_path = $this->uploads_path;
                $file_uploaded->move($uploads_path, $image);

                if ($Model_Data->image != "") {
                    File::delete($uploads_path."/".$Model_Data->image);
                }
            }
            $Model_Data->photo = ltrim(rtrim($image));

            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success($this->msg_updated);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* update status of the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function makeActive($id)
    {  
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		{
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App User made Active successfully.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* update status of the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function makeInActive($id)
    {  
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		{
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App User made InActive successfully.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function suspend($id, $days=0)
    {
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		{
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 2;
			$message = "App User Suspended successfully.";	
			if($days != 0)
			{
        		$current_time = time();				
				$Model_Data->suspend_time = ($current_time + ($days*24*60*60));
				$message = "App User Suspended for $days days successfully.";
			}
			else
			{			
				$Model_Data->suspend_time = 0;
			}
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success($message);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function destroy($id)
    {  
        return redirect(route($this->home_route));

        /*$Auth_User = Auth::user();
        if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
        {
            $Model_Data = AppUser::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->delete();

            Flash::success($this->msg_deleted);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->delete_permission_error_message);
            return redirect()->route($this->home_route);
        }*/
    }

}

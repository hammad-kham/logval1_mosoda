<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;

use App\Models\Report;
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

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;

use App\Models\SvcVendor;
use App\Models\SvcProduct;
use App\Models\SvcReview;

class SvcReviewController extends Controller
{
    private $uploads_path = "uploads/svc/reviews";
    private $uploads_root = "uploads";
	
    private $views_path = "svc.vendors.reviews";

    private $dashboard_route = "dashboard";

    private $home_route = "reviews.index";
    private $create_route = "reviews.create";
    private $edit_route = "reviews.edit";
    private $view_route = "reviews.show";
    private $delete_route = "reviews.destroy";

    private $msg_created = "Reviews added successfully.";
    private $msg_updated = "Reviews updated successfully.";
    private $msg_deleted = "Reviews deleted successfully.";
    private $msg_not_found = "Reviews not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Reviews name";

    private $list_permission = "vendor-reviews-listing";
    private $add_permission = "vendor-reviews-add";
    private $edit_permission = "vendor-reviews-edit";
    private $view_permission = "vendor-reviews-view";
    private $status_permission = "vendor-reviews-status";
    private $delete_permission = "vendor-reviews-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of reviews. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add reviews. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update reviews. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View product details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of reviews. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete reviews. Please Contact Administrator.";
	
	
	/**
	* Display a listing of the Model.
	*
	* 
	* @return Response
	*/
    public function index()
    {      
		$Auth_User = Auth::user();		
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
            $records_exists = 0;

            $records = SvcReview::select(['id'])
                ->where('id', '>=', 1)
                ->limit(1)->get();

            foreach ($records as $record) {
                $records_exists = 1;
            }

            $vendors_array = SvcVendor::select(['id', 'name'])
                ->where('id', '>=', 1)
                ->where('status', '=', 1)
                ->orderby('name', 'asc')
                ->pluck('name', 'id');

            return view($this->views_path . '.listing', compact('records_exists', 'vendors_array'));
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
            if ($Auth_User->user_type == 'admin') {
                return $this->admin_datatable($request);
            } elseif ($Auth_User->user_type == 'vendor') {
                return $this->vendor_datatable($request);
            }
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function admin_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $vend_id = $Auth_User->vend_id;

        $Records = SvcReview::leftjoin('svc_vendors', 'svc_reviews.vend_id', '=', 'svc_vendors.id')
            ->leftjoin('svc_orders', 'svc_reviews.order_id', '=', 'svc_orders.id')
            ->select(['svc_reviews.*', 'svc_vendors.id as vendor_id', 'svc_vendors.name as vendor_name', 'svc_orders.order_no as order_no'])
            ->orderBy('id','desc');

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request) {
                if ($request->has('vendor_id') && $request->get('vendor_id') != -1) {
                    $query->where('svc_vendors.id', '=', "{$request->get('vendor_id')}");
                }
                if ($request->has('order_no') && !empty($request->order_no)) {
                    $query->where('svc_orders.order_no', 'like', "%{$request->get('order_no')}%");
                }
                if ($request->has('search_rating') && !empty($request->search_rating)) {
                    $query->where('svc_reviews.rating', 'like', "%{$request->get('search_rating')}%");
                }
                if ($request->has('badwords') && $request->get('badwords') != -1) {
                    $query->where('svc_reviews.has_badwords', '=', "{$request->get('badwords')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_reviews.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('bad_word', function ($Records) {
                $record_id = $Records->id;
                $title = badwords_found($record_id);

                return $title;
            })

            ->addColumn('status', function ($Records) {
                $record_id = $Records->id;
                $status = $Records->status;
                $Auth_User = Auth::user();

                $str = '';
                if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
                    if ($status == 1) {
                        $str = '<a href="' . route('svc_reviews_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Review Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
                    } else {
                        $str = '<a href="' . route('svc_reviews_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Review Active">
                        <span class="fa fa-power-off"></span> Inactive
                        </a>';
                    }
                } else {
                    if($status == 1)
                    {
                        $str = '<a class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Active
                                    </a>';
                    }
                    else
                    {
                        $str = '<a class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Inactive
                                    </a>';
                    }
                }

                return $str;
            })

            ->addColumn('action', function ($Records) {
                $record_id = $Records->id;
                $Auth_User = Auth::user();

                $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                if ($Auth_User->can($this->view_permission) || $Auth_User->can('all')) {
                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
                }

                return $str;

            })
            ->rawColumns(['title', 'status', 'action'])
            ->setRowId(function ($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;

    }

    public function vendor_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $vend_id = $Auth_User->vend_id;

        $Records = SvcReview::leftjoin('svc_orders', 'svc_reviews.order_id', '=', 'svc_orders.id')
            ->select(['svc_reviews.*', 'svc_orders.order_no as order_no'])
            ->orderBy('id','desc')
	        ->where('svc_reviews.vend_id', '=', $vend_id);

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request) {
                if ($request->has('order_no') && !empty($request->order_no)) {
                    $query->where('svc_orders.order_no', 'like', "%{$request->get('order_no')}%");
                }
                if ($request->has('search_rating') && !empty($request->search_rating)) {
                    $query->where('svc_reviews.rating', 'like', "%{$request->get('search_rating')}%");
                }
                if ($request->has('badwords') && $request->get('badwords') != -1) {
                    $query->where('svc_reviews.has_badwords', '=', "{$request->get('badwords')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_reviews.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('bad_word', function ($Records) {
                $record_id = $Records->id;
                $title = badwords_found($record_id);

                return $title;
            })

            ->addColumn('status', function ($Records) {
                $record_id = $Records->id;
                $status = $Records->status;
                $Auth_User = Auth::user();

                $str = '';
                if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
                    if ($status == 1) {
                        $str = '<a href="' . route('svc_reviews_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Review Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
                    } else {
                        $str = '<a href="' . route('svc_reviews_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Review Active">
                        <span class="fa fa-power-off"></span> Inactive
                        </a>';
                    }
                } else {
                    if($status == 1)
                    {
                        $str = '<a class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Active
                                    </a>';
                    }
                    else
                    {
                        $str = '<a class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Inactive
                                    </a>';
                    }
                }

                return $str;
            })

            ->addColumn('action', function ($Records) {
                $record_id = $Records->id;
                $Auth_User = Auth::user();

                $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                if ($Auth_User->can($this->view_permission) || $Auth_User->can('all')) {
                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
                }

                return $str;

            })
            ->rawColumns(['title', 'status', 'action'])
            ->setRowId(function ($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;

    }

    public function is_not_authorized($id, $Auth_User)
    {
        $bool = 1;
        if($Auth_User->user_type == 'admin')
        {
            $bool = 0;
        }
        else
        {
            $vend_id = $Auth_User->vend_id;
            $records = SvcReview::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
            foreach($records as $record)
            {
                $bool = 0;
            }
        }

        return $bool;
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
            $Model_Data = SvcReview::find($id);

            if (empty( $Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $vendor_array = SvcVendor::where('id', '=',$Model_Data->vend_id)->first(['id','name','arabic_name','location','phone']);

            $user_array = AppUser::where('id', '=',$Model_Data->user_id)->first(['id','name']);

            return view($this->views_path.'.show', compact('Model_Data','vendor_array','user_array'));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function report_review(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $id = $request->id;

            $Model_Data = SvcReview::find($id);

            if (empty($Model_Data))
            {
                return false;
            }

            $app_user_id = $Model_Data->user_id;

            $Model_Data->is_reported = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            $current_time = time();
            $reason = $request->reason;

            $Report = new Report();

            $Report->app_user_id = $app_user_id;
            $Report->user_id = $Auth_User->id;
            $Report->ref_type = 'Services Review';
            $Report->ref_id = $id;
            $Report->reason = $reason;
            $Report->report_time = $current_time;

            $Report->save();

            $Model_Data = AppUser::find($app_user_id);
            $Model_Data->is_reported = 1;
            $Model_Data->save();

            return 'Review successfully reported';
        }
        else
        {
            return 'You can not report this Review';
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
            $Model_Data = SvcReview::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Review made Active successfully.');
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
            $Model_Data = SvcReview::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Review made InActive successfully.');
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
            $Model_Data = SvcReview::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
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

<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;

use App\Models\BackendNotification;
use App\Models\SvcTransaction;
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

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;

use App\Models\SvcVendor;
use App\Models\SvcProduct;
use App\Models\SvcOrder;
use App\Models\SvcOrderDetail;
use App\Models\SvcOrderFile;

use App\Models\AppUser;
use App\Models\AppUserLocation;
use MultipleIterator;
use ArrayIterator;
use Carbon\Carbon;


class SvcOrderController extends Controller
{
    private $uploads_path = "uploads/svc/orders";
    private $uploads_root = "uploads";

    private $views_path = "svc.vendors.orders";

    private $dashboard_route = "dashboard";

    private $home_route = "orders.index";
    private $create_route = "orders.create";
    private $edit_route = "orders.edit";
    private $view_route = "orders.show";
    private $delete_route = "orders.destroy";

    private $msg_created = "Orders added successfully.";
    private $msg_updated = "Orders updated successfully.";
    private $msg_deleted = "Orders deleted successfully.";
    private $msg_not_found = "Orders not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Orders name";

    private $submit_quote = "Quote Submitted Successfully";

    private $list_permission = "vendor-orders-listing";
    private $add_permission = "vendor-orders-add";
    private $edit_permission = "vendor-orders-edit";
    private $view_permission = "vendor-orders-view";
    private $status_permission = "vendor-orders-status";
    private $delete_permission = "vendor-orders-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Orders. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Orders. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Orders. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View product details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Orders. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Orders. Please Contact Administrator.";


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

            $records = SvcOrder::select(['id'])
                ->where('id', '>=', 1)
                ->limit(1)->get();

            foreach ($records as $record) {
                $records_exists = 1;
            }

            $svc_vendor_array = SvcVendor::select(['id', 'name'])
                ->where('id', '>=', 1)
                ->where('status', '=', 1)
                ->orderby('name', 'asc')
                ->pluck('name', 'id');

            $app_user_data = SvcOrder::leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
                ->select('app_users.id as app_user_id', 'app_users.name as app_user_name')
                ->pluck('app_user_name', 'app_user_id');

            $categories = SvcCategory::where('status',1)->pluck('title', 'id');

            return view($this->views_path . '.listing', compact('records_exists', 'svc_vendor_array', 'app_user_data', 'categories'));
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
            $user_type = $Auth_User->user_type;

            if($user_type == 'admin')
            {
                return  $this->admin_datatable($request);
            }
            elseif($user_type == 'vendor')
            {
                return  $this->vendor_datatable($request);
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
        $Records = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id')
            ->leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
            ->leftjoin('svc_categories', 'svc_orders.cat_id', '=', 'svc_categories.id')
            ->select(['svc_orders.*',
                'svc_categories.id as category_id', 'svc_categories.title as category_title',
                'svc_vendors.id as svc_vendors_id', 'svc_vendors.name as svc_vendors_name',
                'app_users.id as app_users_id', 'app_users.name as app_users_name', 'svc_orders.total as svc_order_details_price'])
            ->orderBy('svc_orders.id','desc');

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request)
            {
                if ($request->has('price') && !empty($request->price)) {
                    $query->where('svc_orders.total', '>', "{$request->get('price')}");
                }
                if ($request->has('vendor_name') && $request->get('vendor_name') != -1) {
                    $query->where('svc_orders.vend_id', '=', "{$request->get('vendor_name')}");
                }
                if ($request->has('user_name') && $request->get('user_name') != -1) {
                    $query->where('svc_orders.user_id', '=', "{$request->get('user_name')}");
                }
                if ($request->has('category_title') && $request->get('category_title') != -1) {
                    $query->where('svc_categories.id', '=', "{$request->get('category_title')}");
                }
                if ($request->has('type') && $request->get('type') != -1) {
                    $query->where('svc_orders.type', '=', "{$request->get('type')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_orders.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('type', function ($Records)
            {
                $record_id = $Records->id;
                $type = $Records->type;

                if($type == 0){
                    $type = 'Fixed Price';
                }
                elseif($type == 1){
                    $type = 'Get A Quote';
                }
                return $type;
            })

            ->addColumn('status', function ($Records)
            {
                $status = get_svc_order_status($Records->status, $Records->type);

                return $status;
            })

            ->addColumn('action', function ($Records)
            {
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

            ->setRowId(function ($Records)
            {
                return 'myDtRow' . $Records->id;
            })

            ->make(true);

        return $response;
    }

    public function vendor_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $vend_id = $Auth_User->vend_id;

        $Records = SvcOrder::leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
            ->leftjoin('svc_categories', 'svc_orders.cat_id', '=', 'svc_categories.id')
            ->select(['svc_orders.*',
                'svc_categories.id as category_id', 'svc_categories.title as category_title',
                'app_users.id as app_users_id', 'app_users.name as app_users_name', 'svc_orders.total as svc_order_details_price'])
            ->orderBy('svc_orders.id','desc')
            ->where('svc_orders.vend_id', '=', $vend_id);

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request)
            {
                if ($request->has('price') && !empty($request->price)) {
                    $query->where('svc_orders.total', '>', "{$request->get('price')}");
                }
                if ($request->has('user_name') && $request->get('user_name') != -1) {
                    $query->where('svc_orders.user_id', '=', "{$request->get('user_name')}");
                }
                if ($request->has('category_title') && $request->get('category_title') != -1) {
                    $query->where('svc_categories.id', '=', "{$request->get('category_title')}");
                }
                if ($request->has('type') && $request->get('type') != -1) {
                    $query->where('svc_orders.type', '=', "{$request->get('type')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_orders.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('type', function ($Records)
            {
                $record_id = $Records->id;
                $type = $Records->type;

                if($type == 0){
                    $type = 'Fixed Price';
                }
                elseif($type == 1){
                    $type = 'Get A Quote';
                }
                return $type;
            })

            ->addColumn('status', function ($Records)
            {
                $status = get_svc_order_status($Records->status, $Records->type);

                return $status;
            })

            ->addColumn('action', function ($Records)
            {
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

            ->setRowId(function ($Records)
            {
                return 'myDtRow' . $Records->id;
            })

            ->make(true);

        return $response;
    }

    public function dashboard_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $user_type = $Auth_User->user_type;

            if($user_type == 'admin')
            {
                return  $this->admin_dashboard_datatable($request);
            }
            elseif($user_type == 'vendor')
            {
                return  $this->vendor_dashboard_datatable($request);
            }
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function admin_dashboard_datatable(Request $request)
    {
        $created_at = Carbon::today();

        $Records = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id')
            ->leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
            ->leftjoin('svc_categories', 'svc_orders.cat_id', '=', 'svc_categories.id')
            ->select(['svc_orders.*',
                'svc_categories.id as category_id', 'svc_categories.title as category_title',
                'svc_vendors.id as svc_vendors_id', 'svc_vendors.name as svc_vendors_name',
                'app_users.id as app_users_id', 'app_users.name as app_users_name', 'svc_orders.total as svc_order_details_price'])
            ->orderBy('svc_orders.id','desc')
            ->whereDate('svc_orders.created_at', '=', $created_at);

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request)
            {
                if ($request->has('price') && !empty($request->price)) {
                    $query->where('svc_orders.total', '>', "{$request->get('price')}");
                }
                if ($request->has('vendor_name') && $request->get('vendor_name') != -1) {
                    $query->where('svc_orders.vend_id', '=', "{$request->get('vendor_name')}");
                }
                if ($request->has('user_name') && $request->get('user_name') != -1) {
                    $query->where('svc_orders.user_id', '=', "{$request->get('user_name')}");
                }
                if ($request->has('category_title') && $request->get('category_title') != -1) {
                    $query->where('svc_categories.id', '=', "{$request->get('category_title')}");
                }
                if ($request->has('type') && $request->get('type') != -1) {
                    $query->where('svc_orders.type', '=', "{$request->get('type')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_orders.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('type', function ($Records)
            {
                $record_id = $Records->id;
                $type = $Records->type;

                if($type == 0){
                    $type = 'Fixed Price';
                }
                elseif($type == 1){
                    $type = 'Get A Quote';
                }
                return $type;
            })

            ->addColumn('status', function ($Records)
            {
                $status = get_svc_order_status($Records->status, $Records->type);

                return $status;
            })

            ->addColumn('action', function ($Records)
            {
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

            ->setRowId(function ($Records)
            {
                return 'myDtRow' . $Records->id;
            })

            ->make(true);

        return $response;

    }

    public function vendor_dashboard_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $vend_id = $Auth_User->vend_id;

        $created_at = Carbon::today();

        $Records = SvcOrder::leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
            ->leftjoin('svc_categories', 'svc_orders.cat_id', '=', 'svc_categories.id')
            ->select(['svc_orders.*',
                'svc_categories.id as category_id', 'svc_categories.title as category_title',
                'app_users.id as app_users_id', 'app_users.name as app_users_name', 'svc_orders.total as svc_order_details_price'])
            ->orderBy('svc_orders.id','desc')
            ->where('svc_orders.vend_id', '=', $vend_id)
            ->whereDate('svc_orders.created_at', '=', $created_at);

        $response = Datatables::of($Records)
            ->filter(function ($query) use ($request)
            {
                if ($request->has('price') && !empty($request->price)) {
                    $query->where('svc_orders.total', '>', "{$request->get('price')}");
                }
                if ($request->has('user_name') && $request->get('user_name') != -1) {
                    $query->where('svc_orders.user_id', '=', "{$request->get('user_name')}");
                }
                if ($request->has('category_title') && $request->get('category_title') != -1) {
                    $query->where('svc_categories.id', '=', "{$request->get('category_title')}");
                }
                if ($request->has('type') && $request->get('type') != -1) {
                    $query->where('svc_orders.type', '=', "{$request->get('type')}");
                }
                if ($request->has('status') && $request->get('status') != -1) {
                    $query->where('svc_orders.status', '=', "{$request->get('status')}");
                }
            })

            ->addColumn('type', function ($Records)
            {
                $record_id = $Records->id;
                $type = $Records->type;

                if($type == 0){
                    $type = 'Fixed Price';
                }
                elseif($type == 1){
                    $type = 'Get A Quote';
                }
                return $type;
            })

            ->addColumn('status', function ($Records)
            {
                $status = get_svc_order_status($Records->status, $Records->type);

                return $status;
            })

            ->addColumn('action', function ($Records)
            {
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

            ->setRowId(function ($Records)
            {
                return 'myDtRow' . $Records->id;
            })

            ->make(true);

        return $response;
    }

    public function is_not_authorized($id, $Auth_User)
    {
        $bool = 1;
        if ($Auth_User->user_type == 'admin') {
            $bool = 0;
        } else {
            $vend_id = $Auth_User->vend_id;
            $records = SvcOrder::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
            foreach ($records as $record) {
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
            $Order = SvcOrder::leftjoin('svc_brand_options','svc_orders.brand_id','=','svc_brand_options.id')
                ->select('svc_orders.*','svc_brand_options.name as brand_name')
                ->where('svc_orders.id',$id)
                ->first();

            if (empty($Order) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Order_Details = SvcOrderDetail::leftjoin('svc_services','svc_order_details.service_id','=','svc_services.id')
                ->leftjoin('svc_sub_services','svc_order_details.sub_service_id','=','svc_sub_services.id')
                ->leftjoin('svc_products','svc_order_details.product_id','=','svc_products.id')
                ->leftjoin('svc_brand_options','svc_order_details.brand_id','=','svc_brand_options.id')
                ->select('svc_order_details.*','svc_services.title as service_title','svc_sub_services.title as sub_service_title','svc_products.name as product_name','svc_brand_options.name as brand_name')
                ->where('svc_order_details.order_id',$id)
                ->orderBy('svc_order_details.sub_cat_id','asc')
                ->orderBy('svc_order_details.service_id','asc')
                ->orderBy('svc_order_details.sub_service_id','asc')
                ->get();

            $Order_Files = SvcOrderFile::where('order_id',$id)->get();
            $App_User = AppUser::find($Order->user_id);
            $App_User_Location = AppUserLocation::where('id',$Order->loc_id)->where('user_id',$Order->user_id)->first();
            $Vendor = SvcVendor::find($Order->vend_id);

            $Transaction = null;
            if($Order->transaction_id != 0){
                $Transaction = SvcTransaction::find($Order->transaction_id);
            }

            $user_order_count = SvcOrder::where('user_id',$Order->user_id)->count();

            $cat_id = 0;
            if($Order->cat_id > 0){
                $cat_id = $Order->cat_id;
            }
            $Category = SvcCategory::find($cat_id);

            $sub_cat_id = array();
            if($Order->sub_cat_id > 0){
                $sub_cat_id[] = $Order->sub_cat_id;
            }
            else{
                foreach($Order_Details as $order_detail){
                    if($order_detail->sub_cat_id > 0){
                        $sub_cat_id[] = $order_detail->sub_cat_id;
                    }
                }
            }
            $Sub_Category = SvcSubCategory::whereIn('id', $sub_cat_id)->get();


            $items = SvcOrder::join('svc_order_details','svc_orders.id','=','svc_order_details.order_id')
                ->join('svc_order_sub_details', 'svc_order_details.id', '=', 'svc_order_sub_details.detail_id')
                ->join('home_items', 'svc_order_sub_details.item_id', '=', 'home_items.id')
                ->select('svc_orders.id as order_id',
                    'svc_order_details.id as order_details_id',
                    'svc_order_sub_details.id as order_sub_details_id', 'svc_order_sub_details.quantity as order_quantity', 'svc_order_sub_details.price as Order_price',
                    'home_items.title as item_title', 'home_items.created_at as created_at')
                ->where('svc_orders.id', '=', $id)
                ->get();

//            echo "<pre>";
//            print_r($items);
//            exit;

            $items_count = 0;
            $items_count = $items->count();

            return view($this->views_path.'.show',compact('Order','Order_Details','Order_Files','Transaction','App_User','App_User_Location','Vendor','user_order_count','Category','Sub_Category','items','items_count'));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    /**
     * update status of the specified resource in storage.
     *
     * @param  \App\Models\Model  $id
     * @return \Illuminate\Http\Response
     * 
     */

    public function add_addons(Request $request)
    {
       // echo $request->order_id." " .$request->vat_value." " .$request->final_value;
        $order = SvcOrder::where('id', $request->order_id)->update(['addons_exists'=>1]);

        $total_addon_amount = 0;
        $reason = $request->reason;
        $amount = $request->amount;
        $order_id = $request->order_id;
        //return $reason[0];

      
        

        foreach($amount as $r)
        {
            $total_addon_amount += $r;
            
        }
        
        $vat_value = ($total_addon_amount*get_vat_value())/100;
       
        $final_value = $total_addon_amount + $vat_value;
       
        $check_addon = DB::table('order_addons')->where('order_id', $order_id)->first();
        if(!empty($check_addon))
        {
            $total_addon_amount = $check_addon->total_value + $total_addon_amount;
            $vat_value = ($total_addon_amount*get_vat_value())/100;
            $final_value = $total_addon_amount + $vat_value;
            
            $order_addons = DB::table('order_addons')->where('order_id', $order_id)
                            ->update([
                                    'total_value'=> +$total_addon_amount,
                                    'vat_value'=> $vat_value,
                                    'final_value'=> +$final_value 
                                    ]);
        }
        else
        {
            $order_addons = DB::table('order_addons')
                            ->insert([
                                    'order_id'=>$request->order_id, 
                                    'total_value'=> $total_addon_amount,
                                    'vat_value'=> $vat_value,
                                    'final_value'=> $final_value 
                                    ]);
        }


        $iterator = new MultipleIterator;
        $iterator->attachIterator(new ArrayIterator($reason));
        $iterator->attachIterator(new ArrayIterator($amount));

        $addon_id = DB::table('order_addons')->where('order_id', $request->order_id)->first();

        foreach ($iterator as $values) {
            $order_addons = DB::table('order_addons_details')
            ->insert([
                    'addon_id'=> $addon_id->id,
                    'reason'=>$values[0], 
                    'amount'=>$values[1],
                
                    ]);
        }
        $notification_title = "Added Addons";
        $order_id = $request->order_id;
        $user_id = $request->user_id;
        create_app_user_notification($notification_title, $user_id, 'sod', 'order', $order_id);

        Flash::success('Addon Added Successfully.');
        return redirect()->back();
    }

    public function order_accept($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $Model_Data = SvcOrder::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 5;
            if($Model_Data->type == 1){
                $Model_Data->status = 6;
            }
            $Model_Data->accepted_time = time();
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();


            $order_id = $Model_Data->id;
            $order_no = $Model_Data->order_no;
            $vend_id = $Model_Data->vend_id;
            $user_id = $Model_Data->user_id;
            $type = $Model_Data->type;

            //Creating Notifications
            {

                if($type == 0){

                    $notification_status = 5;
                    $notification_type_for = 1;
                    $notification_title = "Booking Accepted";
                    $notfication_message = 'Booking Accepted Against Order No. ' . $order_no;

                }
                elseif($type == 1){

                    $notification_status = 5;
                    $notification_type_for = 2;
                    $notification_title = "Request Accepted";
                    $notfication_message = 'Request Accepted Against Order No. ' . $order_no;

                }

                //For App Notification
                create_app_user_notification($notification_title, $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, $notification_type_for, $notification_status, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, $notification_type_for, $notification_status, $user_id, $order_no);

                //To Send Vendor Notification
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);


            }

            Flash::success('Order Accepted Successfully.');
            return redirect()->route($this->view_route,$id);
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function order_reject(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $order_id = $request->order_id;
            $reason = $request->reason;

            $Model_Data = SvcOrder::find($order_id);

            if (empty($Model_Data) || $this->is_not_authorized($order_id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 4;
            $Model_Data->declined_time = time();
            $Model_Data->decline_reason = $reason;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();


            $order_no = $Model_Data->order_no;
            $vend_id = $Model_Data->vend_id;
            $user_id = $Model_Data->user_id;
            $type = $Model_Data->type;

            //Creating Notifications
            {

                if($type == 0){

                    $notification_status = 4;
                    $notification_type_for = 1;
                    $notification_title = "Booking Declined";
                    $notfication_message = 'Booking Declined Against Order No. ' . $order_no;

                }
                elseif($type == 1){

                    $notification_status = 4;
                    $notification_type_for = 2;
                    $notification_title = "Request Declined";
                    $notfication_message = 'Request Declined Against Order No. ' . $order_no;

                }


                //For App Notification
                create_app_user_notification($notification_title, $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, $notification_type_for, $notification_status, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, $notification_type_for, $notification_status, $user_id, $order_no);

                //To Send Vendor Notification
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);

            }

            Flash::success('Order Declined Successfully.');
            return redirect()->route($this->view_route,$order_id);
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function order_status_change($id, $status)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {

            $Model_Data = SvcOrder::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = $status;


            $order_id = $Model_Data->id;
            $order_no = $Model_Data->order_no;
            $vend_id = $Model_Data->vend_id;
            $user_id = $Model_Data->user_id;


            if($status == 6){
                $Model_Data->team_left_time = time();
                Flash::success('Team Left Successfully.');

                $notification_status = 6;
                $notification_title = "Team Left";
                $notfication_message = 'Team Left Against Order No. ' . $order_no;
            }
            elseif($status == 7){
                $Model_Data->team_reached_time = time();
                Flash::success('Team Reached Successfully.');

                $notification_status = 7;
                $notification_title = "Team Reached";
                $notfication_message = 'Team Reached Against Order No. ' . $order_no;
            }
            elseif($status == 8){
                $Model_Data->service_delivered_time = time();
                Flash::success('Service Delivered Successfully.');

                $notification_status = 8;
                $notification_title = "Service Delivered";
                $notfication_message = 'Service Delivered Against Order No. ' . $order_no;
            }


            //Creating Notifications
            {

                //For App Notification
                create_app_user_notification($notification_title, $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, 1, $notification_status, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, 1, $notification_status, $user_id, $order_no);

                //To Send Vendor Notification
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);

            }

            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            return redirect()->route($this->view_route,$id);
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
            $Model_Data = SvcOrder::find($id);

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

    public function submit_quote(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $order_id = $request->order_id;

            $Order = SvcOrder::find($order_id);

            if (empty($Order) || $this->is_not_authorized($order_id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Order_Details = SvcOrderDetail::leftjoin('svc_services','svc_order_details.service_id','=','svc_services.id')
                ->leftjoin('svc_sub_services','svc_order_details.sub_service_id','=','svc_sub_services.id')
                ->select('svc_order_details.*','svc_order_details.id as detail_id','svc_services.title as service_title','svc_sub_services.title as sub_service_title')
                ->where('svc_order_details.order_id',$order_id)
                ->orderBy('svc_order_details.sub_cat_id','asc')
                ->orderBy('svc_order_details.service_id','asc')
                ->orderBy('svc_order_details.sub_service_id','asc')
                ->get();

            $sub_cat_id = array();
            if($Order->sub_cat_id > 0){
                $sub_cat_id[] = $Order->sub_cat_id;
            }
            else{
                foreach($Order_Details as $order_detail){
                    if($order_detail->sub_cat_id > 0){
                        $sub_cat_id[] = $order_detail->sub_cat_id;
                    }
                }
            }
            $Sub_Category = SvcSubCategory::whereIn('id', $sub_cat_id)->get();

            $order_value = 0;
            foreach($Sub_Category as $sub_cat){
                $field_id = $sub_cat->id;

                if(!isset($Order_Details) || empty($Order_Details) ||  count($Order_Details)==0)
                {
                    $field = "quote_price_".$field_id;
                    $quantity_field = "sub_cat_quantity_".$field_id;

                    if(isset($request->$field) && $request->$field != 0){
                        $Order->sub_cat_price = $request->$field;

                        $order_value += ($request->$field * $request->$quantity_field);

                        $Order->save();
                    }


                }
                else{

                    foreach($Order_Details as $order_Detail)
                    {
                        $detail_id = $order_Detail->detail_id;
                        $detail = SvcOrderDetail::find($detail_id);
                        if($order_Detail->sub_cat_id == $sub_cat->id)
                        {
                            $service_id = 0;
                            if($order_Detail->service_id != 0) {

                                $service_id = $order_Detail->service_id;
                                if($order_Detail->sub_service_id == 0){
                                    $field_id = $service_id;
                                    $field = "quote_price_".$field_id;
                                    $quantity_field = "sub_cat_quantity_".$field_id;

                                    if(isset($request->$field) && $request->$field != 0){
                                        $detail->service_price = $request->$field;
                                        $order_value += ($request->$field * $request->$quantity_field);
                                    }

                                }
                                else{
                                    $field_id = $order_Detail->sub_service_id;
                                    $field = "quote_price_".$field_id;
                                    $quantity_field = "sub_cat_quantity_".$field_id;

                                    if(isset($request->$field) && $request->$field != 0){
                                        $detail->sub_service_price = $request->$field;
                                        $order_value += ($request->$field * $request->$quantity_field);
                                    }
                                }

                            }

                            $detail->save();

                        }
                    }
                }
            }

            // Vat Inclusion
            {
                $vend_id = $Order->vend_id;
                $vat_exists = 0;
                $vat_include = 0;
                $vat_value = 0;
                $final_value = 0;

                $vat_details = get_vendor_bank_details_for_orders($vend_id);
                if ($vat_details != null && !empty($vat_details)) {
                    $vat_exists = 1;
                    $vat_include = $vat_details['vat_percentage'];
                    if ($vat_include > 0) {
                        $vat_include = 0;
                    } else {
                        $vat_include = 1;
                    }
                }
                if ($vat_exists == 0 || $vat_include == 1) {
                    $vat_include = get_vat_value();
                }

                if ($vat_include > 0) {
                    $vat_value = (($vat_include / 100) * $order_value);
                    $vat_value = round($vat_value, 2);
                }

                $final_value = ($order_value + $vat_value);

            }

            $Order->total = $order_value;
            $Order->vat_included = $vat_include;
            $Order->vat_value = $vat_value;
            $Order->final_value = $final_value;


            $Order->status = 7;
            $Order->save();



            $order_id = $Order->id;
            $order_no = $Order->order_no;
            $vend_id = $Order->vend_id;
            $user_id = $Order->user_id;

            //Creating Notifications
            {

                //For App Notification
                create_app_user_notification('Quote Submitted', $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, 2, 7, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, 2, 7, $user_id, $order_no);

                //To Send Vendor Notification
                $notfication_message = 'Quote Submitted Against Order No. ' . $order_no;
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);

            }


            Flash::success($this->submit_quote);
            return redirect()->route($this->view_route,$order_id);
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function get_notifications($id ,$vend_id, $module)
    {
        $vend_id = Auth::user()->vend_id;

        $notification_id = 0;
        if(is_numeric($id))
        {
            $notification_id = $id;
        }

        $notifications = BackendNotification::where('id', '>', $notification_id)->where('user_id', $vend_id)->where('module', $module)->where('read_status','=',0)->where('status',1)->get();

        $str = 0;
        if(count($notifications) >= 1)
        {
            $str = '';
            foreach($notifications as $notification)
            {

                $str.='<div class="notify_id row" data-last_id="'.$notification->id.'">
                            <div class="col-sm-10">
                                <a href="'.route($this->view_route, $notification->type_id).'" onclick="mark_as_read('.$notification->id.')" class="dropdown-item has-icon" style="white-space: pre-line;">
                                '.$notification->message.'<br>
                                <small>'.date("Y-m-d h:i a",strtotime($notification->created_at)).'</small>
                                </a>
                            </div>
                            <a id="'.$notification->id.'" class="col-sm-2" title="Mark As Read" onclick="mark_as_read('.$notification->id.')">
                                <i class="far fa-envelope-open child"></i>
                            </a>
                        </div>';
            }
        }
        return $str;
    }

    public function read_notifications($id)
    {
        $str = 0;
        if(BackendNotification::where('id',$id)->update(['read_status'=>1,'read_time'=>time()])){
            $str = 1;
        }

        return $str;
    }

}

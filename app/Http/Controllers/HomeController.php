<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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



use App\Models\BadWord;
use App\Models\Report;



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

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
		$Auth_User = Auth::user();	
				
		$today = Carbon::today();
		$yesterday = Carbon::yesterday();
		$previousday = Carbon::now()->subDays(2);
			
		$sellers_array = array();
		$svc_vendor_array = array();
		$app_user_data = array();
		$categories = array();
			
		$user_type = $Auth_User->user_type;

		if($user_type == 'admin')
		{
			
            $svc_vendor_array = SvcVendor::select(['id', 'name'])
                ->where('id', '>=', 1)
                ->where('status', '=', 1)
                ->orderby('name', 'asc')
                ->pluck('name', 'id');

            $app_user_data = SvcOrder::leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
                ->select('app_users.id as app_user_id', 'app_users.name as app_user_name')
                ->pluck('app_user_name', 'app_user_id');

            $categories = SvcCategory::where('status',1)->pluck('title', 'id');
		}
		elseif($user_type == 'vendor')
		{
            $app_user_data = SvcOrder::leftjoin('app_users', 'svc_orders.user_id', '=', 'app_users.id')
                ->select('app_users.id as app_user_id', 'app_users.name as app_user_name')
                ->pluck('app_user_name', 'app_user_id');

            $categories = SvcCategory::where('status',1)->pluck('title', 'id');
		}
		elseif($user_type == 'seller')
		{
		}
		
        return view('dashboard', compact('sellers_array', 'svc_vendor_array', 'app_user_data', 'categories'));
    }
}

<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Api\BaseApiController as BaseController;



use App\Models\GeneralSetting;


use App\Models\HomeItem;
use App\Models\OccasionType;
use App\Models\SvcCategory;

use App\Models\SvcSubCategory;

use App\Models\SvcService;

use App\Models\SvcSubService;



use App\Models\SvcVendor;

use App\Models\SvcVendorCategory;

use App\Models\SvcVendorSubCategory;

use App\Models\SvcVendorService;



use App\Models\SvcReview;



use App\Models\SvcOrder;

use App\Models\SvcOrderFile;

use App\Models\SvcOrderDetail;

use App\Models\SvcOrderSubDetail;



use App\Models\User;

use App\Models\AppUser;

use App\Models\AppUserLocation;

use App\Models\PaymentMethod;

use App\Models\AppUserPaymentMethod;

use App\Models\AppUserFavorite;

use App\Models\AppUserQuery;



use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Events\Registered;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Validator;



use File;
    
    
    
class HomeApiController extends BaseController    
{
	private $_token = null;
	private $lat= null;    
	private $lng=null;	
	private $radius=null;        
	
	public function retMethod(Request $request, $action='listing')
	{
        ((!empty($request->header('token'))) ? $this->_token=$request->header('token') : $this->_token=null);

        $token =  $this->_token;
        if(!empty($token))
        {
            $Verifications = DB::table('verification_codes')->where('token', $token)->where('expired', 1)->first();
            if(empty($Verifications))
            {
                $response = [
                    'code' => '201',
                    'status' => false,
                    'token' => $token,
                    'data' => null,
                    'message' => 'Incorrect Access Token!',
                ];
                return response()->json($response,200);
            }
        }
		// else
        // {
        //     return $this->sendError('Please Provide valid Access Token');
        // }
		
		$user_id = 0;
        $User = getUser($this->_token);
        if($User!=null)
        {
            $user_id = $User->id;
        }
        // else
        // {
        //     return $this->sendError('Incorrect Access Token Provided');
        // }
        

        ((!empty($request->header('lat'))) ? $this->lat=$request->header('lat') : $this->lat=null);        

        ((!empty($request->header('lng'))) ? $this->lng=$request->header('lng') : $this->lng=null);        

        ((!empty($request->header('radius'))) ? $this->radius=$request->header('radius') : $this->radius=5);
		
		$page = 1;
		$limit = 10;
		(isset($request->page) ? $page = trim($request->page) : 1);
		(isset($request->limit) ? $limit = trim($request->limit) : 10);
		
		switch($action)		
		{	
			case 'home-listing':
			{
				return $this->homeListing($page, $limit);
			}	
			break;
			
			case 'home-favorite-listing':
			{
				if(!empty($token))
				{
					return $this->favoriteVendorListing($page, $limit);
				}
				else
				{
					return $this->sendError('Please login first to get favorite vendors listing');
				}
			}	
			break;
			
			case 'show-all-categories':
			{
				return $this->showAllCategories($page, $limit);
			}	
			break;
			
			case 'show-all-featured':
			{
				return $this->showAllFeatured($page, $limit);
			}	
			break;
			
			case 'show-all-exclusive':
			{
				return $this->showAllExclusive($page, $limit);
			}	
			break;
			
			case 'home-items':
			{
				return $this->showHomeItems($page, $limit);
			}	
			break;
			
			case 'occasion-types':
			{
				return $this->showOccasionTypes($page, $limit);
			}
			break;

			// case 'show-all-rewards':
			// {
				
			// 	$type_id = 0;
					
			// 	(isset($request->type_id) ? $type_id = trim($request->type_id) : 0);
					
			// 	return $this->showAllRewards();
			// }	

			//break;
			
			default:				
			{					
				return $this->sendError('Invalid Request');					
			}				
			break;
		}
	}
	
	
	
	public function homeListing($page, $limit)
	
	{
		
		$skip = (($page-1)*$limit);
		
		$data = array();
		
		
		
		// Categories
		
		{
			
			$categories = null;
			
			$Records = SvcCategory::where(['status'=>1]);
			$Records = $Records->orderBy('is_order', 'asc');
			$Records = $Records->skip($skip);
			$Records = $Records->take($limit);
			$Records = $Records->get();
			
			
			if(!empty($Records))
			{
				$records_data =  array();
				foreach($Records as $model)
				{
					$categories[] = get_category_array($model);
				}
				
			}
			
			$n_arr = array();
			$n_arr['type'] = 'categories';
			$n_arr['data'] = $categories;
			$data[] = $n_arr;
			
		}
		
		
		// user Orders listing
		{
			$User = getUser($this->_token);
			if(!empty($User))

			{
				$user_id = $User->id;
				
				$count_all = SvcOrder::leftjoin('app_users','svc_orders.user_id','=','app_users.id');
				$count_all = $count_all->where(['svc_orders.status'=>6,'svc_orders.user_id'=>$user_id,'app_users.status'=>1]);
				$count_all = $count_all->select(['svc_orders.id']);
				$count_all = $count_all->count();
				
				$Records = SvcOrder::leftjoin('app_users','svc_orders.user_id','=','app_users.id');
				$Records = $Records->where(['svc_orders.status'=>6,'svc_orders.user_id'=>$user_id,'app_users.status'=>1]);
				$Records = $Records->select(['svc_orders.*']);
				$Records = $Records->skip($skip);
				$Records = $Records->take($limit);
				$Records = $Records->get();
				
				$orders =  array();
				$page_count = 0;
				
				if(!empty($Records))
				{
					foreach($Records as $record)
					{
						$id	= $record->id;
						$orders[] = get_order_data($id);
					}
					$page_count = count($orders);
				}
				
				if(count($orders) == 0)
					$orders = null;
				
				
				$n_arr = array();
				$n_arr['type'] = 'user_orders';
				$n_arr['page_count'] = $page_count;
				$n_arr['total_count'] =$count_all;
				$n_arr['data'] = $orders;
				
				$data[] = $n_arr;
			}
		}
		
		
		// Categories With Sub-Categories
		{
			
			$records_data = null;
			
			$Records = SvcCategory::where(['status'=>1]);
			$Records = $Records->skip($skip);
			$Records = $Records->take($limit);
			$Records = $Records->get();
			
			
			$records_data = null;
			if(!empty($Records))
			{
				$records_data =  array();
				foreach($Records as $model)
				{
					$records_data[] = $this->get_category_with_sub_category_array($model);
				}
				
			}
			
			
			$n_arr = array();
			$n_arr['type'] = 'categories_with_sub_categories';
			$n_arr['data'] = $records_data;
			$data[] = $n_arr;
			
		}
		
		// near-by vendor
		{
			$near_by_vendor = array();
			
			if($this->lat!=null && $this->lng!=null && $this->radius!=null )
			{
				$near_by_vendor = null;
				
				$n_arr = array();
				
				$n_arr['type'] = 'nearby_vendors';
				$n_arr['total_count'] = 0;
				
				$array_data = $this->get_nearby_vendors($this->lat, $this->lng, $this->radius,$page,$limit);
				if(!empty($array_data))
				{
					$near_by_vendor = $array_data;
					$n_arr['total_count'] = count($near_by_vendor);
				}
				
				$n_arr['data'] = $near_by_vendor;
				$data[] = $n_arr;
			}
		}
		
		// Exclusive Vendors
		{
			$count_all = SvcVendor::where(['status'=>1,'is_exclusive'=>1]);
			$count_all = $count_all->select(['id']);
			$count_all = $count_all->count();
			
			$Records = SvcVendor::where(['status'=>1,'is_exclusive'=>1]);
			$Records = $Records->select(['id','name','arabic_name','description','arabic_description','image', 'location']);
			$Records = $Records->skip($skip);
			$Records = $Records->take($limit);
			$Records = $Records->get();
			
			
			
			$exclusive = null;
			$page_count = 0;
			
			if(!empty($Records))
			{
				$array_data = exclusive_data($Records);
				if(!empty($array_data))
				{
					$exclusive = $array_data;
					$page_count = count($exclusive);
				}
			}
			
			$n_arr = array();
			$n_arr['type'] = 'exclusive_vendors';
			$n_arr['page_count'] = $page_count;
			$n_arr['total_count'] =$count_all;
			$n_arr['data'] = $exclusive;
			$data[] = $n_arr;
			
		}
		
		// Contact Details
		{
			$Records = GeneralSetting::All();
			$contact_details = null;
			
			foreach($Records as $Record)
			{
				$contact_details[$Record->title] = $Record->value;
			}
			$n_arr = array();
			$n_arr['type'] = 'contact_details';
			$n_arr['data'] = $contact_details;
			$data[] = $n_arr;
			
		}
		
		
		// Featured Categories
		
		/*{

			$count_all = SvcCategory::where(['svc_categories.is_featured'=>1,'svc_categories.status'=>1]);

			$count_all = $count_all->select(['categories.id']);

			$count_all = $count_all->count();

			

			$Records = SvcCategory::where(['svc_categories.is_featured'=>1,'svc_categories.status'=>1]);

			$Records = $Records->select(['svc_categories.*']);

			$Records = $Records->skip($skip);

			$Records = $Records->take($limit);

			$Records = $Records->get();

			

			$categories = null;

			$page_count = 0;

			

			if(!empty($Records))

			{

				$array_data = categories_data($Records);

				if(!empty($array_data))

				{

					$categories = $array_data;

					$page_count = count($categories);

				}

			}

			

			$n_arr = array();

				$n_arr['type'] = 'featured_categories';

				$n_arr['page_count'] = $page_count;

				$n_arr['total_count'] = $count_all;

				$n_arr['data'] = $categories;

			$data[] = $n_arr;

		}*/
		
		
		
		// Featured Vendors
		/*{
			$count_all = SvcVendor::where(['status'=>1,'is_featured'=>1]);
			$count_all = $count_all->select(['id']);
			$count_all = $count_all->count();
			
			$Records = SvcVendor::where(['status'=>1,'is_featured'=>1]);
			$Records = $Records->select(['id','name','arabic_name','description','arabic_description','image', 'location']);
			$Records = $Records->skip($skip);
			$Records = $Records->take($limit);
			$Records = $Records->get();
			
			
			$featured = null;
			$page_count = 0;
			
			if(!empty($Records))
			{
				$array_data = featured_data($Records);
				if(!empty($array_data))
				{
					$featured = $array_data;
					$page_count = count($featured);
				}
			}
			
			$n_arr = array();
			$n_arr['type'] = 'featured_vendors';
			$n_arr['page_count'] = $page_count;
			$n_arr['total_count'] =$count_all;
			$n_arr['data'] = $featured;
			$data[] = $n_arr;
		}*/
		
		
		
		// user favorite listing
		
		/*{
			
			$User = getUser($this->_token);
			
			if(!empty($User))
			
			{
				
				$user_id = $User->id;
				
				
				
				$count_all = SvcVendor::leftjoin('svc_app_user_favorites','svc_vendors.id','=','svc_app_user_favorites.vend_id');
				
				$count_all = $count_all->where(['svc_vendors.status'=>1,'svc_app_user_favorites.user_id'=>$user_id]);
				
				$count_all = $count_all->select(['svc_vendors.id']);
				
				$count_all = $count_all->count();
				
				
				
				$Records = SvcVendor::leftjoin('svc_app_user_favorites','svc_vendors.id','=','svc_app_user_favorites.vend_id');
				
				$Records = $Records->where(['svc_vendors.status'=>1,'svc_app_user_favorites.user_id'=>$user_id]);
				
				
				
				$Records = $Records->select(['svc_vendors.id']);
				
				
				
				$Records = $Records->skip($skip);
				
				$Records = $Records->take($limit);
				
				$Records = $Records->get();
				
				
				
				
				
				$favorites =  array();
				
				$page_count = 0;
				
				
				
				if(!empty($Records))
				
				{
					
					foreach($Records as $record)
					
					{
						
						$id	= $record->id;
						
						$modelData = SvcVendor::find($id);
						
						$favorites[]= common_home($modelData, $this->_token, $this->lat ,$this->lng);
						
					}
					
					$page_count = count($favorites);
					
				}
				
				
				
				if(count($favorites) == 0)
					
					$favorites = null;
				
				
				
				$n_arr = array();
				
				$n_arr['type'] = 'favorite_vendors';
				
				$n_arr['page_count'] = $page_count;
				
				$n_arr['total_count'] =$count_all;
				
				$n_arr['data'] = $favorites;
				
				
				
				$data[] = $n_arr;
				
			}
			
		}*/
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => 'Home Listing retrieved successfully.',
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
		
	}
	
	public function showAllCategories($page=1, $limit=10)
	
	{
		
		
		
		$skip = (($page-1)*$limit);
		
		
		
		$count_all = SvcCategory::where(['svc_categories.is_featured'=>1,'svc_categories.status'=>1]);
		
		$count_all = $count_all->select(['svc_categories.id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records = SvcCategory::where(['svc_categories.is_featured'=>1,'svc_categories.status'=>1]);
		
		$Records = $Records->select(['svc_categories.*']);
		
		$Records = $Records->skip($skip);
		
		$Records = $Records->take($limit);
		
		$Records = $Records->get();
		
		
		
		$categoriess = null;
		
		$page_count = 0;
		
		$message  = 'No Record Found.';
		
		
		
		if(!empty($Records))
		
		{
			
			$array_data = categories_data($Records, $this->_token, $this->lat ,$this->lng);
			
			if(!empty($array_data))
			
			{
				
				$categoriess = $array_data;
				
				$page_count = count($array_data);
				
				$message  = 'All Category Listing retrieved successfully.';
				
			}
			
		}
		
		
		
		$data = array();
		
		$data['type'] = 'featured_categories';
		
		$data['page'] = $page;
		
		$data['limit'] = $limit;
		
		$data['page_count'] = $page_count;
		
		$data['total_count'] = $count_all;
		
		$data['categories'] = $categoriess;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => $message,
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
		
	}
	
	public function showAllFeatured($page=1, $limit=10)
	
	{
		
		
		
		$skip = (($page-1)*$limit);
		
		
		
		$count_all = SvcVendor::where(['status'=>1,'is_featured'=>1]);
		
		$count_all = $count_all->select(['id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records = SvcVendor::where(['status'=>1,'is_featured'=>1]);
		
		$Records = $Records->select(['id','name','arabic_name','description','arabic_description','image', 'location']);
		
		$Records = $Records->orderBy('id','DESC');
		
		$Records = $Records->skip($skip);
		
		$Records = $Records->take($limit);
		
		$Records = $Records->get();
		
		
		
		$featured = null;
		
		$page_count = 0;
		
		$message  = 'No Record Found.';
		
		
		
		if(!empty($Records))
		
		{
			
			$array_data = featured_data($Records, $this->_token, $this->lat ,$this->lng);
			
			if(!empty($array_data))
			
			{
				
				$featured = $array_data;
				
				$page_count = count($array_data);
				
				$message  = 'All Featured Listing retrieved successfully.';
				
			}
			
		}
		
		
		
		$data = array();
		
		$data['type'] = 'featured_vendors';
		
		$data['page'] = $page;
		
		$data['limit'] = $limit;
		
		$data['page_count'] = $page_count;
		
		$data['total_count'] =$count_all;
		
		$data['vendors'] = $featured;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => $message,
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
		
	}
	
	public function showAllExclusive($page=1, $limit=10)
	
	{
		
		
		
		$skip = (($page-1)*$limit);
		
		
		
		$count_all = SvcVendor::where(['status'=>1,'is_exclusive'=>1]);
		
		$count_all = $count_all->select(['id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records = SvcVendor::where(['status'=>1,'is_exclusive'=>1]);
		
		$Records = $Records->select(['id','name','arabic_name','description','arabic_description','image', 'location']);
		
		$Records = $Records->orderBy('id','DESC');
		
		$Records = $Records->skip($skip);
		
		$Records = $Records->take($limit);
		
		$Records = $Records->get();
		
		
		
		$exclusive = null;
		
		$page_count = 0;
		
		$message  = 'No Record Found.';
		
		
		
		if(!empty($Records))
		
		{

			$array_data = exclusive_data($Records, $this->_token, $this->lat ,$this->lng);
			
			if(!empty($array_data))
			
			{
				
				$exclusive = $array_data;
				
				$page_count = count($array_data);
				
				$message  = 'All Exclusive Listing retrieved successfully.';
				
			}
			
		}
		
		
		
		$data = array();
		
		$data['type'] = 'exclusive_vendors';
		
		$data['page'] = $page;
		
		$data['limit'] = $limit;
		
		$data['page_count'] = $page_count;
		
		$data['total_count'] = $count_all;
		
		$data['vendors'] = $exclusive;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => $message,
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
		
	}


	public function showHomeItems($page=1, $limit=10)

	{



		$skip = (($page-1)*$limit);



		$count_all = HomeItem::where(['status'=>1]);

		$count_all = $count_all->select(['id']);

		$count_all = $count_all->count();



		$Records = HomeItem::where(['status'=>1]);

		$Records = $Records->orderBy('id','DESC');

		$Records = $Records->skip($skip);

		$Records = $Records->take($limit);

		$Records = $Records->get();



		$items = null;

		$page_count = 0;

		$message  = 'No Record Found.';



		if(!empty($Records))

		{

			foreach ($Records as $record){
				$array = array();
				$array['id'] = $record->id;
				$array['title'] = $record->title;
				$array['ar_title'] = $record->ar_title;

				$array_data[] = $array;
			}

			if(!empty($array_data))

			{

				$items = $array_data;

				$page_count = count($array_data);

				$message  = 'Home Items retrieved successfully.';

			}

		}



		$data = array();

		$data['type'] = 'Home Items';

		$data['page'] = $page;

		$data['limit'] = $limit;

		$data['page_count'] = $page_count;

		$data['total_count'] = $count_all;

		$data['home_items'] = $items;



		$response = [

			'code' => '201',

			'status' => true,

			'message' => $message,

			'data' => $data,

		];

		return response()->json($response,200);

	}

	public function showOccasionTypes($page=1, $limit=10)
	{
		$skip = (($page-1)*$limit);

		$count_all = OccasionType::where(['status'=>1]);
		$count_all = $count_all->select(['id']);
		$count_all = $count_all->count();

		$Records = OccasionType::where(['status'=>1]);
		$Records = $Records->orderBy('id','DESC');
		$Records = $Records->skip($skip);
		$Records = $Records->take($limit);
		$Records = $Records->get();

		$occasions = null;
		$page_count = 0;
		$message  = 'No Record Found.';

		if(!empty($Records))
		{
			foreach ($Records as $record){
				$array = array();
				$array['id'] = $record->id;
				$array['title'] = $record->title;
				$array['ar_title'] = $record->ar_title;

				$array_data[] = $array;
			}

			if(!empty($array_data))
			{
				$occasions = $array_data;
				$page_count = count($array_data);
				$message  = 'Occasion Types retrieved successfully.';
			}
		}

		$data = array();

		$data['type'] = 'Occasion Types';
		$data['page'] = $page;
		$data['limit'] = $limit;
		$data['page_count'] = $page_count;
		$data['total_count'] = $count_all;
		$data['occasion_types'] = $occasions;

		$response = [
			'code' => '201',
			'status' => true,
			'message' => $message,
			'data' => $data,
		];

		return response()->json($response,200);
	}
	
	public function favoriteVendorListing($page=1, $limit=10)
	
	{
		
		
		
		$skip = (($page-1)*$limit);
		
		
		
		$user_id=-1;
		
		$User = getUser($this->_token);
		
		if($User!=null)
		
		{
			
			$user_id = $User->id;
			
		}
		
		
		
		$count_all = SvcVendor::leftjoin('svc_app_user_favorites','svc_vendors.id','=','svc_app_user_favorites.vend_id');
		
		$count_all = $count_all->where(['svc_vendors.status'=>1, 'svc_app_user_favorites.user_id'=>$user_id]);
		
		$count_all = $count_all->select(['svc_vendors.id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records = SvcVendor::leftjoin('svc_app_user_favorites','svc_vendors.id','=','svc_app_user_favorites.vend_id');
		
		$Records = $Records->where(['svc_vendors.status'=>1, 'svc_app_user_favorites.user_id'=>$user_id]);
		
		$Records = $Records->select(['svc_vendors.id']);
		
		$Records = $Records->get();
		
		
		
		$favorites = array();
		
		$page_count = 0;
		
		$message  = 'All Favorite Listing retrieved successfully.';
		
		
		
		if(!empty($Records))
		
		{
			
			$favorites = array();
			
			foreach($Records as $record)
			
			{
				
				$id	= $record->id;
				
				$modelData = SvcVendor::find($id);
				
				$array = common_home($modelData, $this->_token, $this->lat ,$this->lng);
				
				$favorites[] = $array;
				
			}
			
			$page_count = count($favorites);
			
			if($page_count == 0)
			
			{
				
				$favorites = null;
				
				$message  = 'No Record Found.';
				
			}
			
		}
		
		
		
		$data = array();
		
		$data['type'] = 'favorite_vendors';
		
		$data['page'] = $page;
		
		$data['limit'] = $limit;
		
		$data['page_count'] = $page_count;
		
		$data['total_count'] = $count_all;
		
		$data['vendors'] = $favorites;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => $message,
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
		
	}
	
	public function get_nearby_vendors($lat, $lng, $radius=5, $page=1, $limit=10)
	
	{
		
		$skip = (($page-1)*$limit);
		
		//->skip($skip)->take($limit)
		
		//skip is not working on this method
		
		
		
		$Response = array();
		
		if((!empty($lat)||$lat==null) && !empty($lng)||$lng==null)
		
		{
			
			//$radius = 5;
			
			
			
			$modelData = SvcVendor::select("*", DB::raw("6371 * acos(cos(radians(" . $lat . "))

				  * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))

			+ sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));
			
			$modelData          =       $modelData->having('distance', '<', $radius);
			
			$modelData          =       $modelData->orderBy('distance', 'asc');
			
			$modelDatas          =       $modelData->get();
			
			if (is_null($modelDatas) || count($modelDatas) < 1)
			
			{
				
				//return $this->sendError('No Vendor found near by within 5 km radius.');
				
			}
			
			
			
			$data_array=array(); //this also part of a
			
			foreach($modelDatas as $modelData)
			
			{
				
				$id	= $modelData->id;
				
				//bofore
				
				//$Response[] = common_home($modelData, $this->_token, $this->lat ,$this->lng);
				
				
				
				//after
				
				$data_array['vendor'] = common_home($modelData, $this->_token, $this->lat ,$this->lng);
				
				$Response[] = $data_array;
				
			}
			
			
			
		}
		
		return $Response;
		
	}
	
	
	
	public function get_category_with_sub_category_array($record)
	{
		$record_id = $record->id;
		
		$subcategories =  null;
		if($record->has_subcategories == 1)
		{
			$subcategories =  array();
			
			$modelData = SvcSubCategory::where('cat_id', '=', $record_id)->where('status', '=', '1')->get();
			foreach($modelData as $model)
			{
				$subcategories[] = $this->get_sub_category_array($model);
			}
			if(count($subcategories) == 0)
			{
				$subcategories = null;
			}
		}
		
		$image = $record->icon;
		$image_path = 'svc/categories/';
		if($image == 'category.png')
		{
			$image_path = 'defaults/';
		}
		$image_path.= $image;
		$image = uploads($image_path);
		
		$array = array();
		
		$array['id'] = $record->id;
		$array['title'] = $record->title;
		$array['ar_title'] = $record->ar_title;
		$array['description'] = $record->description;
		$array['ar_description'] = $record->ar_description;
		$array['image'] = $image;
		$array['has_subcategories'] = $record->has_subcategories;
		$array['subcategories'] = $subcategories;
		
		return $array;
		
	}
	
	public function get_sub_category_array($record)
	{
		$record_id = $record->id;
		
		$image = $record->icon;
		$image_path = 'svc/sub_categories/';
		if($image == 'sub_category.png')
		{
			$image_path = 'defaults/';
		}
		$image_path.= $image;
		$image = uploads($image_path);
		
		$array = array();
		
		$array['id'] = $record->id;
		$array['cat_id'] = $record->cat_id;
		$array['title'] = $record->title;
		$array['ar_title'] = $record->ar_title;
		$array['description'] = $record->description;
		$array['ar_description'] = $record->ar_description;
		$array['image'] = $image;
		
		return $array;
		
	}
	


	public function showAllRewards()
		
	{
		return 0;
		
		$skip=($page-1)*$limit;
		
		echo $type_id;
		
		$count_all = Reward::leftjoin('restaurants','rewards.rest_id','=','restaurants.id');
		
		$count_all = $count_all->where(['rewards.status'=>1,'restaurants.status'=>1]);
		
		if($type_id>0)
		
		{
			$count_all = $count_all->where(['rewards.type'=>$type_id]);
		}
		
		$count_all = $count_all->select(['rewards.id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records = Reward::leftjoin('restaurants','rewards.rest_id','=','restaurants.id');
		
		$Records = $Records->where(['rewards.status'=>1,'restaurants.status'=>1]);
		if($type_id>0)
		{
			$Records = $Records->where(['rewards.type'=>$type_id]);
		}
		
		$Records = $Records->select(['rewards.id','rewards.rest_id','rewards.min_orders','rewards.min_order_value','rewards.type','rewards.apply_type','rewards.fixed_value','rewards.discount_percentage','rewards.has_limitations','rewards.intervals','rewards.start_date','rewards.end_date']);
		
		$Records = $Records->orderBy('rewards.id','DESC');
		
		$Records = $Records->skip($skip);
		
		$Records = $Records->take($limit);
		
		$Records = $Records->get();
		
		
		
		$rewards = null;
		
		$message  = 'No Record Found.';
		
		
		
		if( !empty($Records))
		
		{
			
			$array_data = rewards_data($Records, $this->_token, $this->lat ,$this->lng, 'home');
			
			if(!empty($array_data))
			
			{
				
				$rewards = $array_data;
				$message  = 'All Rewards Listing retrieved successfully.';
				
			}
			
		}
		
		
		
		$data = array();
		
		$n_arr = array();
		
		$n_arr['type'] = 'rewards';
		
		$n_arr['page'] = $page;
		
		$n_arr['limit'] = $limit;
		
		$n_arr['page_count'] = count($Records);
		
		$n_arr['total_count'] =$count_all;
		
		$n_arr['data'] = $rewards;
		
		$data = $n_arr;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'data' => $data,
			
			'message' => $message,
		
		];
		
		return response()->json($response,200);
		
	}
	
}


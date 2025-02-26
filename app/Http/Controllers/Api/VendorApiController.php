<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Api\BaseApiController as BaseController;



use App\Models\GeneralSetting;



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



class VendorApiController extends BaseController
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
		else
        {
           // return $this->sendError('Please Provide valid Access Token');
        }
		
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



        $title = '';

        $location = '';

        if (isset($request->title))

        {

            $title = trim($request->title);

        }

        if (isset($request->location))

        {

            $location = trim($request->location);

        }



        if($action == 'listing')

        {

            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)))

            {

                return $this->filterVendors($title, $location, $page, $limit);

            }

            else

            {

                return $this->index($page, $limit);

            }

        }

        elseif($action == 'timings-by-date')

        {

            if (isset($request->vend_id) && !empty($request->vend_id) && isset($request->date) && !empty($request->date))
            {

                return $this->vendor_timings_by_date($request->vend_id,$request->date);

            }

            else

            {

                return $this->sendError('Missing Parameters');

            }

        }

        elseif($action == 'listing_by_categories')

        {

            $cat_id = 0;

            if (isset($request->cat_id))

            {

                $cat_id = trim($request->cat_id);

            }



            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)) || ($cat_id != 0 && !empty($cat_id)))

            {

                return $this->filter_by_category($title, $location, $cat_id, $page, $limit);

            }

            else

            {

                return $this->sendError('Invalid Request');

            }

        }

        elseif($action == 'listing_by_sub_categories')

        {

            $sub_cat_id = 0;

            if (isset($request->sub_cat_id))

            {

                $sub_cat_id = trim($request->sub_cat_id);

            }



            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)) || ($sub_cat_id != 0 && !empty($sub_cat_id)))

            {

                return $this->filter_by_sub_category($title, $location, $sub_cat_id, $page, $limit);

            }

            else

            {

                return $this->sendError('Invalid Request');

            }

        }

        elseif($action == 'listing_by_services')

        {

            $service_id = 0;

            if (isset($request->service_id))

            {

                $service_id = trim($request->service_id);

            }



            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)) || ($service_id != 0 && !empty($service_id)))

            {

                return $this->filter_by_service($title, $location, $service_id, $page, $limit);

            }

            else

            {

                return $this->sendError('Invalid Request');

            }

        }

        elseif($action == 'listing_by_sub_services')

        {

            $sub_service_id = 0;

            if (isset($request->sub_service_id))

            {

                $sub_service_id = trim($request->sub_service_id);

            }



            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)) || ($sub_service_id != 0 && !empty($sub_service_id)))

            {

                return $this->filter_by_sub_service($title, $location, $sub_service_id, $page, $limit);

            }

            else

            {

                return $this->sendError('Invalid Request');

            }

        }

        elseif($action == 'listing_by_any')

        {

            if(($title != '' && !empty($title)) || ($location != '' && !empty($location)))

            {

                return $this->filter_by_any($request, $page, $limit);

            }

            else

            {

                return $this->sendError('Invalid Request');

            }

        }

        elseif($action == 'near_by')

        {

            if($this->lat!=null && $this->lng!=null && $this->radius!=null )

            {

                return $this->get_nearby_vendors($request, $page, $limit, $this->lat, $this->lng, $this->radius);

            }

            else

            {

                return $this->sendError('Please provide Restaurant Latitude & Longitude.');

            }

        }

        elseif(isset($request->id))

        {

            $id = trim($request->id);

            if ($id != null && !empty($id))

            {

                $modelData = SvcVendor::find($id);

                if (is_null($modelData) )

                {

                    return $this->sendError('Vendor Details not found.');

                    exit;

                }

                switch($action)

                {

                    case 'details':

                        {

                            return $this->details($modelData);

                        }

                        break;



                    case 'contact_details':

                        {

                            return $this->contact_details($modelData);

                        }

                        break;



                    case 'location_details':

                        {

                            return $this->location_details($modelData);

                        }

                        break;



                    case 'categories':

                        {

                            return $this->categories($modelData);

                        }

                        break;



                    case 'subcategories':

                        {

                            return $this->subcategories($modelData);

                        }

                        break;

                    case 'subcategories_of_category':

                        {

                            if(isset($request->cat_id))

                            {

                                $cat_id = trim($request->cat_id);

                                if ($cat_id != null && !empty($cat_id))

                                {

                                    return $this->subcategories($modelData, $cat_id);

                                }

                            }

                            return $this->sendError('Parameters Missing.');

                        }

                        break;



                    case 'services':

                        {

                            return $this->services($modelData);

                        }

                        break;

                    case 'services_of_sub_category':

                        {

                            if(isset($request->sub_cat_id))

                            {

                                $sub_cat_id = trim($request->sub_cat_id);

                                if ($sub_cat_id != null && !empty($sub_cat_id))

                                {

                                    return $this->services($modelData, $sub_cat_id);

                                }

                            }

                            return $this->sendError('Parameters Missing.');



                        }

                        break;



                    case 'sub_services':

                        {

                            return $this->subservices($modelData);

                        }

                        break;

                    case 'sub_services_of_service':

                        {

                            if(isset($request->service_id))

                            {

                                $service_id = trim($request->service_id);

                                if ($service_id != null && !empty($service_id))

                                {

                                    return $this->subservices($modelData, $service_id);

                                }

                            }

                            return $this->sendError('Parameters Missing.');

                        }

                        break;



                    case 'reviews':

                        {

                            return $this->reviews($modelData);

                        }

                        break;

                    default:

                        {

                            return $this->sendError('Invalid Request');

                        }

                        break;

                }

            }

            else

            {

                return $this->sendError('Please Provide Vendor id in Request');

                exit;

            }

        }

        else

        {

            return $this->sendError('Invalid Request');

            exit;

        }

    }











    public function index($page, $limit)

    {



        $skip = (($page-1)*$limit);



        $count_all = SvcVendor::where(['status'=>1]);

        $count_all = $count_all->select(['id']);

        $count_all = $count_all->count();



        $Records = SvcVendor::where(['status'=>1]);

        $Records = $Records->orderBy('id','DESC');

        $Records = $Records->skip($skip);

        $Records = $Records->take($limit);

        $Records = $Records->get();



        $vendors = null;

        $page_count = 0;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $vendors =  array();

            foreach($Records as $model)

            {

                $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

            }

            if(!empty($vendors))

            {

                $page_count = count($vendors);

                $message  = 'All Vendor Listing retrieved successfully.';

            }

        }



        $data = array();

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];

        return response()->json($response,200);

    }


    public function vendor_timings_by_date($vend_id, $date)

    {




        $Records = SvcVendor::where(['status'=>1]);

        $Records = $Records->where('id',$vend_id);

        $Records = $Records->get();



        $vendors = null;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $timings =  array();

            foreach($Records as $model)

            {

                $timings = get_vendor_timings_data($model, false, $date);

            }

            if(!empty($timings))

            {

                $message  = 'Timings Data retrieved successfully.';

            }

        }



//        $data = array();
//
//        $data['timings'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'data' => $timings,

            'message' => $message,

        ];

        return response()->json($response,200);

    }



    public function filterVendors($title, $location, $page, $limit)

    {



        $skip = (($page-1)*$limit);



        $count_all = SvcVendor::select(['svc_vendors.id']);

        if($title != null && !empty($title))

        {

            $count_all = $count_all->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $count_all = $count_all->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $count_all = $count_all->where(['svc_vendors.status'=>1]);

        $count_all = $count_all->count();







        $Records = SvcVendor::select(['svc_vendors.*']);

        if($title != null && !empty($title))

        {

            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['svc_vendors.status'=>1]);

        $Records = $Records->orderBy('svc_vendors.id','DESC');

        $Records = $Records->skip($skip);

        $Records = $Records->take($limit);

        $Records = $Records->get();



        $vendors = null;

        $page_count = 0;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $vendors =  array();

            foreach($Records as $model)

            {

                $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

            }

            if(!empty($vendors))

            {

                $page_count = count($vendors);

                $message  = 'All Vendor Listing retrieved successfully.';

            }

        }



        $data = array();

        $data['filter_title'] = $title;

        $data['filter_location'] = $location;

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];

        return response()->json($response,200);

    }



    public function filter_by_category($title, $location, $cat_id, $page, $limit)

    {

        $skip = (($page-1)*$limit);


        $vendor_ids = array();

        $Records = SvcVendor::select(['svc_vendors.id']);
        if($title != null && !empty($title))
        {
            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');
        }

        if($location != null && !empty($location))
        {
            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');
        }

        $Records = $Records->where(['svc_vendors.status'=>1]);
        $Records = $Records->get();

        foreach($Records as $Record)
        {
            $vendor_id = $Record->id;
            if(!in_array($vendor_id, $vendor_ids))
            {
                $vendor_ids[] = $vendor_id;
            }
        }


        $requested_categories = '';
        {
            $requested_categories = $cat_id;
            $categories = explode(',',$requested_categories);

            $count = count($categories);
            if($count>0)
            {
                $vendor_ids_old = $vendor_ids;
                $vendor_ids = array();

                foreach($vendor_ids_old as $vendor_id)
                {
                    $exists = 0;
                    foreach($categories as $category)
                    {
                        $modelData = SvcVendorCategory::select('id');
                        $modelData = $modelData->where('vend_id', '=', $vendor_id);
                        $modelData = $modelData->where('cat_id', '=', $category);
                        $modelData = $modelData->where('status', '=', '1');
                        $modelData = $modelData->get();
                        $ex = 0;
                        foreach($modelData as $modelD)
                        {
                            $ex = 1;
                        }

                        if($ex == 1)
                        {
                            $exists++;
                        }

                    }

                    if(!in_array($vendor_id, $vendor_ids) && $exists == $count)
                    {
                        $vendor_ids[] = $vendor_id;
                    }

                }
            }

        }



        $vendors = null;
        $page_count = $count_all = 0;
        $message  = 'No Record Found.';

        if(!empty($vendor_ids))
        {
            /*$count_all = Vendor::select(['vendors.id']);
            $count_all = $count_all->whereIn('vendors.id', $vendor_ids);
            $count_all = $count_all->count();*/

            $count_all = count($vendor_ids);

            $Records = SvcVendor::select('svc_vendors.*');
            $Records = $Records->whereIn('svc_vendors.id', $vendor_ids);
            $Records = $Records->orderBy('svc_vendors.id','DESC');
            $Records = $Records->skip($skip);
            $Records = $Records->take($limit);
            $Records = $Records->get();

            if(!empty($Records))
            {
                $vendors =  array();
                foreach($Records as $model)
                {
                    $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius, $cat_id);
                }

                if(!empty($vendors))
                {
                    $page_count = count($vendors);
                    $message  = 'All Vendor Listing retrieved successfully.';
                }

            }

        }



        $data = array();

        $data['filter_title'] = $title;
        $data['filter_location'] = $location;
        $data['filter_cat_id'] = $requested_categories;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = $page_count;
        $data['total_count'] = $count_all;
        $data['vendors'] = $vendors;


        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response,200);

    }



    public function filter_by_sub_category($title, $location, $sub_cat_id, $page, $limit)

    {



        $skip = (($page-1)*$limit);





        $vendor_ids = array();



        $Records = SvcVendor::select(['svc_vendors.id']);

        if($title != null && !empty($title))

        {

            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['svc_vendors.status'=>1]);

        $Records = $Records->get();

        foreach($Records as $Record)

        {

            $vendor_id = $Record->id;

            if(!in_array($vendor_id, $vendor_ids))

            {

                $vendor_ids[] = $vendor_id;

            }

        }



        $requested_sub_categories = '';

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_sub_categories = $sub_cat_id;

            $sub_categories = explode(',',$requested_sub_categories);

            $count = count($sub_categories);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($sub_categories as $sub_category)

                {

                    $modelData = SvcVendorSubCategory::select('svc_vendor_sub_categories.id');

                    $modelData = $modelData->where('svc_vendor_sub_categories.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_sub_categories.sub_cat_id', '=', $sub_category);

                    $modelData = $modelData->where('svc_vendor_sub_categories.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }



        $vendors = null;

        $page_count = $count_all = 0;

        $message  = 'No Record Found.';



        if(!empty($vendor_ids))

        {

            /*$count_all = Vendor::select(['vendors.id']);

            $count_all = $count_all->whereIn('vendors.id', $vendor_ids);

            $count_all = $count_all->count();*/



            $count_all = count($vendor_ids);



            $Records = SvcVendor::select('svc_vendors.*');

            $Records = $Records->whereIn('svc_vendors.id', $vendor_ids);

            $Records = $Records->orderBy('svc_vendors.id','DESC');

            $Records = $Records->skip($skip);

            $Records = $Records->take($limit);

            $Records = $Records->get();



            if(!empty($Records))

            {

                $vendors =  array();

                foreach($Records as $model)

                {

                    $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

                }

                if(!empty($vendors))

                {

                    $page_count = count($vendors);

                    $message  = 'All Vendor Listing retrieved successfully.';

                }

            }

        }



        $data = array();

        $data['filter_title'] = $title;

        $data['filter_location'] = $location;

        $data['filter_sub_cat_id'] = $requested_sub_categories;

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];



        return response()->json($response,200);



        /*$query = '';

        $count_all = 0;

        if($sub_cat_id != null && !empty($sub_cat_id))

        {

            $count_all = Vendor::leftJoin('vendor_sub_categories', 'vendors.id','=', 'vendor_sub_categories.vend_id');

            if($sub_cat_id != null && !empty($sub_cat_id))

            {

                $count_all = $count_all->where('vendor_sub_categories.sub_cat_id', '=', $sub_cat_id);

            }

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1,'vendor_sub_categories.status'=>1]);

            $count_all = $count_all->select(['vendors.id']);

            $count_all = $count_all->count();





            $Records = Vendor::leftJoin('vendor_sub_categories', 'vendors.id','=', 'vendor_sub_categories.vend_id');

            $Records = $Records->select('vendors.*');

            $Records = $Records->where('vendor_sub_categories.status', '=', '1');

        }

        else

        {

            $count_all = Vendor::select(['vendors.id']);

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1]);

            $count_all = $count_all->count();









            $Records = Vendor::select('vendors.*');

        }



        if($sub_cat_id != null && !empty($sub_cat_id))

        {

            $Records = $Records->where('vendor_sub_categories.sub_cat_id', '=', $sub_cat_id);

        }

        if($title != null && !empty($title))

        {

            $Records = $Records->where('vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['vendors.status'=>1]);

        $Records = $Records->orderBy('vendors.id','DESC');

        $Records = $Records->skip($skip);

        $Records = $Records->take($limit);

        $Records = $Records->get();



        $vendors = null;

        $page_count = 0;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $vendors =  array();

            foreach($Records as $model)

            {

                $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

            }

            if(!empty($vendors))

            {

                $page_count = count($vendors);

                $message  = 'All Vendor Listing retrieved successfully.';

            }

        }



        $data = array();

            $data['filter_title'] = $title;

            $data['filter_location'] = $location;

            $data['filter_sub_cat_id'] = $sub_cat_id;

            $data['page'] = $page;

            $data['limit'] = $limit;

            $data['page_count'] = $page_count;

            $data['total_count'] = $count_all;

            $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];

        return response()->json($response,200);*/



    }



    public function filter_by_service($title, $location, $service_id, $page, $limit)

    {



        $skip = (($page-1)*$limit);





        $vendor_ids = array();



        $Records = SvcVendor::select(['svc_vendors.id']);

        if($title != null && !empty($title))

        {

            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['svc_vendors.status'=>1]);

        $Records = $Records->get();

        foreach($Records as $Record)

        {

            $vendor_id = $Record->id;

            if(!in_array($vendor_id, $vendor_ids))

            {

                $vendor_ids[] = $vendor_id;

            }

        }





        $requested_services = '';



        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_services = $service_id;

            $services = explode(',',$requested_services);

            $count = count($services);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($services as $service)

                {

                    $modelData = SvcVendorService::select('svc_vendor_services.id');

                    $modelData = $modelData->where('svc_vendor_services.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_services.sub_service_id', '=', $service);

                    $modelData = $modelData->where('svc_vendor_services.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }



        $vendors = null;

        $page_count = $count_all = 0;

        $message  = 'No Record Found.';



        if(!empty($vendor_ids))

        {

            /*$count_all = Vendor::select(['vendors.id']);

            $count_all = $count_all->whereIn('vendors.id', $vendor_ids);

            $count_all = $count_all->count();*/



            $count_all = count($vendor_ids);



            $Records = SvcVendor::select('svc_vendors.*');

            $Records = $Records->whereIn('svc_vendors.id', $vendor_ids);

            $Records = $Records->orderBy('svc_vendors.id','DESC');

            $Records = $Records->skip($skip);

            $Records = $Records->take($limit);

            $Records = $Records->get();



            if(!empty($Records))

            {

                $vendors =  array();

                foreach($Records as $model)

                {

                    $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

                }

                if(!empty($vendors))

                {

                    $page_count = count($vendors);

                    $message  = 'All Vendor Listing retrieved successfully.';

                }

            }

        }



        $data = array();

        $data['filter_title'] = $title;

        $data['filter_location'] = $location;

        $data['filter_service_id'] = $requested_services;

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];



        return response()->json($response,200);



        /*$query = '';

        $count_all = 0;

        if($service_id != null && !empty($service_id))

        {

            $count_all = Vendor::leftJoin('vendor_services', 'vendors.id','=', 'vendor_services.vend_id');

            if($service_id != null && !empty($service_id))

            {

                $count_all = $count_all->where('vendor_services.service_id', '=', $service_id);

            }

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1,'vendor_services.status'=>1]);

            $count_all = $count_all->select(['vendors.id']);

            $count_all = $count_all->count();





            $Records = Vendor::leftJoin('vendor_services', 'vendors.id','=', 'vendor_services.vend_id');

            $Records = $Records->select('vendors.*');

            $Records = $Records->where('vendor_services.status', '=', '1');

        }

        else

        {

            $count_all = Vendor::select(['vendors.id']);

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1]);

            $count_all = $count_all->count();









            $Records = Vendor::select('vendors.*');

        }



        if($service_id != null && !empty($service_id))

        {

            $Records = $Records->where('vendor_services.service_id', '=', $service_id);

        }

        if($title != null && !empty($title))

        {

            $Records = $Records->where('vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['vendors.status'=>1]);

        $Records = $Records->orderBy('vendors.id','DESC');

        $Records = $Records->skip($skip);

        $Records = $Records->take($limit);

        $Records = $Records->get();



        $vendors = null;

        $page_count = 0;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $vendors =  array();

            foreach($Records as $model)

            {

                $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

            }

            if(!empty($vendors))

            {

                $page_count = count($vendors);

                $message  = 'All Vendor Listing retrieved successfully.';

            }

        }



        $data = array();

            $data['filter_title'] = $title;

            $data['filter_location'] = $location;

            $data['filter_service_id'] = $service_id;

            $data['page'] = $page;

            $data['limit'] = $limit;

            $data['page_count'] = $page_count;

            $data['total_count'] = $count_all;

            $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];

        return response()->json($response,200);*/



    }



    public function filter_by_sub_service($title, $location, $sub_service_id, $page, $limit)

    {



        $skip = (($page-1)*$limit);





        $vendor_ids = array();



        $Records = SvcVendor::select(['svc_vendors.id']);

        if($title != null && !empty($title))

        {

            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['svc_vendors.status'=>1]);

        $Records = $Records->get();

        foreach($Records as $Record)

        {

            $vendor_id = $Record->id;

            if(!in_array($vendor_id, $vendor_ids))

            {

                $vendor_ids[] = $vendor_id;

            }

        }





        $requested_sub_services = '';

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_sub_services = $sub_service_id;

            $sub_services = explode(',',$requested_sub_services);

            $count = count($sub_services);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($sub_services as $sub_service)

                {

                    $modelData = SvcVendorService::select('svc_vendor_services.id');

                    $modelData = $modelData->where('svc_vendor_services.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_services.sub_service_id', '=', $sub_service);

                    $modelData = $modelData->where('svc_vendor_services.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }



        $vendors = null;

        $page_count = $count_all = 0;

        $message  = 'No Record Found.';



        if(!empty($vendor_ids))

        {

            /*$count_all = Vendor::select(['vendors.id']);

            $count_all = $count_all->whereIn('vendors.id', $vendor_ids);

            $count_all = $count_all->count();*/



            $count_all = count($vendor_ids);



            $Records = SvcVendor::select('svc_vendors.*');

            $Records = $Records->whereIn('svc_vendors.id', $vendor_ids);

            $Records = $Records->orderBy('svc_vendors.id','DESC');

            $Records = $Records->skip($skip);

            $Records = $Records->take($limit);

            $Records = $Records->get();



            if(!empty($Records))

            {

                $vendors =  array();

                foreach($Records as $model)

                {

                    $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

                }

                if(!empty($vendors))

                {

                    $page_count = count($vendors);

                    $message  = 'All Vendor Listing retrieved successfully.';

                }

            }

        }



        $data = array();

        $data['filter_title'] = $title;

        $data['filter_location'] = $location;

        $data['filter_sub_service_id'] = $requested_sub_services;

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];



        return response()->json($response,200);



        /*$Records = '';

        $count_all = 0;

        if($sub_service_id != null && !empty($sub_service_id))

        {

            $count_all = Vendor::leftJoin('vendor_services', 'vendors.id','=', 'vendor_services.vend_id');

            if($sub_service_id != null && !empty($sub_service_id))

            {

                $count_all = $count_all->where('vendor_services.sub_service_id', '=', $sub_service_id);

            }

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1,'vendor_services.status'=>1]);

            $count_all = $count_all->select(['vendors.id']);

            $count_all = $count_all->count();





            $Records = Vendor::leftJoin('vendor_services', 'vendors.id','=', 'vendor_services.vend_id');

            $Records = $Records->select('vendors.*');

            $Records = $Records->where(['vendors.status'=>1,'vendor_services.status'=>1]);

        }

        else

        {

            $count_all = Vendor::select(['vendors.id']);

            if($title != null && !empty($title))

            {

                $count_all = $count_all->where('vendors.name', 'like', '%' . $title . '%');

            }

            if($location != null && !empty($location))

            {

                $count_all = $count_all->where('vendors.location', 'like', '%' . $location . '%');

            }

            $count_all = $count_all->where(['vendors.status'=>1]);

            $count_all = $count_all->count();









            $Records = Vendor::select('vendors.*');

            $Records = $Records->where(['vendors.status'=>1]);

        }



        if($sub_service_id != null && !empty($sub_service_id))

        {

            $Records = $Records->where('vendor_services.sub_service_id', '=', $sub_service_id);

        }

        if($title != null && !empty($title))

        {

            $Records = $Records->where('vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->orderBy('vendors.id','DESC');

        $Records = $Records->skip($skip);

        $Records = $Records->take($limit);

        $Records = $Records->get();



        $vendors = null;

        $page_count = 0;

        $message  = 'No Record Found.';



        if(!empty($Records))

        {

            $vendors =  array();

            foreach($Records as $model)

            {

                $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

            }

            if(!empty($vendors))

            {

                $page_count = count($vendors);

                $message  = 'All Vendor Listing retrieved successfully.';

            }

        }



        $data = array();

            $data['filter_title'] = $title;

            $data['filter_location'] = $location;

            $data['filter_sub_service_id'] = $sub_service_id;

            $data['page'] = $page;

            $data['limit'] = $limit;

            $data['page_count'] = $page_count;

            $data['total_count'] = $count_all;

            $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];

        return response()->json($response,200);*/



    }







    public function filter_by_any($request, $page, $limit)

    {



        $skip = (($page-1)*$limit);



        $title = trim($request->title);

        $location = trim($request->location);





        $vendor_ids = array();



        $Records = SvcVendor::select(['svc_vendors.id']);

        if($title != null && !empty($title))

        {

            $Records = $Records->where('svc_vendors.name', 'like', '%' . $title . '%');

        }

        if($location != null && !empty($location))

        {

            $Records = $Records->where('svc_vendors.location', 'like', '%' . $location . '%');

        }

        $Records = $Records->where(['svc_vendors.status'=>1]);

        $Records = $Records->get();

        foreach($Records as $Record)

        {

            $vendor_id = $Record->id;

            if(!in_array($vendor_id, $vendor_ids))

            {

                $vendor_ids[] = $vendor_id;

            }

        }



        $requested_categories = '';

        if(isset($request->cat_id) && !empty($request->cat_id))

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_categories = $request->cat_id;

            $categories = explode(',',$requested_categories);

            $count = count($categories);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($categories as $category)

                {

                    $modelData = SvcVendorCategory::select('svc_vendor_categories.id');

                    $modelData = $modelData->where('svc_vendor_categories.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_categories.cat_id', '=', $category);

                    $modelData = $modelData->where('svc_vendor_categories.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }



        $requested_sub_categories = '';

        if(isset($request->sub_cat_id) && !empty($request->sub_cat_id))

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_sub_categories = $request->sub_cat_id;

            $sub_categories = explode(',',$requested_sub_categories);

            $count = count($sub_categories);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($sub_categories as $sub_category)

                {

                    $modelData = SvcVendorSubCategory::select('svc_vendor_sub_categories.id');

                    $modelData = $modelData->where('svc_vendor_sub_categories.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_sub_categories.sub_cat_id', '=', $sub_category);

                    $modelData = $modelData->where('svc_vendor_sub_categories.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }





        $requested_services = '';

        if(isset($request->service_id) && !empty($request->service_id))

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_services = $request->service_id;

            $services = explode(',',$requested_services);

            $count = count($services);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($services as $service)

                {

                    $modelData = SvcVendorService::select('svc_vendor_services.id');

                    $modelData = $modelData->where('svc_vendor_services.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_services.sub_service_id', '=', $service);

                    $modelData = $modelData->where('svc_vendor_services.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }





        $requested_sub_services = '';

        if(isset($request->sub_service_id) && !empty($request->sub_service_id))

        {

            $vendor_ids_old = $vendor_ids;

            $vendor_ids = array();



            $requested_sub_services = $request->sub_service_id;

            $sub_services = explode(',',$requested_sub_services);

            $count = count($sub_services);



            foreach($vendor_ids_old as $vendor_id)

            {

                $exists = 0;

                foreach($sub_services as $sub_service)

                {

                    $modelData = SvcVendorService::select('svc_vendor_services.id');

                    $modelData = $modelData->where('svc_vendor_services.vend_id', '=', $vendor_id);

                    $modelData = $modelData->where('svc_vendor_services.sub_service_id', '=', $sub_service);

                    $modelData = $modelData->where('svc_vendor_services.status', '=', '1');

                    $modelData = $modelData->get();

                    $ex = 0;
                    foreach($modelData as $modelD)
                    {
                        $ex = 1;
                    }

                    if($ex == 1)
                    {
                        $exists++;
                    }

                }



                if(!in_array($vendor_id, $vendor_ids) && $exists == $count)

                {

                    $vendor_ids[] = $vendor_id;

                }

            }

        }



        $vendors = null;

        $page_count = $count_all = 0;

        $message  = 'No Record Found.';



        if(!empty($vendor_ids))

        {

            /*$count_all = Vendor::select(['vendors.id']);

            $count_all = $count_all->whereIn('vendors.id', $vendor_ids);

            $count_all = $count_all->count();*/



            $count_all = count($vendor_ids);



            $Records = SvcVendor::select('svc_vendors.*');

            $Records = $Records->whereIn('svc_vendors.id', $vendor_ids);

            $Records = $Records->orderBy('svc_vendors.id','DESC');

            $Records = $Records->skip($skip);

            $Records = $Records->take($limit);

            $Records = $Records->get();



            if(!empty($Records))

            {

                $vendors =  array();

                foreach($Records as $model)

                {

                    $vendors[] = get_vendors_array($model, $this->_token, $this->lat, $this->lng, $this->radius);

                }

                if(!empty($vendors))

                {

                    $page_count = count($vendors);

                    $message  = 'All Vendor Listing retrieved successfully.';

                }

            }

        }



        $data = array();

        $data['filter_title'] = $title;

        $data['filter_location'] = $location;

        $data['filter_cat_id'] = $requested_categories;

        $data['filter_sub_cat_id'] = $requested_sub_categories;

        $data['filter_service_id'] = $requested_services;

        $data['filter_sub_service_id'] = $requested_sub_services;

        $data['page'] = $page;

        $data['limit'] = $limit;

        $data['page_count'] = $page_count;

        $data['total_count'] = $count_all;

        $data['vendors'] = $vendors;



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $data,

        ];



        return response()->json($response,200);



    }











    // Get Listing of Nearby Vendors	

    public function get_nearby_vendors(Request $request, $page, $limit, $lat, $lng, $radius)

    {

        if((!empty($lat) || $lat!=null) && (!empty($lng) || $lng!=null) && (!empty($radius) || $radius!=null))

        {

            //echo '<pre>';print_r($request);exit;



            $skip = (($page-1)*$limit);



            $name = '';

            if (isset($request->search_name))

            {

                $name = trim($request->search_name);

            }



            $sort_by = '';

            if(isset($request->sort_by) && !empty($request->sort_by))

            {

                $sort_by = $request->sort_by;

            }



            $requested_categories = '';

            $categories = array();

            if(isset($request->categories) && !empty($request->categories))

            {

                $requested_categories = $request->categories;

                $categories = explode(',',$request->categories);

            }





            $count_all = 0;

            $Records = '';



            if (count($categories)>0)

            {

                $count_all = SvcVendor::leftjoin('svc_vendor_categories','svc_vendors.id','=','svc_vendor_categories.rest_id');

                $count_all = $count_all->leftjoin('svc_categories','svc_vendor_categories.cat_id','=','svc_categories.id');

                $count_all = $count_all->select('svc_vendors.id', DB::raw("6371 * acos(cos(radians(" . $lat . "))

                      * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))

				+ sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));

                if ($name != null && !empty($name))

                {

                    $count_all = $count_all->where('svc_vendors.name', 'like', '%' . $name . '%');

                }

                $count_all = $count_all->whereIn('svc_vendor_categories.cat_id', $categories);

                $count_all = $count_all->where('svc_vendors.status', '=', '1');

                if ($radius>0)

                {

                    $count_all = $count_all->having('distance', '<', $radius);

                }

                $count_all = $count_all->count();

















                $Records = SvcVendorCategory::leftjoin('svc_vendors','svc_vendor_categories.rest_id','=','svc_vendors.id');

                $Records = $Records->leftjoin('svc_categories','svc_vendor_categories.cat_id','=','svc_categories.id');

                $Records = $Records->select('svc_vendors.*', DB::raw("6371 * acos(cos(radians(" . $lat . "))

                      * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))

				+ sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));

                $Records = $Records->whereIn('svc_vendor_categories.cat_id', $categories);

            }

            else

            {

                $count_all = SvcVendor::select("svc_vendors.id", DB::raw("6371 * acos(cos(radians(" . $lat . "))

                      * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))

				+ sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));

                if ($name != null && !empty($name))

                {

                    $count_all = $count_all->where('svc_vendors.name', 'like', '%' . $name . '%');

                }

                $count_all = $count_all->where('svc_vendors.status', '=', '1');

                if ($radius>0)

                {

                    $count_all = $count_all->having('distance', '<', $radius);

                }

                $count_all = $count_all->count();











                $Records = SvcVendor::select('svc_vendors.*', DB::raw("6371 * acos(cos(radians(" . $lat . "))

                      * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))

				+ sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));

            }



            if ($name != null && !empty($name))

            {

                $Records = $Records->where('svc_vendors.name', 'like', '%' . $name . '%');

            }



            $Records = $Records->where('svc_vendors.status', '=', '1');



            if ($radius>0)

            {

                $Records = $Records->having('distance', '<', $radius);

            }



            if($sort_by != '')

            {

                switch($sort_by)

                {

                    case 'distance_low':

                        {

                            $Records = $Records->orderby('distance', 'asc');

                        }

                        break;



                    case 'distance_high':

                        {

                            $Records = $Records->orderby('distance', 'desc');

                        }

                        break;



                    case 'popularity_low':

                        {

                            $Records = $Records->orderby('vendors.likes', 'asc');

                        }

                        break;



                    case 'popularity_high':

                        {

                            $Records = $Records->orderby('vendors.likes', 'desc');

                        }

                        break;



                    case 'rating_low':

                        {

                            $Records = $Records->orderby('vendors.rating', 'asc');

                        }

                        break;



                    case 'rating_high':

                        {

                            $Records = $Records->orderby('vendors.rating', 'desc');

                        }

                        break;



                    case 'time_low':

                        {

                            $Records = $Records->orderby('vendors.avg_time', 'asc');

                        }

                        break;



                    case 'time_high':

                        {

                            $Records = $Records->orderby('vendors.avg_time', 'desc');

                        }

                        break;



                    default:

                        break;

                }

            }

            $Records = $Records->skip($skip);

            $Records = $Records->take($limit);

            $Records = $Records->get();





            $page_count = 0;

            $Response = array();

            foreach($Records as $record)

            {

                $page_count++;

                $id	= $record->id;

                $Response[] = common($record, $this->_token, $this->lat ,$this->lng);

            }



            $message  = 'No Vendor found near by within '.$radius.'km radius.';

            if($page_count>0)

            {

                $message  = 'All Near by Vendor Listing within '.$radius.'km radius retrieved successfully.';

            }

            else

            {

                $Response = null;

            }



            $data = array();

            $data['lat'] = $lat;

            $data['lng'] = $lng;

            $data['radius'] = $radius;

            $data['search_name'] = $name;

            $data['sort_by'] = $sort_by;

            $data['categories'] = $requested_categories;

            $data['page'] = $page;

            $data['limit'] = $limit;

            $data['total_count'] = $count_all;

            $data['page_count'] = $page_count;

            $data['vendors'] = $Response;



            $response = [

                'code' => '201',

                'status' => true,

                'message' => $message,

                'data' => $data,

            ];

            return response()->json($response,200);



        }

        else

        {

            return $this->sendError('Please Provide Latitude and Longitude');

            exit;

        }

    }







    // Get All Details of Vendor

    public function details($record)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        $staff = 15;//$record->staff;

        $Response['staff'] = $staff;



        $timing = 90;//$record->timing;

        $Response['timing'] = $timing;



        $is_featured = (($record->is_featured == 1) ? true : false);

        $Response['is_featured'] = $is_featured;



        // Vendor Basic Details

        $Response['basic_details'] = get_vendor_basic_data($record);



        // Vendor Contact Details

        $Response['contact_details'] = get_vendor_contact_data($record);



        // Vendor Location

        $Response['location_details'] = get_vendor_location_data($record, $this->lat, $this->lng, $this->radius);


        // Vendor Today Timings
        $Response['timing_details'] = get_vendor_timings_data($record, true);



        // Vendor Categories
        $categories_count = 0;
        $categories = get_vendor_categories($record);
        if($categories!=null)
        {
            $categories_count = count($categories);
        }
        $Response['categories_count'] = $categories_count;
        $Response['categories'] = $categories;



        // Vendor SubCategories

        $Response['subcategories'] = get_vendor_subcategories($record_id);



        // Vendor Services

        $Response['services'] = get_vendor_services($record_id);



        // Reviews

        $reviews = get_vendor_reviews($record_id,1);

        $Response['overall_rating'] = $reviews['overall_rating'];

        $Response['reviews_count'] = $reviews['reviews_count'];

        $Response['reviews'] = $reviews['reviews'];



        /*$User=$this->getUser();

        if($User!=null)

        {

            // User Order Count

            $Response['user_orders_count'] = 0;

            $data = $this->get_user_orders($id,$User);

            if($data!=null)

                $Response['user_orders_count'] = count($data);

            $Response['user_orders'] = $data;

        }*/



        $response = [

            'code' => '201',

            'status' => true,

            'message' => 'Vendor Details retrieved successfully.',

            'data' => $Response,

        ];



        return response()->json($response,200);

    }











    // Get Contact Details of Vendor

    public function contact_details($record)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;





        // Vendor Contact Details

        $Response['contact_details'] = get_vendor_contact_data($record);



        $response = [

            'code' => '201',

            'status' => true,

            'message' => 'Vendor Contact Details retrieved successfully.',

            'data' => $Response,

        ];

        return response()->json($response,200);



    }











    // Get Location Details of Vendor

    public function location_details($record)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        // Vendor Location

        $Response['location_details'] = get_vendor_location_data($record, $this->lat, $this->lng, $this->radius);



        $response = [

            'code' => '201',

            'status' => true,

            'message' => 'Vendor Location Details retrieved successfully.',

            'data' => $Response,

        ];

        return response()->json($response,200);



    }











    // Get Categories of Vendor

    public function categories($record)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        $Data = get_vendor_categories($record);

        $Response['categories'] = $Data;



        $page_count = count($Data);

        $message  = 'No Record Found.';

        if($page_count>0)

        {

            $message  = 'Vendor Categories Listing retrieved successfully.';

        }



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $Response,

        ];

        return response()->json($response,200);

    }











    // Get SubCategories of Vendor

    public function subcategories($record, $cat_id = 0)

    {

        $Data = array();

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;

        if($cat_id!=0 && $cat_id!=null)

        {

            $Response['cat_id'] = $cat_id;

        }



        $Data = get_vendor_subcategories($record_id, $cat_id, true, true);

        $Response['subcategories'] = $Data;



        if($Data != null){
            $page_count = count($Data);
        }
        else{
            $page_count = 0;
        }


        $message  = 'No Record Found.';

        if($page_count>0)

        {

            $message  = 'Vendor SubCategories Listing retrieved successfully.';

        }



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $Response,

        ];

        return response()->json($response,200);

    }











    // Get Services of Vendor

    public function services($record, $sub_cat_id = 0)

    {


        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        $sub_categories = '';

        if($sub_cat_id != 0 && $sub_cat_id != null && !empty($sub_cat_id))

        {

            $sub_categories = $sub_cat_id;

            $sub_cat_id = explode(',',$sub_cat_id);

        }

        $Response['sub_cat_id'] = $sub_categories;



        $Data = get_vendor_services($record_id, $sub_cat_id, true, true);

        $Response['services'] = $Data;



        $page_count = 0;

        if($Data!=null)

            $page_count = count($Data);



        $message  = 'No Record Found.';

        if($page_count>0)

        {

            $message  = 'Vendor Services Listing retrieved successfully.';

        }



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $Response,

        ];

        return response()->json($response,200);

    }











    // Get Services of Vendor

    public function subservices($record, $service_id = 0)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        $services = '';

        if($service_id != 0 && $service_id != null && !empty($service_id))

        {

            $services = $service_id;

            $service_id = explode(',',$service_id);

        }

        $Response['service_id'] = $services;



        $Data = get_vendor_subservices($record_id, $service_id, true);

        $Response['services'] = $Data;



        $page_count = 0;

        if($Data!=null)

            $page_count = count($Data);



        $message  = 'No Record Found.';

        if($page_count>0)

        {

            $message  = 'Vendor SubServices Listing retrieved successfully.';

        }



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $Response,

        ];

        return response()->json($response,200);

    }













    // Get Reviews of Vendor

    public function reviews($record)

    {

        $id = $record->id;

        $record_id = $record->id;

        $Response = array();

        $Response['id'] = $id;



        $reviews = get_vendor_reviews($record_id,0);

        $Response['overall_rating'] = $reviews['overall_rating'];

        $Response['reviews_count'] = $reviews['reviews_count'];

        $Response['reviews'] = $reviews['reviews'];



        $page_count = $reviews['reviews_count'];

        $message  = 'No Record Found.';

        if($page_count>0)

        {

            $message  = 'Vendor Reviews Listing retrieved successfully.';

        }



        $response = [

            'code' => '201',

            'status' => true,

            'message' => $message,

            'data' => $Response,

        ];

        return response()->json($response,200);

    }

}
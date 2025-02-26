<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;
use App\Models\SvcSubService;
use App\Models\SvcProduct;

use App\Models\SvcVendor;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends BaseController
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
        

        ((!empty($request->header('lat'))) ? $this->lat=$request->header('lat') : $this->lat=null);        

        ((!empty($request->header('lng'))) ? $this->lng=$request->header('lng') : $this->lng=null);        

        ((!empty($request->header('radius'))) ? $this->radius=$request->header('radius') : $this->radius=5);
		
        $page = 1;
        $limit = 20;
        (isset($_REQUEST['page']) ? $page = trim($_REQUEST['page']) : $page);
        (isset($_REQUEST['limit']) ? $limit = trim($_REQUEST['limit']) : $limit);

        return $this->index($request, $page, $limit);

    }

    public function index($request, $page, $limit)
    {
        $skip = (($page-1)*$limit);

        $name = '';
        if (isset($request->name))
        {
            $name = trim($request->name);
        }

        $cat_id = '';
        if (isset($request->cat_id) && is_numeric($request->cat_id))
        {
            $cat_id = trim($request->cat_id);
        }

        $sub_cat_id = '';
        if (isset($request->sub_cat_id))
        {
            $sub_cat_id = trim($request->sub_cat_id);
			$sub_cat_id = explode(',',$sub_cat_id);
        }

        $vend_id = '';
        if (isset($request->vend_id) && is_numeric($request->vend_id))
        {
            $vend_id = trim($request->vend_id);
        }

        $maximum_price = 0;
        if (isset($request->maximum_price) && is_numeric($request->maximum_price))
        {
            $maximum_price = trim($request->maximum_price);
        }

        $minimum_price = 0;
        if (isset($request->minimum_price) && is_numeric($request->minimum_price))
        {
            $minimum_price = trim($request->minimum_price);
        }

        $occasion_type = '';
        if (isset($request->occasion_type))
        {
            $occasion_type = "(".trim($request->occasion_type).")";
        }

        $order_by = '';
        if (isset($request->order_by))
        {
            $order_by = trim($request->order_by);
        }

        $count_all = SvcProduct::leftjoin('svc_sub_categories','svc_products.sub_cat_id','=','svc_sub_categories.id');
        $count_all = $count_all->leftjoin('svc_categories','svc_sub_categories.cat_id','=','svc_categories.id');
        if($name != '')
        {
            $count_all = $count_all->where('svc_products.name', 'like', '%' . $name . '%');
        }
        if($cat_id != '')
        {
            $count_all = $count_all->where('svc_products.cat_id', '=', $cat_id);
        }
        if($sub_cat_id != '')
        {
            $count_all = $count_all->whereIn('svc_products.sub_cat_id', $sub_cat_id);
        }
        if($vend_id != '')
        {
            $count_all = $count_all->where('svc_products.vend_id', '=', $vend_id);
        }
        if($maximum_price != 0)
        {
            $count_all = $count_all->where('svc_products.price', '<=', $maximum_price);
        }
        if($minimum_price != 0)
        {
            $count_all = $count_all->where('svc_products.price', '>=', $minimum_price);
        }
        if($occasion_type != '')
        {
            $count_all = $count_all->where('svc_products.occasion_type', 'like', '%' . $occasion_type . '%');
        }
        $count_all = $count_all->where(['svc_products.status'=>1,'svc_sub_categories.status'=>1,'svc_categories.status'=>1]);
        $count_all = $count_all->select(['svc_products.id']);
        $count_all = $count_all->count();



        $Records = SvcProduct::leftjoin('svc_sub_categories','svc_products.sub_cat_id','=','svc_sub_categories.id');
        $Records = $Records->leftjoin('svc_categories','svc_sub_categories.cat_id','=','svc_categories.id');
        if($name != '')
        {
            $Records = $Records->where('svc_products.name', 'like', '%' . $name . '%');
        }
        if($cat_id != '')
        {
            $Records = $Records->where('svc_products.cat_id', '=', $cat_id);
        }
        if($sub_cat_id != '')
        {
            $Records = $Records->whereIn('svc_products.sub_cat_id', $sub_cat_id);
        }
        if($vend_id != '')
        {
            $Records = $Records->where('svc_products.vend_id', '=', $vend_id);
        }
        if($maximum_price != 0)
        {
            $Records = $Records->where('svc_products.price', '<=', $maximum_price);
        }
        if($minimum_price != 0)
        {
            $Records = $Records->where('svc_products.price', '>=', $minimum_price);
        }
        if($occasion_type != '')
        {
            $Records = $Records->where('svc_products.occasion_type', 'like', '%' . $occasion_type . '%');
        }

        $Records = $Records->where(['svc_products.status'=>1,'svc_sub_categories.status'=>1,'svc_categories.status'=>1]);
        $Records = $Records->select(['svc_products.*']);

        if($order_by != '' && $order_by == 'name-asc')
        {
            $Records = $Records->orderBy('name', 'asc');
        }
        if($order_by != '' && $order_by == 'name-desc')
        {
            $Records = $Records->orderBy('name', 'desc');
        }
        if($order_by != '' && $order_by == 'price-asc')
        {
            $Records = $Records->orderBy('price', 'asc');
        }
        if($order_by != '' && $order_by == 'price-desc')
        {
            $Records = $Records->orderBy('price', 'desc');
        }
        $Records = $Records->skip($skip);
        $Records = $Records->take($limit);
        $Records = $Records->get();

        $records_data = null;
        $page_count = 0;
        $message  = 'No Record Found.';

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_product_array($model);
            }
            if(!empty($records_data))
            {
                $page_count = count($records_data);
                $message  = 'All Products Listing retrieved successfully.';
            }
        }

        $data = array();
        $data['vend_id'] = $vend_id;
        $data['cat_id'] = $cat_id;
        $data['sub_cat_id'] = $sub_cat_id;
        $data['name'] = $name;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = $page_count;
        $data['total_count'] = $count_all;
        $data['products'] = $records_data;

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function get_product_array($record)
    {
        $record_id = $record->id;
        $cat_id = $record->cat_id;
        $sub_cat_id = $record->sub_cat_id;

        $category =  array();
        $modelData = SvcCategory::where('id', '=', $cat_id)->where('status', '=', '1')->get();
        foreach($modelData as $model)
        {
            $category = $this->get_category_array($model);
        }

        $subcategory =  array();
        $modelData = SvcSubCategory::where('id', '=', $sub_cat_id)->where('status', '=', '1')->get();
        foreach($modelData as $model)
        {
            $subcategory = $this->get_sub_category_array($model);
        }


        $subservices =  null;
        if($record->has_sub_services == 1)
        {
            $subservices =  array();

            $modelData = SvcSubService::where('service_id', '=', $record_id)->where('status', '=', '1')->get();
            foreach($modelData as $model)
            {
                $subservices[] = $this->get_sub_service_array($model);
            }
            if(count($subservices) == 0)
            {
                $subservices = null;
            }
        }

        $image = $record->image;
        $image_path = 'svc/products/';
        if($image == 'product.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        $image = uploads($image_path);

        $array = array();

        $array['id'] = $record->id;
        //$array['cat_id'] = $record->cat_id;
        //$array['sub_cat_id'] = $record->sub_cat_id;
        $array['name'] = $record->name;
        $array['ar_name'] = $record->ar_name;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['price'] = $record->price;
        $array['image'] = $image;
        $array['category'] = $category;
        $array['subcategory'] = $subcategory;
        $array['has_sub_services'] = $record->has_sub_services;
        $array['subservices'] = $subservices;

        return $array;
    }

    public function get_category_array($record)
    {
        $record_id = $record->id;

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
        $array['name'] = $record->name;
        $array['ar_name'] = $record->ar_name;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

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
        //$array['cat_id'] = $record->cat_id;
        $array['name'] = $record->name;
        $array['ar_name'] = $record->ar_name;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

        return $array;
    }

    public function get_sub_service_array($record)
    {
        $record_id = $record->id;

        $image = $record->icon;
        $image_path = 'sub_services/';
        if($image == 'sub_service.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        $image = uploads($image_path);

        $array = array();

        $array['id'] = $record->id;
        //$array['cat_id'] = $record->cat_id;
        //$array['sub_cat_id'] = $record->sub_cat_id;
        //$array['service_id'] = $record->service_id;
        $array['name'] = $record->name;
        $array['ar_name'] = $record->ar_name;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

        return $array;
    }



}
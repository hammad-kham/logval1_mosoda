<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;
use App\Models\SvcSubService;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class CategoryApiController extends BaseController
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
        $limit = 10;
        (isset($request->page) ? $page = trim($request->page) : 1);
        (isset($request->limit) ? $limit = trim($request->limit) : 10);

        return $this->index($request, $page, $limit);
    }


    public function index($request, $page, $limit)
    {

        $skip = (($page-1)*$limit);

        $title = '';
        if (isset($request->title))
        {
            $title = trim($request->title);
        }

        $count_all = SvcCategory::where(['status'=>1]);
        if($title != '')
        {
            $count_all = $count_all->where('title', 'like', '%' . $title . '%');
        }
        $count_all = $count_all->select(['id']);
        $count_all = $count_all->count();

        $Records = SvcCategory::where(['status'=>1]);
        if($title != '')
        {
            $Records = $Records->where('title', 'like', '%' . $title . '%');
        }
        $Records = $Records->orderBy('is_order', 'asc');
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
                $records_data[] = $this->get_category_array($model);
            }
            if(!empty($records_data))
            {
                $page_count = count($records_data);
                $message  = 'All Categories Listing retrieved successfully.';
            }
        }

        $data = array();
        $data['title'] = $title;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = $page_count;
        $data['total_count'] = $count_all;
        $data['categories'] = $records_data;

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function get_category_array($record)
    {
        $record_id = $record->id;

        $subcategories = null;
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

        $ban_image = $record->ban_image;
        $image_path = 'svc/categories/';
        if($ban_image == 'cat_ban_image.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $ban_image;
        $ban_image = uploads($image_path);


        $thumb_image = $record->thumb_image;
        $image_path = 'svc/categories/';
        if($thumb_image == 'cat_thumb_image.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $thumb_image;
        $thumb_image = uploads($image_path);

        $array = array();

        $array['id'] = $record->id;
        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;
        $array['ban_image'] = $ban_image;
        $array['thumb_image'] = $thumb_image;
        $array['is_order'] = $record->is_order;
        $array['has_subcategories'] = $record->has_subcategories;
        $array['subcategories'] = $subcategories;

        return $array;
    }

    public function get_sub_category_array($record)
    {
        $record_id = $record->id;


        $services = null;
        if($record->has_services == 1)
        {
            $services =  array();
            $modelData = SvcService::where('sub_cat_id', '=', $record_id)->where('status', '=', '1')->get();
            foreach($modelData as $model)
            {
                $services[] = $this->get_service_array($model);
            }
            if(count($services) == 0)
            {
                $services = null;
            }
        }

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
        $array['static_id'] = $record->static_id;
        $array['cat_id'] = $record->cat_id;
        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['type'] = $record->type;
        $array['image'] = $image;
        $array['has_services'] = $record->has_services;
        $array['services'] = $services;

        return $array;
    }

    public function get_service_array($record)
    {
        $record_id = $record->id;

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

        $image = $record->icon;
        $image_path = 'svc/services/';
        if($image == 'service.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        $image = uploads($image_path);

        $array = array();

        $array['id'] = $record->id;
        $array['cat_id'] = $record->cat_id;
        $array['sub_cat_id'] = $record->sub_cat_id;
        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;
        $array['has_sub_services'] = $record->has_sub_services;
        $array['subservices'] = $subservices;

        return $array;
    }

    public function get_sub_service_array($record)
    {
        $record_id = $record->id;

        $image = $record->icon;
        $image_path = 'svc/sub_services/';
        if($image == 'sub_service.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        $image = uploads($image_path);

        $array = array();

        $array['id'] = $record->id;
        $array['cat_id'] = $record->cat_id;
        $array['sub_cat_id'] = $record->sub_cat_id;
        $array['service_id'] = $record->service_id;
        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

        return $array;
    }
}
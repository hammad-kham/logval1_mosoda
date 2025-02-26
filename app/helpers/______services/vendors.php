<?php

use App\Models\SvcAttribute;
use App\Models\SvcAttributeOption;
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

use App\Models\SvcVendorTiming;
use App\Models\User;
use App\Models\AppUser;
use App\Models\AppUserLocation;
use App\Models\PaymentMethod;
use App\Models\AppUserPaymentMethod;
use App\Models\SvcAppUserFavorite;
use App\Models\AppUserQuery;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
//$this->	




if (! function_exists('common'))
{
    function common($record, $token=null, $lat=null, $lng=null, $radius=null)
    {
        if(!is_null($record) && !empty($record))
        {
            $id	= $record->id;
            $record_id	= $record->id;
            $Record = array();
            $Record['id'] = $id;
            //$Record['is_like'] = is_liked($token, $id);
            $Record['status'] = (($record->status == 1) ? true : false);
            //$Record['is_open'] = is_vendor_open($record);//(($record->is_open == 1) ? true : false);
            $Record['is_featured'] = (($record->is_featured == 1) ? true : false);

            // Vendor Basic Details
            $Record['basic_details'] = get_vendor_basic_data($record);

            // Vendor Contact Details
            $Record['contact_details'] = get_vendor_contact_data($record);

            // Vendor Location
            $Record['location_details'] = get_vendor_location_data($record, $lat, $lng, $radius);

            // Vendor Today Timings
            $Record['timing_details'] = get_vendor_timings_data($record, true);

            // Vendor Categories
            $categories_count = 0;
            $categories = get_vendor_categories($record);
            if($categories!=null)
            {
                $categories_count = count($categories);
            }
            $Record['categories_count'] = $categories_count;
            $Record['categories'] = $categories;

            // Vendor SubCategories
            //$Record['subcategories'] = get_vendor_subcategories($record_id);

            // Vendor Services
            //$Record['services'] = get_vendor_services($record_id);

            // Reviews
            $reviews = get_vendor_reviews($record_id,1);
            $Record['overall_rating'] = $reviews['overall_rating'];
            $Record['reviews_count'] = $reviews['reviews_count'];
            $Record['reviews'] = $reviews['reviews'];

            return $Record;
        }
        else
        {
            return null;
        }
    }
}




if (! function_exists('common_user'))
{
    function common_user($record, $token=null, $lat=null, $lng=null, $radius=null)
    {
        $id	= $record->id;
        $record_id	= $record->id;
        $Record = array();

        $Record['id'] = $id;
        //$Record['is_like'] = is_liked($token, $id);
        $Record['status'] = (($record->status == 1) ? true : false);
        //$Record['is_open'] = is_vendor_open($record);//(($record->is_open == 1) ? true : false);
        $Record['is_featured'] = (($record->is_featured == 1) ? true : false);

        // Vendor Basic Details
        $Record['basic_details'] = get_vendor_basic_data($record);

        // Vendor Contact Details
        $Record['contact_details'] = get_vendor_contact_data($record);

        // Vendor Location
        $Record['location_details'] = get_vendor_location_data($record, $lat, $lng, $radius);

        // Vendor Today Timings
        $Record['timing_details'] = get_vendor_timings_data($record, true);

        // Vendor Categories
        $categories_count = 0;
        $categories = get_vendor_categories($record);
        if($categories!=null)
        {
            $categories_count = count($categories);
        }
        $Record['categories_count'] = $categories_count;
        $Record['categories'] = $categories;

        // Vendor SubCategories
        //$Record['subcategories'] = get_vendor_subcategories($record_id);

        // Vendor Services
        //$Record['services'] = get_vendor_services($record_id);

        // Reviews
        $reviews = get_vendor_reviews($record_id,1);
        $Record['overall_rating'] = $reviews['overall_rating'];
        $Record['reviews_count'] = $reviews['reviews_count'];
        $Record['reviews'] = $reviews['reviews'];

        return $Record;


        /*$response = array();
        $response['vendor'] = $Record;

        return $response;*/
    }
}




if (! function_exists('common_home'))
{
    function common_home($record, $token=null, $lat=null, $lng=null, $radius=null)
    {
        if(!is_null($record) && !empty($record))
        {
            $id	= $record->id;
            $record_id	= $record->id;
            $Record = array();
            $Record['id'] = $id;
            //$Record['is_like'] = is_liked($token, $id);
            $Record['status'] = (($record->status == 1) ? true : false);
            //$Record['is_open'] = is_vendor_open($record);//(($record->is_open == 1) ? true : false);
            $Record['is_featured'] = (($record->is_featured == 1) ? true : false);

            // Vendor Basic Details
            $Record['basic_details'] = get_vendor_basic_data($record);

            // Vendor Contact Details
            $Record['contact_details'] = get_vendor_contact_data($record);

            // Vendor Location
            $Record['location_details'] = get_vendor_location_data($record, $lat, $lng, $radius);

            // Vendor Today Timings
            $Record['timing_details'] = get_vendor_timings_data($record, true);

            // Vendor Categories
            $categories_count = 0;
            $categories = get_vendor_categories($record);
            if($categories!=null)
            {
                $categories_count = count($categories);
            }
            $Record['categories_count'] = $categories_count;
            $Record['categories'] = $categories;

            // Vendor SubCategories
            //$Record['subcategories'] = get_vendor_subcategories($record_id);

            // Vendor Services
            //$Record['services'] = get_vendor_services($record_id);

            // Reviews
            $reviews = get_vendor_reviews($record_id,1);
            $Record['overall_rating'] = $reviews['overall_rating'];
            $Record['reviews_count'] = $reviews['reviews_count'];
            $Record['reviews'] = $reviews['reviews'];

            return $Record;
        }
        else
        {
            return null;
        }
    }
}




if (! function_exists('update_vendor_reviews_count'))
{
    function update_vendor_reviews_count($vend_id)
    {
        $reviews_count = 0;
        $rating = 0;
        $Reviews = SvcReview::select('rating')->where('vend_id', $vend_id)->where('status',1)->get();
        foreach($Reviews as $Review)
        {
            if(is_numeric($Review->rating))
            {
                $rating+=$Review->rating;
                $reviews_count++;
            }
        }

        if($reviews_count>0 && $rating>0)
        {
            $rating = round($rating/$reviews_count);
        }

        $vendor = SvcVendor::find($vend_id);
		if(!empty($vendor))
		{
			$vendor->rating = $rating;
			$vendor->reviews = $reviews_count;
			$vendor->save();
		}

    }
}




if (! function_exists('update_vendor_likes_count'))
{
    function update_vendor_likes_count($vend_id)
    {
        $likes = 0;
        $Favorites = SvcAppUserFavorite::where('vend_id', $vend_id)->get();
        foreach($Favorites as $Favorite)
        {
            $likes++;
        }

        $vendor = SvcVendor::find($vend_id);
        $vendor->likes = $likes;
        $vendor->save();
    }
}




if (! function_exists('get_vendor_reviews_without_listing'))
{
    function get_vendor_reviews_without_listing($vend_id)
    {
        $count = 0;
        $rating = 0;
        $Reviews = SvcReview::select('rating')->where('vend_id', $vend_id)->where('status',1)->get();
        foreach($Reviews as $Review)
        {
            $count++;
            if(is_numeric($Review->rating))
            {
                $rating+=$Review->rating;
            }
        }
        if($count>0 && $rating>0)
        {
            $rating = round($rating/$count);
        }
        $reviews_count = $count;
        $Response = array();
        $Response['overall_rating'] = $rating;
        $Response['reviews_count'] = $reviews_count;

        return $Response;
    }
}




if (! function_exists('categories_data'))
{
    function categories_data($Records, $token=null, $lat=null, $lng=null)
    {
        $Data_Array=array();

        foreach ($Records as  $Record)
        {
            $cat_id = $Record->id;

            $data_array=array();

            $cat_image = $Record->icon;
            $cat_image_path = 'vendors/categories/';
            if($cat_image == 'category.png')
            {
                $cat_image_path = 'defaults/';
            }
            $cat_image_path.= $cat_image;
            $cat_image_path = uploads($cat_image_path);

            $data_array['id'] = $Record->id;
            $data_array['title'] = $Record->title;
            $data_array['ar_title'] = $Record->ar_title;
            $data_array['description'] = $Record->description;
            $data_array['ar_description'] = $Record->ar_description;
            $data_array['image'] = $cat_image_path;

            // sub categories
            $subcategories =  array();
            {
                $SubCategories = SvcSubCategory::where('svc_sub_categories.cat_id', '=', $cat_id);
                $SubCategories = $SubCategories->where(['sub_categories.status'=>1]);
                $SubCategories = $SubCategories->select(['sub_categories.*']);
                $SubCategories = $SubCategories->get();

                foreach($SubCategories as $SubCategory)
                {
                    $image = $SubCategory->icon;
                    $image_path = 'sub_categories/';
                    if($image == 'sub_category.png')
                    {
                        $image_path = 'defaults/';
                    }
                    $image_path.= $image;
                    $image = uploads($image_path);

                    $array = array();

                    $array['id'] = $SubCategory->id;
                    $array['title'] = $SubCategory->title;
                    $array['ar_title'] = $SubCategory->ar_title;
                    $array['description'] = $SubCategory->description;
                    $array['ar_description'] = $SubCategory->ar_description;
                    $array['image'] = $image;
                    $array['has_services'] = $SubCategory->has_services;

                    $subcategories[] = $array;
                }
            }
            if(count($subcategories) == 0)
            {
                $subcategories = null;
            }
            $data_array['subcategories'] = $subcategories;

            //$modelData = Vendor::find($Record->id);
            //$data_array['vendor'] = common_home($modelData, $token, $lat , $lng);

            $Data_Array[] = $data_array;
        }

        return 	$Data_Array;
    }
}




if (! function_exists('featured_data'))
{
    function featured_data($Records, $token=null, $lat=null, $lng=null)
    {
        $Data_Array=array();
        foreach ($Records as  $Record)
        {
            $data_array = array();
            $modelData = SvcVendor::find($Record->id);
            //$data_array['vendor'] = common_home($modelData, $token, $lat , $lng);
            $data_array = common_home($modelData, $token, $lat , $lng);
            $Data_Array[] = $data_array;
        }
        return $Data_Array;
    }
}




if (! function_exists('exclusive_data'))
{
    function exclusive_data($Records, $token=null, $lat=null, $lng=null)
    {
        $Data_Array=array();
        foreach ($Records as  $Record)
        {
            $data_array = array();
            $modelData = SvcVendor::find($Record->id);
            //$data_array['vendor'] = common_home($modelData, $token, $lat , $lng);
            $data_array = common_home($modelData, $token, $lat , $lng);
            $Data_Array[] = $data_array;
        }
        return $Data_Array;
    }
}




if (! function_exists('get_vendors_array'))
{
    function get_vendors_array($record, $token, $lat, $lng, $radius,$cat_id=0)
    {
        $record_id = $record->id;

        $staff = 15;//$record->staff;

        $timing = 90;//$record->timing;

        $is_featured = (($record->is_featured == 1) ? true : false);

        // Basic Details
        $basic_details = get_vendor_basic_data($record);

        // Vendor Contact Details
        $contact_details = get_vendor_contact_data($record);

        // Vendor Location Details
        $location_details = get_vendor_location_data($record, $lat, $lng, $radius);

        // Vendor Today Timings
        $timing_details = get_vendor_timings_data($record, true);

        // Vendor Categories
        $categories_count = 0;
        $categories = get_vendor_categories($record);
        if($categories!=null)
        {
            $categories_count = count($categories);
        }



        if($cat_id != 0){

            $has_attributes = 0;
            $attributes_array = null;
            $category = SvcCategory::find($cat_id);
            if(!empty($category) && $category->has_attributes == 1){
                $has_attributes = 1;
                $attributes = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$record_id)->first();

                if($attributes->count() > 0 && $attributes->attributes != null){
                    $attributes = $attributes->attributes;
                    $attributes = json_decode($attributes);

                    $prices_array = $attributes->prices;
                    $values_array = $attributes->values;

                    $count = count($prices_array);

                    for($i=0;$i<$count;$i++){
                        $attributes_array[$values_array[$i]] = $prices_array[$i];
                    }
                }
            }
        }
        // Vendor SubCategories
        //$subcategories_data = get_vendor_subcategories($record_id);

        // Vendor Services
        //$services_data = get_vendor_services($record_id);

        // Vendor Reviews
        $reviews = get_vendor_reviews($record_id,1);

        $array = array();

        $array['id'] = $record->id;
        $array['is_featured'] = $is_featured;
        $array['covid_charges'] = $record->covid_charges;
        $array['cleaning_material_charges'] = $record->cleaning_material_charges;
        $array['ironing_charges'] = $record->ironing_charges;
        $array['pickup_charges'] = $record->pickup_charges;
        $array['staff'] = $staff;
        $array['timing'] = $timing;

        if($cat_id != 0){
            $array['has_attributes'] = $has_attributes;
            $array['attributes'] = $attributes_array;
        }

        $array['basic_details'] = $basic_details;
        $array['contact_details'] = $contact_details;
        $array['location_details'] = $location_details;
        $array['timings'] = $timing_details;
        $array['categories_count'] = $categories_count;
        $array['categories'] = $categories;
        //$array['subcategories'] = $subcategories_data;
        //$array['services'] = $services_data;
        $array['overall_rating'] = $reviews['overall_rating'];
        $array['reviews_count'] = $reviews['reviews_count'];
        $array['reviews'] = $reviews['reviews'];

        return $array;
    }
}




if (! function_exists('get_vendor_basic_data'))
{
    function get_vendor_basic_data($record)
    {
        $basic_details = array();
        $basic_details['name'] = $record->name;
        $basic_details['ar_name'] = $record->arabic_name;
        $basic_details['description'] = $record->description;
        $basic_details['ar_description'] = $record->arabic_description;

        $image = $record->image;
        $image_path = 'svc/vendors/';
        if($image == 'vendor.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        $image = uploads($image_path);
        $basic_details['image'] = $image;

        return $basic_details;
    }
}




if (! function_exists('get_vendor_contact_data'))
{
    function get_vendor_contact_data($record)
    {
        $contact_details = array();
        $contact_details['email'] = $record->email;
        $contact_details['phone'] = $record->phone;
        $contact_details['website'] = $record->website;

        return $contact_details;
    }
}




if (! function_exists('get_vendor_location_data'))
{
    function get_vendor_location_data($record, $lat, $lng, $radius)
    {
        $location_details = array();
        $location_details['location'] = $record->location;
        $location_details['lat'] = $record->lat;
        $location_details['lng'] = $record->lng;

        if($lat!=null && $lng!=null){
            $location_details['distance'] = near_by_vendors($lat, $lng, $radius, $record->id);
        }
        return $location_details;
    }
}



if (! function_exists('get_vendor_timings_data'))
{
    function get_vendor_timings_data($record, $today=false, $date = 0)
    {
        $timing_details = array();

        $vend_id = $record->id;

        if($date == date("Y-m-d")){
            $today = true;
        }
        if($today){

            $current_time = time();
            $current_time = date("H:i",$current_time);
            $current_time = explode(":",$current_time);

            $time = ($current_time[0]*2);
            if($current_time[1] >= 30){
                $time = ($time + 1);
            }
            $time = ($time*30*60);
            $current_day = strtolower(date('l',time()));
            $current_day_status = $current_day."_status";

            $timings = SvcVendorTiming::select('time_value')->where('vend_id', '=', $vend_id)->where('time_value', '>', $time)->where($current_day_status, '=', 1)->get();
        }
        else{
            $day = strtotime($date);

            $current_day = strtolower(date('l',$day));
            $current_day_status = $current_day."_status";

            $timings = SvcVendorTiming::select('time_value')->where('vend_id', '=', $vend_id)->where($current_day_status, '=', 1)->get();
        }
        $i = 0;
        foreach ($timings as $timing){
            $i++;
            $value = date("H:i",$timing->time_value);
            $timing_details[$value] = $value;
        }

        return $timing_details;
    }
}




if (! function_exists('get_vendor_categories'))
{
    function get_vendor_categories($record)
    {
        $vend_id = $record->id;
        $category_data =  array();
        {
            $categories = SvcVendorCategory::where('vend_id', '=', $vend_id)->where('status', '=', '1')->get();
            foreach($categories as $category)
            {
                $category = $category->cat_id;
                $modelData = SvcCategory::where('id', '=', $category)->where('status', '=', '1')->get();
                foreach($modelData as $model)
                {
                    $category_data[] = get_category_array($model);
                }
            }
        }

        if(count($category_data) == 0)
        {
            $category_data = null;
        }
        else{
            $count = count($category_data);
        }

        return $category_data;
    }
}




if (! function_exists('get_vendor_subcategories'))
{
    function get_vendor_subcategories($vend_id, $cat_id = 0, $get_attributes=false, $get_brands=false)
    {
        $ids = array();
        if($cat_id != null && !empty($cat_id))
        {
            $modelData = SvcSubCategory::select('id')->where('cat_id', '=', $cat_id)->where('status', '=', '1')->get();
            foreach($modelData as $model)
            {
                $ids[] = $model->id;
            }
        }
        $query = SvcVendorSubCategory::select('sub_cat_id');

        $query = $query->where('vend_id', '=', $vend_id);

        if(!empty($ids))
        {
            $query = $query->whereIn('sub_cat_id', $ids);
        }

        $query = $query->where('status', '=', '1');

        $modelData = $query->get();

        $subcategory_data =  array();
        foreach($modelData as $model)
        {
            $model = SvcSubCategory::find($model->sub_cat_id);

            $categories_details = true;
            if($cat_id != null && !empty($cat_id))
            {
                $categories_details = false;
            }

            $subcategory_data[] = get_sub_category_array($model,$categories_details,$vend_id,$get_attributes,$get_brands);
        }

        if(count($subcategory_data) == 0)
            $subcategory_data = null;

        return $subcategory_data;
    }
}




if (! function_exists('get_vendor_services'))
{
    function get_vendor_services($vend_id, $sub_cat_id = 0, $get_attributes=false, $get_brands=false)
    {
        $services_main_data =  array();
        if($sub_cat_id != 0 && $sub_cat_id != null && !empty($sub_cat_id))
        {
            $sub_cat_ids = $sub_cat_id;
            foreach($sub_cat_ids as $sub_cat_id)
            {
                $ids = array();
                $modelData = SvcService::select('id');
                $modelData = $modelData->where('sub_cat_id', '=', $sub_cat_id);
                $modelData = $modelData->where('status', '=', '1');
                $modelData = $modelData->get();
                foreach($modelData as $model)
                {
                    $ids[] = $model->id;
                }


                $query = SvcVendorService::select('service_id', 'sub_service_id', 'attributes', 'price');
                $query = $query->where('vend_id', '=', $vend_id);
//                $query = $query->where('sub_service_id', '=', 0);
                if(!empty($ids))
                {
                    $query = $query->whereIn('service_id', $ids);
                }
                $query = $query->where('status', '=', '1');
                $modelData = $query->get();

                $service_ids_array = array();

                $services_data =  array();
                foreach($modelData as $model)
                {
                    if(!in_array($model->service_id, $service_ids_array)) {
                        $service_ids_array[] = $model->service_id;

                        $price = $model->price;
                        $service_id = $model->service_id;
                        $sub_service_id = $model->sub_service_id;

                        $sub_details = true;
                        if ($sub_cat_id != null && !empty($sub_cat_id)) {
                            $sub_details = false;
                        }

                        $record = SvcService::find($service_id);
                        if ($sub_service_id == 0) {

                            $data = get_service_array($record, $price, $sub_details, $vend_id, $get_attributes, $get_brands);

                        } else {
                            $data = get_service_array($record, false, $sub_details, $vend_id, $get_attributes, $get_brands);

                            $sub_services = array();

                            $records = SvcSubService::where('service_id',$service_id)->get();
                            foreach ($records as $record){
                                $sub_services[] = get_sub_service_array($record, $price, true,$vend_id,$get_attributes);
                            }
                            if(count($sub_services) == 0){
                                $sub_services == null;
                            }
                            $data['sub_services'] = $sub_services;

                        }
                        $services_data[] = $data;
                    }
                }

                if(count($services_data) == 0)
                    $services_data = null;

                $services_main_data[$sub_cat_id] = $services_data;
            }

            if(count($services_main_data) == 0)
                $services_main_data = null;
        }
        else
        {
            $ids = array();
            $modelData = SvcService::select('id');
            $modelData = $modelData->where('status', '=', '1');
            $modelData = $modelData->get();
            foreach($modelData as $model)
            {
                $ids[] = $model->id;
            }


            $query = SvcVendorService::select('service_id', 'sub_service_id', 'attributes', 'price');
            $query = $query->where('vend_id', '=', $vend_id);
            if(!empty($ids))
            {
                $query = $query->whereIn('service_id', $ids);
            }
            $query = $query->where('status', '=', '1');
            $modelData = $query->get();

            $services_data =  array();
            foreach($modelData as $model)
            {
                $price = $model->price;
                $service_id = $model->service_id;
                $sub_service_id = $model->sub_service_id;

                $sub_details = true;
                if($sub_cat_id != null && !empty($sub_cat_id))

                {
                    $sub_details = false;
                }

                $record = SvcService::find($service_id);
                if($sub_service_id == 0)
                {
                    $data = get_service_array($record, $price, $sub_details);
                }
                else
                {
                    $data = get_service_array($record, false, $sub_details);

                    $record = SvcSubService::find($sub_service_id);
                    $data['subservice'] = get_sub_service_array($record, $price);
                }
                $services_data[] = $data;
            }

            if(count($services_data) == 0)
                $services_data = null;

            $services_main_data = $services_data;

        }

        return $services_main_data;
    }
}




if (! function_exists('get_vendor_subservices'))
{
    function get_vendor_subservices($vend_id, $service_id = 0, $get_attributes=false)
    {
        $sub_services_main_data =  array();
        if($service_id != 0 && $service_id != null && !empty($service_id))
        {
            $service_ids = $service_id;
            foreach($service_ids as $service_id)
            {
                $ids = array();
                $modelData = SvcSubService::select('id');
                $modelData = $modelData->where('service_id', '=', $service_id);
                $modelData = $modelData->where('status', '=', '1');
                $modelData = $modelData->get();
                foreach($modelData as $model)
                {
                    $ids[] = $model->id;
                }

                $modelData = SvcVendorService::select('sub_service_id','price');
                $modelData = $modelData->where('vend_id', '=', $vend_id);
                if(!empty($ids))
                {
                    $modelData = $modelData->whereIn('sub_service_id', $ids);
                }
                $modelData = $modelData->where('status', '=', '1');
                $modelData = $modelData->get();

                $sub_services_data =  array();
                foreach($modelData as $model)
                {
                    $sub_service_id = $model->sub_service_id;
                    if($sub_service_id>0)
                    {
                        $price = $model->price;
                        $sub_details = true;
                        if($service_id != null && !empty($service_id))
                        {
                            $sub_details = false;
                        }

                        $record = SvcSubService::find($sub_service_id);

                        $sub_services_data[] = get_sub_service_array($record, $price, $sub_details,$vend_id,$get_attributes);
                    }
                }

                if(count($sub_services_data) == 0)
                    $sub_services_data = null;

                $sub_services_main_data[$service_id] = $sub_services_data;
            }

            if(count($sub_services_main_data) == 0)
                $sub_services_main_data = null;
        }
        else
        {
            $ids = array();
            $modelData = SvcSubService::select('id');
            $modelData = $modelData->where('status', '=', '1');
            $modelData = $modelData->get();
            foreach($modelData as $model)
            {
                $ids[] = $model->id;
            }

            $modelData = SvcVendorService::select('sub_service_id','price');
            $modelData = $modelData->where('vend_id', '=', $vend_id);
            if(!empty($ids))
            {
                $modelData = $modelData->whereIn('sub_service_id', $ids);
            }
            $modelData = $modelData->where('status', '=', '1');
            $modelData = $modelData->get();

            $sub_services_data =  array();
            foreach($modelData as $model)
            {
                $sub_service_id = $model->sub_service_id;
                if($sub_service_id>0)
                {
                    $price = $model->price;
                    $sub_details = true;
                    if($service_id != null && !empty($service_id))
                    {
                        $sub_details = false;
                    }

                    $record = SvcSubService::find($sub_service_id);

                    $sub_services_data[] = get_sub_service_array($record, $price, $sub_details);
                }
            }

            if(count($sub_services_data) == 0)
                $sub_services_data = null;

            $sub_services_main_data = $sub_services_data;

        }

        return $sub_services_main_data;
    }
}




if (! function_exists('get_vendor_reviews'))
{
    function get_vendor_reviews($vend_id,$limit=0)
    {
        $count = 0;
        $rating = 0;
        $reviews = array();
        $Reviews = SvcReview::where('vend_id',$vend_id)->where('status',1)->get();
        foreach($Reviews as $Review)
        {
            $count++;
            $proceed = 1;
            if($count>5 && $limit==1)
            {
                $proceed = 0;
            }
            if($proceed==1)
            {
                $app_user = $count;
                $app_user_data = app_user_data($Review->user_id);
                $arr = array();
                $arr['rating'] = $Review->rating;
                $arr['review'] = $Review->review;
                $arr['reviewer'] = $count;
                $arr['reviewer_name'] = $app_user_data->name;
                $image = $app_user_data->photo;
                if($image == "app_user.png")
                {
                    $image = uploads('defaults') .'/'.$image;
                }
                else
                {
                    $image = uploads('app_users') .'/'.$image;
                }
                $arr['reviewer_image'] = $image;
                $arr['reviewed_at'] = date('d/m/Y',strtotime($Review->created_at));
                $reviews[] = $arr;
            }

            if(is_numeric($Review->rating))
            {
                $rating+=$Review->rating;
            }
        }
        if($count>0 && $rating>0)
        {
            $rating = round($rating/$count);
        }
        $reviews_count = $count;

        $array = array();
        $array['overall_rating'] = $rating;
        $array['reviews_count'] = $reviews_count;
        $array['reviews'] = $reviews;

        return $array;
    }
}




/*if (! function_exists('abbccdf'))
{
}




if (! function_exists('abbccdf'))
{
}




if (! function_exists('abbccdf'))
{
}*/
	
	
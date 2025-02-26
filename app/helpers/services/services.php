<?php

use App\Models\SvcBrand;
use App\Models\SvcBrandOption;
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

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

if (! function_exists('get_category_array'))
{
    function get_category_array($record)
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
        if($ban_image == 'cat_thumb_image.png')
        {
            $thumb_image = 'defaults/';
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

        return $array;
    }

}

if (! function_exists('get_sub_category_array'))
{
    function get_sub_category_array($record, $categories_details = true, $vend_id = 0, $get_attributes = false, $get_brands = false)
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
        $array['static_id'] = $record->static_id;
        //$array['cat_id'] = $record->cat_id;
        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['type'] = $record->type;
        $array['image'] = $image;
        $array['has_services'] = $record->has_services;

        if($get_attributes){

            $has_attributes = 0;
            $attributes_array = null;
            $subcategory = SvcSubCategory::find($record_id);
            if(!empty($subcategory) && $subcategory->has_attributes == 1){
                $has_attributes = 1;
                $attributes = SvcVendorSubCategory::where('sub_cat_id',$record_id)->where('vend_id',$vend_id)->first();

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

            $array['has_attributes'] = $has_attributes;
            $array['attributes'] = $attributes_array;
        }


        if($get_brands){

            $has_brands = 0;
            $brands_array = null;
            $subcategory = SvcSubCategory::find($record_id);
            if(!empty($subcategory) && $subcategory->has_brands == 1){
                $has_brands = 1;
                $brands = SvcBrand::where('ref_id',$record_id)->where('ref_type',"App/Models/SvcSubCategory")->first();

                $brands_options = SvcBrandOption::where('brand_id', $brands->id)->get();
                foreach ($brands_options as $brands_option){
                    $brands_array[] = $brands_option->name;
                }
            }

            $array['has_brands'] = $has_brands;
            $array['brands'] = $brands_array;
        }


        if($categories_details == true)
        {
            $model = SvcCategory::find($record->cat_id);
            $array['category'] = get_category_array($model);
        }

        return $array;
    }
}

if (! function_exists('get_service_array'))
{
    function get_service_array($record, $price=false, $sub_details = true, $vend_id = 0, $get_attributes = false, $get_brands = false)
    {
        $record_id = $record->id;

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

        //$array['cat_id'] = $record->cat_id;

        //$array['sub_cat_id'] = $record->sub_cat_id;

        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

        if($get_attributes){

            $has_attributes = 0;
            $attributes_array = null;
            $service = SvcService::find($record_id);
            if(!empty($service) && $service->has_attributes == 1){
                $has_attributes = 1;
                $attributes = SvcVendorService::where('service_id',$record_id)->where('vend_id',$vend_id)->first();

                if($attributes->count() > 0 && $attributes->attributes != null)
                {
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

            $array['has_attributes'] = $has_attributes;
            $array['attributes'] = $attributes_array;
        }


        if($get_brands){

            $has_brands = 0;
            $brands_array = null;
            $service = SvcService::find($record_id);
            if(!empty($service) && $service->has_brands == 1){
                $has_brands = 1;
                $brands = SvcBrand::where('ref_id',$record_id)->where('ref_type',"App/Models/SvcService")->first();

                $brands_options = SvcBrandOption::where('brand_id', $brands->id)->get();
                foreach ($brands_options as $brands_option){
                    $brands_array[] = $brands_option->name;
                }
            }

            $array['has_brands'] = $has_brands;
            $array['brands'] = $brands_array;
        }

        $array['has_sub_services'] = $record->has_sub_services;



        if($sub_details == true)
        {
            $model = SvcCategory::find($record->cat_id);
            $array['category'] = get_category_array($model);

            $model = SvcSubCategory::find($record->sub_cat_id);
            $categories_details = false;
            $array['subcategory'] = get_sub_category_array($model, $categories_details);
        }

        if($price!=false)
            $array['price'] = $price;
        else
            $array['price'] = 0;

        return $array;
    }
}

if (! function_exists('get_sub_service_array'))
{
    function get_sub_service_array($record, $price=false, $sub_details = true, $vend_id = 0, $get_attributes = false)
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
        if($price!=false)
            $array['price'] = $price;

        //$array['cat_id'] = $record->cat_id;

        //$array['sub_cat_id'] = $record->sub_cat_id;

        //$array['service_id'] = $record->service_id;

        $array['title'] = $record->title;
        $array['ar_title'] = $record->ar_title;
        $array['description'] = $record->description;
        $array['ar_description'] = $record->ar_description;
        $array['image'] = $image;

        if($get_attributes){

            $has_attributes = 0;
            $attributes_array = null;
//            $subcategory = SvcSubService::find($record_id);
            if(!empty($record) && $record->has_attributes == 1){

                $has_attributes = 1;
                $attributes = SvcVendorService::where('sub_service_id',$record_id)->where('vend_id',$vend_id)->first();

                if($attributes->count() > 0 && $attributes->attributes != null)
                {
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

            $array['has_attributes'] = $has_attributes;
            $array['attributes'] = $attributes_array;
        }

        return $array;
    }
}


if (! function_exists('get_category_name'))
{
    function get_category_name($cat_id)
    {
        $category = SvcCategory::select('title')->where('id', $cat_id)->first();
        return $category->title;
    }
}


if (! function_exists('get_sub_category_name'))
{
    function get_sub_category_name($sub_cat_id)
    {
        $category = SvcSubCategory::select('title')->where('id', $sub_cat_id)->first();
        return $category->title;
    }
}


if (! function_exists('get_service_name'))
{
    function get_service_name($service_id)
    {
        $category = SvcService::select('title')->where('id', $service_id)->first();
        return $category->title;
    }
}


if (! function_exists('get_sub_service_name'))
{
    function get_sub_service_name($sub_service_id)
    {
        $category = SvcSubService::select('title')->where('id', $sub_service_id)->first();
        return $category->title;
    }
}


if (! function_exists('get_vendor_name'))
{
    function get_vendor_name($vend_id)
    {
        $vendor = SvcVendor::select('name')->where('id', $vend_id)->first();
        return $vendor->name;
    }
}

?>
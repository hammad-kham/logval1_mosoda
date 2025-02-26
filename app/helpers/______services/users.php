<?php

use App\Models\SvcCategory;
use App\Models\Notification;
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

if (! function_exists('getUser'))
{
    function getUser($token)
    {
        $User = null;
        if(!empty($token))
        {
            $Verifications = DB::table('verification_codes')->where('token', $token)->where('expired', 1)->first();

            if(!empty($Verifications)){
                $user_id = $Verifications->user_id;

                $User = AppUser::find($user_id);
            }
        }

        return $User;
    }
}

if (! function_exists('is_liked'))
{
    function is_liked($token, $vend_id)
    {
        $bool = false;
        if(!empty($token))
        {
            $Verifications = DB::table('verification_codes')->where('token', $token)->where('expired', 1)->first();

            if(!empty($Verifications)){

                $user_id = $Verifications->user_id;

                $is_liked_count = SvcAppUserFavorite::where('vend_id', '=', $vend_id)->where('user_id', '=', $user_id)->count();
                if($is_liked_count>0)
                {
                    $bool = true;
                }
            }
        }

        return $bool;
    }
}

if (! function_exists('near_by_vendors'))
{
    function near_by_vendors($lat,$lng,$radius=null,$vend_id=null)
    {
        if((!empty($lat)||$lat==null) && !empty($lng)||$lng==null)
        {
            $query = SvcVendor::select("*", DB::raw("6371 * acos(cos(radians(" . $lat . "))
                      * cos(radians(lat)) * cos(radians(lng) - radians(" . $lng . "))
                + sin(radians(" .$lat. ")) * sin(radians(lat))) AS distance"));
            if($radius!=null)
                $query          =       $query->having('distance', '<', $radius);
            $query          =       $query->orderBy('distance', 'asc');
            $query          =       $query->where('id',$vend_id);
            $modelData          =       $query->first();
            $distance=null;
            if(!empty($modelData))
            { $distance= round($modelData['distance'] ,2).' km';}

            return $distance;
        }
        else
        {
            return 'Please Provide Latitude and Longitude';
        }
    }
}

if (! function_exists('app_user_data'))
{
    function app_user_data($id)
    {
        $modelData = AppUser::where('id', '=', $id)->first();
        return $modelData;
    }
}

if (! function_exists('get_user_array'))
{
    function get_user_array($record)
    {
        $image = $record->photo;
        $image_path = '';
        if($record->photo_type == 0)
        {
            $image_path = 'app_users/';
            if($image == 'app_user.png')
            {
                $image_path = 'defaults/';
            }
            $image_path.= $image;
            $image_path = uploads($image_path);
        }
        else
        {
            $image_path.= $image;
        }

        $array = array();
        $array['id'] = $record->id;
        $array['name'] = $record->name;
        $array['email'] = $record->email;
        $array['photo'] = $image_path;

        return $array;
    }
}

if (! function_exists('get_user_location_data'))
{
    function get_user_location_data($record)
    {
        $array = array();
        $array['id'] = $record->id;
        $array['is_default'] = (($record->is_default==1) ? true : false);
        $array['nick_name'] = $record->nick_name;
        $array['flat'] = $record->flat;
        $array['building'] = $record->building;
        $array['address'] = $record->address;
        $array['lat'] = $record->lat;
        $array['lng'] = $record->lng;

        return $array;
    }
}

if (! function_exists('get_user_pm_data'))
{
    function get_user_pm_data($record)
    {
        $array = array();
        $array['id'] = $record->id;
        $array['is_default'] = (($record->is_default==1) ? true : false);
        $method_id = $record->method_id;

        $details = array();
        $method = PaymentMethod::find($method_id);
        //foreach($methods as $method)
        {
            $details['id'] = $method->id;
            $details['name'] = $method->name;
            $image = $method->image;

            $image_path = 'payment_methods/';
            if($image == 'method.png')
            {
                $image_path = 'defaults/';
            }
            $image_path.= $image;
            $image_path = uploads($image_path);
            $details['image'] = $image_path;

        }
        $array['method'] = $details;

        if($method_id == 1)
        {
            $array['paypal_email'] = $record->paypal_email;
            $array['card_number'] = '';
            $array['card_expiry_month'] = '';
            $array['card_expiry_year'] = '';
            $array['card_civ'] = '';
        }
        elseif($method_id == 2)
        {
            $array['paypal_email'] = '';
            $array['card_number'] = $record->card_number;
            $array['card_expiry_month'] = $record->card_expiry_month;
            $array['card_expiry_year'] = $record->card_expiry_year;
            $array['card_civ'] = $record->card_civ;
        }
        else
        {
            $array['paypal_email'] = '';
            $array['card_number'] = '';
            $array['card_expiry_month'] = '';
            $array['card_expiry_year'] = '';
            $array['card_civ'] = '';
        }

        return $array;
    }
}

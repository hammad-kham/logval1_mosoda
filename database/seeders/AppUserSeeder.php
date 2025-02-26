<?php

namespace Database\Seeders;

use App\Models\AppUserLocation;
use App\Models\AppUserSetting;
use App\Models\AppUserSocial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppUser;

class AppUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array();
        $array['App User 1'] = 'user1@gmail.com';
        $array['App User 2'] = 'user2@gmail.com';
        $array['App User 3'] = 'user3@gmail.com';
        $array['App User 4'] = 'user4@gmail.com';
        $array['App User 5'] = 'user5@gmail.com';

        $address = 'Islamabad';

        $count = 0;
        foreach($array as $name => $email)
        {
            $count++;

            $model = new AppUser();
            $model->name = $name;
            $model->email = $email;
            $model->phone = "+9778400000".$count;
            $model->photo = "app_user.png";
            $model->created_by = "1";
            $model->save();

            $id = $model->id;

            $App_user_location = new AppUserLocation();
            $App_user_location->user_id = $id;
            $App_user_location->nick_name = $this->nick_name();
            $App_user_location->flat = $this->flat();
            $App_user_location->building = $this->building();
            $App_user_location->address = $address;
            $App_user_location->lat = 33.650388;
            $App_user_location->lng = 73.034916;
            $App_user_location->is_default = $this->is_default();
            $App_user_location->created_by = "1";
            $App_user_location->save();


            $model_setting = new AppUserSetting();
            $model_setting->user_id = $id;
            $model_setting->created_by = "1";
            $model_setting->save();


            $model_social = new AppUserSocial();
            $model_social->user_id = $id;
            $model_social->created_by = "1";
            $model_social->save();
        }

    }


    function nick_name()
    {
        $nick_name = array("a"=>"Home", "b"=>"Office");
        shuffle($nick_name);
        foreach($nick_name as $name)
        {
            $name = $name;
        }
        return $name;
    }

    function flat()
    {
        $flat = array("a"=>"40", "b"=>"50", "c"=>"70", "d"=>"22", "e"=>"35", "f"=>"423", "g"=>"464", "h"=>"222");
        shuffle($flat);
        foreach($flat as $flats)
        {
            $flats = $flats;
        }
        return $flats;
    }

    function building()
    {
        $building = array("a"=>"plaza", "b"=>"Garden Road", "c"=>"alnoor block", "d"=>"alhassan block");
        shuffle($building);
        foreach($building as $buildings)
        {
            $buildings = $buildings;
        }
        return $buildings;
    }

    function is_default()
    {
        $is_default = array("a"=>"0", "b"=>"1");
        shuffle($is_default);
        foreach($is_default as $is_defaults)
        {
            $is_defaults = $is_defaults;
        }
        return $is_defaults;
    }


}
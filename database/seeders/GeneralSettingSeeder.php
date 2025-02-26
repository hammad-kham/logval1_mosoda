<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\GeneralSetting;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {			
        $model = new GeneralSetting();
			$model->title = "phone";
			$model->value = "+97784567832";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "email";
			$model->value = "info@homely-uae.com";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "website";
			$model->value = "www.homely-uae.com";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "VAT";
			$model->value = "5";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Order Declining Time";
			$model->value = "30";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Order Declining Reason";
			$model->value = "Busy";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Order Collection Time";
			$model->value = "30";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Ramadan";
			$model->value = "0";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Maximum Fixed Discount Value";
			$model->value = "80";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "Maximum Percentage Discount Value";
			$model->value = "80";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "New Order Notification Audio";
			$model->value = "new_order.mp3";
			$model->created_by = "1";
			$model->save();
			
        $model = new GeneralSetting();
			$model->title = "User Arrived Notification Audio";
			$model->value = "user_arrived.mp3";
			$model->created_by = "1";
			$model->save();

        $model = new GeneralSetting();
			$model->title = "Google Maps API Key";
			$model->value = "AIzaSyCD8bY_JqPR9R6H-PaCp06DMc1dpyFaFbg";
			$model->created_by = "1";
			$model->save();

    }
}
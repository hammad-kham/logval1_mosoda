<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppLabel;

class AppLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['home'] = 'home';
		$array['register'] = 'register';
		$array['login'] = 'login';
		$array['profile'] = 'profile';
		$array['name'] = 'name';
		$array['phone'] = 'phone';
		$array['email'] = 'email';
		$array['locations'] = 'locations';
		$array['map'] = 'map';
		$array['offers'] = 'offers';
		$array['deals'] = 'deals';
		$array['promos'] = 'promos';
		$array['restaurants'] = 'restaurants';
		$array['orders'] = 'orders';
		$array['rewards'] = 'rewards';
		$array['gifts'] = 'gifts';
		
		
		foreach($array as $name => $value)
		{				
			$model = new AppLabel();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
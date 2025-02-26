<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array[] = 'Master Card';
		$array[] = 'VISA Card';
		$array[] = 'Paypal';
		$array[] = 'Cash';		
		
		foreach($array as $name)
		{				
			$model = new PaymentMethod();
				$model->name = $name;
				$model->image = "method.png";
				$model->created_by = "1";
				$model->save();
		}

    }
}
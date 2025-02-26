<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\OccasionType;

class OccasionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Birthday'] = 'Birthday';
		$array['Anniversary'] = 'Anniversary';
		$array['Thinking of You'] = 'Thinking of You';
		$array['Congratulations'] = 'Congratulations';
		$array['Thank You'] = 'Thank You';
		$array['Get Well Soon'] = 'Get Well Soon';
		
		
		foreach($array as $name => $value)
		{				
			$model = new OccasionType();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
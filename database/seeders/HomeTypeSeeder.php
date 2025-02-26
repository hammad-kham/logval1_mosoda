<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\HomeType;

class HomeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Apartment'] = 'Apartment';
		$array['Cottage'] = 'Cottage';
		$array['Barn'] = 'Barn';
		$array['Bungalow'] = 'Bungalow';
		$array['Villa'] = 'Villa';
		$array['Mansion'] = 'Mansion';
		$array['Castle'] = 'Castle';
		$array['Palace'] = 'Palace';
		$array['Studio'] = 'Studio';
		
		
		foreach($array as $name => $value)
		{				
			$model = new HomeType();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
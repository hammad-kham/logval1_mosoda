<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\FlowerColor;

class FlowerColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Black'] = '#000000';
		$array['Silver'] = '#FFFFFF';
		$array['White'] = '#FFFFFF';
		$array['Grey'] = '#757983';
		$array['Green'] = '#3D6E07';
		$array['Red'] = '#E62222';
		$array['Brown'] = '#813030';
		$array['Light Blue'] = '#6289EA';
		$array['Purple'] = '#511D8C';
		$array['Gold'] = '#C6A23D';
		$array['Yellow'] = '#EBD721';
		$array['Other'] = '#0CA8D8';
		
		
		foreach($array as $name => $value)
		{				
			$model = new FlowerColor();
				$model->name = $name;
				$model->ar_name = $name;
				$model->value = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
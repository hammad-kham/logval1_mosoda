<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\HomeItem;

class HomeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Beds'] = 'Beds';
		$array['Dining Table'] = 'Dining Table';
		$array['Computer Table'] = 'Computer Table';
		$array['Sofa Set 3 Seater'] = 'Sofa Set 3 Seater';
		$array['Sofa Set 4 Seater'] = 'Sofa Set 4 Seater';
		$array['Sofa Set L Shape'] = 'Sofa Set L Shape';
		$array['Entertainment Unit'] = 'Entertainment Unit';
		$array['Chest Draws'] = 'Chest Draws';
		
		
		foreach($array as $name => $value)
		{				
			$model = new HomeItem();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
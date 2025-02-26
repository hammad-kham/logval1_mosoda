<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\FlowerSize;

class FlowerSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Single'] = 'Single';
		$array['Bunch'] = 'Bunch';
		$array['Bouqet'] = 'Bouqet';
		
		
		foreach($array as $name => $value)
		{				
			$model = new FlowerSize();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
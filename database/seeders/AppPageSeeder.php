<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppPage;

class AppPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['About Us'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper. Donec tincidunt et augue sit amet gravida. Mauris pellentesque malesuada mi, sit amet sollicitudin nunc volutpat sed.';
		$array['Privacy Policy'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper. Donec tincidunt et augue sit amet gravida. Mauris pellentesque malesuada mi, sit amet sollicitudin nunc volutpat sed.';
		$array['Terms and Conditions'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper. Donec tincidunt et augue sit amet gravida. Mauris pellentesque malesuada mi, sit amet sollicitudin nunc volutpat sed.';		
		$array['Ecommerce Home'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper. Donec tincidunt et augue sit amet gravida. Mauris pellentesque malesuada mi, sit amet sollicitudin nunc volutpat sed.';
        $array['Classified Home'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper. Donec tincidunt et augue sit amet gravida. Mauris pellentesque malesuada mi, sit amet sollicitudin nunc volutpat sed.';

		foreach($array as $title => $description)
		{				
			$model = new AppPage();
				$model->title = $title;
				$model->ar_title = $title;
				$model->description = $description;
				$model->ar_description = $description;
				$model->created_by = "1";
				$model->save();
		}

    }
}
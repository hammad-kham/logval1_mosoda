<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Bedroom'] = 'Bedroom';
		$array['Living Room'] = 'Living Room';
		$array['Dining Room'] = 'Dining Room';
		$array['Study Room'] = 'Study Room';
		$array['Maid Room'] = 'Maid Room';
		$array['Storage Room'] = 'Storage Room';
		
		
		foreach($array as $name => $value)
		{				
			$model = new RoomType();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
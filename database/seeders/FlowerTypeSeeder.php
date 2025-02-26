<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\FlowerType;

class FlowerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$array = array();
		$array['Alstroemerias'] = 'Alstroemerias';
		$array['Calla Lilies'] = 'Calla Lilies';
		$array['Carnations'] = 'Carnations';
		$array['Daisies'] = 'Daisies';
		$array['Gardenias'] = 'Gardenias';
		$array['Gerbera Daisies'] = 'Gerbera Daisies';
		$array['Lilies'] = 'Lilies';
		$array['Orchids'] = 'Orchids';
		$array['Roses'] = 'Roses';
		$array['Sunflowers'] = 'Sunflowers';
		$array['Tulips'] = 'Tulips';
		$array['Peonies'] = 'Peonies';
		$array['Dahlias'] = 'Dahlias';
		$array['Marigold'] = 'Marigold';
		$array['Aster'] = 'Aster';
		$array['Azalea'] = 'Azalea';
		$array['Black-Eyed Susan'] = 'Black-Eyed Susan';
		$array['Buttercup'] = 'Buttercup';
		$array['California Poppy'] = 'California Poppy';
		$array['Chrysanthemum'] = 'Chrysanthemum';
		$array['Crocus'] = 'Crocus';
		$array['Daffodil'] = 'Daffodil';
		$array['Delphinium'] = 'Delphinium';
		$array['Dusty Miller'] = 'Dusty Miller';
		$array['Geranium'] = 'Geranium';
		$array['Iris'] = 'Iris';
		$array['Lavender'] = 'Lavender';
		$array['Periwinkle'] = 'Periwinkle';
		$array['Petunia'] = 'Petunia';
		$array['Ranunculus'] = 'Ranunculus';
		$array['Snapdragon'] = 'Snapdragon';
		$array['Violet'] = 'Violet';
		$array['Zinnia'] = 'Zinnia';
		
		
		foreach($array as $name => $value)
		{				
			$model = new FlowerType();
				$model->title = $name;
				$model->ar_title = $value;
				$model->created_by = "1";
				$model->save();
		}

    }
}
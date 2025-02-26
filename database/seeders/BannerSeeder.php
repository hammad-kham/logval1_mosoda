<?php

namespace Database\Seeders;

use App\Models\AppPage;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$EcomAppPage = AppPage::find(4);
		$EcomAppPageTitle = $EcomAppPage->title;
		
		for($i=1;$i<=2;$i++)
		{
			$title = "Banner No.".$i." of ".$EcomAppPageTitle;
			$model = new Banner();
			$model->title = $title;
			$model->ar_title = $title;
			$model->topic_app_page_id = 4;
			$model->image = 'banner.png';
			$model->created_by = "1";
			$model->save();
		}
		
		
		$CaAppPage = AppPage::find(5);
		$CaAppPageTitle = $CaAppPage->title;
		
		for($i=1;$i<=2;$i++)
		{
			$title = "Banner No.".$i." of ".$CaAppPageTitle;
			$model = new Banner();
			$model->title = $title;
			$model->ar_title = $title;
			$model->topic_app_page_id = 5;
			$model->image = 'banner.png';
			$model->created_by = "1";
			$model->save();
		}
	}
}

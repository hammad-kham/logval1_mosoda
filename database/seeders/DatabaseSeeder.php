<?php

namespace Database\Seeders;

use App\Models\CaConditionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
			
			AppLabelSeeder::class,
			
			AppPageSeeder::class,
			
			AppSlideSeeder::class,

			BannerSeeder::class,

			ContactDetailSeeder::class,

			GeneralSettingSeeder::class,

            CurrencySeeder::class,

            CountrySeeder::class,

            FaqTopicSeeder::class,
			
			FlowerColorSeeder::class,
			
			FlowerSizeSeeder::class,
			
			FlowerTypeSeeder::class,
			
			HomeItemSeeder::class,
			
			HomeTypeSeeder::class,

            LanguageSeeder::class,
			
			OccasionTypeSeeder::class,
			
			PaymentMethodSeeder::class,
			
			RoomTypeSeeder::class,
			
			TemplateSeeder::class,
			
			ModuleSeeder::class,
			
			RoleSeeder::class,
			
			AppUserSeeder::class,
			
			SvcCategorySeeder::class,
			
			SvcSubCategorySeeder::class,
			
			SvcServiceSeeder::class,
			
			SvcVendorSeeder::class,

            SvcProductSeeder::class,

            
			UserSeeder::class

		]);
    }
}

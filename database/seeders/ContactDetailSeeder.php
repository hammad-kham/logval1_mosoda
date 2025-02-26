<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\ContactDetail;

class ContactDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {			
        $model = new ContactDetail();
			$model->title = "phone";
			$model->value = "+97784567832";
			$model->created_by = "1";
			$model->save();
			
        $model = new ContactDetail();
			$model->title = "email";
			$model->value = "info@homely.com";
			$model->created_by = "1";
			$model->save();
			
        $model = new ContactDetail();
			$model->title = "website";
			$model->value = "www.homely-uae.com";
			$model->created_by = "1";
			$model->save();

    }
}
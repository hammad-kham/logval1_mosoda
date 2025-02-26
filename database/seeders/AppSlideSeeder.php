<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppSlide;

class AppSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // For App

        $array = array();
        $array['Get Started With Homely'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Get Services'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Favourite Products'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';

        foreach($array as $title => $description)
        {

            $model = new AppSlide();

            $model->title = $title;
            $model->ar_title = $title;
            $model->description = $description;
            $model->ar_description = $description;
            $model->module = 0;
            $model->type = 0;
            $model->image = "slide.png";
            $model->status = "1";
            $model->created_by = "1";
            $model->save();

        }


        // For services home

        $array = array();
        $array['Cover'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Drive'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Collect'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';

        foreach($array as $title => $description)
        {

            $model = new AppSlide();

            $model->title = $title;
            $model->ar_title = $title;
            $model->description = $description;
            $model->ar_description = $description;
            $model->module = 1;
            $model->type = 1;
            $model->image = "slide.png";
            $model->status = "1";
            $model->created_by = "1";
            $model->save();

        }


        // For ecommerce home

        $array = array();
        $array['Offer'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Value'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
        $array['Expense'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';

        foreach($array as $title => $description)
        {
            $model = new AppSlide();

            $model->title = $title;
            $model->ar_title = $title;
            $model->description = $description;
            $model->ar_description = $description;
            $model->module = 2;
            $model->type = 1;
            $model->image = $title.".png";
            $model->status = "1";
            $model->created_by = "1";
            $model->save();

        }
	
	
	    // For Classified home
	
	    $array = array();
	    $array['Buyer'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
	    $array['Seller'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
	    $array['Market'] = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
	
	    foreach($array as $title => $description)
	    {
		
		    $model = new AppSlide();
		
		    $model->title = $title;
		    $model->ar_title = $title;
		    $model->description = $description;
		    $model->ar_description = $description;
		    $model->module = 3;
		    $model->type = 1;
		    $model->image = $title.".png";
		    $model->status = "1";
		    $model->created_by = "1";
		    $model->save();
		
	    }

    }
}
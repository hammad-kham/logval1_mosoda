<?php

namespace Database\Seeders;

use App\Models\SvcProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;

class SvcProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{

        $array = array();

        $child = array();
        $child['name'] = "Kathleen Castillo";
        $child['description'] = "Commodi quis harum e";
        $child['cat_id'] = 2;
        $child['sub_cat_id'] = 13;
        $child['vend_id'] = 1;
        $child['image'] = "product_image.png";
        $child['price'] = 167;
        $child['occasion_type'] = "(1),(2)";

        $array[] = $child;

        $child = array();
        $child['name'] = "Lenore Thomas";
        $child['description'] = "Commodi quis harum e";
        $child['cat_id'] = 2;
        $child['sub_cat_id'] = 13;
        $child['vend_id'] = 1;
        $child['image'] = "product_image.png";
        $child['price'] = 652;
        $child['occasion_type'] = "(3),(2)";

        $array[] = $child;

        $child = array();
        $child['name'] = "Hunter Macdonald";
        $child['description'] = "Commodi quis harum e";
        $child['cat_id'] = 2;
        $child['sub_cat_id'] = 14;
        $child['vend_id'] = 1;
        $child['image'] = "product_image.png";
        $child['price'] = 965;
        $child['occasion_type'] = "(4),(1)";

        $array[] = $child;


        foreach ($array as $record){
            $product = new SvcProduct();

            $product->name = $record["name"];
            $product->description = $record["description"];
            $product->cat_id = $record["cat_id"];
            $product->sub_cat_id = $record["sub_cat_id"];
            $product->vend_id = $record["vend_id"];
            $product->image = $record["image"];
            $product->price = $record["price"];
            $product->occasion_type = $record["occasion_type"];
            $product->created_by = 1;

            $product->save();
        }

    }
}
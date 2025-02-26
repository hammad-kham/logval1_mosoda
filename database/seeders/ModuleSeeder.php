<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Module;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$type = 0;		
		
		// 1 Service on Demand
        $array = array();
        $array[] = 'Vendors';
        $array[] = 'Vendor Bank Details';
        $array[] = 'Vendor Categories';
        $array[] = 'Vendor Sub Categories';
        $array[] = 'Vendor Services';
        $array[] = 'Vendor Products';//change from Products
        $array[] = 'Vendor Orders';//change from Orders
        $array[] = 'Vendor Reviews';//change from Reviews
		
		$type++;
		foreach($array as $name)
		{	
			$this->common($name, $type);
		}
		
		// 2 Service on Demand General Settings
        $array = array();
        $array[] = 'Categories';
        $array[] = 'Sub Categories';
        $array[] = 'Services';
        $array[] = 'Sub Services';
		
		$type++;
		foreach($array as $name)
		{	
			$this->common($name, $type);
		}
		
		
		// 7 App Users
        $array = array();
        $array[] = 'App Users';
        $array[] = 'App User Queries';
        $array[] = 'App Improvements';
		
		$type++;
		foreach($array as $name)
		{	
			$this->common($name, $type);
		}
		
		// 8 Users
        $array = array();
        $array[] = 'Users';
        $array[] = 'Modules';
        $array[] = 'Roles';
		
		$type++;
		foreach($array as $name)
		{	
			$this->common($name, $type);
		}
		
		// 9 General Settings
        $array = array();
        $array[] = 'App Labels';
        $array[] = 'App Pages';
        $array[] = 'App Slides';
		$array[] = 'Bad Words';
        $array[] = 'Banners';
        $array[] = 'Contact Details';
		$array[] = 'Currency';
		$array[] = 'Countries';
        $array[] = 'Faq Topics';
        $array[] = 'Flower Types';
        $array[] = 'Flower Sizes';
        $array[] = 'Flower Colors';
        $array[] = 'Home Types';
        $array[] = 'Home Items';
	    $array[] = 'Languages';
        $array[] = 'Occasion Types';	
        $array[] = 'Payment Methods';
        $array[] = 'Room Types';
        $array[] = 'Templates';
		
		$type++;
		foreach($array as $name)
		{	
			$this->common($name, $type);
		}

    }

    public function common($name, $type)
    {	

		$model = new Module();

			$model->module_name = $name;
			$model->type = $type;
			$model->mod_list = 1;
			$model->mod_add = 1;
			$model->mod_edit = 1;
			$model->mod_view = 1;
			$model->mod_status = 1;
			$model->mod_delete = 1;
			$model->created_by = "1";		

		$model->save();

		$permission = $name.'-listing';	
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);		

		

		$permission = $name.'-add';
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);		

		

		$permission = $name.'-edit';
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);		

		

		$permission = $name.'-view';	
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);		

		

		$permission = $name.'-status';	
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);		

		

		$permission = $name.'-delete';	
		$permission = createSlug($permission);
		Permission::findOrCreate($permission);

    }
}
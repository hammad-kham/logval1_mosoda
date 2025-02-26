<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Module;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $application_status = 0;
        $approval_status = 1;

        ////////////////////////////////////
        //Admin
        {
			$user_type = 'admin';
            $role = 'admin';
            $password = "admin";
            $name = 'Manager Homely';
            $email = 'admin@gmail.com';
            $model = new User();
            $model->company_name = "Homely App";
            $model->name = $name;
            $model->email = $email;
            $model->password = bcrypt($password);
            $model->phone = "+97701010101";
            $model->application_status = $application_status;
            $model->approval_status = $approval_status;
            $model->save();

            $user_id = $model->id;

            // Assign role to user
            $user = User::find($user_id);
            $user->assignRole($role);
        }

        ////////////////////////////////////
        // Users For Services Module
        {
            $vend_id = 0;
            $role = "vendor";
            $phone = 97781010100;

            // Create new vendor User
			{
				$company_name = 'Prime';
				$phone++;
				$vend_id++;
	
				$this->create_vendor($vend_id, $company_name, $phone, $role);
			}


            ////////////////////////////////////////////////

            // Create new vendor User
			{
				$company_name = 'Global';
				$phone++;
				$vend_id++;
	
				$this->create_vendor($vend_id, $company_name, $phone, $role);
			}


            ////////////////////////////////////////////////

            // Create new vendor User
			{
				$company_name = 'Orange';
				$phone++;
				$vend_id++;
	
				$this->create_vendor($vend_id, $company_name, $phone, $role);
			}


            ////////////////////////////////////////////////

            // Create new vendor User
			{
				$company_name = 'Color';
				$phone++;
				$vend_id++;
	
				$this->create_vendor($vend_id, $company_name, $phone, $role);
			}


            ////////////////////////////////////////////////

            // Create new vendor User
			{
				$company_name = 'Metro';
				$phone++;
				$vend_id++;
	
				$this->create_vendor($vend_id, $company_name, $phone, $role);
			}
        }


       

    }
	
	private function create_vendor($vend_id, $company_name, $phone, $role)
	{
		$password = "vendor";
		$address = "Islamabad";
			
        $categories_array = array();
            $categories_array[1] = '1,2,3,5';
            $categories_array[2] = '1,2,3,4';
            $categories_array[3] = '4,5,7';
            $categories_array[4] = '5,6,8';
            $categories_array[5] = '7,8,9';
			
        $application_status = 0;
        $approval_status = 1;
		$created_by = 1;
		
		$name = "Manager $company_name";
		$email = strtolower("svc_".$company_name."@gmail.com");
		
		$company_name.= ' Services';
		
		$model = new User();
			$model->user_type = 'vendor';
			$model->vend_id = $vend_id;
			$model->company_name = $company_name;
			$model->name = $name;
			$model->email = $email;
			$model->password = bcrypt($password);
			$model->phone = "+" . $phone;
			$model->address = $address;
			$model->categories = $categories_array[$vend_id];
			$model->application_status = $application_status;
			$model->approval_status = $approval_status;
			$model->status = 1;
            $model->created_by = $created_by;
		$model->save();

		$user_id = $model->id;

		// Assign role to user
		$user = User::find($user_id);
		$user->assignRole($role);
	}
	

}
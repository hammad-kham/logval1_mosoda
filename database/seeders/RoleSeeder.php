<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Module;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create new User
        $model = new Role();
        $model->name = 'admin';
        $model->guard_name = 'web';
        $model->display_to = 0;
        $model->save();

        $role_id = $model->id;

        // Assign role to user
        $role = Role::find($role_id);


        // Assign permissions to user
        $Modules = Module::where('id', '>', 0)->get();
        foreach($Modules  as $Module)
        {
            $this->common($role, $Module);
        }

        ////////////////////////////////////

        // Create new User For Services Module
        $model = new Role();
        $model->name = 'vendor';
        $model->guard_name = 'web';
        $model->display_to = 1;
        $model->save();

        $role_id = $model->id;

        // Assign role to user
        $role = Role::find($role_id);


        // Assign permissions to user
        $array = array();
        $array[] = 'Vendors';
        $array[] = 'Vendor Bank Details';
        $array[] = 'Vendor Categories';
        $array[] = 'Vendor Sub Categories';
        $array[] = 'Vendor Services';
        $array[] = 'Vendor Products';//change from Products
        $array[] = 'Vendor Orders';//change from Orders
        $array[] = 'Vendor Reviews';//change from Reviews
        $array[] = 'Users';

        foreach($array  as $module_name)
        {
            $Modules = Module::where('module_name', '=', $module_name)->get();
            foreach($Modules  as $Module)
            {
                $this->common($role, $Module);
            }
        }



       

    }

    public function common($role, $Module)
    {

        $module_name = $Module->module_name;


        $action = "listing";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_list == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

        $action = "add";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_add == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

        $action = "edit";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_edit == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

        $action = "view";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_view == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

        $action = "status";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_status == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

        $action = "delete";
        $permission = $module_name.'-'.$action;
        $permission = createSlug($permission);
        if($Module->mod_delete == 1)
        {
            $exits = 0;

            if($role->hasPermissionTo($permission))
            {
                $exits = 1;
            }

            if($exits == 0)
            {
                $role->givePermissionTo($permission);
            }
        }
        elseif($role->hasPermissionTo($permission))
        {
            $role->revokePermissionTo($permission);
        }

    }

}
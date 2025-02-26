<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Auth;
use File;
use Flash;
use Response;
use Attribute;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

use App\Models\Module;

class ModuleController extends Controller
{
    private $views_path = "modules";

    private $dashboard_route = "dashboard";

    private $home_route = "modules.index";
    private $create_route = "modules.create";
    private $edit_route = "modules.edit";
    private $view_route = "modules.show";
    private $delete_route = "modules.destroy";

    private $msg_created = "Module added successfully.";
    private $msg_updated = "Module updated successfully.";
    private $msg_deleted = "Module deleted successfully.";
    private $msg_not_found = "Module not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Module name";

    private $list_permission = "modules-listing";
    private $add_permission = "modules-add";
    private $edit_permission = "modules-edit";
    private $view_permission = "modules-view";
    private $status_permission = "modules-status";
    private $delete_permission = "modules-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Modules. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Module. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Module. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Module details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Module. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Module. Please Contact Administrator.";
	
	
	/**
	* Display a listing of the Model.
	*
	* 
	* @return Response
	*/
    public function index()
    {      
		$Auth_User = Auth::user();		
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
            $records_exists = 0;
            $records = Module::select(['id'])->where('id', '>=', 1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists"));
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function datatable(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
            $Records = Module::select(['modules.id', 'modules.module_name']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('modules.module_name', 'like', "%{$request->get('title')}%");
                    }
                })
                ->addColumn('title', function ($Records)
                {
                    $record_id = $Records->id;
                    $title = $Records->module_name;

                    //$title = '<a href="' . route('modules.show', $record_id) . '" title="View Template Details">'.$title.'</a>';

                    return  $title;
                })
                ->addColumn('listing', function ($Records)
                {
                    $status = $Records->mod_list;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('add', function ($Records)
                {
                    $status = $Records->mod_add;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('edit', function ($Records)
                {
                    $status = $Records->mod_edit;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('view', function ($Records)
                {
                    $status = $Records->mod_view;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('status', function ($Records)
                {
                    $status = $Records->mod_status;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('delete', function ($Records)
                {
                    $status = $Records->mod_delete;

                    $str='';
                    if($status == 1)
                    {
                        $str='<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }
                    else
                    {
                        $str='<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
                    }

                    return $str;
                })
                ->addColumn('action', function ($Records)
                {
                    $record_id = $Records->id;

                    $str = "<div class='btn-group'>";

                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';

                    $str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';

                    /*{
                        $str.= ' <a href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
                                <i class="fa fa-trash"></i>
                                </a>';

                        {
                            $str.='<div id="m-'.$record_id.'" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog" id="animate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm delete following record</h5>
                                                </div>
                                                <div class="modal-body text-center p-lg">
                                                    <p>
                                                        Are you sure to delete this record?
                                                        <br>
                                                        <strong>[ '.$Records->module_name.' ]</strong>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                    <a href="'.route($this->delete_route, $record_id).'" class="btn btn-danger">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }*/

                    $str.= "</div>";
                    return $str;

                })
                ->rawColumns(['title','action'])
                ->setRowId(function($Records) {
                    return 'myDtRow' . $Records->id;
                })
                ->make(true);
            return $response;
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
    public function create()
    {   
		$Auth_User = Auth::user();    
		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{
            return view($this->views_path.'.create');
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
    public function store(Request $request)
    {	
		$Auth_User = Auth::user();      
		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{	
            $request->validate([
                'module_name' => 'required'
            ]);

            $name = ltrim(rtrim($request->module_name));
            if($name != '')
            {
                $bool=0;
                $Model_Results = Module::where('module_name', '=', $name)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = new Module();

                    $Model_Data->module_name = $name;

                    $permissions_allowed = array();
                    $permissions_not_allowed = array();

                    $mod_list = 0;
                    {
                        $permission_name = $name.'-listing';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_list) && $request->mod_list == 1)
                        {
                            $mod_list = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_list = $mod_list;

                    $mod_add = 0;
                    {
                        $permission_name = $name.'-add';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_add) && $request->mod_add == 1)
                        {
                            $mod_add = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_add = $mod_add;

                    $mod_edit = 0;
                    {
                        $permission_name = $name.'-edit';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_edit) && $request->mod_edit == 1)
                        {
                            $mod_edit = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_edit = $mod_edit;

                    $mod_view = 0;
                    {
                        $permission_name = $name.'-view';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_view) && $request->mod_view == 1)
                        {
                            $mod_view = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_view = $mod_view;

                    $mod_status = 0;
                    {
                        $permission_name = $name.'-status';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_status) && $request->mod_status == 1)
                        {
                            $mod_status = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_status = $mod_status;

                    $mod_delete = 0;
                    {
                        $permission_name = $name.'-delete';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_delete) && $request->mod_delete == 1)
                        {
                            $mod_delete = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_delete = $mod_delete;

                    $Model_Data->created_by = $Auth_User->id;
                    $Model_Data->save();

                    foreach($permissions_allowed as $permission)
                    {
                        $permission = Permission::findOrCreate($permission);
                    }

                    foreach($permissions_not_allowed as $permission)
                    {
                        $permissions = Permission::where('name', '=', $permission)->get();
                        foreach($permissions as $permission)
                        {
                            //
                        }
                    }

                    Flash::success($this->msg_created);
                    return redirect()->route($this->home_route);
                }
                else
                {
                    Flash::error($this->msg_exists);
                    return redirect()->route($this->create_route);
                }
            }
            else
            {
                Flash::error($this->msg_required);
                return redirect()->route($this->create_route);
            }
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Display the specified resource.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function show($id)
    {  
		$Auth_User = Auth::user();    
		if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
		{
            $Model_Data = Module::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            return view($this->views_path.'.show')->with('Model_Data', $Model_Data);
        }
        else
        {
            Flash::error($this->view_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function edit($id)
    {   
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		{ 
            $Model_Data= Module::find($id);

            if (empty( $Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            return view($this->views_path.'.edit')->with('Model_Data', $Model_Data);
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Update the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
    public function update($id, Request $request)
    {   
		$Auth_User = Auth::user();   
		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		{
            $Model_Data = Module::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
			 
            $request->validate([
                'module_name' => 'required'
            ]);

            $name = ltrim(rtrim($request->module_name));
            if($name != '')
            {
                $bool=0;
                $Model_Results = Module::where('module_name', '=', $name)->where('id', '!=', $id)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = Module::find($id);

                    $Model_Data->module_name = $name;

                    $permissions_allowed = array();
                    $permissions_not_allowed = array();

                    $mod_list = 0;
                    {
                        $permission_name = $name.'-listing';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_list) && $request->mod_list == 1)
                        {
                            $mod_list = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_list = $mod_list;

                    $mod_add = 0;
                    {
                        $permission_name = $name.'-add';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_add) && $request->mod_add == 1)
                        {
                            $mod_add = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_add = $mod_add;

                    $mod_edit = 0;
                    {
                        $permission_name = $name.'-edit';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_edit) && $request->mod_edit == 1)
                        {
                            $mod_edit = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_edit = $mod_edit;

                    $mod_view = 0;
                    {
                        $permission_name = $name.'-view';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_view) && $request->mod_view == 1)
                        {
                            $mod_view = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_view = $mod_view;

                    $mod_status = 0;
                    {
                        $permission_name = $name.'-status';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_status) && $request->mod_status == 1)
                        {
                            $mod_status = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_status = $mod_status;

                    $mod_delete = 0;
                    {
                        $permission_name = $name.'-delete';
                        $permission_name = createSlug($permission_name);
                        if (isset($request->mod_delete) && $request->mod_delete == 1)
                        {
                            $mod_delete = 1;
                            $permissions_allowed[] = $permission_name;
                        }
                        else
                        {
                            $permissions_not_allowed[] = $permission_name;
                        }
                    }
                    $Model_Data->mod_delete = $mod_delete;

                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();

                    foreach($permissions_allowed as $permission)
                    {
                        $permission = Permission::findOrCreate($permission);
                    }

                    foreach($permissions_not_allowed as $permission)
                    {
                        $permissions = Permission::where('name', '=', $permission)->get();
                        foreach($permissions as $permission)
                        {
                            //
                        }
                    }

                    Flash::success($this->msg_updated);
                    return redirect(route($this->home_route));
                }
                else
                {
                    Flash::error($this->msg_exists);
                    return redirect()->route($this->edit_route, $id);
                }
            }
            else
            {
                Flash::error($this->msg_required);
                return redirect()->route($this->edit_route, $id);
            }
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* update status of the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function makeActive($id)
    {  
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		{
            $Model_Data = Module::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Banner made Active successfully.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* update status of the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function makeInActive($id)
    {  
		$Auth_User = Auth::user();     
		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		{
            $Model_Data = Module::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Banner made InActive successfully.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function destroy($id)
    {  
        return redirect(route($this->home_route));

        /*$Auth_User = Auth::user();
        if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
        {
            $Model_Data = Module::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->delete();

            Flash::success($this->msg_deleted);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->delete_permission_error_message);
            return redirect()->route($this->home_route);
        }*/
    }
}
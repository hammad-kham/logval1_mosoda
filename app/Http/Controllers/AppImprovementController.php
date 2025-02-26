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

use App\Models\AppImprovement;

class AppImprovementController extends Controller
{
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/app_improvements";

    private $views_path = "app_improvements";

    private $dashboard_route = "dashboard";

    private $home_route = "app-improvements.index";
    private $create_route = "app-improvements.create";
    private $edit_route = "app-improvements.edit";
    private $view_route = "app-improvements.show";
    private $delete_route = "app-improvements.destroy";

    private $msg_created = "App Improvement added successfully.";
    private $msg_updated = "App Improvement updated successfully.";
    private $msg_deleted = "App Improvement deleted successfully.";
    private $msg_not_found = "App Improvement not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same email";

    private $list_permission = "app-improvements-listing";
    private $add_permission = "app-improvements-add";
    private $edit_permission = "app-improvements-edit";
    private $view_permission = "app-improvements-view";
    private $status_permission = "app-improvements-status";
    private $delete_permission = "app-improvements-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of App Improvements. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add App Improvement. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update App Improvement. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View App Improvement details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of App Improvement. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete App Improvement. Please Contact Administrator.";
	
	
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
            $records = AppImprovement::select(['id'])->where('id', '>=', 1)->get();
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
            $Records = AppImprovement::leftjoin('app_users', 'app_improvements.user_id', '=', 'app_users.id')
                ->select(['app_improvements.id', 'app_improvements.status', 'app_users.name as user_name']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('user') && !empty($request->user))
                    {
                        $query->where('app_users.name', 'like', "%{$request->get('user')}%");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('app_improvements.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    $status = $Records->status;
                    $Auth_User = Auth::user();

                    $str = '';
                    if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
                    {
                        if($status == 1)
                        {
                            $str = '<a href="'.route('app_improvements_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make App Improvements Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('app_improvements_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make App Improvements Active">
					<span class="fa fa-power-off"></span> InActive
					</a>';
                        }
                    }
                    else
                    {
                        if($status == 1)
                        {
                            $str = '<a class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Active
                                    </a>';
                        }
                        else
                        {
                            $str = '<a class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Inactive
                                    </a>';
                        }
                    }

                    return  $str;
                })
                ->addColumn('action', function ($Records) {
                    $record_id = $Records->id;
                    $Auth_User = Auth::user();

                    $str = "<div class='btn-group'>";

                    if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
                            <i class="fa fa-eye"></i>
                            </a>';
                    }

                    $str.= "</div>";
                    return $str;

                })
                ->rawColumns(['status', 'action'])
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
            $Model_Data = AppImprovement::find($id);

            $User_id = $Model_Data->user_id;

            $User_Data = AppUser::find($User_id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            return view($this->views_path.'.show', compact("Model_Data", "User_Data"));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
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
            $Model_Data = AppImprovement::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App Improvement made Active successfully.');
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
            $Model_Data = AppImprovement::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App Improvement made InActive successfully.');
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
            $Model_Data = AppImprovement::find($id);

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

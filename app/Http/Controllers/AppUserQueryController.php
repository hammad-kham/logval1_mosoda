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

use App\Models\SvcVendor;

use App\Models\AppUser;
use App\Models\AppUserQuery;

class AppUserQueryController extends Controller
{
    private $views_path = "app_user_queries";

    private $dashboard_route = "dashboard";

    private $home_route = "app-user-queries.index";
    private $create_route = "app-user-queries.create";
    private $edit_route = "app-user-queries.edit";
    private $view_route = "app-user-queries.show";
    private $delete_route = "app-user-queries.destroy";

    private $msg_created = "Query added successfully.";
    private $msg_updated = "Query updated successfully.";
    private $msg_deleted = "Query deleted successfully.";
    private $msg_not_found = "Query not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same email";

    private $list_permission = "app-user-queries-listing";
    private $add_permission = "app-user-queries-add";
    private $edit_permission = "app-user-queries-edit";
    private $view_permission = "app-user-queries-view";
    private $status_permission = "app-user-queries-status";
    private $delete_permission = "app-user-queries-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Queries. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Query. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Query. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Query details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Query. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Query. Please Contact Administrator.";
	
	
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
            $records = AppUserQuery::select(['id'])->where('id', '>=', 1)->limit(1)->get();
            if($records->count() > 0)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists", "records"));
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
            $Records = AppUserQuery::select(['app_user_queries.*']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {

                    if ($request->has('name') && !empty($request->name))
                    {
                        $query->where('app_user_queries.name', 'like', "%{$request->get('name')}%");
                    }
                    if ($request->has('subject') && !empty($request->subject))
                    {
                        $query->where('app_user_queries.subject', 'like', "%{$request->get('subject')}%");
                    }

                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('app_user_queries.status', '=', "{$request->get('status')}");
                    }

                })

                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    $record_status = $Records->status;
                    if($record_status == 0){
                        $status = "Not Replied";

                        $str = '<a class="btn btn-danger btn-sm">
								Pending
								</a>';
                    }
                    else{
                        $str = '<a class="btn btn-success btn-sm">
								Replied
								</a>';
                    }

                    return  $str;
                })

                ->addColumn('action', function ($Records) {
                    $record_id = $Records->id;
                    $Auth_User = Auth::user();

                    $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                    if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
								<i class="fa fa-eye"></i>
								</a>';
                    }

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

    public function is_not_authorized($id, $Auth_User)
    {
        $bool = 1;
        if($Auth_User->user_type == 'admin')
        {
            $bool = 0;
        }
        else
        {
            $vend_id = $Auth_User->vend_id;
            $records = AppUserQuery::select(['id'])->where('id', '=', $vend_id)->limit(1)->get();
            foreach($records as $record)
            {
                $bool = 0;
            }
        }

        return $bool;
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
            $Model_Data = AppUserQuery::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');

            return view($this->views_path.'.show', compact("Model_Data", "vendors_array"));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
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
    public function update(Request $request, $id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
        	$vend_id = get_auth_vend_id($request, $Auth_User);
			
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data = AppUserQuery::find($id);

            $subject = 'Reply: '.$Model_Data->title;

            $message = "Query: ".$Model_Data->description;
            $message.= "<br><br>";
            $message.= "Reply: ".$request->reply;


            $Model_Data->reply = $request->reply;
            $Model_Data->status = 1;
            $Model_Data->replied_by = $Auth_User->id;
            $Model_Data->replied_at = now();

            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            if(!empty($User_Data->email) && $User_Data->email!='' && $User_Data->email!=null)
            {
                custom_mail($User_Data->email, $subject, $message);
            }


            Flash::success($this->msg_updated);
            return redirect(route($this->home_route,$vend_id));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
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
            $Model_Data = AppUserQuery::find($id);

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

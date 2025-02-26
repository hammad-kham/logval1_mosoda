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

use App\Models\AppLabel;

class AppLabelController extends Controller
{
    private $views_path = "app_labels";

    private $dashboard_route = "dashboard";

    private $home_route = "app-labels.index";
    private $create_route = "app-labels.create";
    private $edit_route = "app-labels.edit";
    private $view_route = "app-labels.show";
    private $delete_route = "app-labels.destroy";

    private $msg_created = "App Label added successfully.";
    private $msg_updated = "App Label updated successfully.";
    private $msg_deleted = "App Label deleted successfully.";
    private $msg_not_found = "App Label not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same App Label";

    private $list_permission = "app-labels-listing";
    private $add_permission = "app-labels-add";
    private $edit_permission = "app-labels-edit";
    private $view_permission = "app-labels-view";
    private $status_permission = "app-labels-status";
    private $delete_permission = "app-labels-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of App Labels. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add App Label. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update App Label. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View App Label details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of App Label. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete App Label. Please Contact Administrator.";
	
	
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
            $records = AppLabel::select(['id'])->where('id', '>=', 1)->get();
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
            $Records = AppLabel::select(['app_labels.id', 'app_labels.title', 'app_labels.ar_title', 'app_labels.status']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('app_labels.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('ar_title') && !empty($request->ar_title))
                    {
                        $query->where('app_labels.ar_title', 'like', "%{$request->get('ar_title')}%");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('app_labels.status', '=', "{$request->get('status')}");
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
                            $str = '<a href="'.route('app_labels_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('app_labels_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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

                    $str = "<div class='btn-group'>";

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
                                                        <strong>[ '.$Records->title.' ]</strong>
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
                ->rawColumns(['status','action'])
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
                'title' => 'required',
                'ar_title' => 'required'
            ]);

            $name = ltrim(rtrim($request->title));
            if($name != '')
            {
                $bool=0;
                $Model_Results = AppLabel::where('title', '=', $name)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = new AppLabel();

                    $Model_Data->title = $name;
                    $Model_Data->ar_title = ltrim(rtrim($request->ar_title));

                    $Model_Data->created_by = $Auth_User->id;
                    $Model_Data->save();

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
            $Model_Data = AppLabel::find($id);

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
            $Model_Data= AppLabel::find($id);

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
            $request->validate([
                'title' => 'required',
                'ar_title' => 'required'
            ]);

            $Model_Data = AppLabel::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $name = ltrim(rtrim($request->title));
            if($name != '')
            {
                $bool=0;
                $Model_Results = AppLabel::where('title', '=', $name)->where('id', '!=', $id)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = AppLabel::find($id);

                    $Model_Data->title = $name;
                    $Model_Data->ar_title = ltrim(rtrim($request->ar_title));

                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();

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
            $Model_Data = AppLabel::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App Label made Active successfully.');
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
            $Model_Data = AppLabel::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('App Label made InActive successfully.');
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
            $Model_Data = AppLabel::find($id);

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
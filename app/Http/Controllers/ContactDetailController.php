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

use App\Models\ContactDetail;

class ContactDetailController extends Controller
{
    private $views_path = "contact_details";

    private $dashboard_route = "dashboard";

    private $home_route = "contact-details.index";
    private $create_route = "contact-details.create";
    private $edit_route = "contact-details.edit";
    private $view_route = "contact-details.show";
    private $delete_route = "contact-details.destroy";

    private $msg_created = "Contact Detail added successfully.";
    private $msg_updated = "Contact Detail updated successfully.";
    private $msg_deleted = "Contact Detail deleted successfully.";
    private $msg_not_found = "Contact Detail not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Contact name";

    private $list_permission = "contact-details-listing";
    private $add_permission = "contact-details-add";
    private $edit_permission = "contact-details-edit";
    private $view_permission = "contact-details-view";
    private $status_permission = "contact-details-status";
    private $delete_permission = "contact-details-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Contact Details. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Contact Detail. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Contact Detail. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Contact Detail details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Contact Detail. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Contact Detail. Please Contact Administrator.";
	
	
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
            $records = ContactDetail::select(['id'])->where('id', '>=', 1)->get();
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
            $Records = ContactDetail::select(['contact_details.id', 'contact_details.title', 'contact_details.value', 'contact_details.status']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('contact_details.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('s_value') && !empty($request->s_value))
                    {
                        $query->where('contact_details.value', 'like', "%{$request->get('s_value')}%");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('contact_details.status', '=', "{$request->get('status')}");
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
                            $str = '<a href="'.route('contact_details_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('contact_details_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
                'value' => 'required'
            ]);

            $name = ltrim(rtrim($request->title));
            if($name != '')
            {
                $bool=0;
                $Model_Results = ContactDetail::where('title', '=', $name)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = new ContactDetail();

                    $Model_Data->title = $name;
                    $Model_Data->value = ltrim(rtrim($request->value));

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
            $Model_Data = ContactDetail::find($id);

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
            $Model_Data= ContactDetail::find($id);

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
            $Model_Data = ContactDetail::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
			
            $request->validate([
                'title' => 'required',
                'value' => 'required'
            ]);

            $name = ltrim(rtrim($request->title));
            if($name != '')
            {
                $bool=0;
                $Model_Results = ContactDetail::where('title', '=', $name)->where('id', '!=', $id)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = ContactDetail::find($id);

                    $Model_Data->title = $name;
                    $Model_Data->value = ltrim(rtrim($request->value));

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
            $Model_Data = ContactDetail::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Contact Detail made Active successfully.');
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
            $Model_Data = ContactDetail::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Contact Detail made InActive successfully.');
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
            $Model_Data = ContactDetail::find($id);

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
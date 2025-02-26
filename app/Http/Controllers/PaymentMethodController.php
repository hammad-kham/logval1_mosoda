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
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/payment_methods";

    private $views_path = "payment_methods";

    private $dashboard_route = "dashboard";

    private $home_route = "payment-methods.index";
    private $create_route = "payment-methods.create";
    private $edit_route = "payment-methods.edit";
    private $view_route = "payment-methods.show";
    private $delete_route = "payment-methods.destroy";

    private $msg_created = "Payment method added successfully.";
    private $msg_updated = "Payment method updated successfully.";
    private $msg_deleted = "Payment method deleted successfully.";
    private $msg_not_found = "Payment method not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same method name";

    private $list_permission = "payment-methods-listing";
    private $add_permission = "payment-methods-add";
    private $edit_permission = "payment-methods-edit";
    private $view_permission = "payment-methods-view";
    private $status_permission = "payment-methods-status";
    private $delete_permission = "payment-methods-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Payment methods. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Payment method. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Payment method. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Payment method details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Payment method. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Payment method. Please Contact Administrator.";
	
	
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
            $records = PaymentMethod::select(['id'])->where('id', '>=', 1)->get();
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
            $Records = PaymentMethod::select(['payment_methods.id', 'payment_methods.name as title', 'payment_methods.status']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('payment_methods.name', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('payment_methods.status', '=', "{$request->get('status')}");
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
                            $str = '<a href="'.route('payment_methods_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('payment_methods_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
	
	private function create_uploads_directory()
	{
		$uploads_path = $this->uploads_path;
		if(!is_dir($uploads_path))
		{
			mkdir($uploads_path);
			$uploads_root = $this->uploads_root;
			$src_file = $uploads_root."/index.html";
			$dest_file = $uploads_path."/index.html";
			copy($src_file,$dest_file);
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
                'name' => 'required',
                'file_upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048'
            ]);

            $name = ltrim(rtrim($request->name));
            if($name != '')
            {
                $bool=0;
                $Model_Results = PaymentMethod::where('name', '=', $name)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = new PaymentMethod();

                    $Model_Data->name = $name;

                    $image = '';
                    if (isset($request->file_upload) && $request->file_upload != null)
                    {
                        $file_uploaded = $request->file('file_upload');
                        $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

						$this->create_uploads_directory();
						
						$uploads_path = $this->uploads_path;
						$file_uploaded->move($uploads_path, $image);
                    }
                    $Model_Data->image = $image;

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
            $Model_Data = PaymentMethod::find($id);

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
            $Model_Data= PaymentMethod::find($id);

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
            $Model_Data = PaymentMethod::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }	
			
            $request->validate([
                'name' => 'required',
                'file_upload' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048'
            ]);

            $name = ltrim(rtrim($request->name));
            if($name != '')
            {
                $bool=0;
                $Model_Results = PaymentMethod::where('name', '=', $name)->where('id', '!=', $id)->get();
                foreach($Model_Results as $Model_Result)
                {
                    $bool=1;
                }
                if($bool==0)
                {
                    $Model_Data = PaymentMethod::find($id);

                    $Model_Data->name = $name;

                    $image = $Model_Data->image;
                    if($request->hasfile('file_upload') && $request->file_upload != null)
                    {
                        $file_uploaded = $request->file('file_upload');
                        $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

						$this->create_uploads_directory();
						
						$uploads_path = $this->uploads_path;
						$file_uploaded->move($uploads_path, $image);

                        if ($Model_Data->image != "") {
                            File::delete($uploads_path."/".$Model_Data->image);
                        }
                    }
                    $Model_Data->image = ltrim(rtrim($image));

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
            $Model_Data = PaymentMethod::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Payment Method made Active successfully.');
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
            $Model_Data = PaymentMethod::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Payment Method made InActive successfully.');
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
            $Model_Data = PaymentMethod::find($id);

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

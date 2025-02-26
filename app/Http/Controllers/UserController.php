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

use App\Models\EcomCategory;
use App\Models\EcomSeller;
use App\Models\EcomSellerCategory;
use App\Models\Forwarder;
use App\Models\ModelHasRoles;
use App\Models\Module;
use App\Models\SvcAttribute;
use App\Models\SvcAttributeOption;
use App\Models\SvcCategory;
use App\Models\SvcVendor;
use App\Models\SvcVendorCategory;
use App\Models\SvcVendorTiming;

class UserController extends Controller
{
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/users/";

    private $views_path = "users";

    private $dashboard_route = "dashboard";

    private $home_route = "users.index";
    private $create_route = "users.create";
    private $edit_route = "users.edit";
    private $view_route = "users.show";
    private $delete_route = "users.destroy";
    private $view_application_route = "users_show_application";

    private $msg_created = "User added successfully.";
    private $msg_updated = "User updated successfully.";
    private $msg_deleted = "User deleted successfully.";
    private $msg_not_found = "User not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same User name";
    private $permissions_updated = "User Permissions updated successfully.";

    private $list_permission = "users-listing";
    private $add_permission = "users-add";
    private $edit_permission = "users-edit";
    private $view_permission = "users-view";
    private $status_permission = "users-status";
    private $delete_permission = "users-delete";

    private $msg_approved = "Application Approved successfully.";
    private $msg_rejected = "Application Rejected successfully.";
	
	
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
            $roles_array = Role::select(['id','name'])->where('id', '>=', 1)->orderby('name', 'asc')->get();

            $vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->orderby('name', 'asc')->get();

            $records_exists = 0;
            $records = User::select(['id'])->where('id', '>=', 1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists","roles_array","vendors_array"));
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
			$user_type = $Auth_User->user_type;

            if($user_type == 'admin')
            {
                return  $this->admin_datatable($request);
            }
            elseif($user_type == 'vendor')
            {
                return  $this->vendor_datatable($request);
            }
            elseif($user_type == 'seller')
            {
                return  $this->seller_datatable($request);
            }
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function admin_datatable(Request $request)
    {		
		$Records = User::select(['users.id', 'users.user_type', 'users.vend_id', 'users.name', 'users.email', 'users.phone', 'users.status', 'users.application_status', 'users.approval_status']);

		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) 
			{

				if ($request->has('company_name') && $request->get('company_name') != -1)
				{
					$query->where('users.vend_id', '=', "{$request->get('company_name')}");
				}

				if ($request->has('name') && !empty($request->name))
				{
					$query->where('users.name', 'like', "%{$request->get('name')}%");
				}

				if ($request->has('email') && !empty($request->email))
				{
					$query->where('users.email', 'like', "%{$request->get('email')}%");
				}

				if ($request->has('phone') && !empty($request->phone))
				{
					$query->where('users.phone', 'like', "%{$request->get('phone')}%");
				}

				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('users.status', '=', "{$request->get('status')}");
				}

				if ($request->has('application_status') && $request->get('application_status') != -1)
				{
					$query->where('users.application_status', '=', "{$request->get('application_status')}");
				}

				if ($request->has('approval_status') && $request->get('approval_status') != -1)
				{
					$query->where('users.approval_status', '=', "{$request->get('approval_status')}");
				}

			})
			/*>addColumn('company_name', function ($Records) 
			{
				$Auth_User = Auth::user();

				$record_id = $Records->id;
				$title = $Records->company_name;
				if($title == "" || empty($title))
				{
					if($Records->vend_id == 0)
					{
						$vendor_object = User::select('company_name')->where('id', '=', '1')->first();
						$title = $vendor_object->company_name;
					}
					else
					{
						$vendor_object = SvcVendor::select('name')->where('id', '=', $Records->vend_id)->first();
						$title = $vendor_object->name;

					}
				}
				return  $title;
			})*/
			->addColumn('name', function ($Records) 
			{
				$record_id = $Records->id;
				$title = $Records->name;
				$str = "";

				$company_name = '';
				$user_type = $Records->user_type;
				$vend_id = $Records->vend_id;
				if($user_type == 'admin')
				{
					$company_name = 'Homely App';
				}
				else
				{
					if($user_type == 'vendor')
					{
						$record = SvcVendor::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
					elseif($user_type == 'seller')
					{
						$record = EcomSeller::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
				}

				$str = $title."<br>".$company_name;
				//$role = ucfirst($Records->role);
				//$str = $name.'<br><small>'.$role.'</small>';

				return $str;
			})
			->addColumn('status', function ($Records) 
			{
				$record_id = $Records->id;
				$status = $Records->status;
				$approval_status = $Records->approval_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->id != $record_id && $record_id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
				{
					if($record_id == 1)
					{
						$str = '<a class="btn btn-success btn-sm" >
									<span class="fa fa-power-off "></span> Active
								</a>';
					}
					else
					{
						if($approval_status == '2' || $approval_status == '0')
						{
							$str = '<a  class="btn btn-danger btn-sm" title="User Inactive"  style="pointer-events: none; cursor: default;">
						<span class="fa fa-power-off"></span> Inactive
						</a>';
						}
						else
						{
							if($status == 1)
							{
								$str = '<a href="'.route('users-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make User Inactive">
				<span class="fa fa-power-off "></span> Active
				</a>';
							}
							else
							{
								$str = '<a href="'.route('users-active',$record_id).'" class="btn btn-danger btn-sm" title="Make User Active">
				<span class="fa fa-power-off"></span> InActive
				</a>';
							}
						}
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

			->addColumn('application_status', function ($Records) 
			{
				$str = '-';
				if($Records->application_status == 1)
				{
					$record_id = $Records->id;
					$Auth_User = Auth::user();
					
					$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
					if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
					{
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_application_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
					}
				}
				return $str;
			})

			->addColumn('approval_status', function ($Records) 
			{
				$str = 'Pending';
				if($Records->approval_status == 1)
				{
					$str = 'Approved';
				}
				elseif($Records->approval_status == 2)
				{
					$str = 'Rejected';
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
													<strong>[ '.$Records->name.' ]</strong>
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
			
			->rawColumns(['name','status','application_status','action'])
			
			->setRowId(function($Records) 
			{
				return 'myDtRow' . $Records->id;
			})
			
			->make(true);
			
		return $response;
    }

    public function vendor_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $user_type = $Auth_User->user_type;
        $vend_id = $Auth_User->vend_id;
		
		$Records = User::select(['users.id', 'users.user_type', 'users.vend_id', 'users.name', 'users.email', 'users.phone', 'users.status', 'users.application_status', 'users.approval_status'])
				->where('user_type', '=', $user_type)
				->where('vend_id', '=', $vend_id);

		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) 
			{
				if ($request->has('company_name') && $request->get('company_name') != -1)
				{
					$query->where('users.vend_id', '=', "{$request->get('company_name')}");
				}

				if ($request->has('name') && !empty($request->name))
				{
					$query->where('users.name', 'like', "%{$request->get('name')}%");
				}

				if ($request->has('email') && !empty($request->email))
				{
					$query->where('users.email', 'like', "%{$request->get('email')}%");
				}

				if ($request->has('phone') && !empty($request->phone))
				{
					$query->where('users.phone', 'like', "%{$request->get('phone')}%");
				}

				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('users.status', '=', "{$request->get('status')}");
				}

			})
			->addColumn('name', function ($Records) 
			{
				$record_id = $Records->id;
				$title = $Records->name;
				$str = "";

				/*$company_name = '';
				$user_type = $Records->user_type;
				$vend_id = $Records->vend_id;
				if($user_type == 'admin')
				{
					$company_name = 'Homely App';
				}
				else
				{
					if($user_type == 'vendor')
					{
						$record = SvcVendor::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
					elseif($user_type == 'seller')
					{
						$record = EcomSeller::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
				}

				$str = $title."<br>".$company_name;*/
				
				$str = ucwords($title);

				return $str;
			})
			
			->addColumn('status', function ($Records) 
			{
				$record_id = $Records->id;
				$status = $Records->status;
				$approval_status = $Records->approval_status;
				$Auth_User = Auth::user();
				$str = '';
				if($Auth_User->id != $record_id && $record_id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
				{
					if($record_id == 1)
					{
						$str = '<a class="btn btn-success btn-sm" >
									<span class="fa fa-power-off "></span> Active
								</a>';
					}
					else
					{
						if($approval_status == '2' || $approval_status == '0')
						{
							$str = '<a  class="btn btn-danger btn-sm" title="User Inactive"  style="pointer-events: none; cursor: default;">
						<span class="fa fa-power-off"></span> Inactive
						</a>';
						}
						else
						{
							if($status == 1)
							{
								$str = '<a href="'.route('users-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make User Inactive">
				<span class="fa fa-power-off "></span> Active
				</a>';
							}
							else
							{
								$str = '<a href="'.route('users-active',$record_id).'" class="btn btn-danger btn-sm" title="Make User Active">
				<span class="fa fa-power-off"></span> InActive
				</a>';
							}
						}
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
													<strong>[ '.$Records->name.' ]</strong>
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
			
			->rawColumns(['name','status','action'])
			
			->setRowId(function($Records) 
			{
				return 'myDtRow' . $Records->id;
			})
			
			->make(true);
			
		return $response;
    }

    public function seller_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        $user_type = $Auth_User->user_type;
        $vend_id = $Auth_User->vend_id;
		
		$Records = User::select(['users.id', 'users.user_type', 'users.vend_id', 'users.name', 'users.email', 'users.phone', 'users.status', 'users.application_status', 'users.approval_status'])
				->where('user_type', '=', $user_type)
				->where('vend_id', '=', $vend_id);

		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) 
			{
				if ($request->has('company_name') && $request->get('company_name') != -1)
				{
					$query->where('users.vend_id', '=', "{$request->get('company_name')}");
				}

				if ($request->has('name') && !empty($request->name))
				{
					$query->where('users.name', 'like', "%{$request->get('name')}%");
				}

				if ($request->has('email') && !empty($request->email))
				{
					$query->where('users.email', 'like', "%{$request->get('email')}%");
				}

				if ($request->has('phone') && !empty($request->phone))
				{
					$query->where('users.phone', 'like', "%{$request->get('phone')}%");
				}

				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('users.status', '=', "{$request->get('status')}");
				}

			})
			->addColumn('name', function ($Records) 
			{
				$record_id = $Records->id;
				$title = $Records->name;
				$str = "";

				/*$company_name = '';
				$user_type = $Records->user_type;
				$vend_id = $Records->vend_id;
				if($user_type == 'admin')
				{
					$company_name = 'Homely App';
				}
				else
				{
					if($user_type == 'vendor')
					{
						$record = SvcVendor::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
					elseif($user_type == 'seller')
					{
						$record = EcomSeller::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
				}

				$str = $title."<br>".$company_name;*/
				
				$str = ucwords($title);

				return $str;
			})
			
			->addColumn('status', function ($Records) 
			{
				$record_id = $Records->id;
				$status = $Records->status;
				$approval_status = $Records->approval_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->id != $record_id && $record_id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
				{
					if($record_id == 1)
					{
						$str = '<a class="btn btn-success btn-sm" >
									<span class="fa fa-power-off "></span> Active
								</a>';
					}
					else
					{
						if($approval_status == '2' || $approval_status == '0')
						{
							$str = '<a  class="btn btn-danger btn-sm" title="User Inactive"  style="pointer-events: none; cursor: default;">
						<span class="fa fa-power-off"></span> Inactive
						</a>';
						}
						else
						{
							if($status == 1)
							{
								$str = '<a href="'.route('users-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make User Inactive">
				<span class="fa fa-power-off "></span> Active
				</a>';
							}
							else
							{
								$str = '<a href="'.route('users-active',$record_id).'" class="btn btn-danger btn-sm" title="Make User Active">
				<span class="fa fa-power-off"></span> InActive
				</a>';
							}
						}
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
													<strong>[ '.$Records->name.' ]</strong>
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
			
			->rawColumns(['name','status','action'])
			
			->setRowId(function($Records) 
			{
				return 'myDtRow' . $Records->id;
			})
			
			->make(true);
			
		return $response;
    }
	

    public function dashboard_datatable(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
        {
			$user_type = $Auth_User->user_type;

            if($user_type == 'admin')
            {
                return  $this->admin_dashboard_datatable($request);
            }
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->dashboard_route);
        }
    }

    public function admin_dashboard_datatable(Request $request)
    {		
		$Records = User::select(['users.id', 'users.user_type', 'users.vend_id', 'users.name', 'users.email', 'users.phone', 'users.status', 'users.application_status', 'users.approval_status'])
		->where('users.approval_status',0);

		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) 
			{

				if ($request->has('company_name') && $request->get('company_name') != -1)
				{
					$query->where('users.vend_id', '=', "{$request->get('company_name')}");
				}

				if ($request->has('name') && !empty($request->name))
				{
					$query->where('users.name', 'like', "%{$request->get('name')}%");
				}

				if ($request->has('email') && !empty($request->email))
				{
					$query->where('users.email', 'like', "%{$request->get('email')}%");
				}

				if ($request->has('phone') && !empty($request->phone))
				{
					$query->where('users.phone', 'like', "%{$request->get('phone')}%");
				}

				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('users.status', '=', "{$request->get('status')}");
				}

				if ($request->has('application_status') && $request->get('application_status') != -1)
				{
					$query->where('users.application_status', '=', "{$request->get('application_status')}");
				}

				if ($request->has('approval_status') && $request->get('approval_status') != -1)
				{
					$query->where('users.approval_status', '=', "{$request->get('approval_status')}");
				}

			})
			/*>addColumn('company_name', function ($Records) 
			{
				$Auth_User = Auth::user();

				$record_id = $Records->id;
				$title = $Records->company_name;
				if($title == "" || empty($title))
				{
					if($Records->vend_id == 0)
					{
						$vendor_object = User::select('company_name')->where('id', '=', '1')->first();
						$title = $vendor_object->company_name;
					}
					else
					{
						$vendor_object = SvcVendor::select('name')->where('id', '=', $Records->vend_id)->first();
						$title = $vendor_object->name;

					}
				}
				return  $title;
			})*/
			->addColumn('name', function ($Records) 
			{
				$record_id = $Records->id;
				$title = $Records->name;
				$str = "";

				$company_name = '';
				$user_type = $Records->user_type;
				$vend_id = $Records->vend_id;
				if($user_type == 'admin')
				{
					$company_name = 'Homely App';
				}
				else
				{
					if($user_type == 'vendor')
					{
						$record = SvcVendor::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
					elseif($user_type == 'seller')
					{
						$record = EcomSeller::select('name')->where('id',$vend_id)->first();
						$company_name = $record->name;
					}
				}

				$str = $title."<br>".$company_name;
				//$role = ucfirst($Records->role);
				//$str = $name.'<br><small>'.$role.'</small>';

				return $str;
			})
			->addColumn('status', function ($Records) 
			{
				$record_id = $Records->id;
				$status = $Records->status;
				$approval_status = $Records->approval_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->id != $record_id && $record_id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
				{
					if($record_id == 1)
					{
						$str = '<a class="btn btn-success btn-sm" >
									<span class="fa fa-power-off "></span> Active
								</a>';
					}
					else
					{
						if($approval_status == '2' || $approval_status == '0')
						{
							$str = '<a  class="btn btn-danger btn-sm" title="User Inactive"  style="pointer-events: none; cursor: default;">
						<span class="fa fa-power-off"></span> Inactive
						</a>';
						}
						else
						{
							if($status == 1)
							{
								$str = '<a href="'.route('users-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make User Inactive">
				<span class="fa fa-power-off "></span> Active
				</a>';
							}
							else
							{
								$str = '<a href="'.route('users-active',$record_id).'" class="btn btn-danger btn-sm" title="Make User Active">
				<span class="fa fa-power-off"></span> InActive
				</a>';
							}
						}
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

			->addColumn('application_status', function ($Records) 
			{
				$str = '-';
				if($Records->application_status == 1)
				{
					$record_id = $Records->id;
					$Auth_User = Auth::user();
					
					$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
					if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
					{
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_application_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
					}
				}
				return $str;
			})

			->addColumn('approval_status', function ($Records) 
			{
				$str = 'Pending';
				if($Records->approval_status == 1)
				{
					$str = 'Approved';
				}
				elseif($Records->approval_status == 2)
				{
					$str = 'Rejected';
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
													<strong>[ '.$Records->name.' ]</strong>
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
			
			->rawColumns(['name','status','application_status','action'])
			
			->setRowId(function($Records) 
			{
				return 'myDtRow' . $Records->id;
			})
			
			->make(true);
			
		return $response;
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
			$user_type = $Auth_User->user_type;
			
			$roles_array = array();
            $vendors_array = array();
            $sellers_array = array();
			
			if($user_type == 'admin')
			{
				
				$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
	
				$sellers_array = EcomSeller::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
				
				$roles_array = Role::select(['id','name','display_to'])->where('id', '>=', 1)->orderby('name', 'asc')->get();
				
			}
			elseif($user_type == 'vendor')
			{
				
				$roles_array = Role::select(['id','name','display_to'])->where('id', '>=', 1)->where('display_to', '=', 1)->orderby('name', 'asc')->get();
				
			}
			elseif($user_type == 'seller')
			{
				
				$roles_array = Role::select(['id','name','display_to'])->where('id', '>=', 1)->where('display_to', '=', 2)->orderby('name', 'asc')->get();
				
			}

            return view($this->views_path.'.create' , compact("roles_array","vendors_array","sellers_array"));
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

            $Model_Data = new User();

            $user_id = $Auth_User->id;
            $vend_id = get_auth_vend_id($request, $Auth_User);

            $Model_Data->user_type = $request->user_type;
            $Model_Data->vend_id = $vend_id;
            $Model_Data->name = $request->name;
            $Model_Data->company_name = null;
            $Model_Data->phone = $request->phone;
            $Model_Data->email = $request->email;

            if($request->password) {
                $Model_Data->password = \Hash::make($request->password);
            }
            $Model_Data->status = 1;
            $Model_Data->application_status = 0;
            $Model_Data->approval_status = 1;
			
            $Model_Data->created_by = $Auth_User->id;
            $Model_Data->save();

            $user_id = $Model_Data->id;
			
            $Role = Role::select('name')->where('id', '=', $request->role)->first();

            $user = User::find($user_id);
            $user->assignRole($Role->name);

            Flash::success($this->msg_created);
            return redirect()->route($this->home_route);
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
		if($Auth_User->id == $id || ($Auth_User->can($this->view_permission) || $Auth_User->can('all')))
		{
            $Model_Data = $user = User::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $user_type = $Model_Data->user_type;
            $vend_id = $Model_Data->vend_id;
			
			$company_name = '';
            if($user_type == 'admin')
            {
                $company_name = 'Homely App';
            }
            else
            {
                if($user_type == 'vendor')
				{
                    $record = SvcVendor::select('name')->where('id',$vend_id)->first();
                	$company_name = $record->name;
                }
                elseif($user_type == 'seller')
				{
                    $record = EcomSeller::select('name')->where('id',$vend_id)->first();
                	$company_name = $record->name;
                }
            }

            $role_name = '';
            $roles = Role::select('id','name','display_to')->orderBy('name', 'ASC')->get();
            foreach($roles as $role)
            {
                if($user->hasRole($role->name))
                {
                    $role_name = ucwords($role->name);
                }
            }

            $categories_array = array();//SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

            return view($this->views_path.'.show', compact("user", "Model_Data", "categories_array","role_name","company_name"));
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
    public function edit($user_id)
    {   
        $id = $user_id;
		$Auth_User = Auth::user();     
		if($Auth_User->id == $id || ($Auth_User->can($this->view_permission) || $Auth_User->can('all')))
		{ 			
            $Model_Data = $user = User::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $user_type = $Model_Data->user_type;
            $vend_id = $Model_Data->vend_id;
			
			$company_name = '';
            if($user_type == 'admin')
            {
                $company_name = 'Homely App';
            }
            else
            {
                if($user_type == 'vendor')
				{
                    $record = SvcVendor::select('name')->where('id',$vend_id)->first();
                	$company_name = $record->name;
                }
                elseif($user_type == 'seller')
				{
                    $record = EcomSeller::select('name')->where('id',$vend_id)->first();
                	$company_name = $record->name;
                }
            }

            return view($this->views_path.'.edit', compact("user", "Model_Data", "company_name"));
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
    public function update(Request $request)
    {
		$email = $request->email;		
		$Model_Data = $user = User::where('email', $email)->first();
		
		if (empty($Model_Data) || $this->is_not_authorized($Model_Data->id, $Auth_User))
		{
			Flash::error($this->msg_not_found);
			return redirect(route($this->home_route));
		}
		
        $id = $Model_Data->id;
		
        $Auth_User = Auth::user();
        if($Auth_User->id == $id || ($Auth_User->can($this->view_permission) || $Auth_User->can('all')))
        {
            $Model_Data->name = $request->name;
            $Model_Data->phone = $request->phone;
            if($request->password){
                $Model_Data->password = \Hash::make($request->password);
            }
            $Model_Data->save();

            Flash::success($this->msg_updated);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }



	/**
	* update mode display settings of the specified resource in storage.
	*
	* @param  option  $option
	* @return \Illuminate\Http\Response
	*/
    public function set_mode($option)
    {
        $Auth_User = Auth::user();

        $Model_Data = User::find($Auth_User->id);

        if (empty($Model_Data))
        {
            Flash::error($this->msg_not_found);
            return redirect(route($this->home_route));
        }

        $Model_Data->mode = $option;
        $Model_Data->updated_by = $Auth_User->id;
        $Model_Data->save();

        Flash::success("You have updated mode display settings successfully");
        return redirect(route($this->dashboard_route));
    }



	/**
	* update sidebar display settings of the specified resource in storage.
	*
	* @param  option  $option
	* @return \Illuminate\Http\Response
	*/
    public function set_sidebar($option)
    {
        $Auth_User = Auth::user();
        $Model_Data = User::find($Auth_User->id);

        if (empty($Model_Data))
        {
            Flash::error($this->msg_not_found);
            return redirect(route($this->home_route));
        }

        $Model_Data->sidebar = $option;
        $Model_Data->updated_by = $Auth_User->id;
        $Model_Data->save();

        Flash::success("You have updated sidebar display settings successfully");
        return redirect(route($this->dashboard_route));
    }



	/**
	* update theme display settings of the specified resource in storage.
	*
	* @param  theme  $theme
	* @return \Illuminate\Http\Response
	*/
    public function set_theme($option)
    {
        $Auth_User = Auth::user();

        $Model_Data = User::find($Auth_User->id);

        if (empty($Model_Data))
        {
            Flash::error($this->msg_not_found);
            return redirect(route($this->home_route));
        }

        $Model_Data->theme = $option;
        $Model_Data->updated_by = $Auth_User->id;
        $Model_Data->save();


        Flash::success("You have updated theme display settings successfully");
        return redirect(route($this->dashboard_route));
    }



	/**
	* update menu display settings of the specified resource in storage.
	*
	* @param  theme  $theme
	* @return \Illuminate\Http\Response
	*/
    public function set_menu($option)
    {
        $Auth_User = Auth::user();

        $Model_Data = User::find($Auth_User->id);

        if (empty($Model_Data))
        {
            Flash::error($this->msg_not_found);
            return redirect(route($this->home_route));
        }

        $Model_Data->menu = $option;
        $Model_Data->updated_by = $Auth_User->id;
        $Model_Data->save();


        Flash::success("You have updated menu display settings successfully");
        return redirect(route($this->dashboard_route));
    }



	/**
	* update defualt display settings of the specified resource in storage.
	*
	* @param  option  $option
	* @return \Illuminate\Http\Response
	*/
    public function set_default()
    {
        $Auth_User = Auth::user();
        $Model_Data = User::find($Auth_User->id);

        if (empty($Model_Data))
        {
            Flash::error($this->msg_not_found);
            return redirect(route($this->home_route));
        }

        $Model_Data->mode = 'light';
        $Model_Data->sidebar = 'allports';
        $Model_Data->theme = 'allports';
        $Model_Data->menu = 'off';
        $Model_Data->updated_by = $Auth_User->id;
        $Model_Data->save();

        Flash::success("You have updated sidebar display settings successfully");
        return redirect(route($this->dashboard_route));
    }

    public function approve($user_id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $id = $user_id;

            $user = $user = User::find($id);

            if (empty($user)) {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $role = $user->role;


            $vend_id = $user->vend_id;
            $user->status = 1;
            $user->approval_status = 1;
            $user->updated_by = $Auth_User->id;
            $user->save();

            $user->assignRole($role);

            if($role == 'seller'){
                if ($vend_id == 0) {
                    $Model_Data = new EcomSeller();

                    $Model_Data->name = $user->company_name;
                    $Model_Data->arabic_name = $user->company_name;
                    $Model_Data->location = $user->address;
                    $Model_Data->lat = $user->lat;
                    $Model_Data->lng = $user->lng;
                    $Model_Data->phone = $user->phone;
                    $Model_Data->email = $user->email;
                    $Model_Data->website = $user->website;
                    $Model_Data->description = $user->company_name;
                    $Model_Data->arabic_description = $user->company_name;
                    $Model_Data->status = 1;

                    $Model_Data->created_by = $id;
                    $Model_Data->save();

                    $vend_id = $Model_Data->id;

                    $categories = explode(",",$user->categories);

                    foreach($categories as $cat_id) {

                        $Category = EcomCategory::find($cat_id);

                        $Model_Data = new EcomSellerCategory();
                        $Model_Data->seller_id = $vend_id;
                        $Model_Data->cat_id = $cat_id;
                        $Model_Data->save();
                    }

                    $Model_Data = User::find($id);
                    $Model_Data->vend_id = $vend_id;
                    $Model_Data->save();
                }
                else {
                    $Model_Data = EcomSeller::find($vend_id);
                    $Model_Data->status = 1;
                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();
                }
            }
            elseif($role == 'vendor'){
                if ($vend_id == 0) {
                    $Model_Data = new SvcVendor();

                    $Model_Data->name = $user->company_name;
                    $Model_Data->arabic_name = $user->company_name;
                    $Model_Data->location = $user->address;
                    $Model_Data->lat = $user->lat;
                    $Model_Data->lng = $user->lng;
                    $Model_Data->phone = $user->phone;
                    $Model_Data->email = $user->email;
                    $Model_Data->website = $user->website;
                    $Model_Data->description = $user->company_name;
                    $Model_Data->arabic_description = $user->company_name;
                    $Model_Data->status = 1;

                    $Model_Data->created_by = $id;
                    $Model_Data->save();

                    $vend_id = $Model_Data->id;

                    $categories = explode(",",$user->categories);

                    foreach($categories as $cat_id) {

                        $Category = SvcCategory::find($cat_id);

                        $attribute_array = null;

                        if (!empty($Category) && $Category->has_attributes == 1) {
                            $attributes = SvcAttribute::where('attributable_type', 'App/Models/SvcCategory')->where('attributable_id', $cat_id)->get();
                            $attribute_array = $this->common_attributes($attributes, $vend_id, 0);
                        }

                        $Model_Data = new SvcVendorCategory();
                        $Model_Data->vend_id = $vend_id;
                        $Model_Data->cat_id = $cat_id;
                        $Model_Data->attributes = $attribute_array;
                        $Model_Data->save();
                    }

                    $Model_Data = User::find($id);
                    $Model_Data->vend_id = $vend_id;
                    $Model_Data->save();
                }
                else {
                    $Model_Data = SvcVendor::find($vend_id);
                    $Model_Data->status = 1;
                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();
                }
                for($j=0; $j<48; $j++)
                {
                    $Model_Data = new SvcVendorTiming();

                    $Model_Data->vend_id = $vend_id;

                    $time = ($j * 30 * 60);
                    $Model_Data->time_value = $time;

                    if( $time >= 32400 && $time <= 73800 ){
                        $Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 1;
                    }
                    else{
                        $Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 0;
                    }

                    $Model_Data->save();
                }
            }

            Flash::success($this->msg_approved);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function reject($user_id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $id = $user_id;

            $Model_Data = $user = User::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->approval_status = 2;

            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success($this->msg_rejected);
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function changePassword(Request $request)
    {
        $Auth_User = Auth::user();

        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            return view($this->views_path.'.password');
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function updatePassword(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $user = User::find(\Auth::user()->id);
            if(\Hash::check($request->current_password, $user->password))
            {
                $user->password = \Hash::make($request->new_password);
            	$user->updated_by = $Auth_User->id;
                $user->save();

                return redirect()->route('dashboard')->with('success','Successfully Changed');
            }
            else
            {
                return redirect()->route('users.changePassword')->with('error','Incorrect Password');
            }
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function userPermissions($id){

        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $Model_Data = $user = User::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Modules = Module::orderby('id', 'asc')->get();

            $list_array=array();
            $add_array=array();
            $edit_array=array();
            $view_array=array();
            $status_array=array();
            $delete_array=array();

            $role = $Model_Data;

            foreach($Modules as $Module)
            {
                $module_id = $Module->id;
                $module_name = $Module->module_name;

                $action = "listing";
                if($Module->mod_list == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $list_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $list_array[$module_id]=1;
                    }
                }

                $action = "add";
                if($Module->mod_add == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $add_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $add_array[$module_id]=1;
                    }
                }

                $action = "edit";
                if($Module->mod_edit == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $edit_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $edit_array[$module_id]=1;
                    }
                }

                $action = "view";
                if($Module->mod_view == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $view_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $view_array[$module_id]=1;
                    }
                }

                $action = "status";
                if($Module->mod_status == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $status_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $status_array[$module_id]=1;
                    }
                }

                $action = "delete";
                if($Module->mod_delete == 1)
                {
                    $permission = $module_name.'-'.$action;
                    $permission = createSlug($permission);

                    $delete_array[$module_id]=0;
                    if($user->hasPermissionTo($permission))
                    {
                        $delete_array[$module_id]=1;
                    }
                }

            }

            return view($this->views_path.'.userPermissions', compact("user", "Model_Data", "Modules", "list_array", "add_array", "edit_array", "view_array", "status_array", "delete_array"));

        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function userPermissionsSubmit(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $id = $request->user_id;

            $Model_Data = Role::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $user = $Model_Data;

            $counter=0;

            $Modules = Module::orderby('id', 'asc')->get();
            foreach($Modules as $Module)
            {
                $module_id = $Module->id;
                $module_name = $Module->module_name;


                $action = "listing";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_list == 1)
                {
                    $insert = 0;
                    $exits = 0;

                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->list_module[$counter]) && $request->list_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }

                $action = "add";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_add == 1)
                {
                    $insert = 0;
                    $exits = 0;


                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->add_module[$counter]) && $request->add_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }

                $action = "edit";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_edit == 1)
                {
                    $insert = 0;
                    $exits = 0;


                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->edit_module[$counter]) && $request->edit_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }

                $action = "view";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_view == 1)
                {
                    $insert = 0;
                    $exits = 0;


                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->view_module[$counter]) && $request->view_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }

                $action = "status";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_status == 1)
                {
                    $insert = 0;
                    $exits = 0;


                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->status_module[$counter]) && $request->status_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }

                $action = "delete";
                $permission = $module_name.'-'.$action;
                $permission = createSlug($permission);
                if($Module->mod_delete == 1)
                {
                    $insert = 0;
                    $exits = 0;


                    if($user->hasPermissionTo($permission))
                    {
                        $exits = 1;
                    }


                    if(isset($request->delete_module[$counter]) && $request->delete_module[$counter]==1)
                    {
                        $insert = 1;
                    }

                    if($exits == 0 && $insert == 1)
                    {
                        $user->givePermissionTo($permission);
                    }
                    elseif($exits == 1 && $insert == 0)
                    {
                        $user->revokePermissionTo($permission);
                    }
                }
                elseif($user->hasPermissionTo($permission))
                {
                    $user->revokePermissionTo($permission);
                }
                $counter++;
            }

            return redirect(route('userPermissions',$user->id))->with('message', 'Permissions Assigned Successfully');
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function common_attributes($attributes, $i, $add_value)
    {
        $attribute_array = array();
        $prices_array = array();
        $values_array = array();

        $j = 0;
        foreach ($attributes as $attribute)
        {
            $attribute_id = $attribute->id;

            $attribute_options = SvcAttributeOption::where('attributable_id',$attribute_id)->get();


            foreach ($attribute_options as $attribute_option)
            {
                $j++;
                $option_name = trim($attribute_option->name);
                $values_array[] = $option_name;

                $option_name = strtolower($option_name);

                $option_value = (($i * $j * 10)+ $add_value);
                if($option_name == 'callout text' || $option_name == 'callout-text' || $option_name == 'call out text' || $option_name == 'call-out-text')
                    $option_value = $option_name." $i-$j";

                $prices_array[] = $option_value;
            }
        }
        $attribute_array['values'] = $values_array;
        $attribute_array['prices'] = $prices_array;

        if(empty($attribute_array))
        {
            $attribute_array = null;
        }
        else
        {
            $attribute_array = json_encode($attribute_array);
        }

        return $attribute_array;
    }

    public function show_application($user_id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
        {
            $id = $user_id;
            $Model_Data = $user = User::find($id);
            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
            if($user->role == "vendor"){
                $categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
            }
            elseif($user->role =="seller"){
                $categories_array = EcomCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
            }


            return view($this->views_path.'.show_application', compact("user", "Model_Data", "categories_array"));
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
		if($Auth_User->id != $id && $id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))     
		{
            $Model_Data = User::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('User made Active successfully.');
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
		if($Auth_User->id != $id && $id > 1 && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))     
		{
            $Model_Data = User::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('User made InActive successfully.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function is_not_authorized($id, $Auth_User)
	{
		$user_type = $Auth_User->user_type;
		
        $bool = 1;
        if($id == $Auth_User->id)
        {
            $bool = 0;
        }
        else
        {
			if($user_type == 'admin')
			{
				$bool = 0;
			}
			elseif($user_type == 'seller')
			{
				$seller_id = $Auth_User->vend_id;
				$records = User::select(['id'])->where('id', '=', $id)->where('user_type', '=', $user_type)->where('vend_id', '=', $seller_id)->limit(1)->get();
				foreach($records as $record)
				{
					$bool = 0;
				}
			}
			elseif($user_type == 'vendor')
			{
				$vend_id = $Auth_User->vend_id;
				$records = User::select(['id'])->where('id', '=', $id)->where('user_type', '=', $user_type)->where('vend_id', '=', $vend_id)->limit(1)->get();
				foreach($records as $record)
				{
					$bool = 0;
				}
			}
		}

        return $bool;
    }
}

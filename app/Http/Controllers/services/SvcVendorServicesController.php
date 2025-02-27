<?php

namespace App\Http\Controllers\services;

use Auth;

use File;
use Response;
use Attribute;
use Datatables;
use App\Models\User;
use App\Models\SvcVendor;
use App\Models\SvcService;
use Laracasts\Flash\Flash;
use App\Models\SvcCategory;

use App\Models\SvcAttribute;
use Illuminate\Http\Request;

use App\Models\SvcSubService;

use App\Models\SvcSubCategory;
use App\Models\SvcVendorService;

use App\Models\SvcVendorCategory;
use App\Models\SvcAttributeOption;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use App\Models\SvcVendorSubCategory;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class SvcVendorServicesController extends Controller
{
	
	private $views_path = "svc.vendors.services";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "vendor-services.index";
	private $create_route = "vendor-services.create";
	private $edit_route = "vendor-services.edit";
	private $view_route = "vendor-services.show";
	private $delete_route = "vendor-services.destroy";
	
	private $msg_created = "Vendor Services added successfully.";
	private $msg_updated = "Vendor Services updated successfully.";
	private $msg_deleted = "Vendor Services deleted successfully.";
	private $msg_not_found = "Vendor Services not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same SvcCategory name";
	
	private $list_permission = "vendor-services-listing";
	private $add_permission = "vendor-services-add";
	private $edit_permission = "vendor-services-edit";
	private $view_permission = "vendor-services-view";
	private $status_permission = "vendor-services-status";
	private $delete_permission = "vendor-services-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Vendor Services. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Vendor SvcService. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Vendor SvcService. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Vendor SvcService details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Vendor SvcService. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Vendor SvcService. Please Contact Administrator.";
	
	
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
			$records = SvcVendorService::select(['id'])->where('id', '>=', 1)->limit(1)->get();
			
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			$services = SvcService::select(['id','title'])
				->where('status', '=', 1)
				->orderby('title', 'asc')
				->pluck('title','id');
			
			$sub_services = SvcSubService::select(['id','title'])
				->where('status', '=', 1)
				->orderby('title', 'asc')
				->pluck('title','id');
			
			return view($this->views_path.'.listing', compact('records_exists','vendors_array','services','sub_services'));
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
			if($Auth_User->user_type == 'admin')
			{
				return  $this->admin_datatable($request);
			}
			elseif($Auth_User->user_type == 'vendor')
			{
				return  $this->vendor_datatable($request);
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
		$Auth_User = Auth::user();
		$vend_id=$Auth_User->vend_id;
		
		$Records = SvcVendorService::leftjoin('svc_vendors','svc_vendor_services.vend_id','=','svc_vendors.id')
			->leftjoin('svc_services','svc_vendor_services.service_id','=','svc_services.id')
			->leftjoin('svc_sub_services','svc_vendor_services.sub_service_id','=','svc_sub_services.id')
			->select(['svc_vendor_services.id as vend_ser_id','svc_vendor_services.price as vend_ser_price', 'svc_vendor_services.status as vendor_services_status',
				'svc_vendors.id as vend_id','svc_vendors.name as vend_name',
				'svc_services.id as service_id','svc_services.title as service_title',
				'svc_sub_services.id as sub_service_id','svc_sub_services.title as sub_services_title']);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('vendor_id') && $request->get('vendor_id') != -1)
				{
					$query->where('svc_vendors.id', '=', "{$request->get('vendor_id')}");
				}
				if ($request->has('service_id') && !empty($request->service_id))
				{
					$query->where('svc_services.title', 'like', "%{$request->get('service_id')}%");
				}
				if ($request->has('sub_service_id') && !empty($request->sub_service_id))
				{
					$query->where('svc_sub_services.title', 'like', "%{$request->get('sub_service_id')}%");
				}
				if ($request->has('price') && !empty($request->price))
				{
					$query->where('svc_vendor_services.price', '>', "{$request->get('price')}");
				}
				if ($request->has('status') && $request->get('status') != -1) {
					$query->where('svc_vendor_services.status', '=', "{$request->get('status')}");
				}
			})
			->addColumn('vendor_services_status', function ($Records) {
				$record_id = $Records->vend_ser_id;
				$status = $Records->vendor_services_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
					if ($status == 1) {
						$str = '<a href="' . route('svc_vendor_services_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Vendor Services Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					} else {
						$str = '<a href="' . route('svc_vendor_services_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Vendor Services Active">
                        <span class="fa fa-power-off"></span> Inactive
                        </a>';
					}
				} else {
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
				
				return $str;
			})
			->addColumn('action', function ($Records) {
				
				$vend_id = $Records->vend_id;
				$service_id = $Records->service_id;
				$sub_service_id = $Records->sub_service_id;
				
				$record_id = $Records->vend_ser_id;
				$Auth_User = Auth::user();
				
				$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
				
				if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
				}
				
				if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';
					
					if($sub_service_id == 0){
						$attributes = SvcVendorService::where('service_id',$service_id)->where('vend_id',$vend_id)->first();}
					else{
						$attributes = SvcVendorService::where('sub_service_id',$sub_service_id)->where('vend_id',$vend_id)->first();}
					
					if($attributes != null && $attributes->attributes != null) {
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
							Manage Attributes
							</a>';
					}
					
				}
				
				if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
				{
					/*$str.= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
								<i class="fa fa-trash"></i>
								</a>';*/
					
					/*$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
								<i class="fa fa-trash"></i>
								</a>';

					{
						$str.='<div id="m-'.$record_id.'" class="modal fade" data-backdrop="true">
										<div class="modal-dialog" id="animate">
											<div class="modal-content">
												<form action="'.route($this->delete_route, $record_id).'" method="POST">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<div class="modal-header">
													<h5 class="modal-title">Confirm delete following record</h5>
												</div>
												<div class="modal-body text-center p-lg">
													<p>
														Are you sure to delete this record?
														<br>
														<strong>';
						if($Records->sub_services_title != ""){
							$str.='[ '.$Records->service_title." - ".$Records->sub_services_title.' ]';
						}
						else{
							$str.='[ '.$Records->service_title.' ]';
						}


					$str.='</strong>
								</p>
											</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
													<button type="submit" class="btn btn-danger">Yes</button>
												</div>
												</form>
											</div>
										</div>
									</div>';
					}*/
				}
				
				$str.= "</div>";
				return $str;
				
			})
			->rawColumns(['vendor_services_status','action'])
			->setRowId(function($Records) {
				return 'myDtRow' . $Records->vend_ser_id;
			})
			->make(true);
		return $response;
	}
	
	public function vendor_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		$vend_id=$Auth_User->vend_id;
		
		$Records = SvcVendorService::leftjoin('svc_services','svc_vendor_services.service_id','=','svc_services.id')
			->leftjoin('svc_sub_services','svc_vendor_services.sub_service_id','=','svc_sub_services.id')
			->select(['svc_vendor_services.id as vend_ser_id','svc_vendor_services.price as vend_ser_price', 'svc_vendor_services.status as vendor_services_status',
				'svc_services.id as service_id','svc_services.title as service_title',
				'svc_sub_services.id as sub_service_id','svc_sub_services.title as sub_services_title'])
			->where('svc_vendor_services.vend_id', '=', $vend_id);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('service_id') && !empty($request->service_id))
				{
					$query->where('svc_services.title', 'like', "%{$request->get('service_id')}%");
				}
				if ($request->has('sub_service_id') && !empty($request->sub_service_id))
				{
					$query->where('svc_sub_services.title', 'like', "%{$request->get('sub_service_id')}%");
				}
				if ($request->has('price') && !empty($request->price))
				{
					$query->where('svc_vendor_services.price', '>', "{$request->get('price')}");
				}
				if ($request->has('status') && $request->get('status') != -1) {
					$query->where('svc_vendor_services.status', '=', "{$request->get('status')}");
				}
			})
			->addColumn('vendor_services_status', function ($Records) {
				$record_id = $Records->vend_ser_id;
				$status = $Records->vendor_services_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
					if ($status == 1) {
						$str = '<a href="' . route('svc_vendor_services_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Vendor Services Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					} else {
						$str = '<a href="' . route('svc_vendor_services_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Vendor Services Active">
                        <span class="fa fa-power-off"></span> Inactive
                        </a>';
					}
				} else {
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
				
				return $str;
			})
			->addColumn('action', function ($Records) {
				
				$vend_id = $Records->vend_id;
				$service_id = $Records->service_id;
				$sub_service_id = $Records->sub_service_id;
				
				$record_id = $Records->vend_ser_id;
				$Auth_User = Auth::user();
				
				$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
				
				if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
				}
				
				if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';
					
					if($sub_service_id == 0){
						$attributes = SvcVendorService::where('service_id',$service_id)->where('vend_id',$vend_id)->first();}
					else{
						$attributes = SvcVendorService::where('sub_service_id',$sub_service_id)->where('vend_id',$vend_id)->first();}
					
					if($attributes != null && $attributes->attributes != null) {
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
							Manage Attributes
							</a>';
					}
					
				}
				
				if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
				{
					/*$str.= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
								<i class="fa fa-trash"></i>
								</a>';*/
					
					/*$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
								<i class="fa fa-trash"></i>
								</a>';

					{
						$str.='<div id="m-'.$record_id.'" class="modal fade" data-backdrop="true">
										<div class="modal-dialog" id="animate">
											<div class="modal-content">
												<form action="'.route($this->delete_route, $record_id).'" method="POST">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<div class="modal-header">
													<h5 class="modal-title">Confirm delete following record</h5>
												</div>
												<div class="modal-body text-center p-lg">
													<p>
														Are you sure to delete this record?
														<br>
														<strong>';
						if($Records->sub_services_title != ""){
							$str.='[ '.$Records->service_title." - ".$Records->sub_services_title.' ]';
						}
						else{
							$str.='[ '.$Records->service_title.' ]';
						}


					$str.='</strong>
								</p>
											</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
													<button type="submit" class="btn btn-danger">Yes</button>
												</div>
												</form>
											</div>
										</div>
									</div>';
					}*/
				}
				
				$str.= "</div>";
				return $str;
				
			})
			->rawColumns(['vendor_services_status','action'])
			->setRowId(function($Records) {
				return 'myDtRow' . $Records->vend_ser_id;
			})
			->make(true);
		return $response;
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
			$records = SvcVendorService::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
			foreach($records as $record)
			{
				$bool = 0;
			}
		}
		
		return $bool;
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
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			$cat = array();
			$sub_cat = array();
			if($Auth_User->user_type == 'vendor')
			{
				
				$cat = SvcVendorCategory::leftjoin('svc_categories','svc_vendor_categories.cat_id','=','svc_categories.id')
					->select(['svc_categories.id','svc_categories.title'])
					->where(['svc_vendor_categories.status'=>1])
					->where(['svc_vendor_categories.vend_id'=>$Auth_User->vend_id])
					->pluck('title','id');
				
				
				$sub_cat = SvcVendorSubCategory::leftjoin('svc_sub_categories','svc_vendor_sub_categories.sub_cat_id','=','svc_sub_categories.id')
					->select(['svc_sub_categories.id','svc_sub_categories.title'])
					->where(['svc_vendor_sub_categories.status'=>1])
					->pluck('title','id');
				
			}
			
			return view($this->views_path.'.create',compact('vendors_array', 'cat', 'sub_cat'));
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
				'vend_id'  => 'required',
				'cat_id'  => 'required',
				'sub_cat_id'  => 'required',
				'ser_id'  => 'required',
				'price'  => 'required',
			]);
			
			$vend_id = get_auth_vend_id($request, $Auth_User);
			
			$ser_id = $request->get('ser_id');
			$sub_ser_id = $request->get('sub_ser_id');
			
			$service_id = $request->ser_id;
			$sub_service_id = $request->sub_ser_id;
			$vend_id = $request->vend_id;
			
			$attributes_count = 0;
			
			$attributes_array = array();
			$options_array = array();
			
			if($sub_service_id == 0){
				$attributes = SvcAttribute::where('attributable_id',$service_id)->where('attributable_type','App/Models/SvcService')->get();
			}
			else{
				$attributes = SvcAttribute::where('attributable_id',$sub_service_id)->where('attributable_type','App/Models/SvcSubService')->get();
			}
			
			$options_array = array();
			
			foreach ($attributes as $attribute){
				
				$attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();
				
				foreach ($attributes_options as $attributes_option){
					$options = array();
					$options['name'] = $attributes_option->name;
					$options['num_field'] = $attributes_option->num_field;
					$options['text_field'] = $attributes_option->text_field;
					
					$options_array[] = $options;
				}
			}
			
			$attributes_count = count($options_array);
			
			if($attributes_count > 0){
				
				$prices_array = array();
				$values_array = array();
				
				for ($i = 0; $i < $attributes_count; $i++) {
					$name = createSlug($options_array[$i]['name'], '_');
					$values_array[] = $options_array[$i]['name'];
					$prices_array[] = $request->$name;
				}
				
				$attribute_array['values'] = $values_array;
				$attribute_array['prices'] = $prices_array;
				
				$attribute_array = json_encode($attribute_array);
			}
			else{
				$attribute_array = null;
			}
			
			$_exist = 0;
			
			$Vendor_services = SvcVendorService::where([['vend_id', $vend_id], ['service_id', $ser_id], ['sub_service_id', $sub_ser_id]])->get();
			
			foreach($Vendor_services as $service)
			{
				$vend_service_id = $service->id;
				
				$Model_Data = SvcVendorService::find($vend_service_id);
				$Model_Data->attributes = $attribute_array;
				$Model_Data->price = $request->price;
				$Model_Data->status = 1;
				$Model_Data->updated_by = $Auth_User->id;
				$Model_Data->save();
				
				$_exist = 1;
			}
			if ($_exist == 0)
			{
				$Model_Data = new SvcVendorService();
				$Model_Data->vend_id = $vend_id;
				$Model_Data->service_id = $ser_id;
				
				if($sub_ser_id == 0)
				{
					$Model_Data->sub_service_id = 0;
				}
				else
				{
					$Model_Data->sub_service_id = $sub_ser_id;
				}
				
				$Model_Data->price = $request->price;
				$Model_Data->attributes = $attribute_array;
				$Model_Data->status = 1;
				$Model_Data->updated_by = $Auth_User->id;
				$Model_Data->save();
				
			}
			
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
		if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
		{
			$Model_Data = SvcVendorService::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$service_title = SvcService::find($Model_Data->service_id);
			
			$sub_service_title = SvcSubService::find($Model_Data->sub_service_id);
			
			$vend_id = $Model_Data->vend_id;
			
			$vendor_dataa = SvcVendor::find($vend_id);
			
			$service_id = $Model_Data->service_id;
			
			$service_data = SvcService::find($service_id);
			
			$sub_service_id = $Model_Data->sub_service_id;
			
			$sub_service_data = SvcSubService::find($sub_service_id);
			
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$attributes_array = array();
			$prices_array = array();
			$values_array = array();
			
			$attributes = SvcVendorService::where('service_id',$service_id)->where('sub_service_id',$sub_service_id)->where('vend_id',$vend_id)->first();
			
			if($attributes != null && $attributes->attributes != null) {
				$records_exists = 1;
				$attributes = $attributes->attributes;
				
				$attributes = json_decode($attributes);
				
				
				$prices_array = $attributes->prices;
				$values_array = $attributes->values;
				
				$attributes_count = count($prices_array);
			}
			
			
			if($sub_service_id == 0){
				$attributes = SvcAttribute::where('attributable_id',$service_id)->where('attributable_type','App/Models/SvcService')->get();
			}
			else{
				$attributes = SvcAttribute::where('attributable_id',$sub_service_id)->where('attributable_type','App/Models/SvcSubService')->get();
			}
			
			$options_array = array();
			
			foreach ($attributes as $attribute){
				
				$attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();
				
				foreach ($attributes_options as $attributes_option){
					$options = array();
					$options['name'] = $attributes_option->name;
					$options['num_field'] = $attributes_option->num_field;
					$options['text_field'] = $attributes_option->text_field;
					
					$options_array[] = $options;
				}
				
			}
			
			/*return view($this->views_path.'.edit',compact('Model_Data', 'records_exists','options_array', 'vend_id','service_id','sub_service_id','values_array','prices_array','attributes_count','vendor_data', 'category_data', 'sub_category_data',
				'service_data','sub_service_data'));*/
			
			return view($this->views_path.'.show', compact('Model_Data', 'vendor_dataa', 'service_data', 'sub_service_data', 'service_title', 'sub_service_title', 'records_exists','options_array', 'vend_id','service_id','sub_service_id','values_array','prices_array','attributes_count'));
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
			$Model_Data = SvcVendorService::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			//vendor
			$vend_id = $Model_Data->vend_id;
			$vendor_data = SvcVendor::find($vend_id);
			
			//service
			$service_id = $Model_Data->service_id;
			$service_data = SvcService::find($service_id);
			
			//category
			if($service_data != null)
			{
				$vendor_cat_ids = $service_data->cat_id;
				$category_data = SvcCategory::find($vendor_cat_ids);
			}
			else
			{
				$category_data = null;
			}
			
			//sub category
			if($service_data != null)
			{
				$vendor_sub_cat_id = $service_data->sub_cat_id;
				$sub_category_data = SvcSubCategory::find($vendor_sub_cat_id);
			}
			else
			{
				$sub_category_data = null;
			}
			
			//sub service
			if($Model_Data != null)
			{
				$sub_service_id = $Model_Data->sub_service_id;
				$sub_service_data = SvcSubService::find($sub_service_id);
			}
			else
			{
				$sub_service_data = null;
			}
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$attributes_array = array();
			$prices_array = array();
			$values_array = array();
			
			$attributes = SvcVendorService::where('service_id',$service_id)->where('sub_service_id',$sub_service_id)->where('vend_id',$vend_id)->first();
			
			if($attributes != null && $attributes->attributes != null) {
				$records_exists = 1;
				$attributes = $attributes->attributes;
				
				$attributes = json_decode($attributes);
				
				
				$prices_array = $attributes->prices;
				$values_array = $attributes->values;
				
				$attributes_count = count($prices_array);
			}
			
			
			if($sub_service_id == 0){
				$attributes = SvcAttribute::where('attributable_id',$service_id)->where('attributable_type','App/Models/SvcService')->get();
			}
			else{
				$attributes = SvcAttribute::where('attributable_id',$sub_service_id)->where('attributable_type','App/Models/SvcSubService')->get();
			}
			
			$options_array = array();
			
			foreach ($attributes as $attribute){
				
				$attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();
				
				foreach ($attributes_options as $attributes_option){
					$options = array();
					$options['name'] = $attributes_option->name;
					$options['num_field'] = $attributes_option->num_field;
					$options['text_field'] = $attributes_option->text_field;
					
					$options_array[] = $options;
				}
				
			}
			
			return view($this->views_path.'.edit',compact('Model_Data', 'records_exists','options_array', 'vend_id','service_id','sub_service_id','values_array','prices_array','attributes_count','vendor_data', 'category_data', 'sub_category_data', 'service_data','sub_service_data'));
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
			$model_data = SvcVendorService::find($id);
			
			if (empty($model_data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			
			$model_data->price = $request->price;
			$model_data->update();
			
			$service_id = $model_data->service_id;
			$sub_service_id = $model_data->sub_service_id;
			$vend_id = $model_data->vend_id;
			
			$service_name = "";//get_service_name($service_id);
			$sub_service_name = "";//get_sub_service_name($sub_service_id);
			$vend_name = "";//get_vendor_name($vend_id);
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$options_array = array();
			$attribute_array = array();
			
			if($sub_service_id == 0){
				$attributes = SvcAttribute::where('attributable_id',$service_id)->where('attributable_type','App/Models/SvcService')->get();
			}
			else{
				$attributes = SvcAttribute::where('attributable_id',$sub_service_id)->where('attributable_type','App/Models/SvcSubService')->get();
			}
			
			$options_array = array();
			
			foreach ($attributes as $attribute){
				
				$attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();
				
				foreach ($attributes_options as $attributes_option){
					$options = array();
					$options['name'] = $attributes_option->name;
					$options['num_field'] = $attributes_option->num_field;
					$options['text_field'] = $attributes_option->text_field;
					
					$options_array[] = $options;
				}
				
			}
			
			$attributes_count = count($options_array);
			
			if($attributes_count > 0){
				
				$prices_array = array();
				$values_array = array();
				
				for ($i = 0; $i < $attributes_count; $i++) {
					$name = createSlug($options_array[$i]['name'], '_');
					$values_array[] = $options_array[$i]['name'];
					$prices_array[] = $request->$name;
				}
				
				$attribute_array['values'] = $values_array;
				$attribute_array['prices'] = $prices_array;
				
				$attribute_array = json_encode($attribute_array);
			}
			else{
				$attribute_array = null;
			}
			
			$Model_Data = SvcVendorService::where('service_id',$service_id)->where('sub_service_id',$sub_service_id)->where('vend_id',$vend_id)->first();
			
			$Model_Data->attributes = $attribute_array;
			
			$Model_Data->save();
			
			
			//vendor
			$vend_id = $Model_Data->vend_id;
			$vendor_data = SvcVendor::find($vend_id);
			
			//service
			$service_id = $Model_Data->service_id;
			$service_data = SvcService::find($service_id);
			
			//category
			if($service_data != null)
			{
				$vendor_cat_ids = $service_data->cat_id;
				$category_data = SvcCategory::find($vendor_cat_ids);
			}
			else
			{
				$category_data = null;
			}
			
			//sub category
			if($service_data != null)
			{
				$vendor_sub_cat_id = $service_data->sub_cat_id;
				$sub_category_data = SvcSubCategory::find($vendor_sub_cat_id);
			}
			else
			{
				$sub_category_data = null;
			}
			
			//sub service
			if($Model_Data != null)
			{
				$sub_service_id = $Model_Data->sub_service_id;
				$sub_service_data = SvcSubService::find($sub_service_id);
			}
			else
			{
				$sub_service_data = null;
			}
			
			Flash::success($this->msg_updated);
			
			return view($this->views_path.'.edit', compact('records_exists','Model_Data','vend_id','vend_name','service_name','sub_service_name','service_id','sub_service_id', 'options_array','values_array','prices_array','attributes_count','vendor_data', 'category_data', 'sub_category_data','service_data','sub_service_data'));
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
			$Model_Data = SvcVendorService::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Vendor Service made Active successfully.');
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
			$Model_Data = SvcVendorService::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Vendor Service made InActive successfully.');
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
			$Model_Data = SvcVendorService::find($id);

			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
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

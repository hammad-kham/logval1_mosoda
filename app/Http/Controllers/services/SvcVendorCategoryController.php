<?php

namespace App\Http\Controllers\services;

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

use App\Models\SvcAttribute;
use App\Models\SvcAttributeOption;

use App\Models\SvcVendor;
use App\Models\SvcCategory;
use App\Models\SvcVendorCategory;

class SvcVendorCategoryController extends Controller
{
	private $views_path = "svc.vendors.categories";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "vendor-categories.index";
	private $create_route = "vendor-categories.create";
	private $edit_route = "vendor-categories.edit";
	private $view_route = "vendor-categories.show";
	private $delete_route = "vendor-categories.destroy";
	
	private $msg_created = "vendor Category added successfully.";
	private $msg_updated = "vendor Category updated successfully.";
	private $msg_deleted = "vendor Category deleted successfully.";
	private $msg_not_found = "vendor Category not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Category name";
	
	private $list_permission = "vendor-categories-listing";
	private $add_permission = "vendor-categories-add";
	private $edit_permission = "vendor-categories-edit";
	private $view_permission = "vendor-categories-view";
	private $status_permission = "vendor-categories-status";
	private $delete_permission = "vendor-categories-delete";
	
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Vendor Categories. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Vendor Category. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Vendor Category. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Vendor Category details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Vendor Category. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Vendor Category. Please Contact Administrator.";
	
	
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
			$records = SvcVendorCategory::select(['id'])->where('id', '>=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view($this->views_path.'.listing', compact('records_exists','vendors_array'));
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
			if($Auth_User->user_type == 'admin') {
				return  $this->admin_datatable($request);
			}
			elseif($Auth_User->user_type == 'vendor') {
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
		
		$Records = SvcVendorCategory::leftjoin('svc_categories','svc_vendor_categories.cat_id','=','svc_categories.id')
			->leftjoin('svc_vendors','svc_vendor_categories.vend_id','=','svc_vendors.id')
			->select(['svc_vendors.id as vend_id','svc_vendors.name as vendor_name',
				'svc_vendor_categories.*','svc_categories.id as cat_id', 'svc_vendor_categories.status as svc_vendor_categories_status',
				'svc_categories.title as categories_title', 'svc_categories.ar_title as categories_ar_title', 'svc_categories.status']);
		
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				
				if ($request->has('vendor_id') && $request->get('vendor_id') != -1)
				{
					$query->where('svc_vendor_categories.vend_id', '=', "{$request->get('vendor_id')}");
				}
				
				if ($request->has('title') && !empty($request->title))
				{
					$query->where('svc_categories.title', 'like', "%{$request->get('title')}%");
				}
				
				if ($request->has('ar_title') && !empty($request->ar_title))
				{
					$query->where('svc_categories.ar_title', 'like', "%{$request->get('ar_title')}%");
				}
				
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('svc_vendor_categories.status', '=', "{$request->get('status')}");
				}
				
				
			})
			
			->addColumn('status', function ($Records) {
				$record_id = $Records->id;
				$status = $Records->svc_vendor_categories_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
				{
					if($status == 1)
					{
						$str = '<a href="'.route('svc_vendor_categories_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Vendor Categories Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					}
					else
					{
						$str = '<a href="'.route('svc_vendor_categories_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Vendor Categories Active">
                        <span class="fa fa-power-off"></span> Inactive
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
				$cat_id = $Records->cat_id;
				$vend_id = $Records->vend_id;
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
					$attributes = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$vend_id)->first();
					
					if($attributes != null && $attributes->attributes != null) {
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
							Manage Attributes
							</a>';
					}
					
				}
				
				if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
				{
					
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
														<strong>[ '.$Records->categories_title.' ]</strong>
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
				
				
				/*$attribute_count = SvcAttribute::where('attributable_id',$cat_id)->where('attributable_type','App/Models/SvcCategory')->count();

				if($attribute_count > 0){
					$str.= ' <a class="btn btn-outline-primary" href="'.route($this->manage_attributes_route,[$vend_id, $cat_id ] ).'">
								Manage Attributes
								</a>';
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
	
	public function vendor_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		$vend_id=$Auth_User->vend_id;
		
		$Records = SvcVendorCategory::leftjoin('svc_categories','svc_vendor_categories.cat_id','=','svc_categories.id')
			->select(['svc_vendor_categories.*','svc_categories.id as cat_id', 'svc_vendor_categories.status as svc_vendor_categories_status',
				'svc_categories.title as categories_title', 'svc_categories.ar_title as categories_ar_title', 'svc_categories.status'])
			->where('svc_vendor_categories.vend_id', '=', $vend_id);
		
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				
				if ($request->has('title') && !empty($request->title))
				{
					$query->where('svc_categories.title', 'like', "%{$request->get('title')}%");
				}
				
				if ($request->has('ar_title') && !empty($request->ar_title))
				{
					$query->where('svc_categories.ar_title', 'like', "%{$request->get('ar_title')}%");
				}
				
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('svc_vendor_categories.status', '=', "{$request->get('status')}");
				}
				
				
			})
			
			->addColumn('status', function ($Records) {
				$record_id = $Records->id;
				$status = $Records->svc_vendor_categories_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
				{
					if($status == 1)
					{
						$str = '<a href="'.route('svc_vendor_categories_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Vendor Categories Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					}
					else
					{
						$str = '<a href="'.route('svc_vendor_categories_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Vendor Categories Active">
                        <span class="fa fa-power-off"></span> Inactive
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
				$cat_id = $Records->cat_id;
				$vend_id = $Records->vend_id;
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
					$attributes = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$vend_id)->first();
					
					if($attributes != null && $attributes->attributes != null) {
						$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
							Manage Attributes
							</a>';
					}
					
				}
				
				if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
				{
					
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
														<strong>[ '.$Records->categories_title.' ]</strong>
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
				
				
				/*$attribute_count = SvcAttribute::where('attributable_id',$cat_id)->where('attributable_type','App/Models/SvcCategory')->count();

				if($attribute_count > 0){
					$str.= ' <a class="btn btn-outline-primary" href="'.route($this->manage_attributes_route,[$vend_id, $cat_id ] ).'">
								Manage Attributes
								</a>';
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
			$records = SvcVendorCategory::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
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
			$vend_id = $Auth_User->vend_id;
			
			$vendors_array = SvcVendor::select(['name','id'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			$AllCategories = SvcCategory::select(['title','id'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('title', 'asc')->pluck('title','id');
			
			return view($this->views_path.'.create',compact('vendors_array', 'AllCategories', 'vend_id'));
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
			]);
			
			$vend_id = get_auth_vend_id($request, $Auth_User);
			$cat_id = $request->cat_id;
			
			//attributes assigning portion
			{
				$attributes = SvcAttribute::where('attributable_id', $cat_id)->where('attributable_type', 'App/Models/SvcCategory')->get();
				$options_array = array();
				
				foreach ($attributes as $attribute) {
					$attributes_options = SvcAttributeOption::where('attributable_id', $attribute->id)->get();
					foreach ($attributes_options as $attributes_option) {
						$options = array();
						$options['name'] = $attributes_option->name;
						$options['num_field'] = $attributes_option->num_field;
						$options['text_field'] = $attributes_option->text_field;
						
						$options_array[] = $options;
					}
				}
				$attributes_count = count($options_array);
				
				$attribute_array = array();
				
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
			}
			
			$_exist = 0;
			$Vendor_categories = SvcVendorCategory::where(['vend_id' => $vend_id, 'cat_id' => $cat_id])->get();
			foreach($Vendor_categories as $category)
			{
				$vend_cat_id = $category->id;
				
				$Model_Data = SvcVendorCategory::find($vend_cat_id);
				$Model_Data->status = 1;
				$Model_Data->attributes = $attribute_array;
				$Model_Data->save();
				
				$_exist = 1;
			}
			if ($_exist == 0)
			{
				
				$Model_Data = new SvcVendorCategory();
				$Model_Data->vend_id = $vend_id;
				$Model_Data->cat_id = $cat_id;
				$Model_Data->attributes = $attribute_array;
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
			$Model_Data = SvcVendorCategory::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$cat_id = $Model_Data->cat_id;
			$vend_id = $Model_Data->vend_id;
			
			$cat_name = get_category_name($cat_id);
			$vend_name = get_vendor_name($vend_id);
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$prices_array = array();
			$values_array = array();
			
			$attributes = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$vend_id)->first();
			
			if($attributes != null && $attributes->attributes != null) {
				$records_exists = 1;
				$attributes = $attributes->attributes;
				
				$attributes = json_decode($attributes);
				
				$prices_array = $attributes->prices;
				$values_array = $attributes->values;
				
				$attributes_count = count($prices_array);
			}
			
			$attributes = SvcAttribute::where('attributable_id',$cat_id)->where('attributable_type','App/Models/SvcCategory')->get();
			
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
			
			return view($this->views_path.'.show', compact('records_exists','Model_Data','cat_name','vend_name','vend_id','cat_id','options_array','values_array','prices_array','attributes_count'));
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
			$Model_Data = SvcVendorCategory::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$cat_id = $Model_Data->cat_id;
			$vend_id = $Model_Data->vend_id;
			
			$cat_name = get_category_name($cat_id);
			$vend_name = get_vendor_name($vend_id);
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$prices_array = array();
			$values_array = array();
			
			$attributes = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$vend_id)->first();
			
			if($attributes != null && $attributes->attributes != null) {
				$records_exists = 1;
				$attributes = $attributes->attributes;
				
				$attributes = json_decode($attributes);
				
				$prices_array = $attributes->prices;
				$values_array = $attributes->values;
				
				$attributes_count = count($prices_array);
			}
			
			$attributes = SvcAttribute::where('attributable_id',$cat_id)->where('attributable_type','App/Models/SvcCategory')->get();
			
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
			
			return view($this->views_path.'.edit', compact('records_exists','Model_Data','cat_name','vend_name','vend_id','cat_id','options_array','values_array','prices_array','attributes_count'));
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
			$Model_Data = SvcVendorCategory::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$cat_id = $Model_Data->cat_id;
			$vend_id = $Model_Data->vend_id;
			
			$cat_name = get_category_name($cat_id);
			$vend_name = get_vendor_name($vend_id);
			
			$options_array = array();
			$attribute_array = array();
			
			$records_exists = 0;
			$attributes_count = 0;
			
			$attributes = SvcAttribute::where('attributable_id',$cat_id)->where('attributable_type','App/Models/SvcCategory')->get();
			
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
			
			$Model_Data = SvcVendorCategory::where('cat_id',$cat_id)->where('vend_id',$vend_id)->first();
			
			$Model_Data->attributes = $attribute_array;
			
			$Model_Data->save();
			
			return view($this->views_path.'.edit', compact('records_exists','Model_Data','vend_id','cat_id','vend_name','cat_name', 'options_array','values_array','prices_array','attributes_count'));
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
			$Model_Data = SvcVendorCategory::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Category made Active successfully.');
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
			$Model_Data = SvcVendorCategory::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Category made InActive successfully.');
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
			$Model_Data = SvcVendorCategory::find($id);

			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
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

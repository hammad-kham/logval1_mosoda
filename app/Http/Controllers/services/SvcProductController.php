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

use App\Models\OccasionType;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;

use App\Models\SvcVendor;
use App\Models\SvcProduct;
use App\Models\SvcOrder;

class SvcProductController extends Controller
{
	private $uploads_path = "uploads/svc/products";
	private $uploads_root = "uploads";
	
	private $views_path = "svc.vendors.products";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "products.index";
	private $create_route = "products.create";
	private $edit_route = "products.edit";
	private $view_route = "products.show";
	private $delete_route = "products.destroy";
	
	private $msg_created = "Product added successfully.";
	private $msg_updated = "Product updated successfully.";
	private $msg_deleted = "Product deleted successfully.";
	private $msg_not_found = "Product not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Product name";
	
	private $list_permission = "vendor-products-listing";
	private $add_permission = "vendor-products-add";
	private $edit_permission = "vendor-products-edit";
	private $view_permission = "vendor-products-view";
	private $status_permission = "vendor-products-status";
	private $delete_permission = "vendor-products-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of products. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add products. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update products. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View product details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of products. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete products. Please Contact Administrator.";
	
	
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
			
			$records = SvcProduct::select(['id'])
				->where('id', '>=', 1)
				->limit(1)->get();
			
			foreach ($records as $record) {
				$records_exists = 1;
			}
			
			$product_array = SvcProduct::select(['id', 'name', 'description', 'image'])
				->where('id', '>=', 1)
				->limit(1)->get();
			
			$category = SvcCategory::select(['id', 'title'])
				->where('id', '>=', 1)
				->where('status', '=', 1)
				->orderby('title', 'asc')
				->pluck('title', 'id');
			
			$sub_category = SvcSubCategory::select(['id', 'title'])
				->where('id', '>=', 1)
				->where('status', '=', 1)
				->orderby('title', 'asc')
				->pluck('title', 'id');
			
			$vendors = SvcVendor::select(['id', 'name'])
				->where('id', '>=', 1)
				->where('status', '=', 1)
				->orderby('name', 'asc')
				->pluck('name', 'id');
			
			return view($this->views_path . '.listing', compact('records_exists', 'product_array', 'category', 'sub_category', 'vendors'));
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
			
			if ($Auth_User->user_type == 'admin') {
				return $this->admin_datatable($request);
			} elseif ($Auth_User->user_type == 'vendor') {
				return $this->vendor_datatable($request);
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
		$vend_id = $Auth_User->vend_id;
		
		$Records = SvcProduct::leftjoin('svc_categories', 'svc_products.cat_id', '=', 'svc_categories.id')
			->leftjoin('svc_sub_categories', 'svc_products.sub_cat_id', '=', 'svc_sub_categories.id')
			->leftjoin('svc_vendors', 'svc_products.vend_id', '=', 'svc_vendors.id')
			->select(['svc_products.id as product_id', 'svc_products.name as product_name', 'svc_products.description as product_description',
				'svc_products.cat_id', 'svc_products.sub_cat_id', 'svc_products.vend_id',
				'svc_products.image as product_image', 'svc_products.status as product_status',
				'svc_categories.id as categories_id', 'svc_categories.title as categories_title',
				'svc_sub_categories.id as sub_categories_id', 'svc_sub_categories.title as sub_categories_title',
				'svc_vendors.id as vendor_id', 'svc_vendors.name as vendor_name']);
		
		$response = Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('name') && !empty($request->name)) {
					$query->where('svc_products.name', 'like', "%{$request->get('name')}%");
				}
				if ($request->has('vend_id') && $request->get('vend_id') != -1) {
					$query->where('svc_vendors.id', '=', "{$request->get('vend_id')}");
				}
				if ($request->has('cat_id') && !empty($request->cat_id))
				{
					$query->where('svc_categories.title', 'like', "%{$request->get('cat_id')}%");
				}
				if ($request->has('sub_cat_id') && !empty($request->sub_cat_id))
				{
					$query->where('svc_sub_categories.title', 'like', "%{$request->get('sub_cat_id')}%");
				}
				if ($request->has('status') && $request->get('status') != -1) {
					$query->where('svc_products.status', '=', "{$request->get('status')}");
				}
			})
			
			->addColumn('product_status', function ($Records) {
				$record_id = $Records->product_id;
				$status = $Records->product_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
					if ($status == 1) {
						$str = '<a href="' . route('svc_products_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Product Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					} else {
						$str = '<a href="' . route('svc_products_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Product Active">
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
				$record_id = $Records->product_id;
				$Auth_User = Auth::user();
				
				$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
				
				if ($Auth_User->can($this->view_permission) || $Auth_User->can('all')) {
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
				}
				
				if ($Auth_User->can($this->edit_permission) || $Auth_User->can('all')) {
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';
				}
				
				if ($Auth_User->can($this->delete_permission) || $Auth_User->can('all')) {
					/*$str .= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-' . $record_id . '" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
								<i class="fa fa-trash"></i>
								</a>';*/
					
					/*$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
								<i class="fa fa-trash"></i>
								</a>';

					{
						$str .= '<div id="m-' . $record_id . '" class="modal fade" data-backdrop="true">
										<div class="modal-dialog" id="animate">
											<div class="modal-content">
												<form action="' . route($this->delete_route, $record_id) . '" method="POST">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="' . csrf_token() . '">
												<div class="modal-header">
													<h5 class="modal-title">Confirm delete following record</h5>
												</div>
												<div class="modal-body text-center p-lg">
													<p>
														Are you sure to delete this record?
														<br>
														<strong>[ ' . $Records->product_name . ' ]</strong>
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
				
				$str .= "</div>";
				return $str;
				
			})
			->rawColumns(['title', 'product_status', 'action'])
			->setRowId(function ($Records) {
				return 'myDtRow' . $Records->product_id;
			})
			->make(true);
		return $response;
		
	}
	
	public function vendor_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		$vend_id = $Auth_User->vend_id;
		
		$Records = SvcProduct::leftjoin('svc_categories', 'svc_products.cat_id', '=', 'svc_categories.id')
			->leftjoin('svc_sub_categories', 'svc_products.sub_cat_id', '=', 'svc_sub_categories.id')
			->select(['svc_products.id as product_id', 'svc_products.name as product_name', 'svc_products.description as product_description',
				'svc_products.cat_id', 'svc_products.sub_cat_id', 'svc_products.vend_id',
				'svc_products.image as product_image', 'svc_products.status as product_status',
				'svc_categories.id as categories_id', 'svc_categories.title as categories_title',
				'svc_sub_categories.id as sub_categories_id', 'svc_sub_categories.title as sub_categories_title'])
			->where('svc_products.vend_id', '=', $vend_id);
		
		$response = Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('name') && !empty($request->name)) {
					$query->where('svc_products.name', 'like', "%{$request->get('name')}%");
				}
				if ($request->has('cat_id') && !empty($request->cat_id))
				{
					$query->where('svc_categories.title', 'like', "%{$request->get('cat_id')}%");
				}
				if ($request->has('sub_cat_id') && !empty($request->sub_cat_id))
				{
					$query->where('svc_sub_categories.title', 'like', "%{$request->get('sub_cat_id')}%");
				}
				if ($request->has('status') && $request->get('status') != -1) {
					$query->where('svc_products.status', '=', "{$request->get('status')}");
				}
			})
			
			->addColumn('product_status', function ($Records) {
				$record_id = $Records->product_id;
				$status = $Records->product_status;
				$Auth_User = Auth::user();
				
				$str = '';
				if ($Auth_User->can($this->status_permission) || $Auth_User->can('all')) {
					if ($status == 1) {
						$str = '<a href="' . route('svc_products_deactivate', $record_id) . '" class="btn btn-success btn-sm"  title="Make Product Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
					} else {
						$str = '<a href="' . route('svc_products_activate', $record_id) . '" class="btn btn-danger btn-sm" title="Make Product Active">
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
				$record_id = $Records->product_id;
				$Auth_User = Auth::user();
				
				$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
				
				if ($Auth_User->can($this->view_permission) || $Auth_User->can('all')) {
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->view_route, $record_id) . '" title="View Details">
						<i class="fa fa-eye"></i>
						</a>';
				}
				
				if ($Auth_User->can($this->edit_permission) || $Auth_User->can('all')) {
					$str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
						<i class="fa fa-edit"></i>
						</a>';
				}
				
				if ($Auth_User->can($this->delete_permission) || $Auth_User->can('all')) {
					/*$str .= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-' . $record_id . '" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
								<i class="fa fa-trash"></i>
								</a>';*/
					
					/*$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
								<i class="fa fa-trash"></i>
								</a>';

					{
						$str .= '<div id="m-' . $record_id . '" class="modal fade" data-backdrop="true">
										<div class="modal-dialog" id="animate">
											<div class="modal-content">
												<form action="' . route($this->delete_route, $record_id) . '" method="POST">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="' . csrf_token() . '">
												<div class="modal-header">
													<h5 class="modal-title">Confirm delete following record</h5>
												</div>
												<div class="modal-body text-center p-lg">
													<p>
														Are you sure to delete this record?
														<br>
														<strong>[ ' . $Records->product_name . ' ]</strong>
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
				
				$str .= "</div>";
				return $str;
				
			})
			->rawColumns(['title', 'product_status', 'action'])
			->setRowId(function ($Records) {
				return 'myDtRow' . $Records->product_id;
			})
			->make(true);
		return $response;
		
	}
	
	public function is_not_authorized($id, $Auth_User)
	{
		$bool = 1;
		if ($Auth_User->user_type == 'admin') {
			$bool = 0;
		} else {
			$vend_id = $Auth_User->vend_id;
			$records = SvcProduct::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
			foreach ($records as $record) {
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
			$vendor = SvcVendor::select(['id', 'name'])
				->where('id', '>=', 1)
				->where('status', '=', 1)
				->orderby('name', 'asc')
				->pluck('name', 'id');
			
			$menus = '';
			if ($Auth_User->user_type == 'admin') {
				$vend_id = $Auth_User->vend_id;
			}
			$categories = SvcCategory::where('id',2)->pluck('title','id');
			$sub_categories = SvcSubCategory::where('cat_id',2)->pluck('title','id');
			
			$occasion_types = OccasionType::select(['id','title'])->where('id', '>=', 1)->where('status', 1)->orderby('title', 'asc')->pluck('title','id');
			
			return view($this->views_path . '.create', compact('vendor', 'occasion_types', 'categories', 'sub_categories'));
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
				'description' => 'required',
				'cat_id' => 'required',
				'sub_cat_id' => 'required',
				'vend_id' => 'required',
				'price' => 'required',
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
			]);
			
			$category_id = $request->get('cat_id');
			$sub_category_id = $request->get('sub_cat_id');
			$vendor_id = $request->get('vend_id');
			
			$occasion_types = $request->get('occasion_types');
			
			$ocassions = '';
			foreach($occasion_types as $type)
			{
				if($ocassions == ''){
					$ocassions = "(".$type.")";
				}
				else{
					$ocassions = $ocassions.",(".$type.")";
				}
			}
			
			$Model_Data = new SvcProduct();
			
			$Model_Data->name = $request->name;
			$Model_Data->description = $request->description;
			$Model_Data->cat_id = $category_id;
			$Model_Data->sub_cat_id = $sub_category_id;
			$Model_Data->vend_id = $vendor_id;
			
			$image = '';
			
			if (isset($request->image) && $request->image != null) {
				$file_uploaded = $request->file('image');
				$image = date('YmdHis') . "." . $file_uploaded->getClientOriginalExtension();
				
				$uploads_path = $this->uploads_path;
				
				if (!is_dir($uploads_path)) {
					mkdir($uploads_path);
					$uploads_root = $this->uploads_root;
					$src_file = $uploads_root . "/index.html";
					$dest_file = $uploads_path . "/index.html";
					copy($src_file, $dest_file);
				}
				
				$file_uploaded->move($this->uploads_path, $image);
			}
			
			$Model_Data->image = $image;
			$Model_Data->occasion_type = $ocassions;
			$Model_Data->price = $request->price;
			$Model_Data->status = 1;
			$Model_Data->created_by = $Auth_User->id;
			
			$Model_Data->save();
			
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
			$Model_Data = SvcProduct::find($id);
			
			$created_by = User::find($Model_Data->created_by);
			
			$updated_by = User::find($Model_Data->updated_by);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$category_id = $Model_Data->cat_id;
			
			$ocassion_types = $Model_Data->occasion_type;
			
			$ocassion_types = explode(',',$ocassion_types);
			$occasions = '';
			foreach($ocassion_types as $ocassion_type){
				$ocassion_type = ltrim(rtrim($ocassion_type,")"),"(");
				$ocassion_type = OccasionType::find($ocassion_type);
				
				if($occasions == ''){
					$occasions = $ocassion_type->title;
				}
				else{
					$occasions = $occasions.", ".$ocassion_type->title;
				}
			}
			
			$category_data = SvcCategory::find($category_id);
			
			$sub_category_id = $Model_Data->sub_cat_id;
			
			$sub_category_data = SvcSubCategory::find($sub_category_id);
			
			$vendor_id = $Model_Data->vend_id;
			
			$vendor_data = SvcVendor::find($vendor_id);
			
			return view($this->views_path . '.show', compact('Model_Data', 'category_data', 'sub_category_data', 'vendor_data', 'created_by', 'updated_by', 'occasions'));
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
			$Model_Data = SvcProduct::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$occasions = $Model_Data->occasion_type;
			
			$occasions = explode(',',$occasions);
			
			$occassions = array();
			$select_occasions = "";
			
			foreach($occasions as $occasion_type){
				
				$occasion_type = ltrim(rtrim($occasion_type,")"),"(");
				if($select_occasions == ""){
					$select_occasions = $occasion_type;
				}
				else{
					$select_occasions = $select_occasions.",".$occasion_type;
				}
				
				$occasion = OccasionType::find($occasion_type);
				
				$occasions = $occasion->title;
				$occassions[$occasion_type] = $occasions;
				
			}
			
			$occasion_types = OccasionType::select(['id','title'])->where('id', '>=', 1)->where('status', 1)->orderby('title', 'asc')->pluck('title','id');
			
			//category
			$category_id = $Model_Data->cat_id;
			
			$category_data = SvcCategory::find($category_id);
			
			//sub category
			$sub_category_id = $Model_Data->sub_cat_id;
			
			$sub_category_data = SvcSubCategory::find($sub_category_id);
			
			//vendor
			$vendor_id = $Model_Data->vend_id;
			
			$vendor_data = SvcVendor::find($vendor_id);
			
			return view($this->views_path . '.edit', compact('Model_Data', 'vendor_data', 'category_data', 'sub_category_data', 'occasion_types', 'occassions', 'select_occasions'));
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
			$Auth_User = Auth::user();
			
			$request->validate([
				'name' => 'required',
				'description' => 'required',
			]);
			
			$Model_Data = SvcProduct::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$occasion_types = $request->get('occasion_types');
			
			
			
			$ocassions = '';
			foreach($occasion_types as $type)
			{
				if($ocassions == ''){
					$ocassions = "(".$type.")";
				}
				else{
					$ocassions = $ocassions.",(".$type.")";
				}
			}
			
			$image = $Model_Data->image;
			$uploads_path = $this->uploads_path;
			if ($request->hasfile('image') && $request->image != null) {
				$file_uploaded = $request->file('image');
				$image = date('YmdHis') . "." . $file_uploaded->getClientOriginalExtension();
				$file_uploaded->move($uploads_path, $image);
				
				if ($Model_Data->image != "") {
					File::delete($uploads_path . "/" . $Model_Data->image);
				}
			}
			$Model_Data->image = ltrim(rtrim($image));
			
			$Model_Data->name = $request->name;
			$Model_Data->description = $request->description;
			$Model_Data->price = $request->price;
			$Model_Data->occasion_type = $ocassions;
			
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->update();
			
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
			$Model_Data = SvcProduct::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Product made Active successfully.');
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
			$Model_Data = SvcProduct::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User)) {
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Product made InActive successfully.');
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
			$Model_Data = SvcProduct::find($id);

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

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

use App\Models\SvcBrand;
use App\Models\SvcBrandOption;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;

class SvcSubCategoryController extends Controller
{
    private $uploads_root = "uploads/svc";
    private $uploads_path = "uploads/svc/sub_categories/";

    private $views_path = "svc.sub_categories";

    private $dashboard_route = "dashboard";

    private $home_route = "sub-categories.index";
    private $create_route = "sub-categories.create";
    private $edit_route = "sub-categories.edit";
    private $view_route = "sub-categories.show";
    private $delete_route = "sub-categories.destroy";
    private $attribute_edit_route = "sub-categories.attribute_edit";

    private $msg_created = "Sub-category created successfully.";
    private $msg_updated = "Sub-category updated successfully.";
    private $msg_deleted = "Sub-category deleted successfully.";
    private $msg_not_found = "SubCategory not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same SvcSubCategory name";

    private $msg_created_brand_option = "Brand Created successfully.";
	private $duplicate_brand_option_error_message = "Cannot Create Multiple Brand Options With Same Name.";
	
    private $msg_created_attribute = "Attribute Created successfully.";
    private $msg_edited_attribute = "Attribute Edited successfully.";
    private $msg_created_attribute_option = "Attribute Option Created Successfully.";
    private $duplicate_attribute_error_message = "Cannot Create Multiple Attributes With Same Name.";
    private $duplicate_attribute_option_error_message = "Cannot Create Multiple Attribute Options With Same Name.";

    private $list_permission = "sub-categories-listing";
    private $add_permission = "sub-categories-add";
    private $edit_permission = "sub-categories-edit";
    private $view_permission = "sub-categories-view";
    private $status_permission = "sub-categories-status";
    private $delete_permission = "sub-categories-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Sub Categories. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Sub Category. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Sub Category. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Sub Category details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Sub Category. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Sub Category. Please Contact Administrator.";
	
	
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
            $categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

            $records_exists = 0;
            $records = SvcSubCategory::select(['id'])->where('id', '>=', 1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists", "categories_array"));
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
            $Records = SvcSubCategory::leftJoin('svc_categories', 'svc_sub_categories.cat_id', '=', 'svc_categories.id')
                ->select(['svc_sub_categories.id', 'svc_sub_categories.cat_id', 'svc_sub_categories.title', 'svc_sub_categories.ar_title', 'svc_sub_categories.status', 'svc_categories.title as cat_name']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('svc_sub_categories.title', 'like', "%{$request->get('title')}%");
                    }
                    if ($request->has('ar_title') && !empty($request->ar_title))
                    {
                        $query->where('svc_sub_categories.ar_title', 'like', "%{$request->get('ar_title')}%");
                    }
                    if ($request->has('cat_id') && !empty($request->cat_id) && $request->get('cat_id') != -1)
                    {
                        $query->where('svc_sub_categories.cat_id', '=', "{$request->get('cat_id')}");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('svc_sub_categories.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('cat_id', function ($Records) {
                    $record_id = $Records->cat_id;
                    $title = $Records->cat_name;

                    return  $title;
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
                            $str = '<a href="'.route('svc_sub_categories_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Sub Category Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('svc_sub_categories_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Sub Category Active">
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
                ->rawColumns(['title','cat_id','status','action'])
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
            $categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->where('status', 1)->orderby('title', 'asc')->pluck('title','id');

            $types_array = array();
            $types_array[0] = "Fixed Price";
            $types_array[1] = "Get a Quote";

            return view($this->views_path.'.create', compact("categories_array", "types_array"));
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
                'cat_id' => 'required',
                'type' => 'required',
                'title' => 'required',
                'description' => 'required',
                'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ]);

            $image = '';
            if (isset($request->icon) && $request->icon != null)
            {
                $file_uploaded = $request->file('icon');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

                $uploads_path = $this->uploads_path;
                if(!is_dir($uploads_path))
                {
                    mkdir($uploads_path);
                    $uploads_root = $this->uploads_root;
                    $src_file = $uploads_root."/index.html";
                    $dest_file = $uploads_path."/index.html";
                    copy($src_file,$dest_file);
                }

                $file_uploaded->move($this->uploads_path, $image);
            }

            $Model_Data = new SvcSubCategory();

            $Model_Data->cat_id = $request->cat_id;
            $Model_Data->type = $request->type;
            $Model_Data->title = $request->title;
            $Model_Data->ar_title = $request->title;
            $Model_Data->description = $request->description;
            $Model_Data->ar_description = $request->description;
            $Model_Data->icon = ltrim(rtrim($image));

            $Model_Data->created_by = Auth::user()->id;
            $Model_Data->save();

            SvcCategory::where("id", $request->cat_id)->update(["has_subcategories" => 1]);

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
            $Model_Data = SvcSubCategory::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $options_array = array();
            $attributes = array();

            $attributes = SvcAttribute::where('attributable_id',$id)->where('attributable_type','App/Models/SvcSubCategory')->get();

            foreach ($attributes as $attribute){
                $options_sub_array = array();
                $attributes_options = array();
                $attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();

                foreach ($attributes_options as $attributes_option){
                    $options = array();
                    $options['id'] = $attributes_option->id;
                    $options['attributable_id'] = $attributes_option->attributable_id;
                    $options['name'] = $attributes_option->name;
                    $options['num_field'] = $attributes_option->num_field;
                    $options['text_field'] = $attributes_option->text_field;

                    $options_sub_array[] = $options;
                }

                $options_array[$attributes_option->attributable_id] = $options_sub_array;

            }
	
			
	        $brand_options_array = array();
	        $brands = array();
	
	        $brands = SvcBrand::where('ref_id',$id)->where('ref_type','App/Models/SvcSubCategory')->get();
	
	        foreach ($brands as $brand){
		        $options_sub_array = array();
		        $attributes_options = array();
		        $attributes_options = SvcBrandOption::where('brand_id',$brand->id)->get();
		
		        foreach ($attributes_options as $attributes_option){
			        $options = array();
			        $options['id'] = $attributes_option->id;
			        $options['brand_id'] = $attributes_option->brand_id;
			        $options['name'] = $attributes_option->name;
			
			        $options_sub_array[] = $options;
		        }
		
		        $brand_options_array[$attributes_option->brand_id] = $options_sub_array;
		
	        }

            $categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

            return view($this->views_path.'.show', compact("Model_Data", "categories_array", "attributes", "options_array", "brands", "brand_options_array"));
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
            $Model_Data = SvcSubCategory::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

            $types_array = array();
            $types_array[0] = "Fixed Price";
            $types_array[1] = "Get a Quote";

            $options_array = array();
            $attributes = array();

            $attributes = SvcAttribute::where('attributable_id',$id)->where('attributable_type','App/Models/SvcSubCategory')->get();

            foreach ($attributes as $attribute){
                $options_sub_array = array();
                $attributes_options = array();
                $attributes_options = SvcAttributeOption::where('attributable_id',$attribute->id)->get();

                foreach ($attributes_options as $attributes_option){
                    $options = array();
                    $options['id'] = $attributes_option->id;
                    $options['attributable_id'] = $attributes_option->attributable_id;
                    $options['name'] = $attributes_option->name;
                    $options['num_field'] = $attributes_option->num_field;
                    $options['text_field'] = $attributes_option->text_field;

                    $options_sub_array[] = $options;
                }

                $options_array[$attributes_option->attributable_id] = $options_sub_array;

            }
	
	        $brand_options_array = array();
	        $brands = array();
	
	        $brands = SvcBrand::where('ref_id',$id)->where('ref_type','App/Models/SvcSubCategory')->get();
	
	        foreach ($brands as $brand){
		        $options_sub_array = array();
		        $attributes_options = array();
		        $attributes_options = SvcBrandOption::where('brand_id',$brand->id)->get();
		
		        foreach ($attributes_options as $attributes_option){
			        $options = array();
			        $options['id'] = $attributes_option->id;
			        $options['brand_id'] = $attributes_option->brand_id;
			        $options['name'] = $attributes_option->name;
			
			        $options_sub_array[] = $options;
		        }
		
		        $brand_options_array[$attributes_option->brand_id] = $options_sub_array;
		
	        }

            return view($this->views_path.'.edit', compact("Model_Data", "categories_array", "types_array", "attributes", "options_array", "brands", "brand_options_array"));
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
            $Model_Data = SvcSubCategory::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $image = $Model_Data->icon;
            $uploads_path = $this->uploads_path;
            if($request->hasfile('icon') && $request->icon != null)
            {
                $file_uploaded = $request->file('icon');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();
                $file_uploaded->move($uploads_path, $image);

                if ($Model_Data->icon != "") {
                    File::delete($uploads_path."/".$Model_Data->icon);
                }
            }

            $Model_Data->cat_id = $request->cat_id;
            $Model_Data->type = $request->type;
            $Model_Data->title = $request->title;
            $Model_Data->ar_title = $request->ar_title;
            $Model_Data->description = $request->description;
            $Model_Data->ar_description = $request->ar_description;
            $Model_Data->icon = ltrim(rtrim($image));

            $Model_Data->updated_by = Auth::user()->id;
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

    public function editAttribute($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $Model_Data = SvcAttribute::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $options_array = array();

            $attributes_options = SvcAttributeOption::where('attributable_id',$Model_Data->id)->get();

            foreach ($attributes_options as $attributes_option){
                $options = array();
                $options['id'] = $attributes_option->id;
                $options['attributable_id'] = $attributes_option->attributable_id;
                $options['name'] = $attributes_option->name;
                $options['num_field'] = $attributes_option->num_field;
                $options['text_field'] = $attributes_option->text_field;
                $options['is_mandatory'] = $attributes_option->is_mandatory;

                $options_array[] = $options;
            }


            return view($this->views_path.'.attribute_edit', compact("Model_Data", "options_array"));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function editBrand($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $Model_Data = SvcBrand::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $options_array = array();

            $attributes_options = SvcBrandOption::where('brand_id',$Model_Data->id)->get();

            foreach ($attributes_options as $attributes_option){
                $options = array();
                $options['id'] = $attributes_option->id;
                $options['brand_id'] = $attributes_option->attributable_id;
                $options['name'] = $attributes_option->name;

                $options_array[] = $options;
            }


            return view($this->views_path.'.brand_edit', compact("Model_Data", "options_array"));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }
	
	public function storeBrandOption(Request $request)
	{
		$Auth_User = Auth::user();
		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{

			$brand_id = $request->brand_id;
			$name = $request->name;

			$duplicate_count = SvcBrandOption::where('name',$name)->where('brand_id',$brand_id)->count();
			if($duplicate_count > 0){
				Flash::error($this->duplicate_brand_option_error_message);
				return redirect()->route('edit_svc_subcat_brand',$brand_id);
			}

			$Model_data = new SvcBrandOption();

			$Model_data->brand_id = $brand_id;
			$Model_data->name = $name;

			$Model_data->save();



			Flash::success($this->msg_created_brand_option);
			return redirect()->route('edit_svc_subcat_brand',$brand_id);
		}
		else
		{
			Flash::error($this->add_permission_error_message);
			return redirect()->route($this->home_route);
		}
	}

    public function storeAttribute(Request $request)
    {
        return redirect()->route($this->home_route);

        /*$Auth_User = Auth::user();
        if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
        {

            $name = $request->attribute_name;
            $attributable_type = 'App/Models/SvcSubCategory';
            $sub_cat_id = $request->sub_cat_id;

            $names = $request->name;
            $type = $request->type;
            $options_count = count($names);

            $hasDuplicates = count($names) > count(array_unique($names));
            if($hasDuplicates){
                Flash::error($this->duplicate_attribute_option_error_message);
                return redirect()->route($this->edit_route,$sub_cat_id);
            }
            $duplicate_count = 0;
            $duplicate_count = SvcAttribute::where('name',$name)->where('attributable_id',$sub_cat_id)->where('attributable_type',$attributable_type)->count();
            if($duplicate_count > 0){
                Flash::error($this->duplicate_attribute_error_message);
                return redirect()->route($this->edit_route,$sub_cat_id);
            }
            if($request->has('is_mandatory')){
                $is_mandatory = 1;
            }
            else{
                $is_mandatory = 0;
            }

            $Model_data = new SvcAttribute();

            $Model_data->attributable_type = $attributable_type;
            $Model_data->attributable_id = $sub_cat_id;
            $Model_data->name = $name;
            $Model_data->input_name = createSlug($name,'_');
            $Model_data->price_status = 1;
            $Model_data->price_status = 1;

            $Model_data->save();

            $id = $Model_data->id;

            for($i=0; $i<$options_count; $i++){
                $Model_data = new SvcAttributeOption();

                $Model_data->attributable_id = $id;
                $Model_data->name = $names[$i];
                $Model_data->is_mandatory = $is_mandatory;

                if($type[$i] == 0){
                    $Model_data->num_field = 1;
                }
                elseif($type[$i] == 1){
                    $Model_data->text_field = 1;
                }

                $Model_data->save();
            }

            Flash::success($this->msg_created_attribute);
            return redirect()->route($this->edit_route,$sub_cat_id);
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }*/
    }

    public function storeAttributeOption(Request $request)
    {
        return redirect()->route($this->home_route);

        /*$Auth_User = Auth::user();
        if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
        {

            $attribute_id = $request->attribute_id;
            $name = $request->name;
            $type = $request->type;

            $duplicate_count = SvcAttributeOption::where('name',$name)->where('attributable_id',$attribute_id)->count();
            if($duplicate_count > 0){
                Flash::error($this->duplicate_attribute_option_error_message);
                return redirect()->route('edit_svc_subcat_attribute',$attribute_id);
            }

            if($request->has('is_mandatory')){
                $is_mandatory = 1;
            }
            else{
                $is_mandatory = 0;
            }

            $Model_data = new SvcAttributeOption();

            $Model_data->attributable_id = $attribute_id;
            $Model_data->name = $name;
            $Model_data->is_mandatory = $is_mandatory;

            if($type == 0){
                $Model_data->num_field = 1;
            }
            elseif($type == 1){
                $Model_data->text_field = 1;
            }

            $Model_data->save();



            Flash::success($this->msg_created_attribute_option);
            return redirect()->route('edit_svc_subcat_attribute',$attribute_id);
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }*/
    }

    public function updateAttribute(Request $request, $id)
    {
        return redirect()->route($this->home_route);

        /*$Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {

            $Model_data = SvcAttribute::find($id);

            $Model_data->name = $request->name;

            $Model_data->save();



            Flash::success($this->msg_edited_attribute);
            return redirect()->route('edit_svc_subcat_attribute',$id);
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }*/
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

            $Model_Data = SvcSubCategory::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Sub Category made Active successfully.');
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
            $Model_Data = SvcSubCategory::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Sub Category made InActive successfully.');
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
            $Model_Data = SvcSubCategory::find($id);

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
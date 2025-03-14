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

use App\Models\AppPage;
use App\Models\SvcVendor;
use App\Models\Vendor;
use App\Models\Banner;

class BannerController extends Controller
{
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/banners/";

    private $views_path = "banners";

    private $dashboard_route = "dashboard";

    private $home_route = "banners.index";
    private $create_route = "banners.create";
    private $edit_route = "banners.edit";
    private $view_route = "banners.show";
    private $delete_route = "banners.destroy";

    private $msg_created = "Banner created successfully.";
    private $msg_updated = "Banner updated successfully.";
    private $msg_deleted = "Banner deleted successfully.";
    private $msg_not_found = "Banner not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Banner name";

    private $list_permission = "banners-listing";
    private $add_permission = "banners-add";
    private $edit_permission = "banners-edit";
    private $view_permission = "banners-view";
    private $status_permission = "banners-status";
    private $delete_permission = "banners-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Banners. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Banner. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Banner. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Banner details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Banner. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Banner. Please Contact Administrator.";
	
	
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
            $app_pages = AppPage::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
            $records = Banner::select(['id'])->where('id', '>=', 1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            return view($this->views_path.'.listing', compact("records_exists","app_pages"));
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
            $Records = Banner::leftJoin('app_pages', 'banners.topic_app_page_id','=', 'app_pages.id')
                ->select(['banners.id', 'banners.title', 'banners.ar_title', 'banners.topic_app_page_id', 'banners.status', 'app_pages.title as app_pages_title']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('title') && !empty($request->title))
                    {
                        $query->where('banners.title', 'like', "%{$request->get('title')}%");
                    }

                    if ($request->has('ar_title') && !empty($request->ar_title))
                    {
                        $query->where('banners.ar_title', 'like', "%{$request->get('ar_title')}%");
                    }

                    if ($request->has('s_app_page_id') && $request->get('s_app_page_id') != -1)
                    {
                        $query->where('banners.topic_app_page_id', '=', "{$request->get('s_app_page_id')}");
                    }

                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('banners.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('s_app_page_id', function ($Records) {
                    $title = $Records->app_pages_title;
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
                            $str = '<a href="'.route('banners_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('banners_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
            $app_pages = AppPage::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

            return view($this->views_path.'.create', compact('app_pages'));
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
                'ar_title' => 'required',
                'topic_app_page_id'=> 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $Model_Data = new Banner();

            $image = '';
            if (isset($request->image) && $request->image != null)
            {
                $file_uploaded = $request->file('image');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

				$this->create_uploads_directory();
				
                $uploads_path = $this->uploads_path;
                $file_uploaded->move($uploads_path, $image);
            }


            $Model_Data->title = $request->title;
            $Model_Data->ar_title = $request->ar_title;
            $Model_Data->topic_app_page_id = $request->topic_app_page_id ;
            $Model_Data->image = $image;

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
            $Model_Data = Banner::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $app_page_array = AppPage::select(['id','title'])->where('id', '=', $Model_Data->topic_app_page_id)->where('status', '=', 1)->orderby('title', 'asc')->pluck('title','id');


            return view($this->views_path.'.show',compact('Model_Data', 'app_page_array'));
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
            $Model_Data = Banner::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $app_pages = AppPage::select(['id','title'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('title', 'asc')->pluck('title','id');


            return view($this->views_path.'.edit',compact('Model_Data', 'app_pages'));
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
            $Model_Data = Banner::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
			
            $request->validate([
                'title' => 'required',
                'ar_title' => 'required',
                'topic_app_page_id'=> 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $image = $Model_Data->image;
            if($request->hasfile('image') && $request->image != null)
            {
                $file_uploaded = $request->file('image');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

				$this->create_uploads_directory();
				
                $uploads_path = $this->uploads_path;
                $file_uploaded->move($uploads_path, $image);

                if ($Model_Data->image != "") {
                    File::delete($uploads_path."/".$Model_Data->image);
                }
            }
            $Model_Data->image = ltrim(rtrim($image));

            $Model_Data->title = $request->title;
            $Model_Data->ar_title = $request->ar_title;
            $Model_Data->topic_app_page_id = $request->topic_app_page_id ;

			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();

            Flash::success($this->msg_updated);
            return redirect()->route($this->home_route);
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
            $Model_Data = Banner::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Banner made Active successfully.');
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
            $Model_Data = Banner::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Banner made InActive successfully.');
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
            $Model_Data = Banner::find($id);

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

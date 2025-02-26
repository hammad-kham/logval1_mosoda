<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;

use App\Models\SvcBankDetail;
use App\Models\SvcOrder;
use App\Models\SvcReview;
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

use App\Repositories\VendorRepository;

use App\Models\SvcCategory;

use App\Models\SvcVendor;
use App\Models\SvcVendorTiming;

use Illuminate\Database\Eloquent\Model;

class SvcVendorController extends Controller
{
    private $repository;

    private $uploads_root = "uploads/svc";
    private $uploads_path = "uploads/svc/vendors";
    private $qrcode_path = "uploads/svc/vendors/qrcodes";

    private $views_path = "svc.vendors";

    private $dashboard_route = "dashboard";

    private $home_route = "vendors.index";
    private $create_route = "vendors.create";
    private $edit_route = "vendors.edit";
    private $view_route = "vendors.show";
    private $delete_route = "vendors.destroy";

    private $msg_created = "Vendor added successfully.";
    private $msg_updated = "Vendor updated successfully.";
    private $msg_deleted = "Vendor deleted successfully.";
    private $msg_not_found = "Vendor not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Vendor name";

    private $list_permission = "vendors-listing";
    private $add_permission = "vendors-add";
    private $edit_permission = "vendors-edit";
    private $view_permission = "vendors-view";
    private $status_permission = "vendors-status";
    private $delete_permission = "vendors-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Vendors. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Vendor. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Vendor. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Vendor details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Vendor. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Vendor. Please Contact Administrator.";


    public function __construct(VendorRepository $vendor)
    {
        $this->repository = $vendor;
    }


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
            if($Auth_User->user_type == 'admin')
            {
                $records_exists = 0;
                $records = SvcVendor::select(['id'])->where('id', '>=', 1)->limit(1)->get();
                foreach($records as $record)
                {
                    $records_exists = 1;
                }

                return view($this->views_path.'.listing', compact("records_exists"));
            }
            elseif($Auth_User->user_type == 'vendor')
            {
                return redirect()->route($this->view_route,$Auth_User->vend_id);
            }
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
            $Records = SvcVendor::select(['svc_vendors.id', 'svc_vendors.name', 'svc_vendors.arabic_name','svc_vendors.status', 'svc_vendors.is_featured']);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('name') && !empty($request->name))
                    {
                        $query->where('svc_vendors.name', 'like', "%{$request->get('name')}%");
                    }
                    if ($request->has('ar_name') && !empty($request->ar_name))
                    {
                        $query->where('svc_vendors.arabic_name', 'like', "%{$request->get('ar_name')}%");
                    }

                    if ($request->has('phoneno') && !empty($request->phoneno))
                    {
                        $query->where('svc_vendors.phoneno', 'like', "%{$request->get('phoneno')}%");
                    }

                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('svc_vendors.status', '=', "{$request->get('status')}");
                    }

                    if ($request->has('is_featured') && $request->get('is_featured') != -1)
                    {
                        $query->where('svc_vendors.is_featured', '=', "{$request->get('is_featured')}");
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
                            $str = '<a href="'.route('vendors-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make Vendor Inactive">
                        <span class="fa fa-power-off "></span> Active
                        </a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('vendors-active',$record_id).'" class="btn btn-danger btn-sm" title="Make Vendor Active">
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
                ->addColumn('is_featured', function ($Records) {
                    $record_id = $Records->id;
                    $is_featured = $Records->is_featured;
                    $Auth_User = Auth::user();

                    $str = '';
                    if($Auth_User->user_type == 'admin' && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
                    {
                        if($is_featured == 1)
                        {
                            $str = '<a href="'.route('remove-featured-vendors',$record_id).'" class="btn btn-success btn-sm"  title="Remove from Featured">
								<span class="fa fa-power-off "></span> Featured
								</a>';
                        }
                        else
                        {
                            $str = '<a href="'.route('add-featured-vendors',$record_id).'" class="btn btn-danger btn-sm" title="Add to Featured">
								<span class="fa fa-power-off"></span> Not Featured
								</a>';
                        }
                    }
                    else
                    {
                        if($status == 1)
                        {
                            $str = '<a class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Featured
                                    </a>';
                        }
                        else
                        {
                            $str = '<a class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Not Featured
                                    </a>';
                        }
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

                    if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
                    {
                        $str .= ' <a class="btn btn-outline-primary" href="' . route($this->edit_route, $record_id) . '" title="Edit Details">
								<i class="fa fa-edit"></i>
								</a>';
                    }

                    if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
                    {
                        /*$str.= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">
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
															<strong>[ '.$Records->name.' ]</strong>
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
                ->rawColumns(['name','ar_name', 'is_open', 'status','is_featured','action'])
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
            $records = SvcVendor::select(['id'])->where('id', '=', $vend_id)->limit(1)->get();
            foreach($records as $record)
            {
                $bool = 0;
            }
        }

        return $bool;
    }

    public function get_categories_pluck_data()
    {
        $pluck = SvcCategory::select(['id','title'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('title', 'asc')->pluck('title','id');

        return $pluck;
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
                'location' => 'required',
                'phone' => 'required',
                'email' => 'required|unique:svc_vendors',
                'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ]);

            $Model_Data = new SvcVendor();

            $Model_Data->name = $request->name;
            $Model_Data->arabic_name = $request->arabic_name;
            $Model_Data->location = $request->location;
            $Model_Data->phone = $request->phone;
            $Model_Data->email = $request->email;
            $Model_Data->website = $request->website;
            $Model_Data->lat = $request->latitude;
            $Model_Data->lng = $request->lagitude;

            $image = '';
            if (isset($request->profile) && $request->profile != null)
            {
                $file_uploaded = $request->file('profile');
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
            $Model_Data->image = $image;

            $Model_Data->status = 1;
            $Model_Data->description = $request->description;
            $Model_Data->arabic_description = $request->arabic_description;

            $Model_Data->created_by = $Auth_User->id;
            $Model_Data->save();
            $id = $Model_Data->id;

            for($j=0; $j<48; $j++)
            {
                $Model_Data = new SvcVendorTiming();

                $Model_Data->vend_id = $id;

                $time = ($j * 30 * 60);
                $Model_Data->time_value = $time;

                if($time >= 32400 && $time <= 73800 ){
                    $Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 1;
                }
                else{
                    $Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 0;
                }

                $Model_Data->save();
            }

            $timestamp = now();
            $file = public_path($timestamp . 'qrcode.png');

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
            $Model_Data = SvcVendor::find($id);
            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $WorkingHours = SvcVendorTiming::where('vend_id',$id)->get();

            $BankDetail = SvcBankDetail::where('vend_id',$id)->where('status',1)->get();

            // Orders
            {
                $Orders = array();
                $Orders = SvcOrder::leftJoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id')
                    ->where(['svc_orders.vend_id' => $id])
                    ->select(['svc_orders.id'])
                    ->get();

                $UserOrders_exists = 0;
                foreach ($Orders as $Order) {
                    $UserOrders_exists = 1;
                }
            }

            // Reviews
            {
                $Reviews = array();
                $Reviews = SvcReview::leftJoin('svc_vendors', 'svc_reviews.vend_id', '=', 'svc_vendors.id')
                    ->where(['svc_reviews.vend_id' => $id])
                    ->select(['svc_reviews.id'])
                    ->get();

                $UserReviews_exists = 0;
                foreach ($Reviews as $Review) {
                    $UserReviews_exists = 1;
                }
            }

            return view($this->views_path.'.show', compact('Model_Data','BankDetail','Orders','UserOrders_exists','Reviews','UserReviews_exists','WorkingHours'));
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
            $Model_Data= SvcVendor::find($id);

            if (empty( $Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $WorkingHours = SvcVendorTiming::where('vend_id',$id)->get();

            return view($this->views_path.'.edit', compact('Model_Data','WorkingHours'));
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
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $input = $request->all();

            $image = $Model_Data->profile;
            $uploads_path = $this->uploads_path;
            if($request->hasfile('profile') && $request->profile != null)
            {
                $file_uploaded = $request->file('profile');
                $image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();
                $file_uploaded->move($uploads_path, $image);

                if ($Model_Data->profile != "") {
                    File::delete($uploads_path."/".$Model_Data->profile);
                }
            }
            $input['image'] = ltrim(rtrim($image));

            $input['updated_by'] = Auth::user()->id;

            $Model_Data->name = $input['name'];
            $Model_Data->arabic_name = $input['arabic_name'];
            $Model_Data->phone = $input['phone'];
            $Model_Data->email = $input['email'];
            $Model_Data->website = $input['website'];
            $Model_Data->description = $input['description'];
            $Model_Data->arabic_description = $input['arabic_description'];
            $Model_Data->image = $input['image'];
            $Model_Data->location = $input['location'];
            $Model_Data->lat = $input['lat'];
            $Model_Data->lng = $input['lng'];
            $Model_Data->updated_by = $input['updated_by'];

            $Model_Data->update();

            Flash::success($this->msg_updated);
            return redirect(route($this->edit_route,$id));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function update_timings(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $id = $request->vendor_id;
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $time_to_hours = get_time_to_hours_array();
            $days = [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ];

            foreach ($time_to_hours as $time_key => $time_value)
            {
                foreach ($days as $day)
                {
                    $input_field = $day.'_'.$time_key;
                    $status_field = $day.'_status';
                    $status = 0;
                    if ($request->has($input_field)) {
                        $status = $request->input($input_field);
                    }

                    $exists= 0;
                    $records = SvcVendorTiming::select(['id'])->where('vend_id', '=', $id)->where('time_value', '=', $time_key)->limit(1)->get();
                    foreach($records as $record)
                    {
                        $exists = 1;
                        $rec_id = $record->id;
                        $Timing_Data = SvcVendorTiming::find($rec_id);
                        $Timing_Data->$status_field = $status;
                        $Timing_Data->save();
                    }

                    /*if($exists == 0)
                    {
                        $Timing_Data = new SvcVendorTiming;
                        $Timing_Data->time_value = $time_key;
                        $Timing_Data->$status_field = $status;
                        $Timing_Data->save();
                    }*/
                }
            }

            Flash::success("Availabilities Updated");
            return redirect(route($this->edit_route,$id));
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    /**
     * add to featured listing the specified resource in storage.
     *
     * @param  \App\Models\Model  $id
     * @return \Illuminate\Http\Response
     */
    public function addFeatured($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->user_type == 'admin' && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
        {
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->is_featured = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Vendor is now added as featured.');
            return redirect(route($this->home_route));
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    /**
     * remove from featured listing the specified resource in storage.
     *
     * @param  \App\Models\Model  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFeatured($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->user_type == 'admin' && ($Auth_User->can($this->status_permission) || $Auth_User->can('all')))
        {
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->is_featured = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Vendor is removed from featured.');
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
    public function makeActive($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Vendor made Active successfully.');
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
            $Model_Data = SvcVendor::find($id);

            if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->is_featured = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Vendor made InActive successfully.');
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
            $Model_Data = SvcVendor::find($id);

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

    public function review_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();

        $Records = SvcReview::leftJoin('svc_orders', 'svc_reviews.order_id','=', 'svc_orders.id')
            ->leftJoin('svc_vendors', 'svc_reviews.vend_id','=', 'svc_vendors.id')
            ->select(['svc_vendors.name as vend_name', 'svc_reviews.id', 'svc_reviews.order_id', 'svc_reviews.rating', 'svc_reviews.review', 'svc_reviews.status', 'svc_reviews.vend_id', 'svc_orders.order_no'])
            ->where(['svc_reviews.vend_id'=>$id]);



        $response= Datatables::of($Records)
            ->filter(function ($query) use ($request) {

                if ($request->has('order_no') && !empty($request->order_no))
                {
                    $query->where('svc_orders.order_no', 'like', "%{$request->get('order_no')}%");
                }

                if ($request->has('rating') && !empty($request->rating))
                {
                    $query->where('svc_reviews.rating', '>=', "{$request->get('rating')}");
                }

                if ($request->has('review') && !empty($request->review))
                {
                    $query->where('svc_reviews.review', 'like', "%{$request->get('review')}%");
                }

                if ($request->has('badword') && $request->get('badword') != -1)
                {
                    $query->where('svc_reviews.has_badwords', 'like', "%{$request->get('badword')}%");
                }

                if ($request->has('status') && $request->get('status') != -1)
                {
                    $query->where('svc_reviews.status', '=', "{$request->get('status')}");
                }
            })
            ->addColumn('vend_name', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->vend_name;

                return  $title;
            })

            ->addColumn('order_no', function ($Records) {

                $Auth_User = Auth::user();

                $order_id = $Records->order_id;

                $title = $Records->order_no;


                if($Auth_User->can('orders-view') || $Auth_User->can('all'))

                {
                    $title = '<a href="'.route('orders.show',$order_id).'"  title="View Order Details">

							'.$title.'

							</a>';
                }


                return  $title;

            })
            ->addColumn('rating', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->rating;

                return  $title;
            })
            ->addColumn('review', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->review;

                return  $title;
            })

            ->addColumn('badwords_found', function ($Records) {
                $record_id = $Records->id;
                $title = badwords_found($record_id);

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
                        $str = '<a href="javascript:void(0)" class="btn btn-success btn-sm"  title="Make Review Inactive">
							<span class="fa fa-power-off "></span>
							</a>';
                    }
                    else
                    {
                        $str = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Make Review Active">
							<span class="fa fa-power-off"></span>
							</a>';
                    }
                }
                else
                {
                    if($status == 1)
                    {
                        $str = '<span class="fa fa-power-off "></span>';
                    }
                    else
                    {
                        $str = '<span class="fa fa-power-off"></span></a>';
                    }
                }

                return  $str;
            })
            ->addColumn('action', function ($Records) {
                $record_id = $Records->id;
                $Auth_User = Auth::user();

                $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
                {
                    $str .= ' <a class="btn btn-outline-primary" href="' . route('reviews.show', $record_id) . '" title="View Details" target="_blank">
							<i class="fa fa-eye"></i>
							</a>';
                }

                $str.= "</div>";
                return $str;

            })
            ->rawColumns(['order_no','status','action'])
            ->setRowId(function($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;
    }

    public function order_datatable(Request $request, $id)
    {
        $Auth_User = Auth::user();


        $Records = SvcOrder::leftJoin('svc_vendors', 'svc_orders.vend_id','=', 'svc_vendors.id')
            ->leftJoin('app_users', 'svc_orders.user_id','=', 'app_users.id')
            ->select(['svc_orders.id', 'svc_orders.order_no', 'svc_orders.vend_id', 'app_users.name as user_name',  'svc_orders.total','svc_orders.user_id', 'svc_orders.status', 'svc_vendors.name as vend_name'])
            ->where('svc_orders.vend_id', '=',$id);


        $response= Datatables::of($Records)
            ->filter(function ($query) use ($request) {

                if ($request->has('order_no') && !empty($request->order_no))
                {
                    $query->where('svc_orders.order_no', 'like', "%{$request->get('order_no')}%");
                }

                if ($request->has('order_value') && !empty($request->order_value))
                {
                    $query->where('svc_orders.total', '>', "{$request->get('order_value')}");
                }

                if ($request->has('order_status') && $request->get('order_status') != -1)
                {
                    $query->where('svc_orders.status', '=', "{$request->get('order_status')}");
                }

            })
            ->addColumn('vend_name', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->vend_name;

                return  $title;
            })

            ->addColumn('order_no', function ($Records) {
                $Auth_User = Auth::user();
                $order_id = $Records->id;
                $title = $Records->order_no;

                if($Auth_User->can('orders-view') || $Auth_User->can('all'))
                {
                    $title = '<a href="'.route('orders.show',$order_id).'"  title="View Order Details">
					'.$title.'
					</a>';
                }

                return  $title;

            })

            ->addColumn('order_value', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->total;

                return  $title;
            })

            ->addColumn('status', function ($Records) {
                $Auth_User = Auth::user();
                $record_id = $Records->id;
                $status = $Records->status;

                if($status == 1)
                {
                    $status = 'Waiting';
                }
                elseif($status == 2)
                {
                    $status = 'Canceled';
                }
                elseif($status == 3)
                {
                    $status = 'Confirmed';
                }
                elseif($status == 4)
                {
                    $status = 'Declined';
                }
                elseif($status == 5)
                {
                    $status = 'Accepted';
                }
                elseif($status == 6)
                {
                    $status = 'Completed';
                }

                return  $status;
            })

            ->addColumn('action', function ($Records) {
                $Auth_User = Auth::user();
                $record_id = $Records->id;

                $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
                {

                    $str .= ' <a class="btn btn-outline-primary" href="' . route('orders.show', $record_id) . '" title="View Details" target="_blank">
				<i class="fa fa-eye"></i>
				</a>';


                }

                $str.= "</div>";
                return $str;

            })
            ->rawColumns(['vend_id','order_no', 'order_value','status','action'])
            ->setRowId(function($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;

    }

}

<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SvcCoupon;
use App\Models\SvcVendor;
use Datatables;

use Flash;
use Response;
use Auth;
use File;

class SvcCouponController extends Controller
{
    //

    private $uploads_root = "uploads";
	private $uploads_ecom_path = "uploads/svc";
	private $uploads_path = "uploads/svc/coupons/";


    public function index()
	{
		$Auth_User = Auth::user();
		// if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		// {
			$records_exists = 0;
			$records = SvcCoupon::select(['id'])->where('id', '>=', 1)->where('status', '=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$sellers_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view('/svc/vendors/coupons/listing', compact("records_exists", "sellers_array"));
		// }
		// else
		// {
		// 	Flash::error($this->list_permission_error_message);
		// 	return redirect()->route($this->redirect_home);
		// }
	}


    public function datatable(Request $request)
	{
		//$Auth_User = Auth::user();
		// if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		// {
            return $this->admin_datatable($request);
			// if($Auth_User->user_type == 'admin')
			// {
			// }
			// elseif($Auth_User->user_type == 'seller')
			// {
            //     return 0;
			// 	return $this->seller_datatable($request);
			// }
		//}
		// else
		// {
		// 	Flash::error($this->list_permission_error_message);
		// 	return redirect()->route($this->redirect_home);
		// }
	}
	
	public function admin_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		
		$Records = SvcCoupon::leftJoin('svc_vendors', 'svc_coupons.vendor_id','=', 'svc_vendors.id')
			->select(['svc_coupons.*', 'svc_vendors.name as seller_name']);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				
				if ($request->has('vendor_id') && $request->get('vendor_id') != -1)
				{
					$query->where('svc_coupons.vendor_id', '=', "{$request->get('vendor_id')}");
				}
				
				if ($request->has('coupon_code') && !empty($request->coupon_code))
				{
					$query->where('svc_coupons.coupon_code', 'like', "%{$request->get('coupon_code')}%");
				}
				
				if ($request->has('title') && !empty($request->title))
				{
					$query->where('svc_coupons.title', 'like', "%{$request->get('title')}%");
				}
				
				if ($request->has('min_order_value') && !empty($request->min_order_value))
				{
					$query->where('svc_coupons.min_order_value', '>=', "{$request->get('min_order_value')}");
				}
				
				if ($request->has('max_discount_value') && !empty($request->max_discount_value))
				{
					$query->where('svc_coupons.max_discount_value', '>=', "{$request->get('max_discount_value')}");
				}
				
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('svc_coupons.status', '=', "{$request->get('status')}");
				}
			})
			->addColumn('seller_id', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->seller_name;
				
				return  $title;
			})
			->addColumn('status', function ($Records) {
				$record_id = $Records->id;
				$status = $Records->status;
				$Auth_User = Auth::user();
				
				$str = '';
				//if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
				{
					if($status == 1)
					{
						$str = '<a href="'.route('svc_coupons_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
					}
					else
					{
						$str = '<a href="'.route('svc_coupons_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
					<span class="fa fa-power-off"></span> Inactive
					</a>';
					}
				}
				//else
				{
					if($status == 1)
					{
						$str = '<a href="'.route('svc_coupons_deactivate',$record_id).'" class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Active
                                    </a>';
					}
					else
					{
						$str = '<a href="'.route('svc_coupons_activate',$record_id).'" class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Inactive
                                    </a>';
					}
				}
				
				return  $str;
			})
			->addColumn('action', function ($Records) {
				$record_id = $Records->id;
				$Auth_User = Auth::user();
				
				$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";
				
				//if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href=" ' .url('/service/coupon/'.$record_id). ' "title="View Details">
				<i class="fa fa-eye"></i>
				</a>';
				}
				
				//if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
				{
					$str .= ' <a class="btn btn-outline-primary" href="' .url('/service/coupon/'.$record_id). '/edit" title="Edit Details">
				<i class="fa fa-edit"></i>
				</a>';
				}
				
				$str.= "</div>";
				return $str;
				
			})
			->rawColumns(['status','approval','action'])
			->setRowId(function($Records) {
				return 'myDtRow' . $Records->id;
			})
			->make(true);
		return $response;
	}
	
	public function seller_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		$seller_id = $Auth_User->vend_id;
		
		$Records = EcomCoupon::leftJoin('ecom_sellers', 'ecom_coupons.seller_id','=', 'ecom_sellers.id')
			->select(['ecom_coupons.*', 'ecom_sellers.name as seller_name'])
			->where('ecom_coupons.seller_id', '=', $seller_id);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('coupon_code') && !empty($request->coupon_code))
				{
					$query->where('ecom_coupons.coupon_code', 'like', "%{$request->get('coupon_code')}%");
				}
				
				if ($request->has('title') && !empty($request->title))
				{
					$query->where('ecom_coupons.title', 'like', "%{$request->get('title')}%");
				}
				
				if ($request->has('min_order_value') && !empty($request->min_order_value))
				{
					$query->where('ecom_coupons.min_order_value', '>=', "{$request->get('min_order_value')}");
				}
				
				if ($request->has('max_discount_value') && !empty($request->max_discount_value))
				{
					$query->where('ecom_coupons.max_discount_value', '>=', "{$request->get('max_discount_value')}");
				}
				
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('ecom_coupons.status', '=', "{$request->get('status')}");
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
						$str = '<a href="'.route('ecom_coupons_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
					}
					else
					{
						$str = '<a href="'.route('ecom_coupons_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
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
				
				$str.= "</div>";
				return $str;
				
			})
			->rawColumns(['status','approval','action'])
			->setRowId(function($Records) {
				return 'myDtRow' . $Records->id;
			})
			->make(true);
		return $response;
	}



    public function create()
	{
		$Auth_User = Auth::user();
		// if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		// {
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view('svc/vendors/coupons/create',compact('vendors_array'));
		// }
		// else
		// {
			Flash::error($this->add_permission_error_message);
			return redirect()->route($this->home_route);
		//}
	}

    public function store(Request $request)
    {
		$Auth_User = Auth::user();
		//if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
		{
			// Bank Details
			{
				$request->validate([
					'vendor_id' => 'required',
					'coupon_code' => 'required',
					'title' => 'required',
					'ar_title' => 'required',
					'description' => 'required',
					'ar_description' => 'required',
					'min_order_value' => 'required',
					'max_discount_value' => 'required',
					'start_time' => 'required',
					'end_time' => 'required',
					'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
				]);
				
				$image = '';
				if (isset($request->image) && $request->image != null)
				{
					$file_uploaded = $request->file('image');
					$image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();
					
					$this->create_uploads_directory();
					
					$uploads_path = $this->uploads_path;
					$file_uploaded->move($uploads_path, $image);
				}
				
				
				$Model_Data = new SvcCoupon();
				
				$Model_Data->vendor_id = $request->vendor_id;
				
				$Model_Data->coupon_code = $request->coupon_code;
				$Model_Data->title = $request->title;
				$Model_Data->ar_title = $request->ar_title;
				$Model_Data->description = $request->description;
				$Model_Data->ar_description = $request->ar_description;
				$Model_Data->min_order_value = $request->min_order_value;
				$Model_Data->max_discount_value = $request->max_discount_value;
				$Model_Data->start_time = strtotime($request->start_time);
				$Model_Data->end_time = strtotime($request->end_time);
				
				$Model_Data->image = ltrim(rtrim($image));
				
				$Model_Data->status = 1;
				$Model_Data->created_by = $Auth_User->id;
				$Model_Data->save();
			}
			
			Flash::success('Coupon Created!');
			return redirect('/service/coupons');
			
		}
	//	else
		// {
		// 	Flash::error($this->add_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}


    public function show($id)
	{
		$Auth_User = Auth::user();
		//if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
		//{
			$Model_Data = SvcCoupon::find($id);
			
			if (empty( $Model_Data) )
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '=', $Model_Data->seller_id)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view('svc/vendors/coupons/show', compact('Model_Data','vendors_array'));
		// }
		// else
		// {
		// 	Flash::error($this->view_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}



    private function create_uploads_directory()
	{
		$uploads_path = $this->uploads_path;
		if(!is_dir($uploads_path))
		{
			$uploads_root = $this->uploads_root;
			$src_file = $uploads_root."/index.html";
			
			$uploads_ecom_path = $this->uploads_ecom_path;
			if(!is_dir($uploads_ecom_path))
			{
				mkdir($uploads_ecom_path);
				$dest_file = $uploads_ecom_path."/index.html";
				copy($src_file,$dest_file);
			}
			
			mkdir($uploads_path);
			$dest_file = $uploads_path."/index.html";
			copy($src_file,$dest_file);
		}
	}



    public function edit($id)
	{
		$Auth_User = Auth::user();
		//if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		{
			$Model_Data = SvcCoupon::find($id);
			
			if (empty( $Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '=', $Model_Data->vendor_id)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			return view('svc/vendors/coupons/edit', compact('Model_Data','vendors_array'));
		}
		// else
		// {
		// 	Flash::error($this->edit_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}


    public function update($id, Request $request)
	{
		$Auth_User = Auth::user();
		//if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
		//{
			$Model_Data = SvcCoupon::find($id);
			
			if (empty($Model_Data) )
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$request->validate([
				'coupon_code' => 'required',
				'title' => 'required',
				'ar_title' => 'required',
				'description' => 'required',
				'ar_description' => 'required',
				'min_order_value' => 'required',
				'max_discount_value' => 'required',
				'start_time' => 'required',
				'end_time' => 'required'
			]);
			
			$image = '';
			if (isset($request->image) && $request->image != null)
			{
				$file_uploaded = $request->file('image');
				$image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();
				
				$this->create_uploads_directory();
				
				$uploads_path = $this->uploads_path;
				$file_uploaded->move($uploads_path, $image);
			}
			
            
			$Model_Data->vendor_id = $request->vendor_id;
			
			$Model_Data->coupon_code = $request->coupon_code;
			$Model_Data->title = $request->title;
			$Model_Data->ar_title = $request->ar_title;
			$Model_Data->description = $request->description;
			$Model_Data->ar_description = $request->ar_description;
			$Model_Data->min_order_value = $request->min_order_value;
			$Model_Data->max_discount_value = $request->max_discount_value;
			$Model_Data->start_time = strtotime($request->start_time);
			$Model_Data->end_time = strtotime($request->end_time);
			
			if (isset($request->image) && $request->image != null){
				$Model_Data->image = ltrim(rtrim($image));
			}
			
			$Model_Data->status = 1;
			$Model_Data->created_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Coupon Updated!');
			return redirect('/service/coupons');
		//}
		//else
		// {
		// 	Flash::error($this->edit_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}


    public function makeInActive($id)
	{
		$Auth_User = Auth::user();
		// if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		// {
			$Model_Data = SvcCoupon::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Coupon is Deactivated successfully.');
			return redirect('/service/coupons');
		//}
		// else
		// {
		// 	Flash::error($this->status_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}
	
    public function makeActive($id)
	{
		$Auth_User = Auth::user();
		// if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
		// {
			$Model_Data = SvcCoupon::find($id);
			
			$seller_id = $Model_Data->seller_id;

				//			EcomCoupon::where('seller_id',$seller_id)->update(['status'=>'0']);
			
			if (empty($Model_Data) )
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Coupon is Activated successfully.');
			return redirect('service/coupons');
		// }
		// else
		// {
		// 	Flash::error($this->status_permission_error_message);
		// 	return redirect()->route($this->home_route);
		// }
	}
}

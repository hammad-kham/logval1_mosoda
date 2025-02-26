<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;

use App\Models\SvcBankDetail;
use App\Models\SvcVendor;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

use Datatables;

use Flash;
use Response;
use Auth;
use File;

class SvcBankDetailController extends Controller
{
	private $views_path = "svc.vendors.bank_details";
	
	private $home_route = "vendor-bank-details.index";
	private $create_route = "vendor-bank-details.create";
	private $edit_route = "vendor-bank-details.edit";
	private $view_route = "vendor-bank-details.show";
	private $delete_route = "vendor-bank-details.destroy";
	
	private $msg_created = "Bank Details added successfully.";
	private $msg_updated = "Bank Details updated successfully.";
	private $msg_deleted = "Bank Details deleted successfully.";
	private $msg_not_found = "Bank Detail not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same name";
	
	private $redirect_home = "home";//"dashboard";
	
	private $list_permission = "vendor-bank-details-listing";
	private $add_permission = "vendor-bank-details-add";
	private $edit_permission = "vendor-bank-details-edit";
	private $view_permission = "vendor-bank-details-view";
	private $status_permission = "vendor-bank-details-status";
	private $delete_permission = "vendor-bank-details-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Vendor Bank Details. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Vendor Bank Detail. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Vendor Bank Detail. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Vendor Bank Detail. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Vendor Bank Detail. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Vendor Bank Detail. Please Contact Administrator.";
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$Auth_User = Auth::user();
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
			$records_exists = 0;
			$records = SvcBankDetail::select(['id'])->where('id', '>=', 1)->where('status', '=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view($this->views_path.'.listing', compact("records_exists", "vendors_array"));
		}
		else
		{
			Flash::error($this->list_permission_error_message);
			return redirect()->route($this->redirect_home);
		}
	}
	
	public function datatable(Request $request)
	{
		$Auth_User = Auth::user();
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
			if($Auth_User->user_type == 'admin')
			{
				return $this->admin_datatable($request);
			}
			elseif($Auth_User->user_type == 'vendor')
			{
				return $this->vendor_datatable($request);
			}
		}
		else
		{
			Flash::error($this->list_permission_error_message);
			return redirect()->route($this->redirect_home);
		}
	}
	
	public function admin_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		
		$Records = SvcBankDetail::leftJoin('svc_vendors', 'svc_bank_details.vend_id','=', 'svc_vendors.id')
			->select(['svc_bank_details.id', 'svc_bank_details.company_name', 'svc_bank_details.bank_name','svc_bank_details.account_number','svc_bank_details.tax_reg_no','svc_bank_details.address','svc_bank_details.swift_code', 'svc_bank_details.iban', 'svc_bank_details.status', 'svc_bank_details.vend_id', 'svc_vendors.name as vend_name']);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				//company name filter
				if ($request->has('company_name') && !empty($request->company_name))
				{
					$query->where('svc_bank_details.company_name', 'like', "%{$request->get('company_name')}%");
				}
				//bank name filter
				if ($request->has('bank_name') && !empty($request->bank_name))
				{
					$query->where('svc_bank_details.bank_name', 'like', "%{$request->get('bank_name')}%");
				}
				
				//acount number filter
				if ($request->has('account_number') && !empty($request->account_number))
				{
					$query->where('svc_bank_details.account_number', 'like', "%{$request->get('account_number')}%");
				}
				
				
				//status filter
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('svc_bank_details.status', '=', "{$request->get('status')}");
				}
				
				
				if ($request->has('vend_id') && $request->get('vend_id') != -1)
				{
					$query->where('svc_bank_details.vend_id', '=', "{$request->get('vend_id')}");
				}
				
				if ($request->has('approval') && $request->get('approval') != -1)
				{
					$query->where('svc_bank_details.status', '=', "{$request->get('approval')}");
				}
			})
			->addColumn('vend_id', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->vend_name;
				
				return  $title;
			})
			->addColumn('company_name', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->company_name;
				
				return  $title;
			})
			->addColumn('bank_name', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->bank_name;
				
				return  $title;
			})
			->addColumn('tax_reg_no', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->tax_reg_no;
				
				return  $title;
			})
			->addColumn('account_number', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->account_number;
				
				return  $title;
			})
			->addColumn('address', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->address;
				
				return  $title;
			})
			->addColumn('swift_code', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->swift_code;
				
				return  $title;
			})
			->addColumn('iban', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->swift_code;
				
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
						$str = '<a href="'.route('svc_vendor_bank_details_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
					}
					else
					{
						$str = '<a href="'.route('svc_vendor_bank_details_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
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
			->addColumn('approval', function ($Records) {
				$record_id = $Records->id;
				$status = $Records->status;
				$Auth_User = Auth::user();
				
				$str = '';
				if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
				{
					if($status == 1)
					{
						$str = '<a href="'.route('svc_vendor_bank_details_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span>
					</a>';
					}
					else
					{
						$str = '<a href="'.route('svc_vendor_bank_details_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
					<span class="fa fa-power-off"></span>
					</a>';
					}
				}
				else
				{
					if($status == 1)
					{
						$str = '<a class="btn btn-success btn-sm" >
                                        <span class="fa fa-power-off "></span> Approve
                                    </a>';
					}
					else
					{
						$str = '<a class="btn btn-danger btn-sm">
                                        <span class="fa fa-power-off "></span> Not Approve
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
	
	public function vendor_datatable(Request $request)
	{
		$Auth_User = Auth::user();
		$vend_id = $Auth_User->vend_id;
		
		$Records = SvcBankDetail::leftJoin('svc_vendors', 'svc_bank_details.vend_id','=', 'svc_vendors.id')
			->select(['svc_bank_details.id', 'svc_bank_details.company_name', 'svc_bank_details.bank_name','svc_bank_details.account_number','svc_bank_details.tax_reg_no','svc_bank_details.address','svc_bank_details.swift_code', 'svc_bank_details.iban', 'svc_bank_details.status', 'svc_bank_details.vend_id', 'svc_vendors.name as vend_name'])
			->where('svc_bank_details.vend_id', '=', $vend_id);
		
		$response= Datatables::of($Records)
			->filter(function ($query) use ($request) {
				if ($request->has('company_name') && !empty($request->company_name))
				{
					$query->where('svc_bank_details.company_name', 'like', "%{$request->get('company_name')}%");
				}
				if ($request->has('bank_name') && !empty($request->bank_name))
				{
					$query->where('svc_bank_details.bank_name', 'like', "%{$request->get('bank_name')}%");
				}
				if ($request->has('account_number') && !empty($request->account_number))
				{
					$query->where('svc_bank_details.account_number', 'like', "%{$request->get('account_number')}%");
				}
				if ($request->has('status') && $request->get('status') != -1)
				{
					$query->where('svc_bank_details.status', '=', "{$request->get('status')}");
				}
				
			})
			->addColumn('company_name', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->company_name;
				
				return  $title;
			})
			->addColumn('bank_name', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->bank_name;
				
				return  $title;
			})
			->addColumn('tax_reg_no', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->tax_reg_no;
				
				return  $title;
			})
			->addColumn('account_number', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->account_number;
				
				return  $title;
			})
			->addColumn('address', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->address;
				
				return  $title;
			})
			->addColumn('swift_code', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->swift_code;
				
				return  $title;
			})
			->addColumn('iban', function ($Records) {
				$record_id = $Records->id;
				$title = $Records->swift_code;
				
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
						$str = '<a href="'.route('svc_vendor_bank_details_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
					}
					else
					{
						$str = '<a href="'.route('svc_vendor_bank_details_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
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
			
			return view($this->views_path.'.create',compact('vendors_array'));
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
			// Bank Details
			{
				$request->validate([
					'vend_id' => 'required',
					'company_name' => 'required',
					'tax_reg_no' => 'required',
					'bank_name' => 'required',
					'account_number' => 'required',
					'address' => 'required',
					'swift_code' => 'required',
				]);
				
				$Model_Data = new SvcBankDetail();
				
				$Model_Data->vend_id = $request->vend_id;
				
				$Model_Data->company_name = $request->company_name;
				$Model_Data->tax_reg_no = $request->tax_reg_no;
				$Model_Data->bank_name = $request->bank_name;
				$Model_Data->account_number = $request->account_number;
				$Model_Data->address = $request->address;
				$Model_Data->iban = $request->iban;
				$Model_Data->swift_code = $request->swift_code;
				
				if($request->vat_percentage==1){
					$Model_Data->vat_percentage = 1 ;
				}
				
				$Model_Data->status = 0;
				$Model_Data->created_by = $Auth_User->id;
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
			$Model_Data = SvcBankDetail::find($id);
			
			if (empty( $Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '=', $Model_Data->vend_id)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view($this->views_path.'.show', compact('Model_Data','vendors_array'));
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
			$Model_Data = SvcBankDetail::find($id);
			
			if (empty( $Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '=', $Model_Data->vend_id)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			
			return view($this->views_path.'.edit', compact('Model_Data','vendors_array'));
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
			$Model_Data = SvcBankDetail::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			// Bank Details
			{
				$Model_Data->company_name = $request->company_name;
				$Model_Data->tax_reg_no = $request->tax_reg_no;
				$Model_Data->bank_name = $request->bank_name;
				$Model_Data->account_number = $request->account_number;
				$Model_Data->address = $request->address;
				$Model_Data->iban = $request->iban;
				$Model_Data->swift_code = $request->swift_code;
				
				$vat = 0;
				if(isset($request->vat_percentage)){
					$vat = 1 ;
				}
				$Model_Data->vat_percentage = $vat;
				
				$Model_Data->updated_by = $Auth_User->id;
				$Model_Data->save();
			}
			
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
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Model  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$Auth_User = Auth::user();
		if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
		{
			$Model_Data = SvcBankDetail::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			return redirect()->route($this->home_route);
		}
		else
		{
			Flash::error($this->delete_permission_error_message);
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
			$Model_Data = SvcBankDetail::find($id);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Bank Detail is Deactivated successfully.');
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
			$Model_Data = SvcBankDetail::find($id);
			
			$vend_id = $Model_Data->vend_id;
			
			SvcBankDetail::where('vend_id',$vend_id)->update(['status'=>'0']);
			
			if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Bank Detail is Activated successfully.');
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
		$bool = 1;
		if($Auth_User->user_type == 'admin')
		{
			$bool = 0;
		}
		else
		{
			$vend_id = $Auth_User->vend_id;
			$records = SvcBankDetail::select(['id'])->where('id', '=', $id)->where('vend_id', '=', $vend_id)->limit(1)->get();
			foreach($records as $record)
			{
				$bool = 0;
			}
		}
		
		return $bool;
	}
	
}

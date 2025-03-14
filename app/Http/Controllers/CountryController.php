<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Country;
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

use App\Models\FlowerSize;

class CountryController extends Controller
{
	private $views_path = "countries";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "countries.index";
	private $create_route = "countries.create";
	private $edit_route = "countries.edit";
	private $view_route = "countries.show";
	private $delete_route = "countries.destroy";
	
	private $msg_created = "Country created successfully.";
	private $msg_updated = "Country updated successfully.";
	private $msg_deleted = "Country deleted successfully.";
	private $msg_not_found = "Country not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Country name";
	
	private $list_permission = "countries-listing";
	private $add_permission = "countries-add";
	private $edit_permission = "countries-edit";
	private $view_permission = "countries-view";
	private $status_permission = "countries-status";
	private $delete_permission = "countries-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Countries. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Country. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Country. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Country details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Country. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Country. Please Contact Administrator.";
	
	
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
			$records = Country::select(['id'])->where('id', '>=', 1)->limit(1)->get();
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
			$Records = Country::select(['countries.id', 'countries.name', 'countries.code', 'countries.status']);
			
			$response= Datatables::of($Records)
				->filter(function ($query) use ($request) {
					if ($request->has('name') && !empty($request->title))
					{
						$query->where('countries.name', 'like', "%{$request->get('name')}%");
					}
					if ($request->has('code') && !empty($request->ar_title))
					{
						$query->where('countries.code', 'like', "%{$request->get('code')}%");
					}
					if ($request->has('status') && $request->get('status') != -1)
					{
						$query->where('countries.status', '=', "{$request->get('status')}");
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
							$str = '<a href="'.route('countries_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
						}
						else
						{
							$str = '<a href="'.route('countries_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
					
					/*if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))
					{
						$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
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
															<strong>[ '.$Records->title.' ]</strong>
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
				'code' => 'required'
			]);
			
			$Model_Data = new Country();
			
			$Model_Data->name = $request->name;
			$Model_Data->code = $request->code;
			
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
			$Model_Data = Country::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			return view($this->views_path.'.show', compact("Model_Data"));
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
			$Model_Data = Country::find($id);
			
			if (empty($Model_Data))
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
			$Model_Data = Country::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$request->validate([
				'name' => 'required',
				'code' => 'required'
			]);
			
			$Model_Data->name = $request->name;
			$Model_Data->code = $request->code;
			
			$Model_Data->updated_by = $Auth_User->id;
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
			$Model_Data = Country::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Country made Active successfully.');
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
			$Model_Data = Country::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Country made InActive successfully.');
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
			$Model_Data = Country::find($id);

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
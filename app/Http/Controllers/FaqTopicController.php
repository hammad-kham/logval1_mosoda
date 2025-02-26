<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\FaqTopic;
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

class FaqTopicController extends Controller
{
	private $views_path = "faq_topics";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "faq-topics.index";
	private $create_route = "faq-topics.create";
	private $edit_route = "faq-topics.edit";
	private $view_route = "faq-topics.show";
	private $delete_route = "faq-topics.destroy";
	
	private $msg_created = "Faq Topic created successfully.";
	private $msg_updated = "Faq Topic updated successfully.";
	private $msg_deleted = "Faq Topic deleted successfully.";
	private $msg_not_found = "Faq Topic not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Faq Topic name";
	
	private $list_permission = "faq-topics-listing";
	private $add_permission = "faq-topics-add";
	private $edit_permission = "faq-topics-edit";
	private $view_permission = "faq-topics-view";
	private $status_permission = "faq-topics-status";
	private $delete_permission = "faq-topics-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Faq Topics. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Faq Topic. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Faq Topic. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Faq Topic details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Faq Topic. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Faq Topic. Please Contact Administrator.";
	
	
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
			$records = FaqTopic::select(['id'])->where('id', '>=', 1)->limit(1)->get();
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
			$Records = FaqTopic::select(['faq_topics.id', 'faq_topics.title', 'faq_topics.type','faq_topics.status']);
			
			$response= Datatables::of($Records)
				->filter(function ($query) use ($request) {
					if ($request->has('title') && !empty($request->title))
					{
						$query->where('faq_topics.title', 'like', "%{$request->get('name')}%");
					}
					if ($request->has('type') && $request->get('type') != -1)
					{
						$query->where('faq_topics.type', '=', "{$request->get('type')}");
					}
					if ($request->has('status') && $request->get('status') != -1)
					{
						$query->where('faq_topics.status', '=', "{$request->get('status')}");
					}
				})
				->addColumn('type', function ($Records) {
					$record_id = $Records->id;
					$type = $Records->type;
					$str = "";
					
					if($type == 1){
						$str = "Service On Demand";
					}
					elseif($type == 2){
						$str = "Ecommerce";
					}
					elseif($type == 3){
						$str = "Classified Ads";
					}
					
					return  $str;
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
							$str = '<a href="'.route('faq_topics_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
						}
						else
						{
							$str = '<a href="'.route('faq_topics_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
				'title' => 'required',
				'type' => 'required'
			]);
			
			$Model_Data = new FaqTopic();
			
			$Model_Data->title = $request->title;
			$Model_Data->type = $request->type;
			
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
			$Model_Data = FaqTopic::find($id);
			
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
			$Model_Data = FaqTopic::find($id);
			
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
			$Model_Data = FaqTopic::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$request->validate([
				'title' => 'required',
				'type' => 'required'
			]);
			
			$Model_Data->title = $request->title;
			$Model_Data->type = $request->type;
			
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
			$Model_Data = FaqTopic::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Faq Topic made Active successfully.');
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
			$Model_Data = FaqTopic::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Faq Topic made InActive successfully.');
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
			$Model_Data = FaqTopic::find($id);

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
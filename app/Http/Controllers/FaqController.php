<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Faq;
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

class FaqController extends Controller
{
	private $views_path = "faqs";
	
	private $dashboard_route = "dashboard";
	
	private $home_route = "faqs.index";
	private $create_route = "faqs.create";
	private $edit_route = "faqs.edit";
	private $view_route = "faqs.show";
	private $delete_route = "faqs.destroy";
	
	private $msg_created = "Faq created successfully.";
	private $msg_updated = "Faq updated successfully.";
	private $msg_deleted = "Faq deleted successfully.";
	private $msg_not_found = "Faq not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Faq name";
	
	private $list_permission = "faqs-listing";
	private $add_permission = "faqs-add";
	private $edit_permission = "faqs-edit";
	private $view_permission = "faqs-view";
	private $status_permission = "faqs-status";
	private $delete_permission = "faqs-delete";
	
	private $list_permission_error_message = "Error: You are not authorized to View Listings of Faqs. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Faq. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Faq. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Faq details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Faq. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete Faq. Please Contact Administrator.";
	
	
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
			$records = Faq::select(['id'])->where('id', '>=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$topics = FaqTopic::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
			
			return view($this->views_path.'.listing', compact("records_exists","topics"));
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
			$Records = Faq::join('faq_topics','faqs.topic_id','=','faq_topics.id')
				->select(['faqs.id','faqs.topic_id','faqs.question','faqs.answer','faqs.status' ,'faq_topics.title']);
			
			$response= Datatables::of($Records)
				->filter(function ($query) use ($request) {
					if ($request->has('title') && !empty($request->title))
					{
						$query->where('faq_topics.title', 'like', "%{$request->get('title')}%");
					}
					if ($request->has('question') && !empty($request->question))
					{
						$query->where('faqs.question', 'like', "%{$request->get('question')}%");
					}
					if ($request->has('status') && $request->get('status') != -1)
					{
						$query->where('faqs.status', '=', "{$request->get('status')}");
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
							$str = '<a href="'.route('faqs_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Promo Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
						}
						else
						{
							$str = '<a href="'.route('faqs_activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Promo Active">
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
			$topics = FaqTopic::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
			
			return view($this->views_path.'.create', compact("topics"));
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
				'topic_id' => 'required',
				'question' => 'required',
				'answer' => 'required'
			]);
			
			$Model_Data = new Faq();
			
			$Model_Data->topic_id = $request->topic_id;
			$Model_Data->question = $request->question;
			$Model_Data->answer = $request->answer;
			
			$Model_Data->created_by = $Auth_User->id;
			$Model_Data->save();
			
			$topic_id = $Model_Data->topic_id;
			
			//Updating FAQ Topics
			{
				$topic = FaqTopic::find($topic_id);
				$topic->has_faqs = 1;
				$topic->save();
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
			$Model_Data = Faq::join('faq_topics','faqs.topic_id','=','faq_topics.id')
				->select(['faqs.*','faq_topics.title'])
				->where('faqs.id',$id)
				->first();
			
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
			$Model_Data = Faq::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$topics = FaqTopic::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
			
			return view($this->views_path.'.edit', compact('Model_Data','topics'));
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
			$Model_Data = Faq::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$request->validate([
				'title' => 'required',
				'question' => 'required',
				'answer' => 'required'
			]);
			
			$Model_Data->topic_id = $request->topic_id;
			$Model_Data->question = $request->question;
			$Model_Data->answer = $request->answer;
			
			
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
			$Model_Data = Faq::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 1;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Faq made Active successfully.');
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
			$Model_Data = Faq::find($id);
			
			if (empty($Model_Data))
			{
				Flash::error($this->msg_not_found);
				return redirect(route($this->home_route));
			}
			
			$Model_Data->status = 0;
			$Model_Data->updated_by = $Auth_User->id;
			$Model_Data->save();
			
			Flash::success('Faq made InActive successfully.');
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
			$Model_Data = Faq::find($id);

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
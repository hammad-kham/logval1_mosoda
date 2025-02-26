<?php



namespace App\Http\Controllers;
use App\Models\Reward;

use App\Models\RewardHistory;

use App\Models\RewardDiscountType;



use App\Models\User;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;



use Illuminate\Http\Request;



use Datatables;



use Flash;

use Response;

use Auth;

use File;



class RewardDiscountTypeController extends Controller

{

	private $uploads_root = "uploads";

	private $uploads_path = "uploads/reward_types";

	

	private $views_path = "svc/reward_discount_types";

	

	private $home_route = "reward-discount-types.index";

	private $create_route = "reward-types.create";

	private $edit_route = "reward-types.edit";

    private $view_route = "reward-types.show";

    private $delete_route = "reward-types.destroy";

	

	private $msg_created = "Reward discount type added successfully.";

	private $msg_updated = "Reward discount type updated successfully.";

	private $msg_deleted = "Reward discount type deleted successfully.";

	private $msg_not_found = "Reward discount type not found. Please try again.";

	private $msg_required = "Please fill all required fields.";

	private $msg_exists = "Record Already Exists with same Brand name";

	

	private $redirect_home = "dashboard";

	

	private $list_permission = "reward-types-listing";

	private $add_permission = "reward-types-add";

	private $edit_permission = "reward-types-edit";

	private $view_permission = "reward-types-view";

	private $status_permission = "reward-types-status";

	private $delete_permission = "reward-types-delete";

	

	private $list_permission_error_message = "Error: You are not authorized to View Listings of Reward types. Please Contact Administrator.";

	private $add_permission_error_message = "Error: You are not authorized to Add Reward type. Please Contact Administrator.";

	private $edit_permission_error_message = "Error: You are not authorized to Update Reward type. Please Contact Administrator.";

	private $view_permission_error_message = "Error: You are not authorized to View Reward type details. Please Contact Administrator.";

	private $status_permission_error_message = "Error: You are not authorized to change status of Reward type. Please Contact Administrator.";

	private $delete_permission_error_message = "Error: You are not authorized to Delete Reward type. Please Contact Administrator.";

	

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

			$records = RewardDiscountType::select(['id'])->where('id', '>=', 1)->limit(1)->get();

			foreach($records as $record)

			{

				$records_exists = 1;

			}

			

			return view($this->views_path.'.listing', compact("records_exists"));

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

			$Records = RewardDiscountType::select(['reward_discount_types.id', 'reward_discount_types.name', 'reward_discount_types.name_ar'])->where('reward_discount_types.status', '=', 1);

			

			$response= Datatables::of($Records)

					->filter(function ($query) use ($request)

					{

						if ($request->has('name') && !empty($request->name))

						{

							$query->where('reward_discount_types.name', 'like', "%{$request->get('name')}%");

						}

						if ($request->has('name_ar') && !empty($request->name_ar))

						{

							$query->where('reward_discount_types.name_ar', 'like', "%{$request->get('name_ar')}%");

						}

					})

					->addColumn('name', function ($Records) {

						$record_id = $Records->id;

						$Auth_User = Auth::user();

						$title = $Records->name;

						

						if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))

						{

							$title = '<a href="' . route($this->view_route, $record_id) . '" title="View Details">'.$title.'</a>';

						}

						

						return  $title;

					})

					->addColumn('action', function ($Records) {

						$record_id = $Records->id;

						$Auth_User = Auth::user(); 

						

						$str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

							   

						if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))

						{

							$str .= ' <a class="btn btn-outline-primary" href="' . url('service/reward_discount_type/'.$record_id) . '" title="View Details">

								<i class="fa fa-eye"></i>

								</a>';

						}

						   

						if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))

						{

							$str .= ' <a class="btn btn-outline-primary" href="' . url('service/reward_discount_type/edit/'.$record_id) . '" title="Edit Details">

								<i class="fa fa-edit"></i>

								</a>';

						}

						

						

						/*$relation_count = $this->relation_count($record_id);

						

						if(($Auth_User->can($this->delete_permission) || $Auth_User->can('all')) && $relation_count==0)

						{

							$str.= ' <a class="btn btn-outline-warning" href="#" data-toggle="modal" data-target="#m-'.$record_id.'" ui-toggle-class="bounce" ui-target="#animate" title="Delete">

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

							}

						}*/

	

						$str.= "</div>";

						return $str;

	

					})

					->rawColumns(['name','action'])

					->setRowId(function($Records) {

						return 'myDtRow' . $Records->id;

				})

				->make(true);

			return $response;

		}

		else

		{		

			Flash::error($this->list_permission_error_message);			

        	return redirect()->route($this->redirect_home);

		}  

    

    }

	

    public function relation_count($record_id)

    {   

		$count = Reward::where('type_id','=',$record_id)->count();

		return $count;

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

				'name_ar' => 'required',          

				//'file_upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048'

			]);

			

			$name = ltrim(rtrim($request->name));
			$name_ar = ltrim(rtrim($request->name_ar));

			if($name != '' && $name_ar != '')

			{			

				$bool=0;	

				$Model_Results = RewardDiscountType::where('name', '=', $name)->get();

				foreach($Model_Results as $Model_Result)

				{

					$bool=1;

				}

				if($bool==0)

				{

					$Model_Data = new RewardDiscountType();		

					

					$Model_Data->name = $name;
					$Model_Data->name_ar = $name_ar;

					

					$image = '';

					if (isset($request->file_upload) && $request->file_upload != null)

					{

						$file_uploaded = $request->file('file_upload');

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

					$Model_Data->icon = $image;

					

					$Model_Data->created_by = Auth::user()->id;

					$Model_Data->save();

			

					Flash::success($this->msg_created);

					return redirect('/service/reward_discount_types');

				}

				else

				{

					Flash::error($this->msg_exists);

					return redirect()->route($this->create_route);

				}

			}

			else

			{

				Flash::error($this->msg_required);

				return redirect()->route($this->create_route);

			}

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

			$Model_Data = RewardDiscountType::find($id);

	

			if (empty($Model_Data))

			{

				Flash::error($this->msg_not_found);

				return redirect(route($this->home_route));

			}

	

			return view($this->views_path.'.show')->with('Model_Data', $Model_Data);

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

			$Model_Data= RewardDiscountType::find($id);

			

			if (empty( $Model_Data))

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

			$request->validate([

				'name' => 'required',
				

				'name_ar' => 'required'

			]);

			  

			$Model_Data = RewardDiscountType::find($id);

		   

			if (empty($Model_Data))

			{

				Flash::error($this->msg_not_found);

				return redirect(route($this->home_route));

			}

			

			$name = ltrim(rtrim($request->name));
			$name_ar = ltrim(rtrim($request->name_ar));

			if($name != '' && $name_ar != '')

			{			

				$bool=0;	

				$Model_Results = RewardDiscountType::where('name', '=', $name)->where('id', '!=', $id)->get();

				foreach($Model_Results as $Model_Result)

				{

					$bool=1;

				}

				if($bool==0)

				{						

					$Model_Data = RewardDiscountType::find($id);

		

					$Model_Data->name = $name;
					$Model_Data->name_ar = $name_ar;						

				

					$image = $Model_Data->icon;

					$uploads_path = $this->uploads_path;

					if($request->hasfile('file_upload') && $request->file_upload != null)

					{	

						$file_uploaded = $request->file('file_upload');

						$image = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

						$file_uploaded->move($uploads_path, $image); 

							

						if ($Model_Data->icon != "") {

							File::delete($uploads_path."/".$Model_Data->icon);

						}

					}

					$Model_Data->icon = ltrim(rtrim($image));	

					

					$Model_Data->updated_by = Auth::user()->id;

					$Model_Data->save();        

			

					Flash::success($this->msg_updated);				

					return redirect('/service/reward_discount_types');

				}

				else

				{

					Flash::error($this->msg_exists);

					return redirect()->route($this->edit_route, $id);

				}

			}

			else

			{

				Flash::error($this->msg_required);

				return redirect()->route($this->edit_route, $id);

			}

		}

		else			

		{

			Flash::error($this->edit_permission_error_message);

			return redirect('/service/reward_discount_types');

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

		return redirect()->route($this->home_route); 

		/*$Auth_User = Auth::user();     

		if($Auth_User->can($this->delete_permission) || $Auth_User->can('all'))

		{

			$Model_Data = RewardType::find($id);

			

			if (empty($Model_Data))

			{

				Flash::error($this->msg_not_found);			

				return redirect(route($this->home_route));

			}

			

			$Model_Data->status = 0;

			$Model_Data->save();

			

			//$Model_Data->delete();

			

			Flash::success($this->msg_deleted);	

			return redirect(route($this->home_route));

		}

		else			

		{

			Flash::error($this->delete_permission_error_message);

			return redirect()->route($this->home_route);

		}*/

    }		

	

	public function makeInActive($id)

	{     

		$Auth_User = Auth::user();     

		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))

		{      

			$Model_Data = RewardType::find($id);

			

			if (empty($Model_Data))

			{

				Flash::error($this->msg_not_found);			

				return redirect(route($this->home_route));

			}	

			

			$Model_Data->status = 0;

	

			$Model_Data->updated_by = Auth::user()->id;

			$Model_Data->save();

			

			Flash::success('Reward Type InActive successfully.');	

			return redirect(route($this->home_route));

		}

		else			

		{

			Flash::error($this->status_permission_error_message);

			return redirect()->route($this->home_route);

		}

	}

	

	public function makeActive($id)

	{    

		$Auth_User = Auth::user();     

		if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))

		{      

			$Model_Data = RewardType::find($id);

			

			if (empty($Model_Data))

			{

				Flash::error($this->msg_not_found);			

				return redirect(route($this->home_route));

			}	

			

			$Model_Data->status = 1;

	

			$Model_Data->updated_by = Auth::user()->id;

			$Model_Data->save();

			

			Flash::success('Reward Type Active successfully.');

			$data = [

				'data' => 'true',

			];	

			return redirect(route($this->home_route));

		}

		else			

		{

			Flash::error($this->status_permission_error_message);

			return redirect()->route($this->home_route);

		}

	}

}


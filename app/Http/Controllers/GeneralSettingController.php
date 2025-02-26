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

use App\Models\GeneralSetting;

class GeneralSettingController extends Controller
{  

	private $uploads_root = "uploads";
	private $uploads_path = "uploads/audios";	  	

	private $views_path = "general_settings";

    private $dashboard_route = "dashboard";

	private $home_route = "general-settings.index";
	private $create_route = "general-settings.create";
	private $edit_route = "general-settings.edit";
    private $view_route = "general-settings.show";
    private $delete_route = "general-settings.destroy";	

	private $msg_created = "General Setting added successfully.";
	private $msg_updated = "General Setting updated successfully.";
	private $msg_deleted = "General Setting deleted successfully.";
	private $msg_not_found = "General Setting not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same Contact name";
	

	private $list_permission = "general-settings-listing";
	private $add_permission = "general-settings-add";
	private $edit_permission = "general-settings-edit";
	private $view_permission = "general-settings-view";
	private $status_permission = "general-settings-status";
	private $delete_permission = "general-settings-delete";
	

	private $list_permission_error_message = "Error: You are not authorized to View Listings of General Settings. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add General Setting. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update General Setting. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View General Setting details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of General Setting. Please Contact Administrator.";
	private $delete_permission_error_message = "Error: You are not authorized to Delete General Setting. Please Contact Administrator.";
	
	
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
			$records = GeneralSetting::select(['id'])->where('id', '>=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$Ramadan = GeneralSetting::find(8);			

			return view($this->views_path.'.listing', compact("records_exists","Ramadan"));
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

			$Records = GeneralSetting::select(['general_settings.id', 'general_settings.title', 'general_settings.value', 'general_settings.status'])->where('general_settings.id', '<>', "8");

			

			$response= Datatables::of($Records)

					->filter(function ($query) use ($request) {

						if ($request->has('title') && !empty($request->title))

						{

							$query->where('general_settings.title', 'like', "%{$request->get('title')}%");

						}

						if ($request->has('s_value') && !empty($request->s_value))

						{

							$query->where('general_settings.value', 'like', "%{$request->get('s_value')}%");

						}

						if ($request->has('status') && $request->get('status') != -1)

						{

							$query->where('general_settings.status', '=', "{$request->get('status')}");

						}

					})

					->addColumn('title', function ($Records) {

						$Auth_User = Auth::user(); 

						$record_id = $Records->id;

						$title = $Records->title;

						

						if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))

						{

							$title = '<a href="' . route($this->view_route, $record_id) . '" title="View Details">'.$title.'</a>';

						}

						

						return  $title;

					})

					->addColumn('status', function ($Records) {

						$Auth_User = Auth::user();

						$record_id = $Records->id;

						$status = $Records->status;

		

						$str = '';

						if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))

						{

							if($status == 1)

							{

								$str = '<a href="'.route('general_settings-deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Inactive">

						<span class="fa fa-power-off "></span>

						</a>';

							}

							else

							{

								$str = '<a href="'.route('general_settings-activate',$record_id).'" class="btn btn-danger btn-sm" title="Make Active">

						<span class="fa fa-power-off"></span>

						</a>';

							}

						}
					else
					{
						if($status == 1)
						{
							$str = '<a href="javascript:void(0)" class="btn btn-success btn-sm">
								<span class="fa fa-power-off "></span>
								</a>';
						}
						else
						{
							$str = '<a href="javascript:void(0)" class="btn btn-danger btn-sm">
								<span class="fa fa-power-off"></span>
								</a>';
						}
					}

		

						return  $str;

					})

					->addColumn('action', function ($Records) {

						$Auth_User = Auth::user(); 

						$record_id = $Records->id;

						

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

					->rawColumns(['title','status','action'])

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

		return redirect()->route($this->home_route);

		/*$Auth_User = Auth::user();    

		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))

		{

        	return view($this->views_path.'.create');

		}

		else			

		{

			Flash::error($this->add_permission_error_message);

			return redirect()->route($this->home_route);

		}*/

    }



	/**

	* Store a newly created resource in storage.

	*

	* @param  \Illuminate\Http\Request  $request

	* @return \Illuminate\Http\Response

	*/

    public function store(Request $request)

    {	

		return redirect()->route($this->home_route);

		/*$Auth_User = Auth::user();      

		if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))

		{		       

			$request->validate([

				'title' => 'required',

				'value' => 'required'

			]);

			

			$name = ltrim(rtrim($request->title));

			if($name != '')

			{			

				$bool=0;	

				$Model_Results = GeneralSetting::where('title', '=', $name)->get();

				foreach($Model_Results as $Model_Result)

				{

					$bool=1;

				}

				if($bool==0)

				{

					$Model_Data = new GeneralSetting();		

					

					$Model_Data->title = $name;

					$Model_Data->value = ltrim(rtrim($request->value));

					

					$Model_Data->created_by = Auth::user()->id;

					$Model_Data->save();

			

					Flash::success($this->msg_created);

					return redirect()->route($this->home_route);

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

		}*/

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

			$Model_Data = GeneralSetting::find($id);

	

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

    public function edit()

    {   

		$Auth_User = Auth::user();     

		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))

		{     

			$Model_Data_1 = GeneralSetting::find(1);

			$Model_Data_2 = GeneralSetting::find(2);

			$Model_Data_3 = GeneralSetting::find(3);

			$Model_Data_4 = GeneralSetting::find(4);

			$Model_Data_5 = GeneralSetting::find(5);

			$Model_Data_6 = GeneralSetting::find(6);

			$Model_Data_7 = GeneralSetting::find(7);

			$Model_Data_9 = GeneralSetting::find(9);

			$Model_Data_10 = GeneralSetting::find(10);

			$Model_Data_11 = GeneralSetting::find(11);

			$Model_Data_12 = GeneralSetting::find(12);

			$Model_Data_13 = GeneralSetting::find(13);

			return view($this->views_path.'.edit', compact("Model_Data_1","Model_Data_2","Model_Data_3","Model_Data_4","Model_Data_5","Model_Data_6","Model_Data_7","Model_Data_9","Model_Data_10","Model_Data_11","Model_Data_12","Model_Data_13"));

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

    public function update(Request $request)

    {   

		$Auth_User = Auth::user();   

		if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))

		{ 			
			$Model_Data = GeneralSetting::find(1);
			$Model_Data->title = 'phone';
			$Model_Data->value = ltrim(rtrim($request->field_1));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(2);
			$Model_Data->title = 'email';
			$Model_Data->value = ltrim(rtrim($request->field_2));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(3);
			$Model_Data->title = 'website';
			$Model_Data->value = ltrim(rtrim($request->field_3));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(4);
			$Model_Data->title = 'VAT';
			$Model_Data->value = ltrim(rtrim($request->field_4));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(5);
			$Model_Data->title = 'Order Declining Time';
			$Model_Data->value = ltrim(rtrim($request->field_5));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(6);
			$Model_Data->title = 'Order Declining Reason';
			$Model_Data->value = ltrim(rtrim($request->field_6));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(7);
			$Model_Data->title = 'Order Collection Time';
			$Model_Data->value = ltrim(rtrim($request->field_7));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(9);
			$Model_Data->title = 'Maximum Fixed Discount Value';
			$Model_Data->value = ltrim(rtrim($request->field_9));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
						
			$Model_Data = GeneralSetting::find(10);
			$Model_Data->title = 'Maximum Percentage Discount Value';
			$Model_Data->value = ltrim(rtrim($request->field_10));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();

			$Model_Data = GeneralSetting::find(13);
			$Model_Data->title = 'Google Maps API Key';
			$Model_Data->value = ltrim(rtrim($request->field_13));
			$Model_Data->updated_by = Auth::user()->id;
			$Model_Data->save();
			

			

			$audio = '';

			if (isset($request->field_11) && $request->field_11 != null)

			{

				$file_uploaded = $request->file('field_11');

				$audio = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

				

				$uploads_path = $this->uploads_path;

				if(!is_dir($uploads_path))

				{					

					mkdir($uploads_path);

					$uploads_root = $this->uploads_root;

					$src_file = $uploads_root."/index.html";

					$dest_file = $uploads_path."/index.html";

					copy($src_file,$dest_file);

				}

				

				$file_uploaded->move($this->uploads_path, $audio); 
						
				$Model_Data = GeneralSetting::find(11);
				$Model_Data->title = 'New Order Notification Audio';
				$Model_Data->value = ltrim(rtrim($audio));
				$Model_Data->updated_by = Auth::user()->id;
				$Model_Data->save();

			}
			

			

			$audio = '';

			if (isset($request->field_12) && $request->field_12 != null)

			{

				$file_uploaded = $request->file('field_12');

				$audio = date('YmdHis').".".$file_uploaded->getClientOriginalExtension();

				

				$uploads_path = $this->uploads_path;

				if(!is_dir($uploads_path))

				{					

					mkdir($uploads_path);

					$uploads_root = $this->uploads_root;

					$src_file = $uploads_root."/index.html";

					$dest_file = $uploads_path."/index.html";

					copy($src_file,$dest_file);

				}

				

				$file_uploaded->move($this->uploads_path, $audio); 
						
				$Model_Data = GeneralSetting::find(12);
				$Model_Data->title = 'User Arrived Notification Audio';
				$Model_Data->value = ltrim(rtrim($audio));
				$Model_Data->updated_by = Auth::user()->id;
				$Model_Data->save();

			}

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

			$Model_Data = GeneralSetting::find($id);

			

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

    public function startRamadan()

    {

		$id = 8;
		
        $Auth_User = Auth::user();

        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))

        {

            $Model_Data = GeneralSetting::find($id);



            if (empty($Model_Data))

            {

                Flash::error($this->msg_not_found);

                return redirect(route($this->home_route));

            }



            $Model_Data->value = 1;



            $Model_Data->updated_by = $Auth_User->id;

            $Model_Data->save();



            Flash::success('Ramadan started successfully.');

            return redirect(route($this->home_route));

        }

        else

        {

            Flash::error($this->edit_permission_error_message);

            return redirect()->route($this->home_route);

        }

    }

    public function endRamadan()

    {

		$id = 8;
		
        $Auth_User = Auth::user();

        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))

        {

            $Model_Data = GeneralSetting::find($id);



            if (empty($Model_Data))

            {

                Flash::error($this->msg_not_found);

                return redirect(route($this->home_route));

            }



            $Model_Data->value = 0;



            $Model_Data->updated_by = $Auth_User->id;

            $Model_Data->save();



            Flash::success('Ramadan ended successfully.');

            return redirect(route($this->home_route));

        }

        else

        {

            Flash::error($this->edit_permission_error_message);

            return redirect()->route($this->home_route);

        }

    }

}
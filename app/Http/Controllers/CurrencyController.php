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

use App\Models\Currency;

class CurrencyController extends Controller
{
    private $views_path = "currencies";

    private $dashboard_route = "dashboard";

    private $home_route = "currencies.index";
    private $create_route = "currencies.create";
    private $edit_route = "currencies.edit";
    private $view_route = "currencies.show";
    private $delete_route = "currencies.destroy";

    private $msg_created = "Currency added successfully.";
    private $msg_updated = "Currency updated successfully.";
    private $msg_deleted = "Currency deleted successfully.";
    private $msg_not_found = "Currency not found. Please try again.";
    private $msg_required = "Please fill all required fields.";
    private $msg_exists = "Record Already Exists with same Type name";

    private $list_permission = "currencies-listing";
    private $add_permission = "currencies-add";
    private $edit_permission = "currencies-edit";
    private $view_permission = "currencies-view";
    private $status_permission = "currencies-status";
    private $delete_permission = "currencies-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Currencies. Please Contact Administrator.";
    private $add_permission_error_message = "Error: You are not authorized to Add Currency. Please Contact Administrator.";
    private $edit_permission_error_message = "Error: You are not authorized to Update Currency. Please Contact Administrator.";
    private $view_permission_error_message = "Error: You are not authorized to View Currency details. Please Contact Administrator.";
    private $status_permission_error_message = "Error: You are not authorized to change status of Currency. Please Contact Administrator.";
    private $delete_permission_error_message = "Error: You are not authorized to Delete Currency. Please Contact Administrator.";
	
	
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
            $records = Currency::select(['id'])->where('id', '>=', 1)->limit(1)->get();
            foreach($records as $record)
            {
                $records_exists = 1;
            }

            $get_currency_record = Currency::select('id','code','rate')->where('id', '>', 0)->where('status',1)->get();

            $is_default_currency =  Currency::select('id','code','rate')->where('is_default',1)->first();

            return view($this->views_path.'.listing', compact("records_exists", "get_currency_record", "is_default_currency"));
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
            $Records = Currency::select(['currencies.id', 'currencies.code', 'currencies.name', 'currencies.rate', 'currencies.is_default', 'currencies.status'])
            ->where('is_default', '!=', 1);

            $response= Datatables::of($Records)
                ->filter(function ($query) use ($request) {
                    if ($request->has('code') && !empty($request->code))
                    {
                        $query->where('currencies.code', 'like', "%{$request->get('code')}%");
                    }
                    if ($request->has('name') && !empty($request->name))
                    {
                        $query->where('currencies.name', 'like', "%{$request->get('name')}%");
                    }
                    if ($request->has('rate') && $request->get('rate') != -1)
                    {
                        $query->where('currencies.rate', '>=', "{$request->get('rate')}");
                    }
                    if ($request->has('is_default') && $request->get('is_default') != -1)
                    {
                        $query->where('currencies.is_default', '=', "{$request->get('is_default')}");
                    }
                    if ($request->has('status') && $request->get('status') != -1)
                    {
                        $query->where('currencies.status', '=', "{$request->get('status')}");
                    }
                })
                ->addColumn('status', function ($Records) {
                    $record_id = $Records->id;
                    $status = $Records->status;
                    $Auth_User = Auth::user();

                    $is_default = $Records->is_default; //$this->is_default_yes_or_no($record_id);

                    $str = '';
                    if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
                    {
                        if($status == 1 && $is_default == 0)
                        {
                            $str = '<a href="'.route('currencies_deactivate',$record_id).'" class="btn btn-success btn-sm"  title="Make Currency Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';
                        }
                        elseif($status == 0 && $is_default == 0)
                        {
                            $str = '<a href="'.route('currencies_activate',$record_id).'" class="btn btn-danger btn-sm"  title="Make Currency Inactive">
					<span class="fa fa-power-off "></span> Active
					</a>';

                        }
                        elseif($status == 0 && $is_default == 1)
                        {
                            $str = '<a href="javascript:void(0)" class="btn btn-success btn-sm">
                                    <span class="fa fa-power-off "></span>
                                    </a>';
                        }
                        elseif($status == 1 && $is_default == 1)
                        {
                            $str = '<a href="javascript:void(0)" class="btn btn-success btn-sm">
                                    <span class="fa fa-power-off "></span>
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
                ->addColumn('is_default', function ($Records) {
                    $record_id = $Records->id;
                    $is_default = $Records->is_default;
                    $Auth_User = Auth::user();

                    $is_active = $Records->status; //$this->is_active_yes_or_no($record_id);

                    $str = '';
                    if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
                    {
                        if($is_default == 1 && $is_active == 0)
                        {
                            $str = '<a href="javascript:void(0)" class="btn btn-success btn-sm">
                                    <span class="fa fa-power-off "></span>
                                    </a>';
                        }
                        elseif($is_default == 0 && $is_active == 0)
                        {
                            $str = '<a href="javascript:void(0)" class="btn btn-danger btn-sm">
                                    <span class="fa fa-power-off "></span>
                                    </a>';

                        }
                        elseif($is_default == 0 && $is_active == 1)
                        {
                            $str = '<a href="'.route('currencies_default',$record_id).'" class="btn btn-danger btn-sm" title="Make Currency Default">
                                    <span class="fa fa-power-off"></span>
                                    </a>';
                        }
                        elseif($is_default == 1 && $is_active == 1)
                        {
                            $str = '<a href="javascript:void(0)" class="btn btn-success btn-sm">
                                    <span class="fa fa-power-off "></span>
                                    </a>';
                        }
                    }
                    else
                    {
                        if($is_default == 1)
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
                    $is_default = $Records->is_default; //$this->is_default_yes_or_no($record_id);

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
                        /*$str.= ' <a class="btn btn-outline-warning" href="#"  ui-toggle-class="bounce" ui-target="#animate" title="Delete" onclick="deleteModal('.$record_id.')">
								<i class="fa fa-trash"></i>
								</a>';

                                if($is_default == 1)
                                {
                                    {
                                        $str.='<div id="m-'.$record_id.'" class="modal fade" data-backdrop="true">
                                                    <div class="modal-dialog" id="animate">
                                                        <div class="modal-content">
                                                            <form action="" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm delete following record</h5>
                                                            </div>
                                                            <div class="modal-body text-center p-lg">
                                                                <p>
                                                                    Sorry Default record can not be Deleted?
                                                                    <br>
                                                                    <strong>[ '.$Records->name.' ]</strong>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Back</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>';
                                    }
                                }
                                else
                                {
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
                                } */
                    }

                    $str.= "</div>";
                    return $str;

                })
                ->rawColumns(['status', 'is_default', 'action'])
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
                'code' => 'required',
                'name' => 'required',
                'symbol' => 'required',
                'rate' => 'required'
            ]);

            $match_if_exists = Currency::where('code', $request->code)->orwhere('name', $request->name)->count();

            if($match_if_exists == 0)
            {
                if($request->is_default == "No")
                {
                    $Model_Data = new Currency();
                    $Model_Data->code = $request->code;
                    $Model_Data->name = $request->name;
                    $Model_Data->symbol = $request->symbol;
                    $Model_Data->rate = $request->rate;

					$Model_Data->created_by = $Auth_User->id;
                    $Model_Data->save();
                }   
                elseif($request->is_default == "Yes")
                {
                    $Model_Data = new Currency();
                    $Model_Data->code = $request->code;
                    $Model_Data->name = $request->name;
                    $Model_Data->symbol = $request->symbol;
                    $Model_Data->rate = $request->rate;

					$Model_Data->created_by = $Auth_User->id;
                    $Model_Data->save();

                    $id = $Model_Data->id;

                    Currency::select('id')->where('id', '>', 0)->update(['is_default' => '0','updated_by' => $Auth_User->id]);

                    Currency::where('id', $id)->update(['is_default' => '1','updated_by' => $Auth_User->id]);
                }
            }
            else
            {
                Flash::error('Data Already Available With Same Details');
                return redirect(route($this->home_route));
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
            $Model_Data = Currency::find($id);

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
            $Model_Data = Currency::find($id);

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
            $Model_Data = Currency::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
			
            $request->validate([
                'code' => 'required',
                'name' => 'required',
                'symbol' => 'required',
                'rate' => 'required'
            ]);

            $code = ltrim(rtrim($request->code));
            $name = ltrim(rtrim($request->name));

            $duplicate_count = 0 ;
            $duplicate_count = Currency::where('code',$code)->where('name',$name)->count();

            if($duplicate_count > 0)
            {
                if($request->is_default == "No")
                {   
                    $Model_Data->code = $request->code;
                    $Model_Data->name = $request->name;
                    $Model_Data->symbol = $request->symbol;
                    $Model_Data->rate = $request->rate;
                    if($Model_Data->is_default == 1)
                    {
                        $Model_Data->is_default = 0;
                        Currency::where('id', 1)->update(['is_default' => '1','updated_by' => $Auth_User->id]);
                    }
    
                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();
                }
                elseif($request->is_default == "Yes")
                {
                    $Model_Data->code = $request->code;
                    $Model_Data->name = $request->name;
                    $Model_Data->symbol = $request->symbol;
                    $Model_Data->rate = $request->rate;
    
                    $Model_Data->updated_by = $Auth_User->id;
                    $Model_Data->save();
    
                    Currency::select('id')->where('id', '>', 0)->update(['is_default' => '0','updated_by' => $Auth_User->id]);
    
                    Currency::where('id', $id)->update(['is_default' => '1','updated_by' => $Auth_User->id]);
                }
            }
            else
            {
                Flash::error('Data Already Available With Same Details');
                return redirect(route($this->edit_route, $id));
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

    public function currency_rate_update(Request $request)
    {        
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $count_id = count($request['id']);
            $array = array();
            $array_data = array();
            for($i=0; $i<$count_id; $i++)
            {
                $array_data['id'] = $request['id'][$i];
                $array_data['rate'] = $request['rate'][$i];
                $array[] = $array_data;
            }
            foreach($array as $currency)
            {
                $currency_id = $currency['id'];
                $currency_rate = $currency['rate'];

                if($currency_rate > 0)
                {
                    Currency::where('id', $currency_id)->update(['rate' => $currency_rate,'updated_by' => $Auth_User->id]);
                }                
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
	* update default status of the specified resource in storage.
	*
	* @param  \App\Models\Model  $id
	* @return \Illuminate\Http\Response
	*/
    public function makeDefault($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $Model_Data = Currency::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            Currency::select('id')->where('id', '>', 0)->update(['is_default' => '0','updated_by' => $Auth_User->id]);

            $Model_Data->is_default=1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->update();

            Flash::success('Currency set as default successfully.');
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
            $Model_Data = Currency::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 1;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Currency made Active successfully.');
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
            $Model_Data = Currency::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $Model_Data->status = 0;
            $Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Currency made InActive successfully.');
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
            $Model_Data = Currency::find($id);

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

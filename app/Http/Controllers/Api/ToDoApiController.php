<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\AppUser;
use App\Models\AppUserToDo;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToDoApiController extends BaseController
{
    private $_token = null;
    private $lat= null;    
    private $lng=null;	
    private $radius=null;
    private $uploads_root = "uploads";
    private $uploads_path = "uploads/app_users";
    private $uploads_orders_path = "uploads/svc/orders";

    public function retMethod(Request $request, $action='listing')
    {
        ((!empty($request->header('token'))) ? $this->_token=$request->header('token') : $this->_token=null);

        $token =  $this->_token;
        if(!empty($token))
        {
            $Verifications = DB::table('verification_codes')->where('token', $token)->where('expired', 1)->first();
            if(empty($Verifications))
            {
                $response = [
                    'code' => '201',
                    'status' => false,
                    'token' => $token,
                    'data' => null,
                    'message' => 'Incorrect Access Token!',
                ];
                return response()->json($response,200);
            }
        }
		else
        {
            return $this->sendError('Please Provide valid Access Token');
        }
		
		$user_id = 0;
        $User = getUser($this->_token);
        if($User!=null)
        {
            $user_id = $User->id;
        }
        else
        {
            return $this->sendError('Incorrect Access Token Provided');
        }
        

        ((!empty($request->header('lat'))) ? $this->lat=$request->header('lat') : $this->lat=null);        

        ((!empty($request->header('lng'))) ? $this->lng=$request->header('lng') : $this->lng=null);        

        ((!empty($request->header('radius'))) ? $this->radius=$request->header('radius') : $this->radius=5);

        $page = 1;
        $limit = 10;
        (isset($request->page) ? $page = trim($request->page) : 1);
        (isset($request->limit) ? $limit = trim($request->limit) : 10);

        
		switch($action)
		{
			case 'listing':
			{
				return $this->listing($request, $user_id, $page, $limit);
			}
			break;

			case 'create':
			{
				return $this->create($request, $user_id);
			}
			break;

			case 'update':
			{
				return $this->update($request, $user_id);
			}
			break;

			case 'delete':
			{
				return $this->delete($request, $user_id);
			}
			break;

			default:
			{
				return $this->sendError('Invalid Request');
			}
			break;
		}
    }

    public function allUsers($page,$limit)
    {
        $skip = (($page-1)*$limit);
        return User::all();
    }


    public function listing($request, $user_id, $page, $limit)
    {
        $skip = (($page-1)*$limit);

        $count_all = AppUserToDo::where(['user_id'=>$user_id]);
        $count_all = $count_all->select('id');
        $count_all = $count_all->count();


        $Records = AppUserToDo::where(['user_id'=>$user_id]);
        $Records = $Records->skip($skip);
        $Records = $Records->take($limit);
        $Records = $Records->get();


        $records_data = null;
        $page_count = 0;
        $message  = 'No Record Found.';

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = get_to_do_array($model);
            }
            if(!empty($records_data))
            {
                $page_count = count($records_data);
                $message  = 'All To Dos Listing retrieved successfully.';
            }
        }

        $data = array();
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = $page_count;
        $data['total_count'] = $count_all;
        $data['to_dos'] = $records_data;

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function create(Request $request, $user_id)
    {
        if((isset($request->title) && $request->title!='')&& (isset($request->description) && $request->description!='') )
        {
            $title = $request->title;
            $description = $request->description;

            $is_pinned = 0;
            if(isset($request->is_pinned) && $request->is_pinned != 0){
                $is_pinned = $request->is_pinned;
            }

            $record = new AppUserToDo();

            $record->user_id = $user_id;
            $record->title = $title;
            $record->description = $description;
            $record->is_pinned = $is_pinned;
            $record->created_by = $user_id;

            $record->save();

            if($record->id > 0)
            {
                $record = AppUserToDo::find($record->id);

                $array = get_to_do_array($record);

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'To Do created successfully!',
                    'data' => $array

                ];

                return response()->json($response,200);
            }
        }
        else
        {
            return $this->sendError('Required parameters are missing!');
        }
    }

    public function update(Request $request, $user_id)
    {
        if( (isset($request->to_do_id) && $request->to_do_id!='') )
        {
            $count =0;
            $count = AppUserToDo::find($request->to_do_id)->count();
            if($count<=0){
                return $this->sendError('To Do is not Available against requested id');
            }

            $id = $request->to_do_id;
            $record =AppUserToDo::find($id);

            if((isset($request->to_do_id) && $request->to_do_id != '')){
                $record->title = $request->title;
            }

            if((isset($request->description) && $request->description != '')){
                $record->title = $request->description;
            }

            if((isset($request->is_pinned) && $request->is_pinned != '')){
                $record->is_pinned = $request->is_pinned;
            }

            if((isset($request->status) && $request->status != '')){
                $record->status = $request->status;
            }

            $record->save();

            if($record->id > 0)
            {
                $array = get_to_do_array($record);

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'To Do updated successfully!',
                    'data' => $array
                ];

                return response()->json($response,200);
            }
        }
        else
        {
            return $this->sendError('Required parameters are missing!');
        }
    }

    public function delete(Request $request, $user_id)
    {
        if( $request->to_do_id!='' )
        {
            $count =0;
            $count = AppUserToDo::find($request->to_do_id)->count();
            if($count<=0){
                return $this->sendError('To Do is not Available against requested id');
            }

            $record = AppUserToDo::where('id',$request->to_do_id)->delete();

            if($record){

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'To Do Deleted successfully!'
                ];
                return response()->json($response,200);
            }
            else{
                return $this->sendError('Error in Removing Item!');
            }

        }
        else
        {
            return $this->sendError('Required parameters are missing!');
        }
    }

}

?>
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\AppUser;
use App\Models\Notification;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationApiController extends BaseController
{
    private $_token = null;
    private $lat= null;    
    private $lng=null;	
    private $radius=null;
	
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
				return $this->notificationListing($request, $user_id, $page, $limit);
			}
			break;
			
			case 'details':
			{
				return $this->notificationDetails($request, $user_id);
			}
			break;
			
			case 'mark-as-read':
			{
				return $this->notificationRead($request, $user_id);
			}
			break;			
			
			default:
			{
				return $this->sendError('Invalid Request');
			}
			break;
		}
	}
	
	
	public function notificationListing(Request $request, $user_id, $page=1, $limit=10)
	{
		
		$skip = (($page-1)*$limit);
		
		$read_status = $request->read_status;
		$module = $request->module;
		
		$count_all = Notification::where('user_id',$user_id)->where('read_status',$read_status)->where('module',$module);
		$count_all = $count_all->select(['id']);
		$count_all = $count_all->count();
		
		$Records =  Notification::where('user_id',$user_id)->where('read_status',$read_status)->where('module',$module);
		$Records = $Records->orderBy('id','desc');
		$Records = $Records->skip($skip);
		$Records = $Records->take($limit);
		$Records = $Records->get();
		
		$notifications = array();
		$page_count = 0;
		$message  = 'Notifications Listing retrieved successfully.';
		
		if(!empty($Records))
		{
			foreach($Records as $record)
			{
				$id	= $record->id;
				$array = notifications_array($record);
				$notifications[] = $array;
			}
			$page_count = ceil($count_all/$limit);
			if($page_count == 0)
			{
				$notifications = array();
				$message  = 'No Record Found.';
			}
		}
		
		$data = array();
		$data['type'] = 'notifications';
		$data['page'] = (int)$page;
		$data['limit'] = (int)$limit;
		$data['page_count'] = $page_count;
		$data['total_count'] = $count_all;
		$data['notifications'] = $notifications;
		
		$response = [
			'code' => '201',
			'status' => true,
			'message' => $message,
			'data' => $data,
		];
		return response()->json($response,200);
		
	}
	
	public function notificationDetails(Request $request, $user_id)
	{
		if(isset($request->id))
		{			
			$Record = Notification::find($request->id);
			if ($Record != null && !empty($Record))
			{
				$Response = get_notification_details($Record);
				
				$Record->read_status = 1;
				$Record->read_time = time();
				$Record->save();
				
				$message = 'No Record Found.';
				if($Response!=null)
				{
					$message = 'Notification Details Successfully retrieved';
				}
				$response = [
					'code' => '201',
					'status' => true,
					'message' => $message,
					'data' => $Response,
				];
				
				return response()->json($response,200);
			}
		}
		return $this->sendError('Please provide Notification id.');
	}
	
	public function notificationRead(Request $request, $user_id)
	{
		if(isset($request->ids))
		{			
			$ids = $request->ids;
			$ids = explode(',', $ids);
			foreach($ids as $id){
				Notification::where('id',$id)->update(['read_status'=>1,'read_time'=>time()]);
			}
			$message = 'Notification Mark as Read Successfully';
			$response = [
				'code' => '201',
				'status' => true,
				'message' => $message
			];
			
			return response()->json($response,200);
		}
		
		return $this->sendError('Please provide Notification ids.');
	}
	
}

?>
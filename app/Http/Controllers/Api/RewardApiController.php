<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardType;
use App\Models\RewardDiscountType;
use App\Models\RewardHistory;


class RewardApiController extends Controller
{
    public function retMethod(Request $request, $action)
    {
        switch($action)
        {
            case 'rewards-listing':
                {
                    return $this->showAllRewards($request);
                }
            break;

            case 'reward-types-listing':
                {
                     return $this->reward_types($request);
                }
            break;

            // case 'reward-discount-types-listing':
            //     {
            //          return $this->reward_discount_types();
            //     }
            // break;

            // case 'rewards-by-type':
            //     {
            //          return $this->showAllRewardsByType($request);
            //     }
            // break;

            // case 'rewards-by-discount-type':
            //     {
            //          return $this->showAllRewardsByDiscountType($request);
            //     }
            // break;

            // case 'user-rewards-listing':
            //     {
            //          return $this->user_rewards_listing($request);
            //     }
            // break;

            default :
                {
                    return 0;
                }
        }
       
    }





    public function showAllRewards(Request $request)
	{
		$page = 1;
		$limit = 10;
		$skip = 0;
		if(!empty($request->page))
		{
			$page = $request->page;
     	}
		if($request->limit)
		{
			$limit = $request->limit;
			$skip=($page-1)*$limit;
		}
		
		
		$count_all = Reward::where(['rewards.status'=>1]);

	    $count_all = $count_all->select(['rewards.id']);
		
		$count_all = $count_all->count();
		
		
		
		$Records =  Reward::where(['rewards.status'=> 1])->get();

        $records_data = array();
        foreach($Records as $model)
        {
                $records_data[] = $this->get_rewards_data($model);
        
        }
		
		
		
		//$Records = $Records->orderBy('rewards.id','DESC');
		
		$Records = $Records->skip($skip);
		
		$Records = $Records->take($limit);
		
		
		
		
		
		$rewards = $Records ;
		
		$message  = 'No Record Found.';
		
		
		
		if( !empty($Records))
		
		{
			
			
				
				//$rewards = $array_data;
				$message  = 'All Rewards Listing retrieved successfully.';
			
			
		}
		
		
		
		$data = array();
		
		$n_arr = array();
	
		$n_arr['page'] = $page;
		
		$n_arr['limit'] = $limit;
		
		$n_arr['page_count'] = count($Records);
		
		$n_arr['total_count'] =$count_all;
		
		//$n_arr['rewards_data'] = $rewards;
		
        $n_arr['rewards_data'] = $records_data;
		
		$data = $n_arr;
		
		
		
		$response = [
			
			'code' => '201',
			
			'status' => true,
			
			'data' => $data,
			
			'message' => $message,
		
		];
		
		return response()->json($response,200);
		
	}


    public function get_rewards_data($record)
	{
		$record_id = $record->id;
		
		
		$array = array();
		
		$array['id'] = $record_id;
		$array['vendor_id'] = $record->vendor_id;
		$array['silver_punches'] = $record->silver_punches;
		$array['silver_fixed_value'] = $record->silver_fixed_value;
		$array['silver_discount_percentage'] = $record->silver_discount_percentage;
		$array['golden_punches'] = $record->golden_punches;
		$array['golden_fixed_value'] = $record->golden_fixed_value;
		$array['golden_discount_percentage'] = $record->golden_discount_percentage;
		$array['platinum_punches'] = $record->platinum_punches;
		$array['platinum_fixed_value'] = $record->platinum_fixed_value;
		$array['platinum_discount_percentage'] = $record->platinum_discount_percentage;
		$array['min_order_value'] = $record->min_order_value;
		$array['fixed_value'] = $record->fixed_value;
		$array['intervals'] = $record->intervals;
		$array['start_time'] = $record->start_time;
		$array['end_time'] = $record->end_time;
		//$array['reward_types'] = $reward_types_array;
		
		
		return $array;
		
	}


    public function reward_types(Request $request)
    {
		$page = 1;
		$limit = 10;
		$skip = 0;
		if(!empty($request->page))
		{
			$page = $request->page;
     	}
		if($request->limit)
		{
			$limit = $request->limit;
			$skip=($page-1)*$limit;
		}
		
		$array = array();
		$rewardTypes = RewardType::where('status', 1)
                       ->select(['id','name','name_ar'])->get();

		foreach($rewardTypes as $reward_type)
		{

			$array[] = $this->get_reward_types_data($reward_type);
		}

		$data = array();
		
		$n_arr = array();
	
		$n_arr['page'] = $page;
		
		$n_arr['limit'] = $limit;
		
		$n_arr['page_count'] = count($rewardTypes);
		
		$n_arr['total_count'] =count($rewardTypes);

		$n_arr['reward_types'] = $array;
		$data = $n_arr;
        $response = [
			
			'code' => '201',
			
			'status' => true,
			
			'message' => 'Reward Types Listing retrieved successfully.',
			
			'data' => $data,
		
		];
		
		return response()->json($response,200);
    }

	public function get_reward_types_data($reward_type)
	{
		
		
		$rewardTypes['name'] = $reward_type->name ;
		$rewardTypes['name_ar'] = $reward_type->name_ar ;

		$image = $reward_type->icon;
        $image_path = 'reward_types/';
       	$image_path.= $image;
        	
		$rewardTypes['icon']=uploads($image_path);
	

		return  $rewardTypes;
		 
	}


    // public function showAllRewardsByType(Request $request)
	// {
	// 	$page = $request->page;
    //     $limit = $request->limit;
    //   	$skip=($page-1)*$limit;
		
    //     $reward_type = $request->reward_type;  
		
	// 	$count_all = Reward::leftjoin('svc_vendors','rewards.vendor_id','=','svc_vendors.id');
		
    //     $count_all = $count_all->where(['rewards.type'=>$reward_type]);
        
	// 	$count_all = $count_all->where(['rewards.status'=>1,'svc_vendors.status'=>1]);
		
	// 	$count_all = $count_all->select(['rewards.id']);
		
	// 	$count_all = $count_all->count();
		
		
		
	// 	$Records =  Reward::leftjoin('svc_vendors', 'rewards.vendor_id', '=', 'svc_vendors.id')
    //                         ->where(['rewards.status'=> 1, 'svc_vendors.status'=> 1])
    //                         ->where(['rewards.type'=>$reward_type])
    //                         ->select(['rewards.*'])->get();

    //     $records_data = array();
    //     foreach($Records as $model)
    //     {
    //             $records_data[] = $this->get_reward_types($model);
        
    //     }
		
		
		
	// 	//$Records = $Records->orderBy('rewards.id','DESC');
		
	// 	$Records = $Records->skip($skip);
		
	// 	$Records = $Records->take($limit);
		
		
		
		
		
	// 	$rewards = $Records ;
		
	// 	$message  = 'No Record Found.';
		
		
		
	// 	if( !empty($Records))
		
	// 	{
			
			
				
	// 			//$rewards = $array_data;
	// 			$message  = 'All Rewards Listing retrieved successfully.';
			
			
	// 	}
		
		
		
	// 	$data = array();
		
	// 	$n_arr = array();
	
	// 	$n_arr['page'] = $page;
		
	// 	$n_arr['limit'] = $limit;
		
	// 	$n_arr['page_count'] = count($Records);
		
	// 	$n_arr['total_count'] =$count_all;
		
	// 	//$n_arr['rewards_data'] = $rewards;
		
    //     $n_arr['rewards_data'] = $records_data;
		
	// 	$data = $n_arr;
		
		
		
	// 	$response = [
			
	// 		'code' => '201',
			
	// 		'status' => true,
			
	// 		'data' => $data,
			
	// 		'message' => $message,
		
	// 	];
		
	// 	return response()->json($response,200);
		
	// }
		
    
}

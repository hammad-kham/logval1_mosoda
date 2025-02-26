<?php

use App\Models\SvcVendor;




use App\Models\Reward;
use App\Models\RewardHistory;
use App\Models\RewardType;
use App\Models\RewardUser;



use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderSubDetail;

use App\Models\User;
use App\Models\AppUser;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;




if (! function_exists('update_reward_history'))
{
	function update_reward_history($reward_id,$rest_id,$user_id,$claimable)
	{
		$reward_history_data = null;
		if(!empty($claimable) && $rest_id>0 && $user_id>0 && $claimable>0)
		{
			$exists = 0;
			{
				$reward_histories = RewardHistory::where('reward_id',$reward_id)->where('user_id',$user_id)->where('rest_id',$rest_id)->get();
				foreach($reward_histories as $reward_history)
				{
					$exists = 1;
					$id = $reward_history->id;
					
					$claimed = $reward_history->claimed;					
					$claimable = ($claimable - $claimed);
					
					$history = RewardHistory::find($id);
					
					$history->claimable = $claimable;				
					
					$history->save();
					
					$reward_history_data = array();
					$reward_history_data['reward_claimable'] = $claimable;
					$reward_history_data['reward_claimed'] = $claimed;
				}
			}
			if($exists == 0)
			{
					$history = new RewardHistory();	
			
					$history->reward_id = $reward_id;
					$history->user_id = $user_id;
					$history->rest_id = $rest_id;
					$history->claimable = $claimable;					
					
					$history->save();	
					
					$reward_history_data = array();
					$reward_history_data['reward_claimable'] = $claimable;
					$reward_history_data['reward_claimed'] = 0;			
			}
			
		}
		
		return $reward_history_data;
	}
}




if (! function_exists('update_reward_claims'))
{
	function update_reward_claims($reward_id,$rest_id,$user_id)
	{
		$reward_histories = RewardHistory::where('reward_id',$reward_id)->where('user_id',$user_id)->where('rest_id',$rest_id)->get();
		foreach($reward_histories as $reward_history)
		{
			$id = $reward_history->id;
							
			$claimable = $reward_history->claimable;
			$claimable--;
			
			$claimed = $reward_history->claimed;
			$claimed++;	
			
			$history = RewardHistory::find($id);
			
			$history->claimable = $claimable;
			$history->claimed = $claimed;				
			
			$history->save();
		}
	}
}




if (! function_exists('check_reward_claims'))
{
	function check_reward_claims($reward_id, $vendor_id, $user_id)
	{
		$claimable = 0;
		$reward_histories = RewardHistory::where('reward_id',$reward_id)->where('user_id',$user_id)->where('vendor_id',$vendor_id)->get();
		foreach($reward_histories as $reward_history)
		{							
			$claimable = $reward_history->claimable;
		}
		
		return $claimable;
	}
}




if (! function_exists('get_rest_rewards'))
{
	function get_rest_rewards($rest_id,$user_id = 0)
	{
		$rewards = null;
		
		$Records = Reward::leftjoin('SvcVendors','rewards.rest_id','=','restaurants.id');
		$Records = $Records->where(['rewards.status'=>1,'restaurants.status'=>1]);
		$Records = $Records->select(['rewards.id','rewards.created_at','rewards.activated_at','rewards.rest_id','rewards.min_orders','rewards.min_order_value','rewards.type','rewards.apply_type','rewards.fixed_value','rewards.discount_percentage','rewards.has_limitations','rewards.intervals','rewards.start_date','rewards.end_date']);
		$Records = $Records->where('rewards.rest_id' ,'=', $rest_id);
		$Records = $Records->get();
		
		
		if( !empty($Records))
		{
			
			$array_data = rewards_data($Records,null,null,null,$rest_id,$user_id);
			if(!empty($array_data))
			{
				$rewards = $array_data;
			}
		}
		
		return $rewards;
	}
}

if (! function_exists('get_rest_claim_rewards'))
{
	function get_rest_claim_rewards($rest_id,$user_id = 0)
	{
		$rewards = null;

		$Records = Reward::leftjoin('restaurants','rewards.rest_id','=','restaurants.id');
		$Records = $Records->where(['rewards.status'=>1,'restaurants.status'=>1]);
		$Records = $Records->select(['rewards.id','rewards.created_at','rewards.activated_at','rewards.rest_id','rewards.min_orders','rewards.min_order_value','rewards.type','rewards.apply_type','rewards.fixed_value','rewards.discount_percentage','rewards.has_limitations','rewards.intervals','rewards.start_date','rewards.end_date']);
		$Records = $Records->where('rewards.rest_id' ,'=', $rest_id);
		$Records = $Records->get();


		if( !empty($Records))
		{

			$array_data = rewards_claim_data($Records,null,null,null,$rest_id,$user_id);
			if(!empty($array_data))
			{
				$rewards = $array_data;
			}
		}

		return $rewards;
	}
}





if (! function_exists('rewards_data'))

{
	
	function rewards_data($Records, $token=null, $lat=null, $lng=null, $rest='0',$user_id = 0)
	
	{
		
		$Data_Array = array();
		
		$data_array=null;
		
		foreach ($Records as  $Record) {
			
			$data_array=array();
			
			$reward_type = $Record->type;
			$reward_id = $Record->id;
			$reward_apply_type = $Record->apply_type;
			
			
			$data_array['id'] = $Record->id;
			//$data_array['min_orders'] = $Record->min_orders;
			//$data_array['min_order_value'] = $Record->min_order_value;
			$data_array['min_punches'] = $Record->min_orders;
			$data_array['min_punch_value'] = $Record->min_order_value;
			$data_array['type'] = $reward_type;
			
			$reward_type_data = RewardType::find($reward_type);
			$data_array['reward_type_name'] = $reward_type_data->name;
			
			
			if($reward_type == 1){
				$data_array['fixed_value'] = $Record->fixed_value;
			}
			elseif($reward_type == 2){
				$data_array['discount_percentage'] = $Record->discount_percentage;
			}
			
			
			if($Record->has_limitations == 0){
				$data_array['has_limitations'] = false;
			}
			else if($Record->has_limitations == 1){
				$data_array['has_limitations'] = true;
				$data_array['intervals'] = ($Record->intervals)." days";
			}
			elseif($Record->has_limitations == 2){
				$data_array['has_limitations'] = true;
				$data_array['start_date'] = date("Y-m-d",$Record->start_date);
				$data_array['end_date'] = date("Y-m-d",$Record->end_date);
			}
			
			
			
			$data = null;
			
			if($reward_type == 1 || $reward_type == 2) {
				if ($reward_apply_type == 0) {
					$data_array['available_on'] = 'Menus';
					$Reward_Menus = DB::table('menus')
						->join('reward_menus', 'menus.id', '=', 'reward_menus.menu_id')
						->select('menus.id', 'menus.title')
						->where('menus.availability', 1)
						->where('menus.status', 1)
						->where('reward_menus.status', 1)
						->where('reward_menus.reward_id', $reward_id)
						->orderBy('menus.is_order', 'asc')
						->get();
					
					if (!empty($Reward_Menus)) {
						$data = $Reward_Menus;
					}
				} else {
					
					$data_array['available_on'] = 'Items';
					$Reward_Details = DB::table('items')
						->join('reward_details', 'items.id', '=', 'reward_details.item_id')
						->join('menus', 'items.menu_id', '=', 'menus.id')
						->where('items.availability', 1)
						->where('items.status', 1)
						->where('reward_details.status', 1)
						->where('menus.status', 1)
						->where('reward_details.reward_id', $reward_id)
						->select('items.id','items.menu_id', 'items.name', 'items.total_value', 'items.is_order as item_order', 'menus.is_order as menu_order')
						->orderBy('menus.is_order', 'asc')
						->orderBy('items.is_order', 'asc')
						->get();
					
					if(!empty($Reward_Details))
					{
						$data = $Reward_Details;
					}
					
				}
			}
			else{
				$data_array['available_on'] = 'Item';
				$Reward_Details = DB::table('items')
					->join('reward_details', 'items.id', '=', 'reward_details.item_id')
					->select('items.id','items.menu_id', 'items.name', 'items.total_value')
					->where('items.availability', 1)
					->where('items.status', 1)
					->where('reward_details.status', 1)
					->where('reward_details.reward_id', $reward_id)
					->get();
				
				if(!empty($Reward_Details))
				{
					$data = $Reward_Details;
				}
			}
			
			$data_array['details'] = $data;
			
			if($rest == 'home')
			{
				$modelData = Restaurant::find($Record->rest_id);
				$data_array['restaurant'] = common_home($modelData, $token, $lat ,$lng);
			}
			
			$Data_Array[] = $data_array;
			
		}
		
		return $Data_Array;
		
	}
	
}


if (! function_exists('rewards_claim_data'))

{

	function rewards_claim_data($Records, $token=null, $lat=null, $lng=null, $rest='0',$user_id = 0)

	{

		$Data_Array = array();

		$data_array=array();
		$data_array=null;

		foreach ($Records as  $Record) {

			$data_array=array();

			$reward_type = $Record->type;
			$reward_id = $Record->id;
			$reward_apply_type = $Record->apply_type;


			$data_array['id'] = $Record->id;
			//$data_array['min_orders'] = $Record->min_orders;
			//$data_array['min_order_value'] = $Record->min_order_value;
			$data_array['min_punches'] = $Record->min_orders;
			$data_array['min_punch_value'] = $Record->min_order_value;
			$data_array['type'] = $reward_type;
			
			$reward_type_data = RewardType::find($reward_type);
			$data_array['reward_type_name'] = $reward_type_data->name;
			
			
			if($reward_type == 1){
				$data_array['fixed_value'] = $Record->fixed_value;
			}
			elseif($reward_type == 2){
				$data_array['discount_percentage'] = $Record->discount_percentage;
			}


			if($Record->has_limitations == 0){
				$data_array['has_limitations'] = false;
			}
			else if($Record->has_limitations == 1){
				$data_array['has_limitations'] = true;
				$data_array['intervals'] = ($Record->intervals)." days";
			}
			elseif($Record->has_limitations == 2){
				$data_array['has_limitations'] = true;
				$data_array['start_date'] = date("Y-m-d",$Record->start_date);
				$data_array['end_date'] = date("Y-m-d",$Record->end_date);
			}



			$data = null;

			$data_details = null;

			//Fixed Discount Reward
			if($reward_type == 1) {
				
				if ($reward_apply_type == 0) 
				{
					$data_array['available_on'] = 'Menus';
					$Reward_Menus = DB::table('menus')
						->join('reward_menus', 'menus.id', '=', 'reward_menus.menu_id')
						->select('menus.id', 'menus.title')
						->where('menus.availability', 1)
						->where('menus.status', 1)
						->where('reward_menus.status', 1)
						->where('reward_menus.reward_id', $reward_id)
						->orderBy('menus.is_order', 'asc')
						->get();
						
					if(!empty($Reward_Menus))
					{
						$data_details = array();
						foreach ($Reward_Menus as $Reward_Menu){
							$data = array();

							$data["menu_id"] = $Reward_Menu->id;
							$data["title"] = $Reward_Menu->title;
							$Menu_items = Items::where('menu_id',$Reward_Menu->id)->where('availability',1)->where('status',1)->orderBy('is_order','asc')->get();

							$data_items = array();
							foreach($Menu_items as $menu_item){
								$data_item_details = array();
								$data_item_details['id'] = $menu_item->id;
								$data_item_details["name"] = $menu_item->name;
								$data_item_details["total_value"] = $menu_item->total_value;
								$data_item_details["value_after_reward"] = ($menu_item->total_value - $Record->fixed_value);
								$data_items[] = $data_item_details;
							}
							$data['items'] = $data_items;
							$data_details[] = $data;
						}
					}
				} 
				else 
				{

					$data_array['available_on'] = 'Items';
					$Reward_Details = DB::table('items')
						->join('reward_details', 'items.id', '=', 'reward_details.item_id')
						->where('items.availability', 1)
						->where('items.status', 1)
						->where('reward_details.status', 1)
						->where('reward_details.reward_id', $reward_id)
						->select('items.id','items.menu_id')
						->orderBy('items.is_order', 'asc')
						->get();

					if(!empty($Reward_Details))
					{

						$data_menus = null;
						$data_details = array();
						$menus = array();
						$menus_items = array();

						foreach ($Reward_Details as $Reward_Detail){
							$menu_id = $Reward_Detail->menu_id;
							$item_id = $Reward_Detail->id;
							if(!in_array($menu_id, $menus))
							{
								$menus[] = $menu_id;
								$menus_items[$menu_id] = array();
							}
							if(!in_array($item_id, $menus_items[$menu_id]))
							{
								$menus_items[$menu_id][] = $item_id;
							}
						}

						foreach ($menus as $menu=>$menu_id)
						{

							$data_item = array();
							$data = array();

							$Menu_detail = Menu:: where('id',$menu_id)->where('status',1)->first();
							$data["menu_id"] = $Menu_detail->id;
							$data["title"] = $Menu_detail->title;

							foreach ($menus_items[$menu_id] as $item_id){


								$Items = Items::where('id',$item_id)->where('status', 1)->get();

								foreach ($Items as $item){
									$data_item_details = array();

									$data_item_details["id"] = $item->id;
									$data_item_details["name"] = $item->name;
									$data_item_details["total_value"] = $item->total_value;
									$data_item_details["value_after_reward"] = ($item->total_value - $Record->fixed_value);

									$data_item[] = $data_item_details;

								}
							}

							$data["items"] = $data_item;
							$data_menus[] = $data;

						}
						$data_details = $data_menus;

					}
				}
			}
			
			//Percentage Discount Reward
			elseif($reward_type == 2) {
				if ($reward_apply_type == 0) {
					$data_array['available_on'] = 'Menus';

					$Reward_Menus = DB::table('menus')
						->join('reward_menus', 'menus.id', '=', 'reward_menus.menu_id')
						->select('menus.id', 'menus.title')
						->where('menus.availability', 1)
						->where('menus.status', 1)
						->where('reward_menus.status', 1)
						->where('reward_menus.reward_id', $reward_id)
						->orderBy('menus.is_order', 'asc')
						->get();
						
					if(!empty($Reward_Menus))
					{
						$data_details = array();
						foreach ($Reward_Menus as $Reward_Menu)
						{
							$data = array();

							$data["menu_id"] = $Reward_Menu->id;
							$data["title"] = $Reward_Menu->title;
							$Menu_items = Items::where('menu_id',$Reward_Menu->id)->where('availability',1)->where('status',1)->orderBy('is_order','asc')->get();

							$data_items = array();
							foreach($Menu_items as $menu_item){
								$data_item_details = array();
								$data_item_details['id'] = $menu_item->id;
								$data_item_details["name"] = $menu_item->name;
								$data_item_details["total_value"] = $menu_item->total_value;
								$data_item_details["value_after_reward"] = ($menu_item->total_value - (($menu_item->total_value*$Record->discount_percentage)/100));

								$data_items[] = $data_item_details;
							}
							$data['items'] = $data_items;
							$data_details[] = $data;
						}
					}
				} 
				else 
				{

					$data_array['available_on'] = 'Items';

					$Reward_Details = DB::table('items')
						->join('reward_details', 'items.id', '=', 'reward_details.item_id')
						->where('items.availability', 1)
						->where('items.status', 1)
						->where('reward_details.status', 1)
						->where('reward_details.reward_id', $reward_id)
						->select('items.id','items.menu_id')
						->orderBy('items.is_order', 'asc')
						->get();

					if(!empty($Reward_Details))
					{

						$data_menus = null;
						$data_details = array();
						$menus = array();
						$menus_items = array();

						foreach ($Reward_Details as $Reward_Detail){


							$menu_id = $Reward_Detail->menu_id;
							$item_id = $Reward_Detail->id;
							if(!in_array($menu_id, $menus))
							{
								$menus[] = $menu_id;
								$menus_items[$menu_id] = array();
							}
							if(!in_array($item_id, $menus_items[$menu_id]))
							{
								$menus_items[$menu_id][] = $item_id;
							}
						}

						foreach ($menus as $menu=>$menu_id){


							$data_item = array();
							$data = null;

							$Menu_detail = Menu:: where('id',$menu_id)->where('status',1)->first();
							$data["menu_id"] = $Menu_detail->id;
							$data["title"] = $Menu_detail->title;

							foreach ($menus_items[$menu_id] as $item_id){


								$Items = Items::where('id',$item_id)->where('status', 1)->get();

								foreach ($Items as $item){
									$data_item_details = array();

									$data_item_details["id"] = $item->id;
									$data_item_details["name"] = $item->name;
									$data_item_details["total_value"] = $item->total_value;
									$data_item_details["value_after_reward"] = ($item->total_value - (($item->total_value*$Record->discount_percentage)/100));


									$data_item[] = $data_item_details;

								}
							}

							$data["items"] = $data_item;
							$data_menus[] = $data;

						}
						$data_details = $data_menus;

					}
				}
			}
			
			// Free item
			else{
				$data_array['available_on'] = 'Item';
				$Reward_Details = DB::table('items')
					->join('reward_details', 'items.id', '=', 'reward_details.item_id')
					->select('items.id','items.menu_id', 'items.name', 'items.total_value')
					->where('items.availability', 1)
					->where('items.status', 1)
					->where('reward_details.status', 1)
					->where('reward_details.reward_id', $reward_id)
					->get();

				if(!empty($Reward_Details))
				{
					$data_details = array();
					foreach ($Reward_Details as $Reward_Detail){
						$data = array();
						$data_item = array();
						$Menus = Menu::where('id',$Reward_Detail->menu_id)->where('status',1)->first();

						$data["menu_id"] = $Menus->id;
						$data["title"] = $Menus->title;


						$data_item["id"] = $Reward_Detail->id;
						$data_item["menu_id"] = $Reward_Detail->menu_id;
						$data_item["name"] = $Reward_Detail->name;
						$data_item["total_value"] = $Reward_Detail->total_value;
						$data_item["value_after_reward"] = 0;

						$data["items"] = $data_item;

						$data_details[] = $data;
					}
				}
				else{
					$data_details = null;
				}
			}

			$data_array['details'] = $data_details;

			if($rest == 'home')
			{
				$modelData = Restaurant::find($Record->rest_id);
				$data_array['restaurant'] = common_home($modelData, $token, $lat ,$lng);
			}

			$Data_Array[] = $data_array;

		}

		return $Data_Array;

	}

}




if (! function_exists('reward_types_data'))

{
	
	function reward_types_data($Records)
	
	{
		
		$Data_Array = array();
		$Data_Array =null;
		$data_array=array();
		$data_array=null;
		
		
		foreach ($Records as  $Record) {
			
			$data_array=array();
			
			
			$image = $Record->icon;
			
			$deal_image_path = 'restaurants/rewards/';
			
			if($image == 'reward_type.png')
			
			{
				
				$deal_image_path = 'defaults/';
				
			}
			
			$deal_image_path.= $image;
			
			$deal_image_path = uploads($deal_image_path);
			
			$available_count = Reward::where('type',$Record->id)->where('status',1)->count();
			
			
			$data_array['id'] = $Record->id;
			
			$data_array['name'] = $Record->name;
			
			$data_array['name_ar'] = $Record->name_ar;
			
			$data_array['icon']=$deal_image_path;
			
			$data_array['available_count']=$available_count;
			
			
			
			$Data_Array[] = $data_array;
			
		}
		
		
		
		return $Data_Array;
		
	}
	
}

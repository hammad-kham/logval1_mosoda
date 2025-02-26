<?php

use App\Models\SvcBankDetail;
use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;
use App\Models\SvcSubService;

use App\Models\SvcTransaction;
use App\Models\SvcVendor;
use App\Models\SvcVendorCategory;
use App\Models\SvcVendorSubCategory;
use App\Models\SvcVendorService;



use App\Models\SvcBrand;
use App\Models\SvcBrandOption;

use App\Models\SvcReview;

use App\Models\SvcProduct;

use App\Models\SvcOrder;
use App\Models\SvcOrderFile;
use App\Models\SvcOrderDetail;
use App\Models\SvcOrderSubDetail;

use App\Models\User;
use App\Models\AppUser;
use App\Models\AppUserLocation;
use App\Models\PaymentMethod;
use App\Models\AppUserPaymentMethod;
use App\Models\SvcAppUserFavorite;
use App\Models\AppUserQuery;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


if (! function_exists('get_order_data'))
{
	function get_order_data($order_id)
	{
		$array = array();
		
		$record = SvcOrder::find($order_id);
		
		$array['id'] = $record->id;

        $status = get_svc_order_status($record->status, $record->type);

		$order_id = $record->id;
		$cat_id = $record->cat_id;
		$sub_cat_id = $record->sub_cat_id;

        $transaction = null;
        if($record->transaction_id != 0){
            $transaction = get_transaction_details($record->transaction_id);
        }

        $Record = AppUserLocation::find($record->loc_id);
		
		
		$array['status'] = $status;
		$array['is_rated'] = (($record->is_rated == 1) ? true : false);
		$array['order_no'] = $record->order_no;
		$array['user_id'] = $record->user_id;
		$array['loc_id'] = $record->loc_id;
		$array['location'] = get_user_location_data($Record);
		$array['cat_id'] = $record->cat_id;
		$array['cat_name'] = get_category_name($record->cat_id);
		$array['sub_cat_id'] = $record->sub_cat_id;
		$array['vend_id'] = $record->vend_id;
		$array['vend_name'] = get_vendor_name($record->vend_id);
		$array['vat_included'] = $record->vat_included;
		$array['vat_value'] = $record->vat_value;
		$array['final_value'] = $record->final_value;
		$array['total'] = $record->total;
		$array['type'] = $record->type;
		$array['notes'] = $record->notes;
		$array['created_at'] = $record->created_at;
		$array['transaction'] = $transaction;

		switch($cat_id)
		{
			case 2:
				{
					$array['sender_name'] = $record->sender_name;
					$array['receiver_name'] = $record->receiver_name;
					$array['message'] = $record->message;
				}
				break;
			
			case 3:
				{
					$array['need_material'] = $record->need_material;
					$array['material_notes'] = $record->material_notes;
					$array['need_ironing'] = $record->need_ironing;
					$array['cleaners'] = $record->cleaners;
				}
				break;
			
			case 5:
				{
					$array['is_ladder'] = $record->is_ladder;
					$array['ladder_length'] = $record->ladder_length;
				}
				break;
			
			case 8:
			{
				$array['need_pickup'] = $record->need_pickup;
			}
			
			case 9:
				{
					$array['drop_off_loc_id'] = $record->drop_off_loc_id;
				}
				break;
			
			case 11:
			{
				$array['current_wall_color'] = $record->current_wall_color;
				$array['new_wall_color'] = $record->new_wall_color;
				$array['add_white_color_cost'] = $record->add_white_color_cost;
				$array['need_ceilings_painted'] = $record->need_ceilings_painted;
				$array['provide_paint'] = $record->provide_paint;
				$array['brand_id'] = $record->brand_id;
				$array['paint_code'] = $record->paint_code;
				$array['rooms'] = $record->rooms;
			}
			
			case 12:
				{
					$array['date_time_drop_off'] = $record->date_time_drop_off;
					$array['additional_cost'] = $record->additional_cost;
				}
				
				break;
			
			default:
				break;
		}
		
		
		$array['date_time'] =  date('Y-m-d H:i',$record->date_time);
		
		$array['has_attributes'] = $record->has_attributes;
		$array['attributes'] = json_decode($record->attributes);
		
		$array['has_files'] = $record->has_files;
		$array['files'] = get_order_files($order_id);
		$array['details'] = get_order_details($record);
		
		
		return $array;
	}
}


if (! function_exists('get_transaction_details'))
{
	function get_transaction_details($transaction_id)
	{
		$modelData = SvcTransaction::find($transaction_id);

		$array = array();

        $array['id'] = $modelData->id;
        $array['amount'] = $modelData->amount;
        $array['transaction_id'] = $modelData->transaction_id;
        $array['card_number'] = $modelData->card_number;
        $array['card_type'] = $modelData->card_type;
        $array['card_brand'] = $modelData->card_brand;
        $array['nick_name'] = $modelData->nick_name;
        $array['transaction_date_time'] = date("Y-m-d H:i:s",$modelData->transaction_date_time);
		
		return $array;
	}
}


if (! function_exists('get_order_files'))
{
	function get_order_files($order_id)
	{
		$modelData = SvcOrderFile::select('image');
		$modelData = $modelData->where('order_id', '=', $order_id);
		//$modelData = $modelData->where('status', '=', '1');
		$modelData = $modelData->get();

		$array = array();
		foreach($modelData as $model)
		{
			$image = $model->image;
			$image_path = "svc/orders/$order_id/";
			$image_path.= $image;
			$image_path = uploads($image_path);
			$array[] = $image_path;
		}

		if(count($array)==0)
		{
			$array = null;
		}

		return $array;
	}
}


if (! function_exists('get_order_details'))
{
	function get_order_details($record)
	{
		$order_id = $record->id;
		$cat_id = $record->cat_id;
		$sub_cat_id = $record->sub_cat_id;
		
		$details_array = array();
		switch($cat_id)
		{
			case 1:
				{
					$modelData = SvcOrderDetail::select('id', 'sub_cat_id', 'service_id', 'price', 'date_time');
					$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['sub_cat_id'] = $model->sub_cat_id;
						$array['service_id'] = $model->service_id;
						$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 2:
				{
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['sub_cat_id'] = $model->sub_cat_id;
						$array['product_id'] = $model->product_id;
						$array['quantity'] = $model->quantity;
						$array['price'] = $model->price;
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 3:
				{
					$modelData = SvcOrderDetail::select('id', 'sub_cat_id', 'service_id', 'sub_service_id', 'quantity', 'covid', 'repitition', 'daily_hours', 'cleaners', 'need_material', 'material_notes', 'need_ironing', 'ironing_notes', 'price', 'date_time');
					$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['sub_cat_id'] = $model->sub_cat_id;
						$array['service_id'] = $model->service_id;
						$array['sub_service_id'] = $model->sub_service_id;
						
						$array['quantity'] = $model->quantity;
						$array['covid'] = $model->covid;
						$array['cleaners'] = $model->cleaners;
						$array['need_material'] = $model->need_material;
						$array['material_notes'] = $model->material_notes;
						$array['need_ironing'] = $model->need_ironing;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 4:
				{
					$modelData = SvcOrderDetail::select('id', 'sub_cat_id', 'service_id', 'sub_service_id', 'device_name', 'price', 'date_time');
					$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['sub_cat_id'] = $model->sub_cat_id;
						
						$array['service_id'] = $model->service_id;
						$array['sub_service_id'] = $model->sub_service_id;
						$array['device_name'] = $model->device_name;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 5:
				{
					//$modelData = SvcOrderDetail::select('id', 'service_id', 'small_items', 'medium_items', 'large_items', 'is_ladder', 'ladder_length', 'price', 'date_time');
					//$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['service_id'] = $model->service_id;
						$array['sub_service_id'] = $model->sub_service_id;
						$array['quantity'] = $model->quantity;
						
						$array['brand_id'] = $model->brand_id;
						
						$array['small_items'] = $model->small_items;
						$array['medium_items'] = $model->medium_items;
						$array['large_items'] = $model->large_items;
						$array['is_ladder'] = $model->is_ladder;
						$array['ladder_length'] = $model->ladder_length;
						
						$array['home_type_id'] = $model->home_type_id;
						$array['bed_rooms'] = $model->bed_rooms;
						$array['living_rooms'] = $model->living_rooms;
						$array['dining_rooms'] = $model->dining_rooms;
						$array['maid_rooms'] = $model->maid_rooms;
						$array['storage_rooms'] = $model->storage_rooms;
						$array['current_wall_color'] = $model->current_wall_color;
						$array['required_wall_color'] = $model->required_wall_color;
						$array['is_ceileing_color'] = $model->is_ceileing_color;
						$array['ceileing_color'] = $model->ceileing_color;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 6:
				{
					$modelData = SvcOrderDetail::select('id', 'sub_cat_id', 'service_id', 'price', 'date_time');
					$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['sub_cat_id'] = $model->sub_cat_id;
						$array['service_id'] = $model->service_id;
						
						$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 7:
				{
					//$modelData = SvcOrderDetail::select('id', 'service_id', 'price', 'date_time');
					//$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						//$array['service_id'] = $model->service_id;
						
						$array['home_type_id'] = $model->home_type_id;
						$array['bed_rooms'] = $model->bed_rooms;
						$array['living_rooms'] = $model->living_rooms;
						$array['dining_rooms'] = $model->dining_rooms;
						$array['maid_rooms'] = $model->maid_rooms;
						$array['storage_rooms'] = $model->storage_rooms;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 8:
				{
					$modelData = SvcOrderDetail::select('id', 'service_id', 'pet_size', 'need_pickup', 'price', 'date_time');
					$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['service_id'] = $model->service_id;
						$array['pet_size'] = $model->pet_size;
						$array['need_pickup'] = $model->need_pickup;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 9:
				{
					//$modelData = SvcOrderDetail::select('id', 'service_id', 'price', 'date_time');
					//$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['service_id'] = $model->service_id;
						$array['sub_service_id'] = $model->sub_service_id;
						
						$array['has_attributes'] = $model->has_attributes;
						$array['attributes'] = json_decode($model->attributes);
						
						$array['home_type_id'] = $model->home_type_id;
						$array['bed_rooms'] = $model->bed_rooms;
						$array['living_rooms'] = $model->living_rooms;
						$array['dining_rooms'] = $model->dining_rooms;
						$array['maid_rooms'] = $model->maid_rooms;
						$array['storage_rooms'] = $model->storage_rooms;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$sub_details = array();
						$detailData = SvcOrderSubDetail::select('id', 'detail_id', 'item_id', 'quantity', 'price');
						$detailData = $detailData->where('detail_id', '=', $model->id);
						$detailData = $detailData->where('status', '=', '1');
						$detailData = $detailData->get();
						
						foreach($detailData as $detail)
						{
							$arr = array();
							$arr['item_id'] = $detail->item_id;
							$arr['quantity'] = $detail->quantity;
							$arr['price'] = $detail->price;
							$sub_details[] = $arr;
						}
						if(count($sub_details)==0)
						{
							$sub_details = null;
						}
						$array['sub_details'] = $sub_details;
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 10:
				{
					//$modelData = SvcOrderDetail::select('id', 'service_id', 'price', 'date_time');
					//$modelData = $modelData->where('order_id', '=', $order_id);
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						$array['service_id'] = $model->service_id;
						
						$array['home_type_id'] = $model->home_type_id;
						$array['bed_rooms'] = $model->bed_rooms;
						$array['living_rooms'] = $model->living_rooms;
						$array['dining_rooms'] = $model->dining_rooms;
						$array['maid_rooms'] = $model->maid_rooms;
						$array['storage_rooms'] = $model->storage_rooms;
						
						//$array['price'] = $model->price;
						
						$array['date_time'] = date('Y-m-d H:i',$model->date_time);
						
						$sub_details = array();
						$detailData = SvcOrderSubDetail::select('id', 'detail_id', 'item_id', 'quantity', 'price');
						$detailData = $detailData->where('detail_id', '=', $model->id);
						$detailData = $detailData->where('status', '=', '1');
						$detailData = $detailData->get();
						
						foreach($detailData as $detail)
						{
							$arr = array();
							$arr['item_id'] = $detail->item_id;
							$arr['quantity'] = $detail->quantity;
							$arr['price'] = $detail->price;
							$sub_details[] = $arr;
						}
						if(count($sub_details)==0)
						{
							$sub_details = null;
						}
						$array['sub_details'] = $sub_details;
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 11:
				{
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						
						$array['service_id'] = $model->service_id;
						if($model->service_id != 0){
							$array['sub_service_id'] = $model->sub_service_id;
							$array['quantity'] = $model->quantity;
						}
						
						$details_array[] = $array;
					}
				}
				break;
			
			case 12:
				{
					$modelData = SvcOrderDetail::where('order_id', '=', $order_id);
					$modelData = $modelData->where('status', '=', '1');
					$modelData = $modelData->get();
					
					foreach($modelData as $model)
					{
						$array = array();
						
						$array['id'] = $model->id;
						
						$array['sub_cat_id'] = $model->sub_cat_id;
						
						$array['service_id'] = $model->service_id;
						
						$details_array[] = $array;
					}
				}
				break;
			
			default:
				break;
		}
		
		if(count($details_array)==0)
		{
			$details_array = null;
		}
		
		return $details_array;
	}
}


if (! function_exists('get_product_price'))
{
	function get_product_price($product_id, $vend_id)
	{
		$modelData = SvcProduct::select('price');
		$modelData = $modelData->where('id', '=', $product_id);
		$modelData = $modelData->where('vend_id', '=', $vend_id);
		$modelData = $modelData->where('status', '=', '1');
		$modelData = $modelData->get();
		
		$price = null;
		foreach($modelData as $model)
		{
			$price = $model->price;
		}
		
		return $price;
	}
}


if (! function_exists('get_service_price'))
{
	function get_service_price($service_id, $vend_id)
	{
		$modelData = SvcVendorService::select('price');
		$modelData = $modelData->where('vend_id', '=', $vend_id);
		$modelData = $modelData->where('service_id', '=', $service_id);
		$modelData = $modelData->where('status', '=', '1');
		$modelData = $modelData->get();
		
		$price = null;
		foreach($modelData as $model)
		{
			$price = $model->price;
		}
		
		return $price;
	}
}


if (! function_exists('get_sub_service_price'))
{
	function get_sub_service_price($sub_service_id, $vend_id)
	{
		$modelData = SvcVendorService::select('price');
		$modelData = $modelData->where('vend_id', '=', $vend_id);
		$modelData = $modelData->where('sub_service_id', '=', $sub_service_id);
		$modelData = $modelData->where('status', '=', '1');
		$modelData = $modelData->get();
		
		$price = null;
		foreach($modelData as $model)
		{
			$price = $model->price;
		}
		
		return $price;
	}
}


if (! function_exists('get_brand_id_by_name_and_service'))
{
	function get_brand_id_by_name_and_service($service_id, $brand)
	{
		$brand_id = null;
		
		
		$modelData = SvcBrand::select('id');
		$modelData = $modelData->where('ref_id', '=', $service_id);
		$modelData = $modelData->where('ref_type', '=', "App/Models/SvcService");
		$modelData = $modelData->get();
		
		foreach($modelData as $model)
		{
			$id = $model->id;
			
			$model = SvcBrandOption::select('id');
			$model = $model->where('brand_id', '=', $id);
			$model = $model->where('name', '=', $brand);
			$model = $model->get();
			
			foreach($model as $data)
			{
				$brand_id = $data->id;
			}
		}
		
		return $brand_id;
	}
}


if (! function_exists('get_brand_id_by_name_and_sub_category'))
{
	function get_brand_id_by_name_and_sub_category($sub_cat_id, $brand)
	{
		$brand_id = null;
		
		
		$modelData = SvcBrand::select('id');
		$modelData = $modelData->where('ref_id', '=', $sub_cat_id);
		$modelData = $modelData->where('ref_type', '=', "App/Models/SvcSubCategory");
		$modelData = $modelData->get();
		
		foreach($modelData as $model)
		{
			$id = $model->id;
			
			$model = SvcBrandOption::select('id');
			$model = $model->where('brand_id', '=', $id);
			$model = $model->where('name', '=', $brand);
			$model = $model->get();
			
			foreach($model as $data)
			{
				$brand_id = $data->id;
			}
		}
		
		return $brand_id;
	}
}


if (! function_exists('get_vendor_bank_details_for_orders'))
{
	function get_vendor_bank_details_for_orders($vend_id)
	{
		$arr = array();
		$BankDetails = SvcBankDetail::where('vend_id',$vend_id)->where('status',1)->limit(1)->get();
		foreach($BankDetails as $bank_data)
		{
			$arr['vat_percentage'] = $bank_data->vat_percentage;
		}
		if(empty($arr))
			$arr = null;
		
		return $arr;
	}
}


if (! function_exists('get_svc_order_status'))
{
	function get_svc_order_status($status,$type)
	{
        if($type == 0){
            if($status == 1)
            {
                $status = 'Waiting';
            }
            elseif($status == 2)
            {
                $status = 'Canceled';
            }
            elseif($status == 3)
            {
                $status = 'Confirmed';
            }
            elseif($status == 4)
            {
                $status = 'Declined';
            }
            elseif($status == 5)
            {
                $status = 'Accepted';
            }
            elseif($status == 6)
            {
                $status = 'Team Left';
            }
            elseif($status == 7)
            {
                $status = 'Team Reached';
            }
            elseif($status == 8)
            {
                $status = 'Service Delivered';
            }
            elseif($status == 9)
            {
                $status = 'Completed';
            }
        }
        elseif($type == 1){
            if($status == 1)
            {
                $status = 'Waiting';
            }
            elseif($status == 2)
            {
                $status = 'Canceled';
            }
            elseif($status == 3)
            {
                $status = 'Quote Requested';
            }
            elseif($status == 4)
            {
                $status = 'Request Declined';
            }
            elseif($status == 5)
            {
                $status = 'Request Accepted';
            }
            elseif($status == 6)
            {
                $status = 'Quotation Preparing';
            }
            elseif($status == 7)
            {
                $status = 'Quotation Submitted';
            }
            elseif($status == 8)
            {
                $status = 'Quotation Accepted';
            }
            elseif($status == 9)
            {
                $status = 'Quotation Rejected';
            }
        }

		return $status;
	}
}

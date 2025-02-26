<?php

namespace Database\Seeders;

use App\Models\SvcAttribute;
use App\Models\SvcAttributeOption;
use App\Models\SvcBankDetail;
use App\Models\SvcVendorTiming;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\SvcCategory;
use App\Models\SvcSubCategory;
use App\Models\SvcService;
use App\Models\SvcSubService;

use App\Models\SvcVendor;
use App\Models\SvcVendorCategory;
use App\Models\SvcVendorSubCategory;
use App\Models\SvcVendorService;
use App\Models\SvcReview;


class SvcVendorSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$phone = 97781010100;
		$created_by = 1;
		
		$vend_id = 0;
		
		$categories_array = array();
		$categories_array[1] = '1,2,3,4,5,6,7,8,9,10,11,12';
		$categories_array[2] = '1,2,3,4,5,6,7,8,9,10,11,12';
		$categories_array[3] = '1,2,3,4,5,6';
		$categories_array[4] = '5,6,7,8,9,10';
		$categories_array[5] = '7,8,9,10,11,12';
		
		
		
		// Create new SvcVendor User
		{
			$name = 'Prime';
			$phone++;
			$created_by++;
			$vend_id++;
			$rating = 5;
			$lat = "34.138027396556096";
			$lng = "72.11771531300048";
			
			$this->create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by);
		}
		
		// Create new SvcVendor User
		{
			$name = 'Global';
			$phone++;
			$created_by++;
			$vend_id++;
			$rating = 4;
			$lat = "34.238027396556096";
			$lng = "72.21771531300048";
			
			$this->create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by);
		}
		
		// Create new SvcVendor User
		{
			$name = 'Orange';
			$phone++;
			$created_by++;
			$vend_id++;
			$rating = 3;
			$lat = "34.338027396556096";
			$lng = "72.31771531300048";
			
			$this->create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by);
		}
		
		// Create new SvcVendor User
		{
			$name = 'Color';
			$phone++;
			$created_by++;
			$vend_id++;
			$rating = 4;
			$lat = "34.438027396556096";
			$lng = "72.41771531300048";
			
			$this->create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by);
		}
		
		// Create new SvcVendor User
		{
			$name = 'Metro';
			$phone++;
			$created_by++;
			$vend_id++;
			$rating = 2;
			$lat = "34.538027396556096";
			$lng = "72.51771531300048";
			
			$this->create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by);
		}
		
		
		
		// SubCategories
		for($i=1; $i<=5; $i++)
		{
			//Timings
			for($j=0; $j<48; $j++)
			{
				$Model_Data = new SvcVendorTiming();
				
				$Model_Data->vend_id = $i;
				
				$time = ($j * 30 * 60);
				$Model_Data->time_value = $time;
				
				if($time >= 32400 && $time <= 73800 ){
					$Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 1;
				}
				else{
					$Model_Data->monday_status =  $Model_Data->tuesday_status =  $Model_Data->wednesday_status =  $Model_Data->thursday_status =  $Model_Data->friday_status =  $Model_Data->saturday_status =  $Model_Data->sunday_status = 0;
				}
				
				$Model_Data->save();
			}
			
			$add_value = 0;
			
			$categories = $categories_array[$i];
			$categories = explode(',',$categories);
			
			foreach($categories as $cat_id)
			{
				$Category = SvcCategory::find($cat_id);
				
				$attribute_array = null;
				
				if(!empty($Category) && $Category->has_attributes == 1)
				{
					$attributes = SvcAttribute::where('attributable_type','App/Models/SvcCategory')->where('attributable_id',$cat_id)->get();
					$add_value++;
					$attribute_array = $this->common_attributes($attributes, $i, $add_value);
				}
				
				$Model_Data = new SvcVendorCategory();
				$Model_Data->vend_id = $i;
				$Model_Data->cat_id = $cat_id;
				$Model_Data->attributes = $attribute_array;
				$Model_Data->save();
				
				
				
				$SubCategories = SvcSubCategory::where('cat_id',$cat_id)->where('status',1)->get();
				foreach($SubCategories as $SubCategory)
				{
					$sub_cat_id = $SubCategory->id;
					
					$SubCategory = SvcSubCategory::find($sub_cat_id);
					
					$attribute_array = null;
					
					if(!empty($SubCategory) && $SubCategory->has_attributes == 1)
					{
						$attributes = SvcAttribute::where('attributable_type','App/Models/SvcSubCategory')->where('attributable_id',$sub_cat_id)->get();
						
						$add_value++;
						$attribute_array = $this->common_attributes($attributes, $i, $add_value);
					}
					
					$Model_Data = new SvcVendorSubCategory();
					$Model_Data->vend_id = $i;
					$Model_Data->sub_cat_id = $sub_cat_id;
					$Model_Data->attributes = $attribute_array;
					$Model_Data->save();
					
					$has_services = $SubCategory->has_services;
					if($has_services == 1)
					{
						$Services = SvcService::where('sub_cat_id',$sub_cat_id)->where('status',1)->get();
						foreach($Services as $Service)
						{
							$service_id = $Service->id;
							
							$Service = SvcService::find($service_id);
							
							$has_sub_services = $Service->has_sub_services;
							
							if($has_sub_services == 1)
							{
								$j = 0;
								$SubServices = SvcSubService::where('service_id',$service_id)->where('status',1)->get();
								foreach($SubServices as $SubService)
								{
									$j++;
									
									$price = ($i*$j*10);
									if(strpos($Service->title,'Unknown Issue')){
										$price = 0;
									}
									
									$sub_service_id = $SubService->id;
									
									$attribute_array = null;
									
									if(!empty($SubService) && $SubService->has_attributes == 1)
									{
										$attributes = SvcAttribute::where('attributable_type','App/Models/SvcSubService')->where('attributable_id',$sub_service_id)->get();
										
										$add_value++;
										$attribute_array = $this->common_attributes($attributes, $i, $add_value);
									}
									
									$Model_Data = new SvcVendorService();
									$Model_Data->vend_id = $i;
									$Model_Data->service_id = $service_id;
									$Model_Data->sub_service_id = $sub_service_id;
									$Model_Data->attributes = $attribute_array;
									$Model_Data->price = $price;
									$Model_Data->save();
								}
							}
							else
							{
								$Service = SvcService::find($service_id);
								
								$attribute_array = null;
								
								if(!empty($Service) && $Service->has_attributes == 1)
								{
									$attributes = SvcAttribute::where('attributable_type','App/Models/SvcService')->where('attributable_id',$service_id)->get();
									
									$add_value++;
									$attribute_array = $this->common_attributes($attributes, $i, $add_value);
								}
								
								$price = ($i*10);
								if(strpos($Service->title,'Unknown Issue')){
									$price = 0;
								}
								$Model_Data = new SvcVendorService();
								$Model_Data->vend_id = $i;
								$Model_Data->service_id = $service_id;
								$Model_Data->attributes = $attribute_array;
								$Model_Data->price = $price;
								$Model_Data->save();
							}
						}
					}
					
				}
			}
		}
		
		
		/*// Reviews
		for($i=1; $i<=5; $i++)
		{
			for($j=1; $j<=5; $j++)
			{
				$Model_Data = new SvcReview();
					$Model_Data->vend_id = $i;
					$Model_Data->user_id = $j;
					//$Model_Data->order_id = $j;
					$Model_Data->review = "lorem ipsum dolor sit amet consectetuer adipiscing elit";
					$Model_Data->rating = $j;
					$Model_Data->status = 1;
				$Model_Data->save();
			}
		}*/
		
	}
	
	private function create_ecom_vendor($name, $phone, $lat, $lng, $rating, $created_by)
	{
		$image = "vendor.png";
		$location = "Islamabad";
		$description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tristique vulputate ullamcorper.";
		
		$name.= ' Services';
		$description = $name.' . '.$description;
		
		$company_name = strtolower(str_replace(' ','',$name));
		$email = "$company_name@gmail.com";
		$website = "www.".$company_name.".com";
		$charges = (50 * $created_by);
		
		$model = new SvcVendor();
		$model->name = $name;
		$model->arabic_name = $name;
		$model->description = $description;
		$model->arabic_description = $description;
		$model->location = $location;
		$model->phone = "+".$phone;
		$model->email = $email;
		$model->website = $website;
		$model->image = $image;
		$model->lat = $lat;
		$model->lng = $lng;
		$model->rating = $rating;
		$model->is_open = 1;
		$model->is_featured = 1;
		$model->covid_charges = $charges;
		$model->cleaning_material_charges = $charges;
		$model->ironing_charges = $charges;
		$model->pickup_charges = $charges;
		$model->created_by = $created_by;
		$model->save();
		
		$id = $model->id;
		
		$this->create_bank_details($id);
		
	}
	
	public function common_attributes($attributes, $i, $add_value)
	{
		$attribute_array = array();
		$prices_array = array();
		$values_array = array();
		
		$j = 0;
		foreach ($attributes as $attribute)
		{
			$attribute_id = $attribute->id;
			
			$attribute_options = SvcAttributeOption::where('attributable_id',$attribute_id)->get();
			
			$days = 2;
			
			foreach ($attribute_options as $attribute_option)
			{
				$j++;
				$days++;
				
				$option_name = trim($attribute_option->name);
				$values_array[] = $option_name;
				
				$option_name = strtolower($option_name);
				
				$option_value = (($i * $j * 10)+ $add_value);
				if($option_name == 'callout text' || $option_name == 'callout-text' || $option_name == 'call out text' || $option_name == 'call-out-text')
					$option_value = $option_name." $i-$j";
				
				if($option_name == 'Normal Delivery Days' || $option_name == 'normal delivery days' || $option_name == 'normal-delivery-days')
					$option_value = $days;
				
				$prices_array[] = $option_value;
			}
		}
		$attribute_array['values'] = $values_array;
		$attribute_array['prices'] = $prices_array;
		
		if(empty($attribute_array))
		{
			$attribute_array = null;
		}
		else
		{
			$attribute_array = json_encode($attribute_array);
		}
		
		return $attribute_array;
	}
	
	public function create_bank_details($id)
	{
		$Model_Data = new SvcBankDetail();
		
		$Model_Data->vend_id = $id;
		$Model_Data->company_name = "company_name $id";
		$Model_Data->tax_reg_no = "tax_reg_no $id";
		$Model_Data->bank_name = "bank_name $id";
		$Model_Data->account_number = "account_number $id";
		$Model_Data->address = "address $id";
		$Model_Data->iban ="iban $id";
		$Model_Data->swift_code = "swift_code $id";
		$Model_Data->created_by = 1;
		
		$Model_Data->save();
	}
}
<?php



namespace Database\Seeders;



use App\Models\SvcAttribute;
use App\Models\SvcAttributeOption;
use App\Models\SvcBrand;
use App\Models\SvcBrandOption;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;



use App\Models\SvcCategory;

use App\Models\SvcSubCategory;

use App\Models\SvcService;

use App\Models\SvcSubService;


class SvcCategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	
	public function run()
	{
		$description = 'lorem ipsum dolor sit amet consectetuer adipiscing elit';
		
		//1
		
		$title = "Women's Salon";
		{
			$has_subcategories = 1;
			$is_order = 10;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Haircut';
				$has_services = 1;
				$static_id = 1;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Clippers-wash-dry';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Clippers-wash-dry-style';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Washy-dry-style';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Hair Style';
				$has_services = 1;
				$static_id = 2;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Hair Style';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Threading ';
				$has_services = 1;
				$static_id = 3;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Threading ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Hair coloring ';
				$has_services = 1;
				$static_id = 4;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Hair coloring ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				
				$title = 'Manicure ';
				$has_services = 1;
				$static_id = 5;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Manicure ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				
				$title = 'Pedicure ';
				$has_services = 1;
				$static_id = 6;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Pedicure ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Waxing ';
				$has_services = 1;
				$static_id = 7;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Waxing ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Massage ';
				$has_services = 1;
				$static_id = 8;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Massage ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Henna Application ';
				$has_services = 1;
				$static_id = 9;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Henna Application ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Polishing ';
				$has_services = 1;
				$static_id = 10;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Polishing ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Bleach';
				$has_services = 1;
				$static_id = 11;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Face';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Full body';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Full back';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Half front';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Anti-aging Mask';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Rejuvenating Mask';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Anti-aging Diamond Facial';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Charcoal Detox';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				
				$title = 'Combinations';
				$has_services = 1;
				$static_id = 12;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Waxing-Massage-Pedicure';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Haircut-Hairstyle-Threading';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Polishing-Bleach';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		//2
		
		$title = 'Celebrations';
		{
			$has_subcategories = 1;
			$is_order = 5;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Flowers';
				$has_services = 0;
				$static_id = 13;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				$title = 'Cakes';
				$has_services = 0;
				$static_id = 14;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				$title = 'Balloons';
				$has_services = 0;
				$static_id = 15;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				$title = 'Gift trays & Chocolates ';
				$has_services = 0;
				$static_id = 16;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				$title = 'Hire Gazebo ';
				$has_services = 0;
				$static_id = 17;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				$title = 'Hire Photographer ';
				$has_services = 0;
				$static_id = 18;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
			}
		}
		
		//3
		
		$title = 'Cleaning';
		{
			$has_subcategories = 1;
			$is_order = 3;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'House Cleaning';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Cleaning Material Charges';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Ironing Charges';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Charges"] = $child_array;
				$static_id = 19;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array, 0, null, 0, "cleaning.png");
				
				//services of sub category
				{
					$title = 'One Time';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Monthly';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Bi Weekly';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Deep Cleaning';
				$has_services = 1;
				$static_id = 20;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, 0, null, 0, "cleaning.png");
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Furniture Cleaning';
				$has_services = 1;
				$static_id = 21;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, 0, null, 0, "FurnitureCleaning.png");
				
				//services of sub category
				{
					$title = 'Shelf';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Bookcase';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Bed';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Chair';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Coffee table';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Dining table';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Desk';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Couch';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = ' Sofa Chair';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Cabinets';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Dresser';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Chest of Draws';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = ' Wardrobe';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Door';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = ' Other';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Curtains / Blinds ';
				$has_services = 1;
				$static_id = 22;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Curtains';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Sheets';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Blinds';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Disinfection & Sanitization';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Covid Charges';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Charges"] = $child_array;
				$static_id = 23;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Monthly Cleaning Package';
				$has_services = 1;
				$static_id = 24;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Monthly Cleaning Package';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		
		//4
		
		$title = 'Home Electronics';// 3 levels
		{
			$has_subcategories = 1;
			$is_order = 13;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Home Security / CCTV';
				$has_services = 1;
				$static_id = 25;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Home Security / CCTV';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Smart Home System / Entertainment center';
				$has_services = 1;
				$static_id = 26;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Smart Home System';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Mobile phone ';
				$has_services = 1;
				$static_id = 27;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Mobile phone';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Laptop / Desktop ';
				$has_services = 1;
				$static_id = 28;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Laptop / Desktop';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Tablet ';
				$has_services = 1;
				$static_id = 29;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Tablet';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		//5
		
		$title = 'Maintenance';
		{
			$has_subcategories = 1;
			$is_order = 1;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'HandyMan';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 30;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array, 0, null, 0, "handyman.png");
				
				//services of sub category
				{
					$title = 'Furniture Assembly';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Lock fixing ';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Hanging Items';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Lifting and moving';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'General Handyman Services';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'TV Mounting / Hiding Wires ';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Install Shelves';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Install Frames / Mirrors ';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Curtain Installation ';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = '2 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '3 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '4 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '5 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = '6 Hours';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Home Appliance Installation / Repair ';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 31;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array, 0, null, 0, "HomeApplianceRepair.png");
				
				//services of sub category
				{
					$title = 'Washing Machine ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Dryer ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Refrigerator ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Oven ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Cooker ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Microwave ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
					
					$title = 'Dishwasher ';
					$has_sub_services = 0;
					$has_brands = 1;
					$brands_array = ['Samsung', 'Haier', 'Lg', 'Siemens', 'Hitachi', 'Sony', 'Bosch', 'Panasonic', 'Philips', 'Daewoo', 'Hisense', 'Whirlpool', 'Other'];
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, 0, null, $has_brands, $brands_array);
				}
				
				$title = 'Air Conditioning';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 32;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array, 0, null, 0, "AirConditioning.png");
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'AC Repair (Unknown Issue)';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Soft Services / Maintenance';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Coil Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'AC Repair (Unknown Issue)';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Soft Services / Maintenance';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Coil Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					
					//sub services of service
					{
						$title = 'AC Repair (Unknown Issue)';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Soft Services / Maintenance';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Coil Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'AC Deep Cleaning / Duct Cleaning';
						$has_sub_services = 0;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Plumbing';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 33;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'General Plumbing Services';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Repair pipe(s) or sink';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Fix Water Pressure';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair Water Heater';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Fix a leak';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair/Replace a shower';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Fix a water pump';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Toilet';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Unclog';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Flush Repair';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bad Smell';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Others';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Shower';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Install';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Replacement';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Faucets / Taps';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Install';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Replacement';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Gutter';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Install';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Replacement';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Electrical';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 34;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'General Electrical Services';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Power Outlets';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Standard';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'USB';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Ethernet';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Others';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Light Switches';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Standard';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dimmer';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Touch LED';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Others';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Ceiling Fan/ Shander';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Installation';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Repair';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Replacement';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Removal';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Others';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Lighting Installation';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Water Tank';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 35;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'Small';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Medium';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		//6
		
		$title = "Men's Salon ";//3 levels
		{
			
			$has_subcategories = 1;
			$is_order = 9;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Haircut';
				$has_services = 1;
				$static_id= 36;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Clippers-wash-dry';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Clippers-wash-dry-style';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Washy-dry-style';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Beard';
				$has_services = 1;
				$static_id= 37;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Beard';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Facial';
				$has_services = 1;
				$static_id= 38;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Fruit';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Cold';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Clean up';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Manicure / Pedicure';
				$has_services = 1;
				$static_id= 39;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Manicure / Pedicure';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Waxing / Hair Removal';
				$has_services = 1;
				$static_id= 40;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Waxing / Hair Removal';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Massage';
				$has_services = 1;
				$static_id= 41;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Massage';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Combinations';
				$has_services = 1;
				$static_id= 42;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Waxing-Massage-Manicure';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Haircut-Beard-Facial';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		//7
		
		$title = 'Pest Control';// 3 levels
		{
			$has_subcategories = 1;
			$is_order = 7;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'General Pest Control';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 43;
				$sub_cat_id = $this->subcategory($cat_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Rodent';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 44;
				$sub_cat_id = $this->subcategory($cat_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Cockroaches';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 45;
				$sub_cat_id = $this->subcategory($cat_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Bed Bugs';
				$has_services = 1;
				$has_attributes = 1;
				
				$main_attributes_array = array();
				$child_array = array();
				{
					$sub_array= array();
					$sub_array['name'] = 'Callout Price';
					$sub_array['num_field'] = 1;
					$sub_array['text_field'] = 0;
					$child_array[] = $sub_array;
					
					$sub_array= array();
					$sub_array['name'] = 'Callout Text';
					$sub_array['num_field'] = 0;
					$sub_array['text_field'] = 1;
					$child_array[] = $sub_array;
				}
				
				$main_attributes_array[$title." Callout"] = $child_array;
				$static_id = 46;
				$sub_cat_id = $this->subcategory($cat_id, $cat_id, $title, $description, $has_services, $has_attributes, $main_attributes_array);
				
				//services of sub category
				{
					$title = '1 Bed';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = '2 Beds';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = '3 Beds';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = '4 Beds';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = '5 Beds';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = '6 Beds';
					$has_sub_services = 0;
					$sub_service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		//8
		
		$title = 'Pet Grooming';// 4 levels
		{
			$has_subcategories = 1;
			$has_attributes = 1;
			
			$main_attributes_array = array();
			$child_array = array();
			{
				$sub_array= array();
				$sub_array['name'] = 'Pickup Charges';
				$sub_array['num_field'] = 1;
				$sub_array['text_field'] = 0;
				$child_array[] = $sub_array;
			}
			
			$main_attributes_array[$title." Charges"] = $child_array;
			$is_order = 6;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order, $has_attributes, $main_attributes_array);
			
			//sub categories of category
			{
				$title = 'Cats';
				$has_services = 1;
				$static_id = 47;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Medium';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Large';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Dogs';
				$has_services = 1;
				$static_id = 48;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Medium';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Large';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bath & Brush';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Haircut';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Fluminator';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Tick & Flees';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Medicated Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Bath & Brush + Organic Shampoo';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Haircut only';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garden Table';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Nail Clipping';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Teeth Brushing';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
			}
		}
		
		
		//9
		
		$title = 'Moving Services';// 3 levels
		{
			$has_subcategories = 1;
			$is_order = 8;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Moving Home ';
				$has_services = 1;
				$static_id = 49;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Dubai';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Sharjah';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Abu Dhabi';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					
					$title = 'RAK';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Ajman';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Fujairah';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Umm Al Quwain';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Apartment';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Villa';
						$has_attributes = 1;
						
						$main_attributes_array = array();
						$child_array = array();
						{
							$sub_array= array();
							$sub_array['name'] = 'Bedroom Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Living Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Dinning Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Maid Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Storage Room Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
							
							$sub_array= array();
							$sub_array['name'] = 'Garage or Garden Price';
							$sub_array['num_field'] = 1;
							$sub_array['text_field'] = 0;
							$child_array[] = $sub_array;
						}
						
						$main_attributes_array[$title." Price"] = $child_array;
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes, $main_attributes_array);
						
						
						$title = 'Studio';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
				}
				
				$title = 'Hire a truck';
				$has_services = 1;
				$static_id = 50;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services,0 , null, 0, null, 0, "Hireatruck.png");
				
				//services of sub category
				{
					$title = 'Dubai';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Sharjah';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'International Moving Services ';
				$has_services = 1;
				$static_id = 51;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Muscat';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Dubai';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		//10
		
		$title = 'Storage';// 3 level
		{
			$has_subcategories = 1;
			$is_order = 12;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Household Items ';
				$has_services = 1;
				$static_id = 52;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Household Items';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Appliances';
				$has_services = 1;
				$static_id = 53;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Appliances';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Furniture ';
				$has_services = 1;
				$static_id = 54;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Service of Furniture';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		
		//11
		
		$title = 'Painting';// 1 levels
		{
			$has_subcategories = 1;
			$is_order = 2;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Moving In/ Moving Out';
				$has_services = 1;
				$static_id = 55;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, 0, null, 0, "Painting.png");
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Repaint Same Colour';
				$has_services = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 56;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Change From Light Colour to Dark Colour';
				$has_services = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 57;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Change From Dark Colour to Light Colour';
				$has_services = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 58;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array);
				
				//services of sub category
				{
					$title = 'Apartment';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Villa';
					$has_sub_services = 1;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					//sub services of service
					{
						$title = 'Bedroom';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Living Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Dinning Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Maid Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Storage Room';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
						
						$title = 'Garage Or Garden';
						$sub_service_id = $this->subservice($cat_id, $sub_cat_id, $service_id, $title, $description);
					}
					
					$title = 'Studio';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Apartment';
				$has_services = 1;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 60;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				//services of sub category
				{
					$title = 'Bedroom';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Living Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Dinning Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Maid Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Storage Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Garage Or Garden';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Villa';
				$has_services = 1;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 61;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				//services of sub category
				{
					$title = 'Bedroom';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Living Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Dinning Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Maid Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Storage Room';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Garage Or Garden';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Studio';
				$has_services = 0;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 62;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				$title = 'Individual Rooms';
				$has_services = 0;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 63;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				$title = 'Individual Walls';
				$has_services = 0;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 64;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				$title = 'Individual Doors';
				$has_services = 0;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 65;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
				
				$title = 'Villa Exterior';
				$has_services = 0;
				$type = 1;
				$has_brands = 1;
				$brands_array = ['Asian Paints', 'Caparol Paints', 'Jotun Paints', 'Kansai Paints', 'National Paints', 'Oasis Paints'];
				$static_id = 66;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, $has_brands, $brands_array, $type);
			}
		}
		
		//12
		
		$title = 'Laundry';// 4 levels
		{
			$has_subcategories = 1;
			$has_attributes = 1;
			
			$main_attributes_array = array();
			$child_array = array();
			{
				$sub_array= array();
				$sub_array['name'] = 'Additional Price';
				$sub_array['num_field'] = 1;
				$sub_array['text_field'] = 0;
				$child_array[] = $sub_array;
				
				$sub_array= array();
				$sub_array['name'] = 'Normal Delivery Days';
				$sub_array['num_field'] = 1;
				$sub_array['text_field'] = 0;
				$child_array[] = $sub_array;
			}
			
			$main_attributes_array[$title." Charges"] = $child_array;
			$is_order = 4;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order, $has_attributes, $main_attributes_array);
			
			//sub categories of category
			{
				$title = 'Dry Cleaning';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, 0, null, 0, "Laundry.png");
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Wash & Press';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services, 0, null, 0, null, 0, "Laundry.png");
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Wash & Fold';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Hand Washing';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Bedding & Towel';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Press Only';
				$has_services = 1;
				$static_id = 69;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Small Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Large Bag';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
		
		//13
		
		$title = 'Pool & Garden';// 3 levels
		{
			$has_subcategories = 1;
			$is_order = 11;
			$cat_id = $this->category($title, $description, $has_subcategories, $is_order);
			
			//sub categories of category
			{
				$title = 'Landscaping';
				$has_services = 1;
				$static_id = 72;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Garden Cleaning ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Grass cutting ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Weed control ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Light Pruning (twigs / branches) ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Heavy trimming (branches / bushes) ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Tree removal ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Bush removal ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Soil cultivation ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Plant fertilization ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Grass fertilization ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Installing artificial grass ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Other';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Pool';
				$has_services = 1;
				$static_id = 73;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Cleaning: Check PH level';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Check Chlorine level';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Check water level ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Check filter';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Backwashing filters';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Pressure reading ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Check time clock';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Under water lights ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Clean debris ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Pool vacuum ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Other';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Fountain / Water Feature ';
				$has_services = 1;
				$static_id = 74;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Installation ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Repair ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Removal ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
				
				$title = 'Gazebo / Pergola ';
				$has_services = 1;
				$static_id = 75;
				$sub_cat_id = $this->subcategory($static_id, $cat_id, $title, $description, $has_services);
				
				//services of sub category
				{
					$title = 'Installation ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Repair ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
					
					$title = 'Removal ';
					$has_sub_services = 0;
					$service_id = $this->service($cat_id, $sub_cat_id, $title, $description, $has_sub_services);
				}
			}
		}
	}
	
	
	
	public function category($title, $description, $has_subcategories, $is_order, $has_attributes=0, $attributes_array=null, $has_brands=0, $brands_array=null)
	{
		$title = ltrim(rtrim($title));
		$description = ltrim(rtrim($description));
		
		$model = new SvcCategory();
		
		$model->title = $title;
		$model->ar_title = $title;
		$description = $title.' : '.$description;
		$model->description = $description;
		$model->ar_description = $description;
		$model->icon = "category.png";
		$model->ban_image = "cat_ban_image.png";
		$model->thumb_image = "cat_thumb_image.png";
		$model->has_subcategories = $has_subcategories;
		$model->has_attributes = $has_attributes;
		$model->has_brands = $has_brands;
		$model->is_order = $is_order;
		$model->status = 1;
		$model->created_by = 1;
		
		$model->save();
		
		$id = $model->id;
		
		$attributable_id = $id;
		$attributable_type = 'App/Models/SvcCategory';
		$this->common_attributes($has_attributes, $attributes_array, $attributable_type, $attributable_id, $title);
		
		$ref_id = $id;
		$ref_type = 'App/Models/SvcCategory';
		$this->common_brands($has_brands, $brands_array, $ref_type, $ref_id, $title);
		if($id<=13)
		{
			$model = SvcCategory::find($id);
			$model->icon = "cat_".$id.".jpg";
			$model->save();
		}
		
		return $id;
	}
	
	public function subcategory($static_id, $cat_id, $title, $description, $has_services, $has_attributes=0, $attributes_array=null, $has_brands=0, $brands_array=null, $type=0, $icon="sub_category.png")
	{
		$title = ltrim(rtrim($title));
		$description = ltrim(rtrim($description));
		
		$model = new SvcSubCategory();
		
		$model->static_id = $static_id;
		$model->cat_id = $cat_id;
		$model->title = $title;
		$model->ar_title = $title;
		$description = $title.' : '.$description;
		$model->description = $description;
		$model->ar_description = $description;
		$model->type = $type;
		$model->icon = $icon;
		$model->has_services = $has_services;
		$model->has_attributes = $has_attributes;
		$model->has_brands = $has_brands;
		$model->status = 1;
		$model->created_by = 1;
		
		$model->save();
		
		$id = $model->id;
		
		$attributable_id = $id;
		$attributable_type = 'App/Models/SvcSubCategory';
		$this->common_attributes($has_attributes, $attributes_array, $attributable_type, $attributable_id, $title);
		
		$ref_id = $id;
		$ref_type = 'App/Models/SvcSubCategory';
		$this->common_brands($has_brands, $brands_array, $ref_type, $ref_id, $title);
		
		return $id;
	}
	
	public function service($cat_id, $sub_cat_id, $title, $description, $has_sub_services, $has_attributes=0, $attributes_array=null, $has_brands=0, $brands_array=null)
	{
		$title = ltrim(rtrim($title));
		$description = ltrim(rtrim($description));
		
		$model = new SvcService();
		
		$model->cat_id = $cat_id;
		$model->sub_cat_id = $sub_cat_id;
		$model->title = $title;
		$model->ar_title = $title;
		$description = $title.' : '.$description;
		$model->description = $description;
		$model->ar_description = $description;
		$model->icon = "service.png";
		$model->has_sub_services = $has_sub_services;
		$model->has_attributes = $has_attributes;
		$model->has_brands = $has_brands;
		$model->status = "1";
		$model->created_by = "1";
		
		$model->save();
		
		$id = $model->id;
		
		$attributable_id = $id;
		$attributable_type = 'App/Models/SvcService';
		$this->common_attributes($has_attributes, $attributes_array, $attributable_type, $attributable_id, $title);
		
		$ref_id = $id;
		$ref_type = 'App/Models/SvcService';
		$this->common_brands($has_brands, $brands_array, $ref_type, $ref_id, $title);
		
		return $id;
	}
	
	public function subservice($cat_id, $sub_cat_id, $service_id, $title, $description, $has_attributes=0, $attributes_array=null, $has_brands=0, $brands_array=null)
	{
		$title = ltrim(rtrim($title));
		$description = ltrim(rtrim($description));
		
		$model = new SvcSubService();
		
		$model->cat_id = $cat_id;
		$model->sub_cat_id = $sub_cat_id;
		$model->service_id = $service_id;
		$model->title = $title;
		$model->ar_title = $title;
		$description = $title.' : '.$description;
		$model->description = $description;
		$model->ar_description = $description;
		$model->icon = "sub_service.png";
		$model->has_attributes = $has_attributes;
		$model->has_brands = $has_brands;
		$model->status = "1";
		$model->created_by = "1";
		
		$model->save();
		
		$id = $model->id;
		
		$attributable_id = $id;
		$attributable_type = 'App/Models/SvcSubService';
		$this->common_attributes($has_attributes, $attributes_array, $attributable_type, $attributable_id, $title);
		
		$ref_id = $id;
		$ref_type = 'App/Models/SvcSubService';
		$this->common_brands($has_brands, $brands_array, $ref_type, $ref_id, $title);
		
		return $id;
	}
	
	public function common_attributes($has_attributes, $main_attributes_array, $attributable_type, $attributable_id, $title)
	{
		if($has_attributes == 1 && $main_attributes_array != null)
		{
			foreach ($main_attributes_array as $name => $attributes_array){
				
				$Model_data = new SvcAttribute();
				
				$Model_data->attributable_type = $attributable_type;
				$Model_data->attributable_id = $attributable_id;
				$Model_data->name = $name;
				$Model_data->input_name = createSlug($name,'_');
				$Model_data->price_status = 1;
				
				$Model_data->save();
				
				$attribute_id = $Model_data->id;
				
				foreach ($attributes_array as $attribute)
				{
					$Model_option = new SvcAttributeOption();
					
					$Model_option->attributable_id = $attribute_id;
					$Model_option->name = $attribute['name'];
					$Model_option->num_field = $attribute['num_field'];
					$Model_option->text_field = $attribute['text_field'];
					
					$Model_option->save();
				}
			}
		}
	}
	
	public function common_brands($has_brands, $brands_array, $ref_type, $ref_id, $title)
	{
		if($has_brands == 1 && $brands_array != null)
		{
			$title = $title." brands";
			
			$Model_data = new SvcBrand();
			
			$Model_data->ref_type = $ref_type;
			$Model_data->ref_id = $ref_id;
			$Model_data->name = $title;
			
			$Model_data->save();
			
			$brand_id = $Model_data->id;
			
			foreach ($brands_array as $brand)
			{
				$Model_option = new SvcBrandOption();
				
				$Model_option->brand_id = $brand_id;
				$Model_option->name = $brand;
				
				$Model_option->save();
			}
		}
	}
}
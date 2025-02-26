<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Flash;
use Response;
use Attribute;
use Datatables;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardType;
use App\Models\RewardDiscountType;
use App\Models\SvcVendor;

use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    private $views_path = "svc.rewards";
	
	private $dashboard_route = "dashboard";
	
	//private $home_route = "rewards";
	private $create_route = "vendor-categories.create";
	private $edit_route = "vendor-categories.edit";
	private $view_route = "svc.rewards";
	private $delete_route = "vendor-categories.destroy";
	
	private $msg_created = "vendor Reward added successfully.";
	private $msg_updated = "vendor Reward updated successfully.";
	private $msg_deleted = "vendor Reward deleted successfully.";
	private $msg_not_found = "vendor Reward not found. Please try again.";
	private $msg_required = "Please fill all required fields.";
	private $msg_exists = "Record Already Exists with same reward name";

    private $list_permission = "vendor-rewards-listing";
	private $add_permission = "vendor-rewards-add";
	private $edit_permission = "vendor-rewards-edit";
	private $view_permission = "vendor-rewards-view";
	private $status_permission = "vendor-rewards-status";
	private $delete_permission = "vendor-rewards-delete";

    private $list_permission_error_message = "Error: You are not authorized to View Listings of Vendor rewards. Please Contact Administrator.";
	private $add_permission_error_message = "Error: You are not authorized to Add Vendor reward. Please Contact Administrator.";
	private $edit_permission_error_message = "Error: You are not authorized to Update Vendor reward. Please Contact Administrator.";
	private $view_permission_error_message = "Error: You are not authorized to View Vendor reward details. Please Contact Administrator.";
	private $status_permission_error_message = "Error: You are not authorized to change status of Vendor reward. Please Contact Administrator.";
	



    public function index()
    {
        $Auth_User = Auth::user();
		if($Auth_User->can($this->list_permission) || $Auth_User->can('all'))
		{
			$records_exists = 0;
			$records = Reward::select(['id'])->where('id', '>=', 1)->limit(1)->get();
			foreach($records as $record)
			{
				$records_exists = 1;
			}
			
			$types = RewardType::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
			$vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');

			return view($this->views_path.'.listing', compact('records_exists','types','vendors_array'));
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
            if($Auth_User->vendor_id == 0)
            {
                return $this->admin_datatable($request);
            }
            // elseif($Auth_User->vendor_id > 0)
            // {
            //     return $this->restaurant_datatable($request);
            // }
        }
        else
        {
            Flash::error($this->list_permission_error_message);
            return redirect()->route($this->redirect_home);
        }

    }



    public function admin_datatable(Request $request)
    {
        $Auth_User = Auth::user();

        $Records = Reward::get();

        $response= Datatables::of($Records)
            ->filter(function ($query) use ($request) {


                
                
                if ($request->has('silver_punches') && !empty($request->silver_punches))
                {
                    $query->where('rewards.silver_punches', '>=', "{$request->get('silver_punches')}");
                }
                if ($request->has('golden_punches') && !empty($request->golden_punches))
                {
                    $query->where('rewards.golden_punches', '>=', "{$request->get('golden_punches')}");
                }
                if ($request->has('platinum_punches') && !empty($request->platinum_punches))
                {
                    $query->where('rewards.platinum_punches', '>=', "{$request->get('platinum_punches')}");
                }
                if ($request->has('min_order_value') && !empty($request->min_order_value))
                {
                    $query->where('rewards.min_order_value', '>=', "{$request->get('min_order_value')}");
                }

                if ($request->has('status') && $request->get('status') != -1)
                {
                    $query->where('rewards.status', '=', "{$request->get('status')}");
                }

                if ($request->has('approval') && $request->get('approval') != -1)
                {
                    $query->where('rewards.status', '=', "{$request->get('approval')}");
                }
            })
            // ->addColumn('vendor_id', function ($Records) {
            //     $record_id = $Records->id;
            //     $title = $Records->vendor_name;

            //     return  $title;
            // })
          
            // ->addColumn('type', function ($Records) {
            //     $record_id = $Records->id;
            //     $title=trim($Records->type);

            //     $title_name = RewardType::select('id', 'name')->where('id',$Records->type)->first();
            //     $title = $title_name->name;

            //     return  $title;
            // })
            ->addColumn('silver_punches', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->silver_punches;

                return  $title;
            })
            ->addColumn('golden_punches', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->golden_punches;

                return  $title;
            })
            ->addColumn('platinum_punches', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->platinum_punches;

                return  $title;
            })
            ->addColumn('min_order_value', function ($Records) {
                $record_id = $Records->id;
                $title = $Records->min_order_value;

                return  $title;
            })
            ->addColumn('status', function ($Records) {
                $record_id = $Records->id;
                $status = $Records->status;
                $Auth_User = Auth::user();

                $str = '';
                if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
                {
                    $status_check = Reward::where('status', 1)->get();
                    
                    if($status == 1 )
                    {
                        $str = '<a href="'.route('reward-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span>
					</a>';
                    }
                    else
                    {
                        $str = '<a href="'.route('reward-active',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
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
            ->addColumn('approval', function ($Records) {
                $record_id = $Records->id;
                $status = $Records->status;
                $Auth_User = Auth::user();

                $str = '';
                if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
                {
                    if($status == 1)
                    {
                        $str = '<a href="'.route('reward-inactive',$record_id).'" class="btn btn-success btn-sm"  title="Make Item Inactive">
					<span class="fa fa-power-off "></span>
					</a>';
                    }
                    else
                    {
                        $str = '<a href="'.route('reward-active',$record_id).'" class="btn btn-danger btn-sm" title="Make Item Active">
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
                $record_id = $Records->id;
                $status = $Records->status;
                $Auth_User = Auth::user();

                $str = "<div class='btn-group' role='group' aria-label='Horizontal Info'>";

                if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
                {
                    $str .= ' <a class="btn btn-outline-primary" href="'.url('/service/reward/'.$record_id).'" title="View Details">
				<i class="fa fa-eye"></i>
				</a>';
                }

                if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
                {
                    if($status == 0){
                        $str .= ' <a class="btn btn-outline-primary" href="' . url('/service/reward/'.$record_id.'/edit') . '" title="Edit Details" >
				<i class="fa fa-edit"></i>
				</a>';
                    }
                    else{
                        $alert = "'An active Reward cannot be edited.'";
                        $str .= ' <a class="btn btn-outline-primary" title="Edit Details" onclick="alert('.$alert.');"  style="opacity: 0.5; ">
				<i class="fa fa-edit"></i>
				</a>';
                    }

                }

                $str.= "</div>";
                return $str;

            })
            ->rawColumns(['status','approval','action'])
            ->setRowId(function($Records) {
                return 'myDtRow' . $Records->id;
            })
            ->make(true);
        return $response;
    }



    public function create()
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
        {
            $rest_id = $Auth_User->rest_id;

            $vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');

            $types = RewardType::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('id', 'asc')->pluck('name','id');
           
           


            $items = array();
            $menus = array();
            $all_items = array();
            $menus_array = array();
            $menu_items_array = array();

//            if($Auth_User->rest_id > 0)
//            {
            // $items = Items::leftJoin('menus', 'items.menu_id','=', 'menus.id')
            //     ->leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            //     ->select(['items.id','items.menu_id','items.name','items.total_value'])
            //     ->where('menus.rest_id', '=', $rest_id)
            //     ->where('restaurants.status', '=', 1)
            //     ->where('menus.status', '=', 1)
            //     ->where('items.status', '=', 1)
            //     ->orderby('items.name', 'asc')
            //     ->get();

            // $menus = Menu::leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            //     ->select(['menus.id','menus.title'])
            //     ->where('menus.rest_id', '=', $rest_id)
            //     ->where('restaurants.status', '=', 1)
            //     ->where('menus.status', '=', 1)
            //     ->orderby('menus.title', 'asc')
            //     ->get();



            // foreach($menus as $menu)
            // {
            //     $items_array = array();
            //     $item_array = array();
            //     $menuid = $menu->id;


            //     $itemss = Items::where('menu_id',$menuid)->orderBy('is_order','asc')->get();
            //     foreach($itemss as $item){

            //         $item_array["id"]= $item->id;
            //         $item_array["name"]= $item->name;
            //         $item_array["menu_id"]= $item->menu_id;
            //         $item_array["price"]= $item->price;

            //         $items_array[] = $item_array;

            //     }


            //     $all_items[$menuid] = $items_array;
            //     $menus_array[$menuid] = $menu->title;
            //     $count = Items::select(['items.id'])->where('menu_id', '=', $menuid)->where('status', '=', 1)->count();
            //     $menu_items_array[$menuid] = $count;
            // }
//            }
//            else
//            {
            /*
            $items = Items::leftJoin('menus', 'items.menu_id','=', 'menus.id')
            ->leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            ->select(['items.id','items.menu_id','items.name','items.total_value'])
            ->where('restaurants.status', '=', 1)
            ->where('menus.status', '=', 1)
            ->where('items.status', '=', 1)
            ->orderby('items.name', 'asc')
            ->get();

            $menus = Menu::leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            ->select(['menus.id','menus.title'])
            ->where('restaurants.status', '=', 1)
            ->where('menus.status', '=', 1)
            ->orderby('menus.title', 'asc')
            ->get();

            foreach($menus as $menu)
            {
                $menuid = $menu->id;
                $menus_array[$menuid] = $menu->title;
                $count = Items::select(['items.id'])->where('menu_id', '=', $menuid)->where('status', '=', 1)->count();
                $menu_items_array[$menuid] = $count;
            }
            */
//            }

            return View($this->views_path.'.create', compact('vendors_array', 'types'));
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

    public function store(Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->add_permission) || $Auth_User->can('all'))
        {
        
            $vendor_id = $request->vendor_id;
           

            $input = $request->all();

            $reward_type=$request->type_id;
            //$apply_type=$request->apply_type;

            $Model_Data = new Reward();

            $Model_Data->vendor_id = $vendor_id;

            if(isset($request->silver_discount_type))
            {
                if(isset($request->silver_fixed_value))
                {
                    $Model_Data->silver_fixed_value = $request->silver_fixed_value;
                }
                elseif(isset($request->silver_discount_percentage))
                {
                    $Model_Data->silver_discount_percentage = $request->silver_discount_percentage;
                }
            }

            if(isset($request->golden_discount_type))
            {
                if(isset($request->golden_fixed_value))
                {
                    $Model_Data->golden_fixed_value = $request->golden_fixed_value;
                }
                elseif(isset($request->golden_discount_percentage))
                {
                    $Model_Data->golden_discount_percentage = $request->golden_discount_percentage;
                }
            }

            if(isset($request->platinum_discount_type))
            {
                if(isset($request->platinum_fixed_value))
                {
                    $Model_Data->platinum_fixed_value = $request->platinum_fixed_value;
                }
                elseif(isset($request->platinum_discount_percentage))
                {
                    $Model_Data->platinum_discount_percentage = $request->platinum_discount_percentage;
                }
            }


            $Model_Data->silver_punches= $request->silver_punches;
            if($request->silver_punches < $request->golden_punches)
            {
                $Model_Data->golden_punches= $request->golden_punches;
            }
            else
            {
                Flash::error("silver punches cannot be greater than golden ounches");
                return redirect()->back();
            }
            if($request->golden_punches < $request->platinum_punches)
            {
                $Model_Data->platinum_punches= $request->platinum_punches;
            }
            else
            {
                Flash::error("golden punches cannot be greater than platinum punches");
                return redirect()->back();
            }
            $Model_Data->min_order_value = $request->min_order_value;
            $Model_Data->type = $request->type_id;
           // $Model_Data->discount_type = $request->discount_type_id;
            //$Model_Data->apply_type = $apply_type;

            if($request->type_id == 1){
                $Model_Data->fixed_value = $request->type_value;
            }
            elseif($request->type_id == 2){
                $Model_Data->discount_percentage = $request->type_value;
            }

            if(isset($request->limitation) && $request->limitation == 1){
                $Model_Data->has_limitations = 1;
                $Model_Data->intervals = $request->interval;
            }

            if(isset($request->limitation) && $request->limitation == 2){
                $Model_Data->has_limitations = 2;
                $Model_Data->start_date = strtotime($request->start_date);
                $Model_Data->end_date = strtotime($request->end_date);
            }
            $Model_Data->status = 0;


            $Model_Data->created_by = $Auth_User->id;

            $Model_Data->save();

            $reward_id = $Model_Data->id;


            // if($reward_type == 1 || $reward_type == 2)
            // {
            //     if($apply_type == 0){
            //         if(isset($request->menu_id))
            //         {
            //             $i = 0;
            //             $request_menus = $request->menu_id;
            //             foreach($request_menus as $request_menu)
            //             {
            //                 if(isset($input['menu_id'][$i]))
            //                 {
            //                     $menu_id = $input['menu_id'][$i];

            //                     $rewardDetail = new RewardMenu();

            //                     $rewardDetail->reward_id = $reward_id;
            //                     $rewardDetail->menu_id  = $menu_id;
            //                     $rewardDetail->save();
            //                 }
            //                 $i++;
            //             }
            //         }
            //     }
            //     else{
            //         if(isset($request->item_id))
            //         {
            //             $i = 0;
            //             $request_items = $request->item_id;
            //             foreach($request_items as $request_item)
            //             {
            //                 if(isset($input['item_id'][$i]))
            //                 {
            //                     $item_id = $input['item_id'][$i];

            //                     $rewardDetail = new RewardDetail();

            //                     $rewardDetail->reward_id = $reward_id;
            //                     $rewardDetail->item_id  = $item_id;
            //                     $rewardDetail->save();
            //                 }
            //                 $i++;
            //             }
            //         }
            //     }


            // }

            // elseif($reward_type == 3)
            // {
            //     if(isset($request->item_id))
            //     {
            //         $i = 0;
            //         $request_items = $request->item_id;

            //         if(isset($input['item_id'][$i]))
            //         {
            //             $item_id = $input['item_id'][$i];

            //             $Detail = new RewardDetail();

            //             $Detail->reward_id = $reward_id;
            //             $Detail->item_id  = $item_id;
            //             $Detail->save();
            //         }

            //     }
            // }

            Flash::success($this->msg_created);
            return redirect('rewards');
        }
        else
        {
            Flash::error($this->add_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }


    public function show($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->view_permission) || $Auth_User->can('all'))
        {
            $Model_Data = Reward::find($id);
     
            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

           // $reward_id = $Model_Data->id;
           // $rest_id = $Model_Data->rest_id;

            //$Reward_Details = DB::table('reward_details')->get();

            // $reward_items = array();
            // foreach ($Reward_Details as $item){
            //     $reward_items[] = $item->id;
            // }

            // $Reward_Menus = DB::table('menus')
            //     ->join('reward_menus', 'menus.id', '=', 'reward_menus.menu_id')
            //     ->select('menus.id', 'menus.title')
            //     ->where('menus.status', 1)
            //     ->where('reward_menus.status', 1)
            //     ->where('reward_menus.reward_id', $reward_id)
            //     ->get();

            // $menus = Menu::leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            //     ->select(['menus.id','menus.title'])
            //     ->where('menus.rest_id', '=', $rest_id)
            //     ->where('menus.status', '=', 1)
            //     ->orderby('menus.title', 'asc')
            //     ->get();


            // $menus_array = array();
            // $menu_items_array = array();
            // foreach($menus as $menu)
            // {
            //     $items_array = array();
            //     $item_array = array();
            //     $menuid = $menu->id;


            //     $itemss = Items::where('menu_id',$menuid)->where('status','=',1)->orderBy('is_order','asc')->get();
            //     foreach($itemss as $item){

            //         $item_array["id"]= $item->id;
            //         $item_array["name"]= $item->name;
            //         $item_array["menu_id"]= $item->menu_id;
            //         $item_array["price"]= $item->price;

            //         $items_array[] = $item_array;

            //     }


            //     $all_items[$menuid] = $items_array;
            //     $menus_array[$menuid] = $menu->title;
            //     $count = Items::select(['items.id'])->where('menu_id', '=', $menuid)->where('status', '=', 1)->count();
            //     $menu_items_array[$menuid] = $count;
            // }

            //$SvcVendor = SvcVendor::find($Model_Data->vendor_id);

            $vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');
            
           

            $types = RewardType::select('name')->where('status',1)->where('id', $Model_Data->type)->orderBy('id','asc')->get();

            // $types_array = array();
            // $index=1;
            // foreach($types as $type){
            //     $types_array[$index] = $type["name"];
            //     $index++;
            // }

            $typ="";
            foreach($types as $type)
            {
                $typ = $type->name;
            }
            

            return view($this->views_path.'.show',compact('Model_Data', 'typ'));
        }
        else
        {
            Flash::error($this->view_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }


    public function edit($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $Model_Data = Reward::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }

            $reward_id = $Model_Data->id;
            $rest_id = $Model_Data->rest_id;

            // $menus_array = array();
            // $menu_items_array = array();

            // $items = Items::leftJoin('menus', 'items.menu_id','=', 'menus.id')
            //     ->leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            //     ->select(['items.id','items.menu_id','items.name','items.total_value'])
            //     ->where('menus.rest_id', '=', $rest_id)
            //     ->where('restaurants.status', '=', 1)
            //     ->where('menus.status', '=', 1)
            //     ->where('items.status', '=', 1)
            //     ->orderby('items.name', 'asc')
            //     ->get();

            // $menus = Menu::leftJoin('restaurants', 'menus.rest_id','=', 'restaurants.id')
            //     ->select(['menus.id','menus.title'])
            //     ->where('menus.rest_id', '=', $rest_id)
            //     ->where('restaurants.status', '=', 1)
            //     ->where('menus.status', '=', 1)
            //     ->orderby('menus.title', 'asc')
            //     ->get();


            // foreach($menus as $menu)
            // {
            //     $items_array = array();
            //     $item_array = array();
            //     $menuid = $menu->id;


            //     $itemss = Items::where('menu_id',$menuid)->orderBy('is_order','asc')->get();
            //     foreach($itemss as $item){

            //         $item_array["id"]= $item->id;
            //         $item_array["name"]= $item->name;
            //         $item_array["menu_id"]= $item->menu_id;
            //         $item_array["price"]= $item->price;

            //         $items_array[] = $item_array;

            //     }


            //     $all_items[$menuid] = $items_array;
            //     $menus_array[$menuid] = $menu->title;
            //     $count = Items::select(['items.id'])->where('menu_id', '=', $menuid)->where('status', '=', 1)->count();
            //     $menu_items_array[$menuid] = $count;
            // }


            //$Reward_Details = array();

            //$RewardDetails = DB::table('reward_details')->get();


            // $Reward_Menus = array();
            // if($Model_Data->apply_type == 0)
            // {
            //     $RewardMenus = DB::table('menus')
            //         ->join('reward_menus', 'menus.id', '=', 'reward_menus.menu_id')
            //         ->select('menus.id', 'menus.title')
            //         ->where('menus.status', 1)
            //         ->where('reward_menus.status', 1)
            //         ->where('reward_menus.reward_id', $reward_id)
            //         ->get();

            //     foreach($RewardMenus as $menu)
            //     {
            //         $Reward_Menus[] = $menu->id;
            //     }
            // }
            // else
            // {
            //     $RewardDetails = DB::table('items')
            //         ->join('reward_details', 'items.id', '=', 'reward_details.item_id')
            //         ->select('items.id','items.menu_id', 'items.name', 'items.total_value')
            //         ->where('items.status', 1)
            //         ->where('reward_details.status', 1)
            //         ->where('reward_details.reward_id', $reward_id)
            //         ->get();

            //     foreach($RewardDetails as $Detail)
            //     {
            //         $Reward_Details[] = $Detail->id;
            //     }
            // }

            $reward_types = RewardType::select('id', 'name')->where('id', $Model_Data->type)->first();

            $reward_array = RewardType::select('id', 'name')->where('status', 1)->pluck('name', 'id');
         
           
            $vendor = $vendors_array = SvcVendor::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');

             if($Model_Data->type == 3){
            //     foreach($menus as $menu)
            //     {
            //         $menuid = $menu->id;
            //         $menus_array[$menuid] = $menu->title;
            //         $count = Items::select(['items.id'])->where('menu_id', '=', $menuid)->where('status', '=', 1)->count();
            //         $menu_items_array[$menuid] = $count;
            //     }


                // $RewardDetails = DB::table('reward_details')->get();

                // $Reward_Details = array();
                // foreach($RewardDetails as $Detail)
                // {
                //     $Reward_Details[] = $Detail->id;
                // }
            }
            $reward_type = RewardType::select(['id','name'])->where('id', '>=', 1)->where('status', '=', 1)->orderby('name', 'asc')->pluck('name','id');

            return View($this->views_path.'.edit', compact('Model_Data', 'vendors_array', 'vendor', 'reward_array'));

        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }



    public function update($id, Request $request)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->edit_permission) || $Auth_User->can('all'))
        {
            $vendor_id = $request->vendor_id;

            $input = $request->all();

            $reward_type=$request->type_id;
            $apply_type=$request->apply_type;

            $Model_Data = Reward::find($id);

            if (empty($Model_Data))
            {
                Flash::error($this->msg_not_found);
                return redirect(route($this->home_route));
            }
            $input = $request->all();





            $reward_id = $Model_Data->id;
//            echo $reward_type;
//            exit;
            $vendor_id = $Model_Data->vendor_id;

            $Model_Data->silver_punches=$request->silver_punches;
            $Model_Data->silver_fixed_value=$request->silver_fixed_value;
            $Model_Data->silver_discount_percentage=$request->silver_discount_percentage;
            $Model_Data->golden_punches=$request->golden_punches;
            $Model_Data->golden_fixed_value=$request->golden_fixed_value;
            $Model_Data->golden_discount_percentage=$request->golden_discount_percentage;
            $Model_Data->platinum_punches=$request->platinum_punches;
            $Model_Data->platinum_fixed_value=$request->platinum_fixed_value;
            $Model_Data->platinum_discount_percentage=$request->platinum_discount_percentage;
            $Model_Data->min_order_value=$request->min_order_value;
            $Model_Data->type = $request->type_id;
         

            if($request->type_id == 1){
                $Model_Data->fixed_value = $request->type_value;
                $Model_Data->discount_percentage = null;
            }
            elseif($request->type_id == 2){
                $Model_Data->discount_percentage = $request->type_value;
                $Model_Data->fixed_value = null;
            }


            if(isset($request->limitation) && $request->limitation == 0){
                $Model_Data->has_limitations = 0;
                $Model_Data->intervals = null;
                $Model_Data->start_date = null;
                $Model_Data->end_date = null;
            }
            elseif(isset($request->limitation) && $request->limitation == 1){
                $Model_Data->has_limitations = 1;
                $Model_Data->intervals = $request->interval;
                $Model_Data->start_date = null;
                $Model_Data->end_date = null;
            }
            elseif(isset($request->limitation) && $request->limitation == 2){
                $Model_Data->has_limitations = 2;
                $Model_Data->intervals = null;
                $Model_Data->start_date = strtotime($request->start_date);
                $Model_Data->end_date = strtotime($request->end_date);
            }


            $Model_Data->updated_by=Auth::user()->id;
            $Model_Data->save();

            // update old Items

            // if($reward_type == 1 || $reward_type == 2){
            //     if($apply_type == 0){
            //         $RewardMenus = RewardMenu::where('reward_id',$reward_id)->where('status',1)->get();
            //         foreach($RewardMenus as $RewardMenu)
            //         {
            //             $menu_id = $RewardMenu->id;
            //             $RewardMenu = RewardMenu::find($menu_id);
            //             $RewardMenu->status = 2;
            //             $RewardMenu->save();
            //         }
            //     }
            //     else{
            //         $RewardDetails = RewardDetail::where('reward_id',$reward_id)->where('status',1)->get();
            //         foreach($RewardDetails as $RewardDetail)
            //         {
            //             $detail_id = $RewardDetail->id;
            //             $RewardDetail = RewardDetail::find($detail_id);
            //             $RewardDetail->status = 2;
            //             $RewardDetail->save();
            //         }
            //     }
            // }
            // elseif( $reward_type == 3){
            //     $RewardDetails = RewardDetail::where('reward_id',$reward_id)->where('status',1)->get();
            //     foreach($RewardDetails as $RewardDetail)
            //     {
            //         $detail_id = $RewardDetail->id;
            //         $RewardDetail = RewardDetail::find($detail_id);
            //         $RewardDetail->status = 2;
            //         $RewardDetail->save();
            //     }
            // }

//             if($reward_type == 1 || $reward_type == 2){
//                 if($apply_type == 0){
//                     if(isset($request->menu_id))
//                     {
//                         $i = 0;
//                         $request_menus = $request->menu_id;
//                         foreach($request_menus as $request_menu)
//                         {
//                             if(isset($input['menu_id'][$i]))
//                             {
//                                 $menu_id = $input['menu_id'][$i];

//                                 $exists = 0;
//                                 $RewardMenus = RewardMenu::where('reward_id',$reward_id)->where('menu_id',$menu_id)->where('status',2)->get();
//                                 foreach($RewardMenus as $RewardMenu)
//                                 {
//                                     $exists = 1;
//                                     $detail_id = $RewardMenu->id;
//                                     $RewardMenu = RewardMenu::find($detail_id);
//                                     $RewardMenu->status = 1;
//                                     $RewardMenu->save();
//                                 }
//                                 if($exists == 0)
//                                 {
//                                     $RewardMenu = new RewardMenu();
//                                     $RewardMenu->reward_id = $reward_id;
//                                     $RewardMenu->menu_id  = $menu_id;
//                                     $RewardMenu->save();
//                                 }
//                             }
//                             $i++;
//                         }
//                     }
//                 }
//                 else{
//                     if(isset($request->list_id))
//                     {
//                         $i = 0;
//                         $request_items = $request->list_id;

// //                        print_r($request_items);
// //                        exit();

//                         foreach($request_items as $request_item)
//                         {
//                             if(isset($input['list_id'][$i]))
//                             {
//                                 $item_id = $input['list_id'][$i];

//                                 $exists = 0;
//                                 $RewardDetails = RewardDetail::where('reward_id',$reward_id)->where('item_id',$item_id)->where('status',2)->get();
//                                 foreach($RewardDetails as $RewardDetail)
//                                 {
//                                     $exists = 1;
//                                     $detail_id = $RewardDetail->id;
//                                     $RewardDetail = RewardDetail::find($detail_id);
//                                     $RewardDetail->status = 1;
//                                     $RewardDetail->save();
//                                 }
//                                 if($exists == 0)
//                                 {
//                                     $RewardDetail = new RewardDetail();
//                                     $RewardDetail->reward_id = $reward_id;
//                                     $RewardDetail->item_id  = $item_id;
//                                     $RewardDetail->save();
//                                 }
//                             }
//                             $i++;
//                         }
//                     }
//                 }

//             }
            // else
            // {
            //     if(isset($request->item_id))
            //     {
            //         $i = 0;
            //         $request_item = $request->item_id;


            //         if(isset($input['item_id']))
            //         {
            //             $item_id = $input['item_id'];

            //             $exists = 0;
            //             $RewardDetails = RewardDetail::where('reward_id',$reward_id)->where('item_id',$item_id)->where('status',2)->get();
            //             foreach($RewardDetails as $RewardDetail)
            //             {
            //                 $exists = 1;
            //                 $detail_id = $RewardDetail->id;
            //                 $RewardDetail = RewardDetail::find($detail_id);
            //                 $RewardDetail->status = 1;
            //                 $RewardDetail->save();
            //             }
            //             if($exists == 0)
            //             {
            //                 $RewardDetail = new RewardDetail();
            //                 $RewardDetail->reward_id = $reward_id;
            //                 $RewardDetail->item_id  = $item_id;
            //                 $RewardDetail->save();
            //             }
            //         }


            //     }
            // }

            // $RewardMenus =RewardMenu::where('reward_id',$reward_id)->where('status',2)->get();
            // foreach($RewardMenus as $RewardMenu)
            // {
            //     $detail_id = $RewardMenu->id;
            //     $RewardMenu = RewardMenu::find($detail_id);
            //     $RewardMenu->status = 0;
            //     $RewardMenu->save();
            // }


            // $RewardDetails = RewardDetail::where('reward_id',$reward_id)->where('status',2)->get();
            // foreach($RewardDetails as $RewardDetail)
            // {
            //     $detail_id = $RewardDetail->id;
            //     $RewardDetail = RewardDetail::find($detail_id);
            //     $RewardDetail->status = 0;
            //     $RewardDetail->save();
            // }

            Flash::success($this->msg_updated);
            return redirect('/service/rewards');
        }
        else
        {
            Flash::error($this->edit_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }




    public function makeInActive($id)
    {
        $Auth_User = Auth::user();
        if($Auth_User->can($this->status_permission) || $Auth_User->can('all'))
        {
            $Model_Data = Reward::find($id);

            // $rest_id = $Model_Data->rest_id;

            // $reward_activated_at = $Model_Data->activated_at;

            // $order_data = Order::where('rest_id',$rest_id)->where('status',1)->where('created_at','>=',$reward_activated_at)->get();

            // if($order_data->count() > 0){
            //     Flash::error("Reward Can't be Deactivated because it already have orders.");
            //     return redirect(route($this->home_route));
            // }

            // if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            // {
            //     Flash::error($this->msg_not_found);
            //     return redirect(route($this->home_route));
            // }

            $Model_Data->status = 0;
            $Model_Data->activated_at = null;

            //$Model_Data->updated_by = $Auth_User->id;
            $Model_Data->save();

            Flash::success('Reward is Deactivated successfully.');
            return redirect('rewards');
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
            $Model_Data = Reward::find($id);

            $check = false;


            // $rest_id = $Model_Data->rest_id;

             $rewards_data = Reward::where('status',1)->get();

            // foreach($rewards_data as $reward){

            //     $reward_activated_at = $reward->activated_at;
            //     $order_data = Order::where('rest_id',$rest_id)->where('status',1)->where('created_at','>=',$reward_activated_at)->get();
            //     if($order_data->count() > 0){
            //         $check = true;
            //     }
            // }

            // if($check){
            //     Flash::error("Reward Can't be activated because active reward already have orders.");
            //     return redirect(route($this->home_route));
            // }
            // else{
            //     Reward::where('rest_id',$rest_id)->update(['status'=>'0','activated_at'=>null]);
            // }



            // if (empty($Model_Data) || $this->is_not_authorized($id, $Auth_User))
            // {
            //     Flash::error($this->msg_not_found);
            //     return redirect(route($this->home_route));
            // }

            if($rewards_data->count() == 0)
            {
                $Model_Data->status = 1;
                $Model_Data->activated_at = now();
                $Model_Data->save();

    
                Flash::success('Reward is Activated successfully.');
            }
            else
            {
                Flash::error('cannot activate reward now because another reward is active');
                
            }
            //$Model_Data->updated_by = $Auth_User->id;

            return redirect('rewards');
        }
        else
        {
            Flash::error($this->status_permission_error_message);
            return redirect()->route($this->home_route);
        }
    }

  
}

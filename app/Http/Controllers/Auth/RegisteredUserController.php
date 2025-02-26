<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\EcomCategory;
use App\Providers\RouteServiceProvider;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Models\User;
use App\Models\SvcCategory;

use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		$categories_array = SvcCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');
		$ecom_categories_array = EcomCategory::select(['id','title'])->where('id', '>=', 1)->orderby('title', 'asc')->pluck('title','id');

        return view('auth.register', compact("categories_array", "ecom_categories_array"));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'phone' => 'required|string|min:10|max:255',
            'email' => 'required|string|email|min:6|max:255|unique:users',
            'password' => 'required',
            'address' => 'required|string|min:2|max:255',
            'website' => 'required|string|min:2|max:255',
            'company_name' => 'required|string|min:2|max:255|unique:users',
            'license_no' => 'required|string|min:2|max:255',
            'license_expiry' => 'required|string|min:2|max:255',
            'principal_place' => 'required|string|min:2|max:255',
            'activities' => 'required|string|min:2|max:255',
        ]);
		
		$user_type = 'admin';
		if($request->role == 'vendor')
			$user_type = 'vendor';
		elseif($request->role == 'seller')
			$user_type = 'seller';
		
		$Model_Data = new User();
			$Model_Data->user_type = $type;
			$Model_Data->company_name = $request->company_name;		
			$Model_Data->name = $request->name;	
			$Model_Data->email = $request->email;	
			$Model_Data->password = Hash::make($request->password);
			$Model_Data->phone = $request->phone;
			$Model_Data->address = $request->address;	
			$Model_Data->website = $request->website;
			$Model_Data->license_no = $request->license_no;
			$Model_Data->license_expiry = $request->license_expiry;	
			$Model_Data->principal_place = $request->principal_place;
			$Model_Data->activities = $request->activities;
			$Model_Data->comments = $request->comments;
			$Model_Data->status = 0;
			$Model_Data->application_status = 1;

			$categories = array();
	
			if(!empty($request->input('categories'))){
				foreach($request->input('categories') as $value){
					$categories[] = $value;
				}
				$categories = implode(',',$categories);
			}
	
			if(!empty($request->input('ecom_categories'))){
				foreach($request->input('ecom_categories') as $value){
					$categories[] = $value;
				}
				$categories = implode(',',$categories);
			}
	
			$Model_Data->categories = $categories;
		
		$Model_Data->save();
        return redirect()->route('sellerSignup');

        /*Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);*/
    }

    public function sellerSignup()
    {
        return view('auth.registration-pending');
    }
}

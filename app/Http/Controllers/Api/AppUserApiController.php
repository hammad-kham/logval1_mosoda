<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\AppImprovement;
use App\Models\AppUser;
use App\Models\AppUserLocation;
use App\Models\AppUserPaymentMethod;
use App\Models\AppUserQuery;
use App\Models\AppUserSetting;
use App\Models\AppUserSocial;
use App\Models\PaymentMethod;
use App\Models\SvcAppUserFavorite;
use App\Models\SvcCategory;
use App\Models\Notification;
use App\Models\SvcOrder;
use App\Models\SvcOrderDetail;
use App\Models\SvcOrderFile;
use App\Models\SvcOrderSubDetail;
use App\Models\SvcReview;
use App\Models\SvcSubCategory;
use App\Models\SvcTransaction;
use App\Models\SvcVendor;
use App\Models\SvcVendorCategory;
use App\Models\SvcVendorService;
use App\Models\SvcVendorSubCategory;
use App\Models\User;
use App\Models\RewardHistory;
use App\Models\RewardUser;
use App\Models\Reward;
use App\Models\RewardType;
use App\Models\SvcCoupon;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppUserApiController extends BaseController
{
    private $_token = null;
    private $lat = null;
    private $lng = null;
    private $radius = null;
    private $uploads_root = "uploads";
    private $uploads_path = "app_users";
    private $uploads_orders_path = "uploads/svc/orders";

    public function retMethod(Request $request, $action = 'listing')
    {
        app_users_status_update();

        ((!empty($request->header('lat'))) ? $this->lat = $request->header('lat') : $this->lat = null);

        ((!empty($request->header('lng'))) ? $this->lng = $request->header('lng') : $this->lng = null);

        ((!empty($request->header('radius'))) ? $this->radius = $request->header('radius') : $this->radius = 5);

        $page = 1;
        $limit = 10;
        (isset($request->page) ? $page = trim($request->page) : 1);
        (isset($request->limit) ? $limit = trim($request->limit) : 10);

        if ($action == 'email-signup-signin') {
            return $this->emailSignupSignin($request);
        } elseif ($action == 'email-signup') {
            return $this->emailSignup($request);
        } elseif ($action == 'phone-signup') {
            return $this->phoneSignup($request);
        } elseif ($action == 'verify-otp') {
            return $this->verifyOtp($request);
        } elseif ($action == 'login-email') {
            return $this->loginEmail($request);
        } elseif ($action == 'phone-otp') {
            return $this->phoneOtp($request);
        } elseif ($action == 'login-phone') {
            return $this->loginPhone($request);
        } elseif ($action == 'listing') {
            return $this->allUsers($page, $limit);
        } elseif ($action == 'submit-queries') {
            return $this->querySubmit($request);
        } elseif (!empty($request->header('token'))) {
            ((!empty($request->header('token'))) ? $this->_token = $request->header('token') : $this->_token = null);

            $token =  $this->_token;

            if (!empty($token)) {
                $Verifications = DB::table('verification_codes')->where('token', $token)->where('expired', 1)->first();
                if (empty($Verifications)) {
                    $response = [
                        'code' => '201',
                        'status' => false,
                        'token' => $token,
                        'data' => null,
                        'message' => 'Incorrect Access Token!',
                    ];
                    return response()->json($response, 200);
                }

                if ($action == 'token-validate') {
                    $response = [
                        'code' => '201',
                        'status' => true,
                        'data' => null,
                        'message' => 'Valid Token!',
                    ];
                    return response()->json($response, 200);
                } elseif ($action == 'token-expire') {
                    DB::table('verification_codes')->where('token', $token)->update([
                        'expired' => 0,
                        'updated_at' => now()
                    ]);

                    $response = [
                        'code' => '201',
                        'status' => true,
                        'data' => null,
                        'message' => 'Session Expired Successfully!',
                    ];
                    return response()->json($response, 200);
                }

                $user_id = 0;
                $User = getUser($this->_token);
                if ($User != null) {
                    $user_id = $User->id;
                } else {
                    return $this->sendError('User Not Found!');
                }

                switch ($action) {


                    case 'user-details': {
                            return $this->user_details($request, $User);
                        }
                        break;

                    case 'update-user': {
                            return $this->updateUser($request, $User);
                        }
                        break;



                    case 'user-settings': {
                            return $this->user_setting($request, $User);
                        }
                        break;

                    case 'update-user-settings': {
                            return $this->update_user_setting($request, $User);
                        }
                        break;



                    case 'user-socials': {
                            return $this->user_socials($request, $User);
                        }
                        break;

                    case 'update-user-socials': {
                            return $this->update_user_socials($request, $User);
                        }
                        break;


                    case 'app-improvement': {
                            return $this->app_improvement($request, $User);
                        }
                        break;


                    case 'verify-update-otp': {
                            return $this->verifyUpdateOtp($request, $User);
                        }
                        break;

                    case 'upload-photo': {
                            return $this->uploadPhoto($request, $User);
                        }
                        break;

                    case 'update-email': {
                            return $this->update_email($request, $User);
                        }
                        break;

                    case 'verify-email-otp': {
                            return $this->verify_email_otp($request, $User);
                        }
                        break;

                    case 'update-phone': {
                            return $this->update_phone($request, $User);
                        }
                        break;

                    case 'verify-phone-otp': {
                            return $this->verify_phone_otp($request, $User);
                        }
                        break;

                    case 'verify-old-phone': {
                            return $this->verify_old_phone($request, $User);
                        }
                        break;

                    case 'verify-old-phone-otp': {
                            return $this->verify_old_phone_otp($request, $User);
                        }
                        break;

                    case 'confirm-password': {
                            return $this->confirm_password($request, $User);
                        }
                        break;


                    case 'listing-location': {
                            return $this->locationListing($request, $User);
                        }
                        break;

                    case 'default-location': {
                            return $this->locationDefault($request, $User);
                        }
                        break;

                    case 'create-location': {
                            return $this->locationCreate($request, $User);
                        }
                        break;

                    case 'update-location': {
                            return $this->locationUpdate($request, $User);
                        }
                        break;

                    case 'delete-location': {
                            return $this->locationDelete($request, $User);
                        }
                        break;




                    case 'listing-payment-method': {
                            return $this->paymentMethodListing($request, $User);
                        }
                        break;

                    case 'default-payment-method': {
                            return $this->paymentMethodDefault($request, $User);
                        }
                        break;

                    case 'create-payment-method': {
                            return $this->paymentMethodCreate($request, $User);
                        }
                        break;

                    case 'update-payment-method': {
                            return $this->paymentMethodUpdate($request, $User);
                        }
                        break;

                    case 'delete-payment-method': {
                            return $this->paymentMethodDelete($request, $User);
                        }
                        break;

                    case 'coupons': {
                            return $this->coupons($request, $page, $limit, $User);
                        }
                        break;

                    case 'check-coupon-validity': {
                            return $this->check_coupon_validity($request, $User);
                        }
                        break;



                    case 'notification-listing': {
                            return $this->notificationListing($request, $User, $page, $limit);
                        }
                        break;

                    case 'notification-details': {
                            return $this->notificationDetails($request, $User);
                        }
                        break;

                    case 'notification-read': {
                            return $this->notificationRead($request, $User);
                        }
                        break;




                    case 'listing-favorite-vendor': {
                            return $this->favoriteVendorListing($request, $User);
                        }
                        break;

                    case 'add-favorite-vendor': {
                            return $this->favoriteVendorAdd($request, $User);
                        }
                        break;

                    case 'remove-favorite-vendor': {
                            return $this->favoriteVendorRemove($request, $User);
                        }
                        break;




                    case 'listing-reviews': {
                            return $this->reviewListing($request, $User);
                        }
                        break;

                    case 'create-review': {
                            return $this->reviewCreate($request, $User);
                        }
                        break;

                    case 'update-review': {
                            return $this->reviewUpdate($request, $User);
                        }
                        break;

                    case 'delete-review': {
                            return $this->reviewDelete($request, $User);
                        }
                        break;

                    case 'order-check': {
                            return $this->order_check($request, $User);
                        }
                        break;

                    case 'order-check-with-reward': {
                            return $this->order_check_with_reward($request, $User);
                        }
                        break;

                    case 'order-check-with-coupon': {
                            return $this->order_check_with_coupon($request, $User);
                        }
                        break;

                    case 'user-rewards-listing': {
                            return $this->user_rewards_listing($request, $User);
                        }
                        break;
                    case 'claim-rewards': {
                            return $this->claim_rewards($request, $User);
                        }
                        break;

                    case 'orders': {
                            if (isset($request->cat_id)) {
                                $cat_id = trim($request->cat_id);
                                if ($cat_id != null && !empty($cat_id)) {
                                    $user_id = trim($User->id);
                                    $loc_id = 0;
                                    $vend_id = 0;
                                    $sub_cat_id = 0;

                                    $exists = 0;
                                    $records = SvcCategory::select('id')->where('id', '=', $cat_id)->where('status', '=', 1)->get();

                                    $category = SvcCategory::find($cat_id);
                                    foreach ($records as $record) {
                                        $exists = 1;
                                    }
                                    if ($exists == 0) {
                                        return $this->sendError('Invalid Category Details Provided. Please Try Again');
                                    }

                                    if ($cat_id != 8) {
                                        if (isset($request->loc_id)) {
                                            $exists = 0;
                                            $loc_id = $request->loc_id;
                                            $records = AppUserLocation::select('id')->where('id', '=', $loc_id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
                                            foreach ($records as $record) {
                                                $exists = 1;
                                            }
                                            if ($exists == 0) {
                                                return $this->sendError('Invalid Location Details Provided. Please Try Again');
                                            }
                                        } else {
                                            return $this->sendError('Location Parameter Missing. Please Try Again');
                                        }
                                    }


                                    if (isset($request->sub_cat_id) && ($cat_id != 1 && $cat_id != 6 && $cat_id != 11)) {
                                        $exists = 0;
                                        $sub_cat_id = $request->sub_cat_id;
                                        $records = SvcSubCategory::select('id')->where('id', '=', $sub_cat_id)->where('status', '=', 1)->get();
                                        foreach ($records as $record) {
                                            $exists = 1;
                                        }
                                        if ($exists == 0) {
                                            return $this->sendError('Invalid SubCategory Details Provided. Please Try Again');
                                        }
                                    }

                                    if (isset($request->vendor_id)) {
                                        $exists = 0;
                                        $vend_id = $request->vendor_id;
                                        $records = SvcVendor::select('id')->where('id', '=', $vend_id)->where('status', '=', 1)->get();
                                        foreach ($records as $record) {
                                            $exists = 1;
                                        }
                                        if ($exists == 0) {
                                            return $this->sendError('Invalid Vendor Details Provided. Please Try Again');
                                        }
                                    }

                                    if (!isset($request->details)) {
                                        return $this->sendError('Order details Missing. Please Try Again');
                                    }

                                    $claim_reward = 0;
                                    if ($request->claim_reward == 1) {
                                        $claim_reward = 1;
                                    }

                                    switch ($cat_id) {
                                        case 1: {
                                                if ($sub_cat_id == 0) {
                                                    //return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }
                                                $claim_reward = 1;
                                                return $this->category_1_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 2: {
                                                /*if($sub_cat_id == 0)
											{
												return $this->sendError('SubCategory Parameter Missing. Please Try Again');
											}*/

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }
                                                $claim_reward = 1;
                                                return $this->category_2_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 3: {
                                                if ($sub_cat_id == 0) {
                                                    //return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_3_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 4: {
                                                if ($sub_cat_id == 0) {
                                                    // return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_4_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 5: {
                                                if ($sub_cat_id == 0) {
                                                    //return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_5_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 6: {
                                                if ($sub_cat_id == 0) {
                                                    //return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_6_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 7: {
                                                if ($sub_cat_id == 0) {
                                                    // return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_7_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 8: {
                                                if ($sub_cat_id == 0) {
                                                    // return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_8_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 9: {
                                                if ($sub_cat_id == 0) {
                                                    //return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_9_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 10: {
                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_10_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        case 11: {
                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_11_orders($request, $User, $claim_reward);
                                            }
                                            break;


                                        case 12: {
                                                if ($sub_cat_id == 0) {
                                                    //                                                    return $this->sendError('SubCategory Parameter Missing. Please Try Again');
                                                }

                                                if ($vend_id == 0) {
                                                    return $this->sendError('Vendor Parameter Missing. Please Try Again');
                                                }

                                                return $this->category_12_orders($request, $User, $claim_reward);
                                            }
                                            break;

                                        default:
                                            break;
                                    }
                                }
                            }
                            return $this->sendError('Category Parameter Missing. Please Try Again');
                        }
                        break;

                    case 'order-listing': {
                            return $this->orderListing($request, $User, $page, $limit);
                        }
                        break;

                    case 'order-details': {
                            return $this->orderDetails($request, $User);
                        }
                        break;

                    case 'cancel-order': {
                            return $this->orderCancel($request, $User);
                        }

                    case 'confirm-order': {
                            return $this->orderConfirm($request, $User);
                        }

                    case 'complete-order': {
                            return $this->orderComplete($request, $User);
                        }
                        break;

                    case 'reorder': {
                            return $this->reOrderData($request, $User);
                        }
                        break;




                    default: {
                            return $this->sendError('Invalid Request');
                        }
                        break;
                }
            } else {
                return $this->sendError('Invalid Access Token provided');
            }
        } else {
            return $this->sendError('You are not authorized.');
        }
    }

    public function allUsers($page, $limit)
    {
        $skip = (($page - 1) * $limit);
        return User::all();
    }


    public function emailSignupSignin(Request $request)
    {
        $proceed = 0;
        if (isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password)) {
            $email = trim($request->email);
            $password = md5(trim($request->password));
            $type = 'email';
            $proceed = 1;
        } else {
            return $this->sendError("Missing Parameters");
        }


        if ($proceed) {

            $User = AppUser::where('email', $email)->first();

            if (!empty($User)) {

                $User = AppUser::where('email', $email)->where('password', $password)->first();

                if (empty($User)) {
                    return $this->sendError('Incorrect Credentials Provided!');
                } elseif ($User->status == 2) {
                    return $this->sendError('Your account is suspended. Please Contact Administrator.');
                } elseif ($User->status == 0) {
                    return $this->sendError('Your account is InActive. Please Contact Administrator.');
                }

                $token = gen_random(9, 1) . '-' . gen_random(5, 2);

                $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->latest()->first();
                $code_id = $verification->id;

                $user_id = $User->id;
                $type = "email";

                DB::table('verification_codes')->insert([
                    'user_id' => $user_id,
                    'type' => $type,
                    'sent_to' => $email,
                    'code' => '1234',
                    'verified' => '1',
                    'token' => $token,
                    'expired' => 1,
                    'generated_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $User->device_name = $request->device_name ?? null;
                $User->device_id = $request->device_id ?? null;
                $User->save();

                $array = get_user_array($User);

                $message = 'User authenticated, successfully!';
            } else {

                $User = new AppUser();

                if (isset($request->name) && !empty($request->name))
                    $User->name = $request->name;

                if (isset($request->email) && !empty($request->email))
                    $User->email = $request->email;

                if (isset($request->password) && !empty($request->password))
                    $User->password = md5($request->password);

                $username = explode("@", $request->email);
                $username = $username[0];
                $User->username = $username . "" . rand(1000, 999999);

                $User->save();

                $user_id = $User->id;

                DB::table('app_user_settings')->insert([
                    'user_id' => $user_id,
                    'created_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('app_user_socials')->insert([
                    'user_id' => $user_id,
                    'created_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // generate & send otp to phone
                $code = rand(1000, 9999);
                $code = 1234;

                $token = gen_random(9, 1) . '-' . gen_random(5, 2);

                // store otp in verification codes
                DB::table('verification_codes')->insert([
                    'user_id' => $user_id,
                    'type' => $type,
                    'token' => $token,
                    'sent_to' => $email,
                    'code' => $code,
                    'verified' => 1,
                    'verified_at' => now(),
                    'expired' => 1,
                    'generated_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $User->email_verified = 1;
                $User->email_verified_at = now();
                $User->save();

                $array = get_user_array($User);

                $message = 'User authenticated, successfully!';
            }
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => [
                'token' => $token,
                'user' => $array
            ],
        ];
        return response()->json($response, 200);
    }


    public function emailSignup(Request $request)
    {
        $proceed = 0;
        if (isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password)) {
            $email = trim($request->email);
            $password = trim($request->password);
            $type = "email";
            $proceed = 1;
        } else {
            return $this->sendError("Missing Parameters");
        }

        $message = "";

        if ($proceed) {

            $User = AppUser::where('email', $email)->first();

            if (!empty($User)) {
                return $this->sendError("Email Already Exists");
            }

            $reg_User = AppUser::where('new_email', $email)->first();
            if (!empty($reg_User)) {
                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => "Otp sent successfully!",
                    'data' => null,
                ];
                return response()->json($response, 200);
            }
            $User = new AppUser();

            if (isset($request->name) && !empty($request->name))
                $User->name = $request->name;

            if (isset($request->email) && !empty($request->email))
                $User->new_email = $request->email;
            $User->email_otp = 1234;

            if (isset($request->password) && !empty($request->password))
                $User->password = md5($request->password);

            $username = explode("@", $request->email);
            $username = $username[0];
            $User->username = $username . "" . rand(1000, 999999);
            //			$User->status = 0;


            $User->save();

            $user_id = $User->id;

            DB::table('app_user_settings')->insert([
                'user_id' => $user_id,
                'created_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('app_user_socials')->insert([
                'user_id' => $user_id,
                'created_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            //            $verification = DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $email)->latest()->first();
            //            if (!empty($verification)) {
            //
            //                DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $email)->update([
            //                    'expired' => 0,
            //                    'updated_at' => now()
            //                ]);
            //            }

            // generate & send otp to phone
            $code = rand(1000, 9999);
            $code = 1234;


            // store otp in verification codes
            DB::table('verification_codes')->insert([
                'user_id' => $user_id,
                'type' => $type,
                'sent_to' => $email,
                'code' => $code,
                'verified' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $message = 'OTP sent successfully!';
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => null,
        ];
        return response()->json($response, 200);
    }


    public function update_email(Request $request, $User)
    {
        $new_email = $request->email;
        //$otp = rand(1000, 9999);
        $otp = 1234;
        $data = array();

        $email_check = AppUser::where('email', $new_email)->first();

        if (empty($email_check)) {
            $update_email = AppUser::where('id', $User->id)->update(['new_email' => $new_email, 'email_otp' => $otp]);
            if ($update_email) {
                $data['email'] = $new_email;
                //$data['message'] = 'otp sent on '. $new_email;

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp sent on ' . $new_email,
                    'data' => $data,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['email'] = $new_email;
            //$data['message'] = 'Email already exists';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'Email already exists',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function verify_email_otp(Request $request, $User)
    {
        $email = $request->email;
        $otp = $request->otp;
        $data = array();

        $check_exists = AppUser::where('id', $User->id)->first();
        if ($check_exists->email_otp != null) {
            $verify_otp = AppUser::where('new_email', $email)->where('email_otp', $otp)->first();

            if (!empty($verify_otp)) {
                DB::table('app_user_logs')->insert([
                    'user_id' => $User->id,
                    'type' => 'email',
                    'old_value' => $verify_otp->email,
                    'new_value' => $email
                ]);

                $updated = AppUser::where('id', $User->id)->update([
                    'email' => $email,
                    'new_email' => null,
                    'email_otp' => null,
                ]);

                if ($updated) {
                    //$data['message'] = 'Email updated successfully!';

                    $response = [
                        'code' => '201',
                        'status' => true,
                        'message' => 'Email updated successfully!',
                        'data' => null,
                    ];
                    return response()->json($response, 200);
                }
            } else {
                $data['email'] = $email;
                //$data['message'] = 'otp did not match!';

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp did not exist!',
                    'data' => $data,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['email'] = $email;
            //$data['message'] = 'otp did not match!';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'otp does not exist!',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function update_phone(Request $request, $User)
    {
        $new_phone = $request->phone;
        //$otp = rand(1000, 9999);
        $otp = 1234;
        $data = array();

        $phone_check = AppUser::where('phone', $new_phone)->first();

        if (empty($phone_check)) {
            $update_phone = AppUser::where('id', $User->id)->update(['new_phone' => $new_phone, 'phone_otp' => $otp]);
            if ($update_phone) {
                $data['phone'] = $new_phone;
                //$data['message'] = 'otp sent on '. $new_phone;

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp sent on ' . $new_phone,
                    'data' => $data,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['phone'] = $new_phone;
            //$data['message'] = 'Phone number already exists';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'Phone number already exists!',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function verify_phone_otp(Request $request, $User)
    {
        $phone = $request->phone;
        $otp = $request->otp;
        $data = array();

        $check_exists = AppUser::where('id', $User->id)->first();
        if ($check_exists->phone_otp != null) {
            $verify_otp = AppUser::where('new_phone', $phone)->where('phone_otp', $otp)->first();

            if (!empty($verify_otp)) {
                DB::table('app_user_logs')->insert([
                    'user_id' => $User->id,
                    'type' => 'phone',
                    'old_value' => $verify_otp->phone ?? null,
                    'new_value' => $phone
                ]);

                $updated = AppUser::where('id', $User->id)->update([
                    'phone' => $phone,
                    'new_phone' => null,
                    'phone_otp' => null
                ]);

                if ($updated) {
                    //$data['message'] = 'Phone updated successfully!';

                    $response = [
                        'code' => '201',
                        'status' => true,
                        'message' => 'Phone number updated successfully!',
                        'data' => null,
                    ];
                    return response()->json($response, 200);
                }
            } else {
                $data['phone'] = $phone;
                //$data['message'] = 'otp did not match!';

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp did not match!',
                    'data' => $data,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['phone'] = $phone;
            //$data['message'] = 'otp did not match!';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'otp does not exist!',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function confirm_password(Request $request, $User)
    {
        $email = $request->email;
        $password = md5($request->password);
        $data = array();

        $verify = AppUser::where('id', $User->id)->where('email', $email)->where('password', $password)->first();

        if ($verify) {
            //$data['message'] = "User Verified!";
            $response = [
                'code' => '201',
                'status' => true,
                'message' => "User Verified!",
                'data' => null,
            ];
            return response()->json($response, 200);
        } else {
            //$data['message'] = "User not verified!";
            $response = [
                'code' => '201',
                'status' => true,
                'message' => "User not verified!",
                'data' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function verify_old_phone(Request $request, $User)
    {
        $phone = $request->phone;

        $otp = 1234;
        $data = array();


        $verify = AppUser::where('phone', $phone)->first();

        if (!empty($verify)) {
            $updated = AppUser::where('id', $User->id)->update([
                'phone' => $phone,
                'new_phone' => null,
                'phone_otp' => $otp
            ]);

            if ($updated) {
                //$data['message'] = 'Phone updated successfully!';

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp sent to Phone number successfully!',
                    'data' => null,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['phone'] = $phone;
            //$data['message'] = 'otp did not match!';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'phone number does not match!',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function verify_old_phone_otp(Request $request, $User)
    {
        $phone = $request->phone;
        $otp = $request->otp;
        $data = array();

        $phone_exists = AppUSer::where('id', $User->id)->first();
        if ($phone_exists->phone != null) {
            $phone_exists = AppUSer::where('id', $User->id)->first();
            if ($phone_exists->phone_otp != null) {
                $verify = AppUser::where('phone', $phone)->first();

                if (!empty($verify)) {

                    $check_otp = AppUser::where('phone', $phone)->where('phone_otp', $otp)->first();
                    if (!empty($check_otp)) {
                        // $updated = AppUser::where('id', $User->id)->update([
                        //     'phone' => $phone,
                        //     'new_phone' => null,
                        //     'phone_otp' => $otp
                        // ]);

                        // if($updated)
                        // {
                        //$data['message'] = 'Phone updated successfully!';

                        $response = [
                            'code' => '201',
                            'status' => true,
                            'message' => 'otp matched successfully!',
                            'data' => null,
                        ];
                        return response()->json($response, 200);
                        //}
                    } else {
                        $data['phone'] = $phone;
                        //$data['message'] = 'otp did not match!';

                        $response = [
                            'code' => '201',
                            'status' => true,
                            'message' => 'otp did not match!',
                            'data' => $data,
                        ];
                        return response()->json($response, 200);
                    }
                } else {
                    $data['phone'] = $phone;
                    //$data['message'] = 'otp did not match!';

                    $response = [
                        'code' => '201',
                        'status' => true,
                        'message' => 'phone number does not match!',
                        'data' => $data,
                    ];
                    return response()->json($response, 200);
                }
            } else {
                $data['phone'] = $phone;
                //$data['message'] = 'otp did not match!';

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'otp does not exist!',
                    'data' => $data,
                ];
                return response()->json($response, 200);
            }
        } else {
            $data['phone'] = $phone;
            //$data['message'] = 'otp did not match!';

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'phone number does not exist!',
                'data' => $data,
            ];
            return response()->json($response, 200);
        }
    }

    public function phoneSignup(Request $request)
    {
        $proceed = 0;
        if (isset($request->phone) && !empty($request->phone)) {
            $phone = trim($request->phone);
            $type = "phone";
            $proceed = 1;
        } else {
            return $this->sendError("Missing Parameters");
        }


        if ($proceed) {

            $User = AppUser::where('phone', $phone)->first();


            if (!empty($User)) {
                return $this->sendError("Phone No. Already Exists");
            }

            $reg_User = AppUser::where('new_phone', $phone)->first();
            if (!empty($reg_User)) {
                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => "OTP sent successfully!",
                    'data' => null,
                ];
                return response()->json($response, 200);
            }

            $User = new AppUser();

            if (isset($request->name) && !empty($request->name))
                $User->name = $request->name;

            if (isset($request->phone) && !empty($request->phone))
                $User->new_phone = $request->phone;
            $User->phone_otp = 1234;

            $username = substr($request->phone, -4);
            $User->username = $username . "" . rand(1000, 999999);

            //			$User->status = 0;

            $User->save();

            $user_id = $User->id;


            DB::table('app_user_settings')->insert([
                'user_id' => $user_id,
                'created_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('app_user_socials')->insert([
                'user_id' => $user_id,
                'created_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            //            $verification = DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $phone)->latest()->first();
            //            if (!empty($verification)) {
            //                DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $phone)->update([
            //                    'expired' => 0,
            //                    'updated_at' => now()
            //                ]);
            //            }

            // generate & send otp to phone
            $code = rand(1000, 9999);
            $code = 1234;


            // store otp in verification codes
            DB::table('verification_codes')->insert([
                'user_id' => $user_id,
                'type' => $type,
                'sent_to' => $phone,
                'code' => $code,
                'verified' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $message = 'OTP sent successfully!';
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => null,
        ];
        return response()->json($response, 200);
    }

    public function verifyOtp(Request $request)
    {
        $proceed = 0;
        if (isset($request->phone) && !empty($request->phone)) {
            $phone = trim($request->phone);
            $type = "phone";
            $proceed = 1;
        } elseif (isset($request->email) && !empty($request->email)) {
            $email = trim($request->email);
            $type = "email";
            $proceed = 1;
        } else {
            return $this->sendError("Missing Parameters");
        }

        if ($proceed) {
            $User = array();
            $found = false;

            if ($type == "phone") {
                $User = AppUser::where('new_phone', $phone)->where('phone_otp', $request->code)->first();
            } else {
                $User = AppUser::where('new_email', $email)->where('email_otp', $request->code)->first();
            }
            $found = false;
            if (empty($User)) {
                return $this->sendError('Incorrect Details!');
            } elseif ($User->status == 2) {
                return $this->sendError('Your account is suspended. Please Contact Administrator.');
            } elseif ($User->status == 0) {
                return $this->sendError('Your account is InActive. Please Contact Administrator.');
            } else {
                if ($type == "phone") {
                    AppUser::where('new_phone', $phone)->where('phone_otp', $request->code)->update([
                        'phone' => $phone,
                        'new_phone' => null,
                        'phone_otp' => null
                    ]);
                    $found = true;
                } else {
                    AppUser::where('new_email', $email)->where('email_otp', $request->code)->update([
                        'email' => $email,
                        'new_email' => null,
                        'email_otp' => null
                    ]);
                    $found = true;
                }
            }



            if ($type == "phone") {
                $verifications = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $phone)->get();
            } else {
                $verifications = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->get();
            }

            foreach ($verifications as $verification) {
                $code_id = $verification->id;
                $code_found = $verification->code;
                // if ($request->code == $code_found) {
                //     $found = true;
                //     break;
                // }
            }

            if ($found == false) {
                return $this->sendError('Incorrect OTP!');
            }

            $token = gen_random(9, 1) . '-' . gen_random(5, 2);

            DB::table('verification_codes')->where('id', $code_id)->update([
                'token' => $token,
                'verified' => 1,
                'verified_at' => now(),
                'expired' => 1,
                'generated_at' => now(),
                'updated_at' => now()
            ]);

            $User->device_name = $request->device_name ?? null;
            $User->device_id = $request->device_id ?? null;

            $User->status = 1;
            if ($type == "phone") {
                $User->phone_verified = 1;
                $User->phone_verified_at = now();
            } else {
                $User->email_verified = 1;
                $User->email_verified_at = now();
            }
            $User->save();

            $array = get_user_array($User);

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'User authenticated, successfully!',
                'data' => [
                    'token' => $token,
                    'user' => $array
                ],
            ];
        }

        return response()->json($response, 200);
    }

    public function loginEmail(Request $request)
    {

        if (isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password)) {
            $email = $request->email;
            $password = md5($request->password);
        } else {
            return $this->sendError("Missing Parameters");
        }

        $User = AppUser::where('email', $email)->where('password', $password)->first();

        if (empty($User)) {
            return $this->sendError('Incorrect Credentials Provided!');
        } elseif ($User->status == 2) {
            return $this->sendError('Your account is suspended. Please Contact Administrator.');
        } elseif ($User->status == 0) {
            return $this->sendError('Your account is InActive. Please Contact Administrator.');
        }

        $token = gen_random(9, 1) . '-' . gen_random(5, 2);

        $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->first();
        //$code_id = $verification->id;

        $user_id = $User->id;
        $type = "email";

        DB::table('verification_codes')->insert([
            'user_id' => $user_id,
            'type' => $type,
            'sent_to' => $email,
            'code' => '1234',
            'verified' => '1',
            'token' => $token,
            'expired' => 1,
            'generated_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //        DB::table('verification_codes')->where('id', $code_id)->update([
        //            'token' => $token,
        //            'expired' => 1,
        //            'generated_at' => now(),
        //            'updated_at' => now()
        //        ]);

        $User->device_name = $request->device_name ?? null;
        $User->device_id = $request->device_id ?? null;
        $User->save();

        $array = get_user_array($User);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User authenticated, successfully!',
            'data' => [
                'token' => $token,
                'user' => $array
            ],
        ];


        return response()->json($response, 200);
    }

    public function phoneOtp(Request $request)
    {
        if (isset($request->phone) && !empty($request->phone)) {
            $phone = trim($request->phone);
            $type = "phone";
        } else {
            return $this->sendError("Missing Parameters");
        }


        $User = AppUser::where('new_phone', $phone)->first();


        if (empty($User)) {
            return $this->sendError("Phone No. is not registered");
        } elseif ($User->status == 2) {
            return $this->sendError('Your account is suspended. Please Contact Administrator.');
        } elseif ($User->status == 0) {
            return $this->sendError('Your account is InActive. Please Contact Administrator.');
        }


        $user_id = $User->id;

        //        $verification = DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $phone)->latest()->first();
        /*if (!empty($verification)) {
            DB::table('verification_codes')->where('user_id', $user_id)->where('sent_to', $phone)->update([
                'expired' => 0,
                'updated_at' => now()
            ]);
        }*/

        // generate & send otp to phone
        $code = rand(1000, 9999);
        $code = 1234;


        // store otp in verification codes
        DB::table('verification_codes')->insert([
            'user_id' => $user_id,
            'type' => $type,
            'sent_to' => $phone,
            'code' => $code,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $message = 'OTP sent successfully!';

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => null,
        ];
        return response()->json($response, 200);
    }

    public function loginPhone(Request $request)
    {
        if (isset($request->phone) && !empty($request->phone) && isset($request->code) && !empty($request->code)) {
            $phone = trim($request->phone);
        } else {
            return $this->sendError("Missing Parameters");
        }

        $User = AppUser::where('phone', $phone)->first();
        $found = false;

        if (empty($User)) {
            return $this->sendError('Incorrect Phone No. Provided!');
        } elseif ($User->status == 2) {
            return $this->sendError('Your account is suspended. Please Contact Administrator.');
        } elseif ($User->status == 0) {
            return $this->sendError('Your account is InActive. Please Contact Administrator.');
        }


        $verifications = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $phone)->get();
        foreach ($verifications as $verification) {
            $code_id = $verification->id;
            $code_found = $verification->code;
            if ($request->code == $code_found) {
                $found = true;
                break;
            }
        }

        if ($found == false) {
            return $this->sendError('Incorrect OTP!');
        }

        $token = gen_random(9, 1) . '-' . gen_random(5, 2);

        $user_id = $User->id;
        $type = "phone";

        DB::table('verification_codes')->insert([
            'user_id' => $user_id,
            'type' => $type,
            'sent_to' => $phone,
            'code' => '1234',
            'verified' => '1',
            'token' => $token,
            'expired' => 1,
            'generated_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //        DB::table('verification_codes')->where('id', $code_id)->update([
        //            'token' => $token,
        //            'expired' => 1,
        //            'generated_at' => now(),
        //            'updated_at' => now()
        //        ]);

        $User->device_name = $request->device_name ?? null;
        $User->device_id = $request->device_id ?? null;
        $User->save();

        $array = get_user_array($User);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User authenticated, successfully!',
            'data' => [
                'token' => $token,
                'user' => $array
            ],
        ];

        return response()->json($response, 200);
    }


    public function user_rewards_listing(Request $request, $User)
    {
        $user_id = $User->id;

        $reward = Reward::where('status', 1)->first();
        $user_rewards = RewardUser::where(['user_id' => $user_id])->first();

        $msg = "";
        $get_more_msg = "";
        $array = array();
        $discount_type = array();
        $n_arr = array();


        if (!empty($reward)) {
            if (!empty($user_rewards)) {

                if ($reward->platinum_punches <= $user_rewards->punch_count) {
                    $msg = "You have got a Platinum house";

                    $get_more_msg = "";

                    if ($reward->has_limitations == 1 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                        $end = Carbon::parse($user_rewards->created_at);
                        $current = Carbon::now();
                        $days_since_first_order = $end->diffInDays($current);
                        ///$s = date('d', $user_rewards->start_date);
                        //$e = date('d', $user_rewards->end_date);
                        //$days = date('m-d-Y',strtotime($s.' days',strtotime($t)));


                        $in = $reward->intervals - $days_since_first_order;

                        $get_more_msg = "You can use this platinum house in " . $in . " days";
                    } elseif ($user_rewards->has_limitations == 2 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', $reward->end_date)) {
                        $get_more_msg = "You can use this Platinum house till " . date('m-d-Y', $user_rewards->end_date);
                    }


                    if ($reward->platinum_fixed_value != null) {
                        $discount_type['discount_type'] = "Fixed Value";
                        $discount_type['platinum_fixed_value'] = $reward->platinum_fixed_value;
                    } elseif ($reward->platinum_discount_percentage != null) {
                        $discount_type['discount_type'] = "Discount Percentage";
                        $discount_type['platinum_percentage'] = $reward->platinum_discount_percentage;
                    }
                } elseif ($reward->golden_punches <= $user_rewards->punch_count) {
                    //$days = 0;
                    //$e = 0;
                    if ($reward->has_limitations == 1 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                        $end = Carbon::parse($user_rewards->created_at);
                        $current = Carbon::now();
                        $days_since_first_order = $end->diffInDays($current);
                        ///$s = date('d', $user_rewards->start_date);
                        //$e = date('d', $user_rewards->end_date);
                        //$days = date('m-d-Y',strtotime($s.' days',strtotime($t)));

                        $get_gold = $reward->platinum_punches - $user_rewards->punch_count;

                        $msg = "you have got golden house";

                        $in = $reward->intervals - $days_since_first_order;

                        $get_more_msg = "To get to the platinum house order " . $get_gold . " more orders in " . $in . " days";
                    } elseif ($reward->has_limitations == 2 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', $reward->end_date)) {

                        $get_gold = $reward->platinum_punches - $user_rewards->punch_count;

                        $msg = "you have got golden house";

                        $get_more_msg = "To get to the platinum house order " . $get_gold . " more orders till " . date('m-d-Y', $reward->end_date);
                    } else {
                        RewardUser::where('user_id', $user_id)->delete();
                        $msg = "You do not have any rewards";
                    }



                    if ($reward->golden_fixed_value != null) {
                        $discount_type['discount_type'] = "fixed_value";
                        $discount_type['golden_fixed_value'] = $reward->golden_fixed_value;
                    } elseif ($reward->golden_discount_percentage != null) {
                        $discount_type['discount_type'] = "Percentage";
                        $discount_type['percentage_discount_value'] = $reward->golden_discount_percentage;
                    }
                } elseif ($reward->silver_punches <= $user_rewards->punch_count) {

                    $get_gold = $reward->golden_punches - ($user_rewards->punch_count);

                    if ($reward->has_limitations == 1 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                        $end = Carbon::parse($user_rewards->created_at);
                        $current = Carbon::now();
                        $days_since_first_order = $end->diffInDays($current);
                        ///$s = date('d', $user_rewards->start_date);
                        //$e = date('d', $user_rewards->end_date);
                        //$days = date('m-d-Y',strtotime($s.' days',strtotime($t)));

                        $get_gold = $reward->golden_punches - $user_rewards->punch_count;

                        $msg = "you have got Silver house";

                        $in = $reward->intervals - $days_since_first_order;

                        $get_more_msg = "To get to the Golden house order " . $get_gold . " more orders in " . $in . " days";
                    } elseif ($reward->has_limitations == 2 && $user_rewards->created_at >= $reward->activated_at && $user_rewards->created_at <= date('Y-m-d H:i:s', $reward->end_date)) {
                        //$end = Carbon::parse($user_rewards->created_at);
                        //$current = Carbon::now();
                        //$days_since_first_order = $end->diffInDays($current);
                        ///$s = date('d', $user_rewards->start_date);
                        //$e = date('d', $user_rewards->end_date);
                        //$days = date('m-d-Y',strtotime($s.' days',strtotime($t)));



                        //$end = strtotime('2010-02-20');

                        $get_gold = $reward->golden_punches - $user_rewards->punch_count;

                        $msg = "you have got Silver house";

                        $get_more_msg = "To get to the Golden house order " . $get_gold . " more orders till " . date('Y-m-d H:i:s', ((strtotime($reward->created_at))));
                    }

                    // if($days <= $user_rewards->intervals)
                    // {
                    //     $get_more_msg = "To get to the golden house order ".$get_gold." more orders in ".$days;
                    //     $msg = "You have got a Silver house";
                    // }

                    if ($reward->silver_fixed_value != null) {
                        $discount_type['discount_type'] = "Fixed Value";
                        $discount_type['silver_fixed_value'] = $reward->silver_fixed_value;
                    } elseif ($reward->silver_discount_percentage != null) {
                        $discount_type['discount_type'] = "Percentage Discount";
                        $discount_type['silver_percentage_discount'] = $reward->silver_discount_percentage;
                    }
                } else {
                    $n_arr['message'] = "no rewards available";
                }

                if ($reward->has_limitations == 1) {
                    $array['interval'] = $reward->intervals;
                    $t = date($reward->created_at);
                    $array['expirey_date'] = date('m-d-Y', strtotime($reward->intervals . ' days', strtotime($t)));
                } elseif ($reward->has_limitations == 2) {
                    $array['start_date'] = date("m-d-Y", $reward->start_date);
                    $array['end_date'] = date("m-d-Y", $reward->end_date);
                }
            } else {
                $n_arr['message'] = "no rewards available for this user";
            }
        } else {
            $n_arr['message'] = "no rewards available";
        }

        //$array['remaining_days'] = $user_rewards->intervals - $days_since_first_order;
        //$array['expirey_date'] = date("m-d-Y",$user_rewards->end_date);
        //$n_arr = array();

        $empt = array();
        $empt = "no rewards available";
        if ($discount_type != null) {
            $n_arr['type'] = $discount_type;
            $n_arr['interval'] = $array;
        }







        //$date = new DateTime($t); // Y-m-d

        //$date->add(new DateInterval('P30D'));
        $response = [

            'code' => '201',


            'current house' => $msg,

            'next house' => $get_more_msg,


            'reward' => $n_arr,

        ];

        return response()->json($response, 200);
    }

    public function claim_rewards(Request $request, $User)
    {

        $user_id = $User->id;
        if (!empty($user_id)) {
            $reward_exist = 0;
            $reward_user_exist = 0;
            $reward = Reward::where('status', 1)->first();
            if (!empty($reward)) {
                $reward_exist = 1;
            }

            $reward_user = RewardUser::where('user_id', $User->id)->first();
            if (!empty($reward_user)) {
                $reward_user_exist = 1;
            }
        }
        $reward_id = 0;
        $discount = 0;
        $fixed_value = 0;
        $discount_percentage = 0;

        $discount_value = 0;

        $silver_house = 0;
        $golden_house = 0;
        $platinum_house = 0;


        // if($request->calim_reward == 1)
        // {
        $Reward = Reward::where('status', 1)->first();
        if (!empty($Reward)) {

            $reward_user_check = RewardUser::where('user_id', $user_id)->first();

            $reward = Reward::where('status', 1)->first();

            if ($reward_user_check->punch_count > $Reward->platinum_punches) {

                if ($reward->platinum_fixed_value != null) {
                    $discount = $reward->platinum_fixed_value;
                }
                if ($reward->platinum_discount_percentage != null) {
                    $discount = $reward->platinum_discount_percentage;
                }
                //  $discount = $reward->discount_percentage;

                $reward_user_check->punch_count -= $Reward->platinum_punches;
                $reward_user_check->save();
            } elseif ($reward_user_check->punch_count > $Reward->golden_punches) {

                if ($reward->golden_fixed_value != null) {
                    $discount = $reward->golden_fixed_value;
                }
                if ($reward->golden_discount_percentage != null) {
                    $discount = $reward->golden_discount_percentage;
                }
                //  $discount = $reward->discount_percentage;

                $reward_user_check->punch_count -= $Reward->golden_punches;
                $reward_user_check->save();
            } elseif ($reward_user_check->punch_count > $reward->silver_punches) {
                $discount = 30;

                if ($reward->silver_fixed_value != null) {
                    $discount = $reward->silver_fixed_value;
                }
                if ($reward->silver_discount_percentage != null) {
                    $discount = $reward->silver_discount_percentage;
                }
                //  $discount = $reward->discount_percentage;
                $reward_user_check->punch_count -= $Reward->silver_punches;
                $reward_user_check->save();
            }
        }
        // } 
        // if($reward->min_no_of_punches <= $reward_user_check->min_no_of_punches && $reward->discount_type == 2)
        // {

        //     $total = $total - $reward->fixed_value;
        //     break;
        // }



    }

    public function user_details(Request $request, $user)
    {


        $records_data = null;

        if (!empty($user)) {
            $records_data = $this->get_user_array($user);
        }

        $data = array();
        $data['user_details'] = $records_data;

        $message = "User Details Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function updateUser(Request $request, $User)
    {
        $message = 'User updated, successfully!';
        if (isset($request->phone) && !empty($request->phone)) {

            if ($User->phone == null || $User->phone_verified == 0) {

                $type = "phone";
                $phone = $request->phone;

                $User_with_same_phone = AppUser::where('phone', $phone)->where('id', "!=", $User->id)->first();


                if (empty($User_with_same_phone)) {
                    $User->phone = $phone;
                    $User->save();

                    $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $phone)->latest()->first();

                    if (!empty($verification)) {

                        DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $phone)->update([
                            'expired' => 0,
                            'updated_at' => now()
                        ]);
                    }

                    // generate & send otp to phone
                    $code = rand(1000, 9999);
                    $code = 1234;


                    // store otp in verification codes
                    DB::table('verification_codes')->insert([
                        'user_id' => $User->id,
                        'type' => $type,
                        'sent_to' => $phone,
                        'code' => $code,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $message = "User updated and a verification code is sent to provided phone no.";
                } else {
                    $message = "User updated but phone no. isn't, because phone no. already exists.";
                }
            } else {
                $message = "User details updated, but phone no. can't be updated.";
            }
        }

        if (isset($request->email) && !empty($request->email)) {

            if (isset($request->password) && !empty($request->password)) {

                if ($User->email == null || $User->email_verified == 0) {

                    $type = "email";
                    $email = $request->email;

                    $User_with_same_email = AppUser::where('email', $email)->where('id', "!=", $User->id)->first();


                    if (empty($User_with_same_email)) {
                        $User->email = $email;
                        $User->save();

                        $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->latest()->first();

                        if (!empty($verification)) {

                            DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->update([
                                'expired' => 0,
                                'updated_at' => now()
                            ]);
                        }

                        // [TODO] generate & send otp to phone
                        $code = rand(1000, 9999);
                        $code = 1234;

                        // store otp in verification codes

                        DB::table('verification_codes')->insert([
                            'user_id' => $User->id,
                            'type' => $type,
                            'sent_to' => $email,
                            'code' => $code,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                        $message = "User updated and a verification code is sent to provided phone no.";
                    } else {
                        $message = "User updated but email isn't, because email already exists.";
                    }
                } else {
                    $message = "User details updated, but email can't be updated.";
                }
            } else {
                $message = "User details updated, but email cannot be updated because password is required for email.";
            }
        }

        $photo = $User->photo;
        $photo_type = $User->photo_type;

        $User->name = trim($request->name) ?? $User->name;
        if (isset($request->photo) && !empty($request->photo)) {
            $photo = trim($request->photo);
            $photo_type = 1;

            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
            $check = 1; //in_array($extension,$allowedfileExtension);

            if ($check) {
                $file_uploaded = $request->file('photo');
                $extension = $file_uploaded->getClientOriginalExtension();
                $photo = date('YmdHis') . "." . $extension;
                $photo_type = 0;

                $uploads_path = $this->uploads_path;
                if (!is_dir($uploads_path)) {
                    mkdir($uploads_path);
                    $uploads_root = $this->uploads_root;
                    $src_file = $uploads_root . "/index.html";
                    $dest_file = $uploads_path . "/index.html";
                    copy($src_file, $dest_file);
                }

                $file_uploaded->move($uploads_path, $photo);
            } else {
                return $this->sendError('Invalid image format provided. Please upload image file (jpeg,jpg,png)');
            }
        }

        if (isset($request->username)) {
            $app_users = AppUser::where("username", $request->username)->where("id", "!=", $User->id)->count();
            if ($app_users > 0) {
                return $this->sendError('Username Already Exists');
            } else {
                $User->username = $request->username;
            }
        }
        if (isset($request->date_of_birth)) {
            $User->date_of_birth = $request->date_of_birth;
        }
        if (isset($request->interested_in)) {
            $User->interested_in = $request->interested_in;
        }

        $User->photo = $photo;
        $User->photo_type = $photo_type;


        $User->save();

        $array = get_user_array($User);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' =>  [
                'user' => $array
            ],
        ];
        return response()->json($response, 200);
    }

    public function user_setting(Request $request, $user)
    {


        $id = $user->id;
        $Records = AppUserSetting::where('user_id', '=', $id)->first();


        $records_data = null;

        if (!empty($Records)) {
            $records_data = $this->get_user_setting_array($Records);
        }

        //        $data = array();
        //        $data['user_settings'] = $records_data;

        $message = "User Settings Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $records_data,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function update_user_setting(Request $request, $user)
    {

        $id = $user->id;
        $User = AppUserSetting::where('user_id', '=', $id)->first();

        if (isset($request->country)) {
            $User->country = $request->country;
        }
        if (isset($request->currency)) {
            $User->currency = $request->currency;
        }
        if (isset($request->language)) {
            $User->language = $request->language;
        }
        if (isset($request->discount_sales)) {
            $User->discount_sales = $request->discount_sales;
        }
        if (isset($request->discount_sales_preference)) {
            $User->discount_sales_preference = $request->discount_sales_preference;
        }
        if (isset($request->new_stuff)) {
            $User->new_stuff = $request->new_stuff;
        }
        if (isset($request->new_stuff_preference)) {
            $User->new_stuff_preference = $request->new_stuff_preference;
        }
        if (isset($request->new_collections)) {
            $User->new_collections = $request->new_collections;
        }
        if (isset($request->new_collections_preference)) {
            $User->new_collections_preference = $request->new_collections_preference;
        }
        if (isset($request->stock)) {
            $User->stock = $request->stock;
        }
        if (isset($request->stock_preference)) {
            $User->stock_preference = $request->stock_preference;
        }
        if (isset($request->updates)) {
            $User->updates = $request->updates;
        }
        if (isset($request->updates_preference)) {
            $User->updates_preference = $request->updates_preference;
        }
        if (isset($request->dark_mode)) {
            $User->dark_mode = $request->dark_mode;
        }

        $User->updated_at = now();
        $User->updated_by = $id;

        $User->save();

        $message = 'User Settings updated, successfully!';

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function user_socials(Request $request, $user)
    {


        $id = $user->id;
        $Records = AppUserSocial::where('user_id', '=', $id)->first();


        $records_data = null;

        if (!empty($Records)) {
            $records_data = $this->get_user_socials_array($Records);
        }

        //        $data = array();
        //        $data['user_settings'] = $records_data;

        $message = "User Socials Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $records_data,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function update_user_socials(Request $request, $user)
    {

        $id = $user->id;
        $User = AppUserSocial::where('user_id', '=', $id)->first();

        if (isset($request->google_status)) {
            $User->google_status = $request->google_status;
        }
        if (isset($request->google)) {
            $User->google = $request->google;
        }
        if (isset($request->facebook_status)) {
            $User->facebook_status = $request->facebook_status;
        }
        if (isset($request->facebook)) {
            $User->facebook = $request->facebook;
        }
        if (isset($request->instagram_status)) {
            $User->instagram_status = $request->instagram_status;
        }
        if (isset($request->instagram)) {
            $User->instagram = $request->instagram;
        }
        if (isset($request->pinterest_status)) {
            $User->pinterest_status = $request->pinterest_status;
        }
        if (isset($request->pinterest)) {
            $User->pinterest = $request->pinterest;
        }
        if (isset($request->twitter_status)) {
            $User->twitter_status = $request->twitter_status;
        }
        if (isset($request->twitter)) {
            $User->twitter = $request->twitter;
        }
        if (isset($request->apple_status)) {
            $User->apple_status = $request->apple_status;
        }
        if (isset($request->apple)) {
            $User->apple = $request->apple;
        }

        $User->updated_at = now();
        $User->updated_by = $id;

        $User->save();

        $message = 'User Socials updated, successfully!';

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }



    public function app_improvement(Request $request, $user)
    {

        if (!isset($request->content_text) || empty($request->content_text)) {
            return $this->sendError('Required parameters are missing!');
        }
        $id = $user->id;

        $Model = new AppImprovement();

        $Model->user_id = $id;
        $Model->content_text = $request->content_text;

        $Model->save();


        $message = 'Request Submitted, successfully!';

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }



    public function verifyUpdateOtp(Request $request, $User)
    {
        $proceed = 0;
        if (isset($request->phone) && !empty($request->phone)) {
            $phone = trim($request->phone);
            $type = "phone";
            $proceed = 1;
        } elseif (isset($request->email) && !empty($request->email)) {
            $email = trim($request->email);
            $type = "email";
            $proceed = 1;
        } else {
            return $this->sendError("Missing Parameters");
        }

        if ($proceed) {

            if ($type == "phone") {
                $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $phone)->latest()->first();
            } else {
                $verification = DB::table('verification_codes')->where('user_id', $User->id)->where('sent_to', $email)->latest()->first();
            }

            $code_id = $verification->id;
            $code_found = $verification->code;

            if ($request->code != $code_found) {
                return $this->sendError('Incorrect OTP!');
            }

            DB::table('verification_codes')->where('id', $code_id)->update([
                'verified' => 1,
                'verified_at' => now(),
                'expired' => 1,
                'generated_at' => now(),
                'updated_at' => now()
            ]);

            $User->device_name = $request->device_name ?? null;
            $User->device_id = $request->device_id ?? null;

            if ($type == "phone") {
                $User->phone_verified = 1;
                $User->phone_verified_at = now();
            } else {
                $User->email_verified = 1;
                $User->email_verified_at = now();
            }
            $User->save();

            $array = get_user_array($User);

            $response = [
                'code' => '201',
                'status' => true,
                'message' => 'Verified successfully!',
                'data' => [
                    'user' => $array
                ],
            ];
        }

        return response()->json($response, 200);
    }


    public function uploadPhoto(Request $request, $User)
    {
        if (!$request->hasFile('fileName')) {
            return $this->sendError('Please upload profile image');
        }

        $photo = $User->photo;
        $photo_type = $User->photo_type;

        if (isset($request->fileName) && $request->fileName != null) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'];
            $check = 1; //in_array($extension,$allowedfileExtension);

            if ($check) {
                $file_uploaded = $request->file('fileName');
                $extension = $file_uploaded->getClientOriginalExtension();
                $photo = date('YmdHis') . "." . $extension;
                $photo_type = 0;

                $uploads_path = $this->uploads_path;
                if (!is_dir($uploads_path)) {
                    mkdir($uploads_path);
                    $uploads_root = $this->uploads_root;
                    $src_file = $uploads_root . "/index.html";
                    $dest_file = $uploads_path . "/index.html";
                    copy($src_file, $dest_file);
                }

                $file_uploaded->move($uploads_path, $photo);
            } else {
                return $this->sendError('Invalid image format provided. Please upload image file (jpeg,jpg,png)');
            }
        }

        $User->photo = trim($photo);
        $User->photo_type = $photo_type;

        $User->save();

        $array = get_user_array($User);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'Profile Image uploaded successfully!',
            'data' =>  [
                'user' => $array
            ],
        ];
        return response()->json($response, 200);
    }


    public function locationListing(Request $request, $User)
    {
        $user_id = $User->id;

        $locations =  array();
        $records = AppUserLocation::where('user_id', '=', $user_id)->where('status', '=', 1)->orderBy('is_default', 'DESC')->get();
        foreach ($records as $record) {
            $array = get_user_location_data($record);

            $locations[] = $array;
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Location listing retrieved successfully!',
            'data' => [
                'locations' => $locations
            ]
        ];

        return response()->json($response, 200);
    }

    public function locationDefault(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserLocation::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $records = AppUserLocation::where('user_id', '=', $user_id)->where('status', '=', 1)->get();
            foreach ($records as $record) {
                $record = AppUserLocation::find($record->id);

                $record->is_default = 0;

                $record->save();
            }

            $record = AppUserLocation::find($id);

            $record->is_default = 1;

            $record->save();
        }

        $locations =  array();
        $records = AppUserLocation::where('user_id', '=', $user_id)->where('status', '=', 1)->orderBy('is_default', 'DESC')->get();
        foreach ($records as $record) {
            $array = get_user_location_data($record);

            $locations[] = $array;
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Default Location updated successfully!',
            'data' => [
                'locations' => $locations
            ]
        ];

        return response()->json($response, 200);
    }

    public function locationCreate(Request $request, $User)
    {
        if (!empty($User) && $request->flat != '' && $request->building != '' && $request->address != '' && $request->lat != '' && $request->lng != '') {
            $record = new AppUserLocation();

            $record->user_id = $User->id;

            $nick_name = 'untitled';
            if (isset($request->nick_name))
                $nick_name = trim($request->nick_name);
            $record->nick_name = $nick_name;
            $record->flat = trim($request->flat);
            $record->building = trim($request->building);

            $record->address = trim($request->address);
            $record->lat = trim($request->lat);
            $record->lng = trim($request->lng);

            $record->save();

            if ($record->id > 0) {
                $record = AppUserLocation::find($record->id);

                $array = get_user_location_data($record);

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'User Location created successfully!',
                    'data' => [
                        'location' => $array
                    ]
                ];

                return response()->json($response, 200);
            }
        } else {
            return $this->sendError('Required parameters are missing!');
        }
    }

    public function locationUpdate(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserLocation::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = AppUserLocation::find($id);

            $record->nick_name = trim($request->nick_name) ?? $record->nick_name;
            $record->flat = trim($request->flat);
            $record->building = trim($request->building);

            $record->address = trim($request->address);
            $record->lat = trim($request->lat);
            $record->lng = trim($request->lng);

            $record->save();
        }


        $record = AppUserLocation::find($id);

        $array = get_user_location_data($record);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Location updated successfully!',
            'data' => [
                'location' => $array
            ]
        ];

        return response()->json($response, 200);
    }

    public function locationDelete(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserLocation::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = AppUserLocation::find($id);

            $record->status = 0;

            $record->save();
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Location listing deleted successfully!',
            'data' => null
        ];

        return response()->json($response, 200);
    }



    public function paymentMethodListing(Request $request, $User)
    {
        $user_id = $User->id;

        $methods =  array();
        $records = AppUserPaymentMethod::where('user_id', '=', $user_id)->where('status', '=', 1)->orderBy('is_default', 'DESC')->get();
        foreach ($records as $record) {
            $array = get_user_pm_data($record);

            $methods[] = $array;
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Payment Methods listing retrieved successfully!',
            'data' => [
                'methods' => $methods
            ]
        ];

        return response()->json($response, 200);
    }

    public function paymentMethodDefault(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserPaymentMethod::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $records = AppUserPaymentMethod::where('user_id', '=', $user_id)->where('status', '=', 1)->get();
            foreach ($records as $record) {
                $record = AppUserPaymentMethod::find($record->id);

                $record->is_default = 0;

                $record->save();
            }

            $record = AppUserPaymentMethod::find($id);

            $record->is_default = 1;

            $record->save();
        }

        $methods =  array();
        $records = AppUserPaymentMethod::where('user_id', '=', $user_id)->where('status', '=', 1)->orderBy('is_default', 'DESC')->get();
        foreach ($records as $record) {
            $array = get_user_pm_data($record);

            $methods[] = $array;
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Default Payment Method updated successfully!',
            'data' => [
                'methods' => $methods
            ]
        ];

        return response()->json($response, 200);
    }

    public function paymentMethodCreate(Request $request, $User)
    {
        $proceed = 0;
        $method_id = 0;
        if (isset($request->method_id) && !empty($request->method_id)) {
            $method_id = $request->method_id;
            if ($method_id == 1 && (isset($request->paypal_email) && !empty($request->paypal_email))) {
                $proceed = 1;
            } elseif ($method_id == 2 && (isset($request->card_number) && !empty($request->card_number) && isset($request->card_expiry_month) && !empty($request->card_expiry_month) && isset($request->card_expiry_year) && !empty($request->card_expiry_year) && isset($request->card_civ) && !empty($request->card_civ))) {
                $proceed = 1;
            } else {
                $proceed = 1;
            }
        }

        if ($proceed == 1) {
            $record = new AppUserPaymentMethod();

            $record->user_id = $User->id;
            $record->method_id = $request->method_id;

            $method_id = $request->method_id;
            if ($method_id == 1) {
                $record->paypal_email = $request->paypal_email;
                $record->card_number = '';
                $record->card_expiry_month = '';
                $record->card_expiry_year = '';
                $record->card_civ = '';
            } elseif ($method_id == 2) {
                $record->paypal_email = '';
                $record->card_number = $request->card_number;
                $record->card_expiry_month = $request->card_expiry_month;
                $record->card_expiry_year = $request->card_expiry_year;
                $record->card_civ = $request->card_civ;
            } else {
                $record->paypal_email = '';
                $record->card_number = '';
                $record->card_expiry_month = '';
                $record->card_expiry_year = '';
                $record->card_civ = '';
            }

            $record->save();

            if ($record->id > 0) {
                $record = AppUserPaymentMethod::find($record->id);

                $array = get_user_pm_data($record);

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'User Payment Method created successfully!',
                    'data' => [
                        'method' => $array
                    ]
                ];

                return response()->json($response, 200);
            }
        } else {
            return $this->sendError('Required parameters are missing!');
        }
    }

    public function paymentMethodUpdate(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserPaymentMethod::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = AppUserPaymentMethod::find($id);

            $record->method_id = $request->method_id;

            $record->user_id = $User->id;

            $method_id = $request->method_id;
            if ($method_id == 1) {
                $record->paypal_email = $request->paypal_email;
                $record->card_number = '';
                $record->card_expiry_month = '';
                $record->card_expiry_year = '';
                $record->card_civ = '';
            } elseif ($method_id == 2) {
                $record->paypal_email = '';
                $record->card_number = $request->card_number;
                $record->card_expiry_month = $request->card_expiry_month;
                $record->card_expiry_year = $request->card_expiry_year;
                $record->card_civ = $request->card_civ;
            } else {
                $record->paypal_email = '';
                $record->card_number = '';
                $record->card_expiry_month = '';
                $record->card_expiry_year = '';
                $record->card_civ = '';
            }

            $record->save();
        }


        $record = AppUserPaymentMethod::find($id);

        $array = get_user_pm_data($record);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Payment Method updated successfully!',
            'data' => [
                'method' => $array
            ]
        ];

        return response()->json($response, 200);
    }

    public function paymentMethodDelete(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $exists = 0;
        $records = AppUserPaymentMethod::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = AppUserPaymentMethod::find($id);

            $record->status = 0;

            $record->save();
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Payment Method listing deleted successfully!',
            'data' => null
        ];

        return response()->json($response, 200);
    }




    public function coupons(Request $request, $page, $limit, $User)
    {


        if (isset($request->vendor_id) && $request->vendor_id != '') {
            $vendor_id = $request->vendor_id;

            $skip = (($page - 1) * $limit);

            $count_all = SvcCoupon::where("vendor_id", $vendor_id)->where("status", 1);
            $count_all = $count_all->select('id');
            $count_all = $count_all->count();

            $Records = SvcCoupon::where("vendor_id", $vendor_id)->where("status", 1);
            $Records = $Records->skip($skip);
            $Records = $Records->take($limit);
            $Records = $Records->get();

            $records_data = null;
            $page_count = 0;
            $message  = 'No Record Found.';

            if (!empty($Records)) {
                $records_data =  array();
                foreach ($Records as $model) {
                    $records_data[] = ecom_get_coupons_array($model);
                }
                if (!empty($records_data)) {
                    $page_count = count($records_data);
                    $message  = 'Coupons listing retrieved successfully!';
                }
            }

            $data = array();
            $data['page'] = $page;
            $data['limit'] = $limit;
            $data['vendor_id'] = $vendor_id;
            $data['page_count'] = $page_count;
            $data['total_count'] = $count_all;
            $data['coupons'] = $records_data;

            $response = [
                'code' => '201',
                'status' => true,
                'data' => $data,
                'message' => $message,
            ];
            return response()->json($response, 200);
        } else {
            return $this->sendError('Required parameters are missing!');
        }
    }


    public function check_coupon_validity(Request $request, $User)
    {
        if (isset($request->coupon_code) && $request->coupon_code != '' && isset($request->sub_total) && $request->sub_total != '') {
            $coupon_code = $request->coupon_code;
            $sub_total = $request->sub_total;

            $coupon = SvcCoupon::where("coupon_code", $coupon_code)->first();

            if (!empty($coupon)) {

                $current_time = time();
                //$current_time = strtotime($current_time);
                //return $current_time;
                if (($current_time > $coupon->start_time) && ($current_time < $coupon->end_time)) {

                    if ($sub_total >= $coupon->min_order_value) {

                        $response = [
                            'code' => '201',
                            'status' => true,
                            'message' => 'Coupon is valid !'
                        ];
                        return response()->json($response, 200);
                    } else {
                        return $this->sendError('Order value must be greater than ' . $coupon->min_order_value);
                    }
                } else {
                    return $this->sendError('Coupon is not valid at this time!');
                }
            } else {
                return $this->sendError('Incorrect Coupon Code!');
            }
        } else {
            return $this->sendError('Required parameters are missing!');
        }
    }


    public function notificationListing(Request $request, $User, $page = 1, $limit = 10)
    {

        $skip = (($page - 1) * $limit);

        $user_id = $User->id;

        $count_all = Notification::where('user_id', $user_id)->where('read_status', $request->read_status);
        $count_all = $count_all->select(['id']);
        $count_all = $count_all->count();

        $Records =  Notification::where('user_id', $user_id)->where('read_status', $request->read_status);
        $Records = $Records->orderBy('id', 'desc');
        $Records = $Records->skip($skip);
        $Records = $Records->take($limit);
        $Records = $Records->get();

        $notifications = array();
        $page_count = 0;
        $message  = 'Notifications Listing retrieved successfully.';

        if (!empty($Records)) {
            foreach ($Records as $record) {
                $id    = $record->id;
                $array = notifications_array($record);
                $notifications[] = $array;
            }
            $page_count = ceil($count_all / $limit);
            if ($page_count == 0) {
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
        return response()->json($response, 200);
    }

    public function notificationDetails(Request $request, $User)
    {
        if (isset($request->id)) {
            $user_id = $User->id;

            $Record = Notification::find($request->id);
            if ($Record != null && !empty($Record)) {
                $Response = get_notification_details($Record);

                $Record->read_status = 1;
                $Record->read_time = time();
                $Record->save();

                $message = 'No Record Found.';
                if ($Response != null) {
                    $message = 'Notification Details Successfully retrieved';
                }
                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => $message,
                    'data' => $Response,
                ];

                return response()->json($response, 200);
            }
        }
        return $this->sendError('Please provide Notification id.');
    }

    public function notificationRead(Request $request, $User)
    {
        if (isset($request->ids)) {
            $user_id = $User->id;

            $ids = $request->ids;
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                Notification::where('id', $id)->update(['read_status' => 1, 'read_time' => time()]);
            }
            $message = 'Notification Mark as Read Successfully';
            $response = [
                'code' => '201',
                'status' => true,
                'message' => $message
            ];

            return response()->json($response, 200);
        }

        return $this->sendError('Please provide Notification ids.');
    }


    public function favoriteVendorListing(Request $request, $User, $page = 1, $limit = 10)
    {

        $skip = (($page - 1) * $limit);

        $user_id = $User->id;

        $count_all = SvcVendor::leftjoin('svc_app_user_favorites', 'svc_vendors.id', '=', 'svc_app_user_favorites.vend_id');
        $count_all = $count_all->where(['svc_vendors.status' => 1, 'svc_app_user_favorites.user_id' => $user_id]);
        $count_all = $count_all->select(['svc_vendors.id']);
        $count_all = $count_all->count();

        $Records = SvcVendor::leftjoin('svc_app_user_favorites', 'svc_vendors.id', '=', 'svc_app_user_favorites.vend_id');
        $Records = $Records->where(['svc_vendors.status' => 1, 'svc_app_user_favorites.user_id' => $user_id]);
        $Records = $Records->select(['svc_vendors.id']);
        $Records = $Records->get();

        $favorites = array();
        $page_count = 0;
        $message  = 'All Favorite Listing retrieved successfully.';

        if (!empty($Records)) {
            $favorites = array();
            foreach ($Records as $record) {
                $id    = $record->id;
                $modelData = SvcVendor::find($id);
                $array = common_home($modelData, $this->_token, $this->lat, $this->lng);
                $favorites[] = $array;
            }
            $page_count = count($favorites);
            if ($page_count == 0) {
                $favorites = null;
                $message  = 'No Record Found.';
            }
        }

        $data = array();
        $data['type'] = 'favorite_vendors';
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = $page_count;
        $data['total_count'] = $count_all;
        $data['vendors'] = $favorites;

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, 200);
    }

    public function favoriteVendorAdd(Request $request, $User)
    {
        if (!isset($request->vend_id) || empty($request->vend_id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $vend_id = $request->vend_id;
        $user_id = $User->id;

        $exists = 0;
        $records = SvcAppUserFavorite::where('vend_id', '=', $vend_id)->where('user_id', '=', $user_id)->get();
        foreach ($records as $record) {
            $exists = 1;
        }

        if ($exists == 0) {
            $record = new SvcAppUserFavorite();

            $record->vend_id = $vend_id;
            $record->user_id = $user_id;

            $record->save();

            update_vendor_likes_count($vend_id);
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Favorite listing added successfully!',
            'data' => null
        ];

        return response()->json($response, 200);
    }

    public function favoriteVendorRemove(Request $request, $User)
    {
        if (!isset($request->vend_id) || empty($request->vend_id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $vend_id = $request->vend_id;
        $user_id = $User->id;

        $favorite_id = 0;
        $records = SvcAppUserFavorite::where('vend_id', '=', $vend_id)->where('user_id', '=', $user_id)->get();
        foreach ($records as $record) {
            $favorite_id = $record->id;
        }

        if ($favorite_id > 0) {
            $record = SvcAppUserFavorite::find($favorite_id);
            $record->delete();
            update_vendor_likes_count($vend_id);
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Favorite listing removed successfully!',
            'data' => null
        ];

        return response()->json($response, 200);
    }



    public function reviewListing(Request $request, $User)
    {
        $user_id = $User->id;

        $reviews =  array();
        $records = SvcReview::where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $reviews[] = $this->get_review_array($record);
        }

        if (count($reviews) == 0)
            $reviews = null;

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Reviews listing retrieved successfully!',
            'data' => [
                'reviews' => $reviews
            ]
        ];

        return response()->json($response, 200);
    }

    public function reviewCreate(Request $request, $User)
    {
        if (!empty($User) && $request->vend_id != '' && $request->order_id != '' && $request->rating_option != '' && $request->rating != '' && $request->review != '') {
            $vend_id = $request->vend_id;

            $record = SvcVendor::find($vend_id);
            if (empty($record)) {
                return $this->sendError('Order Details Not found');
            } elseif ($record->status != 1) {
                return $this->sendError('You can not Rate order for this Vendor.');
            }
            $order_id = $request->order_id;


            $record = SvcOrder::find($order_id);
            if (empty($record)) {
                return $this->sendError('Order Details Not found');
            } elseif ($record->status != 9) {
                return $this->sendError('You can not Rate order before order completion.');
            } elseif ($record->is_rated == 1) {
                return $this->sendError('You have already rated this order.');
            }

            $record = new SvcReview();
            $record->user_id = $User->id;
            $record->vend_id = $vend_id;
            $record->order_id = $order_id;
            $record->rating = round($request->rating, 2);
            $record->rating_option = $request->rating_option;
            $record->review = $request->review;
            $record->reviewed_at = time();
            $record->has_badwords = get_review_badwords_status($request->review);
            $record->status = 1;

            $record->save();

            $record_id = $record->id;

            $record = SvcOrder::find($order_id);
            $record->is_rated = 1;
            $record->save();

            update_vendor_reviews_count($vend_id);

            if ($record_id > 0) {
                $record = SvcReview::find($record_id);
                $array = $this->get_review_array($record);

                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => 'User Review submitted successfully!',
                    'data' => [
                        'review' => $array
                    ]
                ];

                return response()->json($response, 200);
            }
        } else {
            return $this->sendError('Required parameters are missing!');
        }
    }

    public function reviewUpdate(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $vend_id = 0;
        $exists = 0;
        $records = SvcReview::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $vend_id = $record->vend_id;
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = SvcReview::find($id);
            $record->rating = round($request->rating, 2);
            $record->review = $request->review;
            $record->reviewed_at = time();
            $record->has_badwords = get_review_badwords_status($request->review);
            $record->save();
        }

        update_vendor_reviews_count($vend_id);


        $record = SvcReview::find($id);

        $array = $this->get_review_array($record);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Review updated successfully!',
            'data' => [
                'review' => $array
            ]
        ];

        return response()->json($response, 200);
    }

    public function reviewDelete(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $vend_id = 0;
        $exists = 0;
        $records = SvcReview::where('id', '=', $id)->where('user_id', '=', $user_id)->where('status', '=', 1)->get();
        foreach ($records as $record) {
            $vend_id = $record->vend_id;
            $exists = 1;
        }

        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            $record = SvcReview::find($id);
            $record->delete();

            $record = SvcOrder::find($order_id);
            $record->is_rated = 0;
            $record->save();

            update_vendor_reviews_count($vend_id);
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Review deleted successfully!',
            'data' => null
        ];

        return response()->json($response, 200);
    }

    public function get_review_array($record)
    {
        $array = array();
        $array['id'] = $record->id;
        $array['order_id'] = $record->order_id;
        $array['rating'] = $record->rating;
        $array['rating_option'] = $record->rating_option;
        $array['review'] = $record->review;

        $vend_id = $record->vend_id;
        $modelData = SvcVendor::find($vend_id);
        $array['vendor'] = common_user($modelData, $this->_token, $this->lat, $this->lng);

        return $array;
    }



    public function orderListing(Request $request, $User, $page = 1, $limit = 10)
    {
        $skip = (($page - 1) * $limit);

        $user_id = $User->id;

        $req_status = '';
        $status_array = array();
        if (isset($request->status)) {
            $req_status = $request->status;
            $req_array = strtolower($req_status);
            $req_array = explode(',', $req_array);
            foreach ($req_array as $status) {

                if ($status == 'waiting') {
                    $status_array[] = 1;
                } elseif ($status == 'canceled') {
                    $status_array[] = 2;
                } elseif ($status == 'confirmed') {
                    $status_array[] = 3;
                } elseif ($status == 'declined') {
                    $status_array[] = 4;
                } elseif ($status == 'accepted') {
                    $status_array[] = 5;
                } elseif ($status == 'team Left') {
                    $status_array[] = 6;
                } elseif ($status == 'team Reached') {
                    $status_array[] = 7;
                } elseif ($status == 'service Delivered') {
                    $status_array[] = 8;
                } elseif ($status == 'completed') {
                    $status_array[] = 9;
                }
            }
        }

        $type_array = array();
        if (isset($request->type) && $request->type != "") {
            if ($request->type == "history") {
                $type_array[] = 2;
                $type_array[] = 4;
                $type_array[] = 8;
                $type_array[] = 9;
            } elseif ($request->type == "live") {
                $type_array[] = 1;
                $type_array[] = 3;
                $type_array[] = 5;
                $type_array[] = 6;
                $type_array[] = 7;
            }
        }

        $count_all = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id');
        $count_all = $count_all->where(['svc_orders.user_id' => $user_id, 'svc_vendors.status' => 1]);
        if (count($status_array) > 0) {
            $count_all = $count_all->whereIn('svc_orders.status', $status_array); //where('orders.status', '=', $status);
        }
        if (count($type_array) > 0) {
            $count_all = $count_all->whereIn('svc_orders.status', $type_array); //where('orders.status', '=', $status);
        }
        $count_all = $count_all->select(['svc_orders.id']);
        $count_all = $count_all->count();




        $Records = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id');
        $Records = $Records->where(['svc_orders.user_id' => $user_id, 'svc_vendors.status' => 1]);
        if (count($status_array) > 0) {
            $Records = $Records->whereIn('svc_orders.status', $status_array); //where('orders.status', '=', $status);
        }
        if (count($type_array) > 0) {
            $Records = $Records->whereIn('svc_orders.status', $type_array); //where('orders.status', '=', $status);
        }
        $Records = $Records->select(['svc_orders.id']);
        $Records = $Records->orderBy('svc_orders.id', 'DESC');
        $Records = $Records->skip($skip);
        $Records = $Records->take($limit);
        $Records = $Records->get();

        $orders = null;
        $message  = 'No Record Found.';

        if (!empty($Records)) {
            $array_data = array();
            foreach ($Records as $Record) {
                $order_id = $Record->id;
                $array_data[] = get_order_data($order_id);
            }
            if (!empty($array_data)) {
                $orders = $array_data;
                $message  = 'All User Orders Listing retrieved successfully.';
            }
        }

        $data = array();
        $data = array();
        $data['status'] = $req_status;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_count'] = count($Records);
        $data['total_count'] = $count_all;
        $data['data'] = $orders;

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, 200);
    }

    public function orderDetails(Request $request, $User)
    {
        $bool = 0;
        if (isset($request->order_id)) {
            $user_id = $User->id;

            $order_id = trim($request->order_id);

            $Record = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id');
            $Record = $Record->where(['svc_orders.id' => $order_id, 'svc_orders.user_id' => $user_id, 'svc_vendors.status' => 1]);
            $Record = $Record->select(['svc_orders.id']);
            $Record = $Record->get();
            if ($Record != null && !empty($Record)) {
                $bool = 1;
                $Response = get_order_data($order_id);

                $message = 'Order Not Found. Please try valid order details';
                if ($Response != null) {
                    $message = 'Order Details Successfully retrieved';
                }
                $response = [
                    'code' => '201',
                    'status' => true,
                    'message' => $message,
                    'data' => $Response,
                ];

                return response()->json($response, 200);
            }
        }
        return $this->sendError('Please provide order details.');
    }

    public function order_check($request, $User)
    {
        $user_id = $User->id;

        $total = 0;
        if (isset($request->total))
            $total = $request->total;


        $array = array();
        $array['total'] = $total;



        $vend_id = 0;
        if (isset($request->vendor_id))
            $vend_id = $request->vendor_id;



        // Vat Inclusion
        {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }
        $data = array();

        $data['total'] = (int) $total;
        $data['vat_include_%'] = (int) $vat_include;
        $data['vat_value'] = (int) $vat_value;
        $data['final_value'] = (int) $final_value;

        $array['discount'] = 0;



        $array['claimable'] = 0;
        $reward_array = array();
        $reward = Reward::where('status', 1)->first();
        if (!empty($reward)) {
            $user_reward = RewardUser::where('user_id', $User->id)->first();

            if ($reward->has_limitations == 1 && $user_reward->created_at >= $reward->activated_at && $user_reward->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                $end = Carbon::parse($user_reward->created_at);
                $current = Carbon::now();
                $days_since_first_order = $end->diffInDays($current);

                $in = $reward->intervals - $days_since_first_order;
                $reward_array['expiry_message'] = "You can use this house in " . $in . " days";
            } elseif ($user_rewards->has_limitations == 2 && $user_reward->created_at >= $reward->activated_at && $user_reward->created_at <= date('Y-m-d H:i:s', $reward->end_date)) {
                $reward_array['message'] = "You can use this house till " . date('m-d-Y', $user_reward->end_date);
            } else {
                RewardUser::where('user_id', $USer->id)->delete();
            }


            if ($user_reward->punch_count >= $reward->platinum_punches) {
                $array['claimable'] = 1;
                if ($array['claimable'] == 1) {

                    if ($reward->platinum_fixed_value != null) {
                        $array['discount'] = $reward->platinum_fixed_value;
                        $reward_array['reward_type'] = "Platinum House";
                        $reward_array['reward_discount_type'] = "fixed value";
                        $reward_array['platinum_fixed_value'] = $reward->platinum_fixed_value;
                    } elseif ($reward->platinum_discount_percentage != null) {
                        $array['discount'] = ($total * $reward->platinum_discount_percentage) / 100;
                        $reward_array['reward_type'] = "Platinum House";
                        $reward_array['reward_discount_type'] = "discount percentage";
                        $reward_array['platinum_discount_percentage'] = $reward->platinum_discount_percentage;
                    }

                    /*
                    if ($reward->has_limitations == 1 && $user_reward->created_at >= $reward->activated_at && $user_reward->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                        $end = Carbon::parse($user_reward->created_at);
                        $current = Carbon::now();
                        $days_since_first_order = $end->diffInDays($current);

                        $in = $reward->intervals - $days_since_first_order;
                        $reward_array['message'] = "You can use this platinum house in " . $in . " days";
                    } elseif ($user_rewards->has_limitations == 2) {
                        $reward_array['message'] = "You can use this Platinum house till " . date('m-d-Y', $user_reward->end_date);
                    }
                    */
                }
            } elseif ($user_reward->punch_count >= $reward->golden_punches) {
                $array['claimable'] = 1;
                if ($array['claimable'] == 1) {
                    if ($reward->golden_fixed_value != null) {
                        $array['discount'] = $reward->golden_fixed_value;
                        $reward_array['reward_type'] = "Golden House";
                        $reward_array['reward_discount_type'] = "fixed value";
                        $reward_array['golden_fixed_value'] = $reward->golden_fixed_value;
                        $total = $total - $reward->golden_fixed_value;
                    } elseif ($reward->golden_discount_percentage != null) {
                        $array['discount'] = ($total * $reward->golden_discount_percentage) / 100;
                        $reward_array['reward_type'] = "Golden house";
                        $reward_array['reward_discount_type'] = "Golden discount percentage";
                        $reward_array['golden_discount_percentage'] = $reward->golden_discount_percentage;
                        $total = $total - $reward->golden_fixed_value;
                    }

                    /*
                    if ($reward->has_limitations == 1) {
                        $end = Carbon::parse($user_reward->created_at);
                        $current = Carbon::now();
                        $days_since_first_order = $end->diffInDays($current);

                        $in = $reward->intervals - $days_since_first_order;
                        $reward_array['expiry_message'] = "You can use this Golden house in " . $in . " days";
                    } elseif ($user_rewards->has_limitations == 2) {
                        $reward_array['message'] = "You can use this Golden house till " . date('m-d-Y', $user_reward->end_date);
                    }
                    */
                }
            } elseif ($user_reward->punch_count >= $reward->silver_punches) {
                $array['claimable'] = 1;
                if ($array['claimable'] == 1) {
                    if ($reward->silver_fixed_value != null) {
                        $array['discount'] = $reward->silver_fixed_value;
                        $reward_array['reward_type'] = "Silver House";
                        $reward_array['reward_discount_type'] = "fixed value";
                        $reward_array['silver_fixed_value'] = $reward->silver_fixed_value;
                    } elseif ($reward->silver_discount_percentage != null) {
                        $array['discount'] = ($total * $reward->silver_discount_percentage) / 100;
                        $reward_array['reward_type'] = "Silver House";
                        $reward_array['reward_discount_type'] = "discount percentage";
                        $reward_array['silver_discount_percentage'] = $reward->silver_discount_percentage;
                    }
                }
            }
        }

        if ($array['discount'] > $total) {
            $array['claimable'] = 0;
        }
        $array['reward_details'] = $reward_array;
        // if($array['claimable'] == 1)
        // $array['final_value'] = $total - $reward_array['platinum_fixed_value'];
        // else 
        // $array['final_value'] = ($total + $data['vat_value']);




        $coupon_code = 0;
        $coupon_discount_value = 0;
        $vendor_id = $request->vendor_id;




        if (isset($request->coupon_code)) {
            $coupon_code = $request->coupon_code;
        }

        $message = 'Order Checked Successfully';

        if ($coupon_code != 0) {


            $coupon = SvcCoupon::where("coupon_code", $coupon_code)->where("vendor_id", $vendor_id)->where('status', 1)->first();

            if (!empty($coupon)) {
                $current_time = time();
                if (($current_time > $coupon->start_time) && ($current_time < $coupon->end_time)) {

                    if ($total >= $coupon->min_order_value) {

                        $coupon_discount_value = $coupon->max_discount_value;

                        $message = 'Order Checked Successfully and Discount also applied!';
                    } else {
                        $message = 'To get coupon discount from this vendor, order value must be greater than ' . $coupon->min_order_value;
                    }
                } else {
                    $message = 'Provided coupon is not available at this time';
                }
            } else {
                $message = "Wrong Coupon Code provided!";
            }
        }






        // $array = array();
        $sub_total = $total;
        if ($coupon_discount_value <= $sub_total)
            $total -= $coupon_discount_value;




        //$array['total'] = $total;






        // Vat Inclusion
        {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }
        $coupon_arrray = array();

        $coupon_arrray['sub_total'] = $sub_total;
        $coupon_arrray['coupon_discount'] = (int) $coupon_discount_value;
        $coupon_arrray['total'] = (int) $total;
        $coupon_arrray['vat_include_%'] = (int) $vat_include;
        $coupon_arrray['vat_value'] = (int) $vat_value;
        $coupon_arrray['final_value'] = (int) $final_value; {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * ($request->total - $array['discount']));
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($request->total - $array['discount'] + $vat_value);
        }


        $array['vat_include_%'] = (int) $vat_include;
        $array['vat_value'] = (int) $vat_value;
        $array['final_value'] = $final_value;

        $c_array = array();
        $c_array['simple_order_check'] = $data;

        $c_array['with_reward_order_check'] = $array;

        if ($request->coupon_code != 0 && $request->coupon_code != null && $coupon_discount_value > 0) {
            $c_array['with_coupon_order_check'] = $coupon_arrray;
        }
        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $c_array

        ];

        return response()->json($response, 200);
    }


    public function order_check_with_reward($request, $User)
    {
        $user_id = $User->id;


        $total = 0;
        if (isset($request->total))
            $total = $request->total;




        $array = array();
        //$sub_total = $total;
        //$total -= $coupon_discount_value;




        $array['total'] = $total;



        $vend_id = 0;
        if (isset($request->vendor_id))
            $vend_id = $request->vendor_id;



        // Vat Inclusion
        {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }


        $array['discount'] = 0;



        $array['claimable'] = 0;
        $reward_array = array();
        $reward = Reward::where('status', 1)->first();
        if (!empty($reward)) {
            $user_reward = RewardUser::where('user_id', $User->id)->first();
            if (!empty($user_reward)) {
                if ($user_reward->punch_count >= $reward->platinum_punches) {
                    $array['claimable'] = 1;
                    if ($array['claimable'] == 1) {

                        if ($reward->platinum_fixed_value != null) {
                            $array['discount'] = $reward->platinum_fixed_value;
                            $reward_array['reward_type'] = "Platinum House";
                            $reward_array['reward_discount_type'] = "fixed value";
                            $reward_array['platinum_fixed_value'] = $reward->platinum_fixed_value;
                            $total = $total - $reward->platinum_fixed_value;
                        } elseif ($reward->platinum_discount_percentage != null) {
                            $array['discount'] = $reward->platinum_discount_percentage;
                            $reward_array['reward_type'] = "Platinum House";
                            $reward_array['reward_discount_type'] = "discount percentage";
                            $reward_array['platinum_discount_percentage'] = $reward->platinum_discount_percentage;
                            $total = $total - $reward->platinum_discount_percentage;
                        }

                        if ($reward->has_limitations == 1 && $user_reward->created_at >= $reward->activated_at && $user_reward->created_at <= date('Y-m-d H:i:s', (strtotime($reward->activated_at) + ($reward->intervals * 24 * 60 * 60)))) {
                            $end = Carbon::parse($user_reward->created_at);
                            $current = Carbon::now();
                            $days_since_first_order = $end->diffInDays($current);

                            $in = $reward->intervals - $days_since_first_order;
                            $reward_array['message'] = "You can use this platinum house in " . $in . " days";
                        } elseif ($user_rewards->has_limitations == 2) {
                            $reward_array['message'] = "You can use this Platinum house till " . date('m-d-Y', $user_reward->end_date);
                        }
                    }
                } elseif ($user_reward->punch_count >= $reward->golden_punches) {
                    $array['claimable'] = 1;
                    if ($array['claimable'] == 1) {
                        if ($reward->golden_fixed_value != null) {
                            $array['discount'] = $reward->golden_fixed_value;
                            $reward_array['reward_type'] = "Golden House";
                            $reward_array['reward_discount_type'] = "fixed value";
                            $reward_array['golden_fixed_value'] = $reward->golden_fixed_value;
                            $total = $total - $reward->golden_fixed_value;
                        } elseif ($reward->golden_discount_percentage != null) {
                            $array['discount'] = $reward->golden_discount_percentage;
                            $reward_array['reward_type'] = "Golden discount percentage";
                            $reward_array['golden_discount_percentage'] = $reward->golden_discount_percentage;
                            $total = $total - $reward->golden_discount_percentage;
                        }

                        if ($reward->has_limitations == 1 && $user_reward->created_at >= $reward->activated_at) {
                            $end = Carbon::parse($user_reward->created_at);
                            $current = Carbon::now();
                            $days_since_first_order = $end->diffInDays($current);

                            $in = $reward->intervals - $days_since_first_order;
                            $reward_array['expiry_message'] = "You can use this Golden house in " . $in . " days";
                        } elseif ($user_rewards->has_limitations == 2) {
                            $reward_array['message'] = "You can use this Golden house till " . date('m-d-Y', $user_reward->end_date);
                        }
                    }
                } elseif ($user_reward->punch_count >= $reward->silver_punches) {
                    $array['claimable'] = 1;
                    if ($array['claimable'] == 1) {
                        if ($reward->silver_fixed_value != null) {
                            $array['discount'] = $reward->silver_fixed_value;
                            $reward_array['reward_type'] = "Silver House";
                            $reward_array['reward_discount_type'] = "fixed value";
                            $reward_array['silver_fixed_value'] = $reward->silver_fixed_value;
                            $total = $total - $reward->silver_fixed_value;
                        } elseif ($reward->silver_discount_percentage != null) {
                            $array['discount'] = $reward->silver_discount_percentage;
                            $reward_array['reward_type'] = "Silver House";
                            $reward_array['reward_discount_type'] = "discount percentage";
                            $reward_array['silver_discount_percentage'] = $reward->silver_discount_percentage;
                            $total = $total - $reward->silver_discount_percentage;
                        }
                    }
                }
            }
        }
        $array['reward_details'] = $reward_array;
        // if($array['claimable'] == 1)
        // $array['final_value'] = $total - $reward_array['platinum_fixed_value'];
        // else 
        // $array['final_value'] = ($total + $data['vat_value']);




        {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }



        $array['vat_include_%'] = (int) $vat_include;
        $array['vat_value'] = (int) $vat_value;
        $array['final_value'] = $final_value;

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'Order Checked Successfully',
            'data' => $array

        ];

        return response()->json($response, 200);
    }

    public function order_check_with_coupon($request, $User)
    {
        $user_id = $User->id;



        $coupon_code = 0;
        $coupon_discount_value = 0;
        $vendor_id = $request->vendor_id;

        $total = 0;
        if (isset($request->total))
            $total = $request->total;


        if (isset($request->coupon_code)) {
            $coupon_code = $request->coupon_code;
        }

        $message = "";

        if ($coupon_code != 0) {


            $coupon = SvcCoupon::where("coupon_code", $coupon_code)->where("vendor_id", $vendor_id)->first();

            if (!empty($coupon)) {
                $current_time = time();
                if (($current_time > $coupon->start_time) && ($current_time < $coupon->end_time)) {

                    if ($total >= $coupon->min_order_value) {

                        $coupon_discount_value = $coupon->max_discount_value;

                        $message = 'Discount also applied!';
                    } else {
                        $message = 'To get coupon discount from this vendor, order value must be greater than ' . $coupon->min_order_value;
                    }
                } else {
                    $message = 'Provided coupon is not available at this time';
                }
            } else {
                $message = "Wrong Coupon Code provided!";
            }
        }






        // $array = array();
        $sub_total = $total;
        $total -= $coupon_discount_value;




        //$array['total'] = $total;



        $vend_id = 0;
        if (isset($request->vendor_id))
            $vend_id = $request->vendor_id;



        // Vat Inclusion
        {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }
        $data = array();

        $data['sub_total'] = $sub_total;
        $data['coupon_discount'] = (int) $coupon_discount_value;
        $data['total'] = (int) $total;
        $data['vat_include_%'] = (int) $vat_include;
        $data['vat_value'] = (int) $vat_value;
        $data['final_value'] = (int) $final_value; {
            $vat_exists = 0;
            $vat_include = 0;
            $vat_value = 0;
            $vat_details = get_vendor_bank_details_for_orders($vend_id);
            if ($vat_details != null && !empty($vat_details)) {
                $vat_exists = 1;
                $vat_include = $vat_details['vat_percentage'];
                if ($vat_include > 0) {
                    $vat_include = 0;
                } else {
                    $vat_include = 1;
                }
            }
            if ($vat_exists == 0 || $vat_include == 1) {
                $vat_include = get_vat_value();
            }

            if ($vat_include > 0) {
                $vat_value = (($vat_include / 100) * $total);
                $vat_value = round($vat_value, 2);
            }

            $final_value = ($total + $vat_value);
        }





        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $data

        ];

        return response()->json($response, 200);
    }



    public function save_order($request, $User, $claim_reward)
    {
        $user_id = $User->id;

        $loc_id = 0;
        if (isset($request->loc_id))
            $loc_id = $request->loc_id;

        $drop_off_loc_id = 0;
        if (isset($request->drop_off_loc_id))
            $drop_off_loc_id = $request->drop_off_loc_id;

        $date_time_drop_off = 0;
        if (isset($request->date_time_drop_off))
            $date_time_drop_off = strtotime($request->date_time_drop_off);

        $cat_id = 0;
        if (isset($request->cat_id))
            $cat_id = $request->cat_id;

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $cat_price = 0;
        if (isset($request->cat_price))
            $cat_price = $request->cat_price;

        $sub_cat_price = 0;
        if (isset($request->sub_cat_price))
            $sub_cat_price = $request->sub_cat_price;

        $vend_id = 0;
        if (isset($request->vendor_id))
            $vend_id = $request->vendor_id;

        $type = 0;
        if (isset($request->type))
            $type = $request->type;

        // random for testing, when adjusted in APIs then assign 0
        // $total = 0; //rand(500, 1000);
        // if (isset($request->total))
        //     $total = $request->total;


        $total = 0;
        foreach ($request->details as $detail) {
            // Check if sub_service_id is present, fetch price accordingly
            if (!empty($detail['sub_service_id'])) {
                $vendorService = SvcVendorService::where('vend_id', $vend_id)
                    ->where('service_id', $detail['service_id'])
                    ->where('sub_service_id', $detail['sub_service_id'])
                    ->first();
            } else {
                $vendorService = SvcVendorService::where('vend_id', $vend_id)
                ->where('service_id', $detail['service_id'])->first();
            }
            $price = $vendorService?->price ?? 0; // Default to 0 if no price found


            // Calculate total item count
            // $item_count = $detail['small_items'] + $detail['medium_items'] + $detail['large_items'];
            // $sub_total = $price * $item_count;
            // Add attribute prices (if any)
            if (!empty($detail['attributes'])) {
                foreach ($detail['attributes'] as $attribute) {
                    // $sub_total += $attribute['price'] * $attribute['quantity'];
                    $price += $attribute['price'] * $attribute['quantity'];
                }
            }
            $total += $price;
        }

        $order_ids = '0';
        if ($vend_id != 0 && $vend_id != '' && !empty($vend_id)) {
            $vend_ids = explode(',', $vend_id);
            foreach ($vend_ids as $vend_id) {
                $notes = trim($request->notes);

                $has_files = 0;
                if (isset($request->images))
                    $has_files = 1;

                $order = new SvcOrder();
                $order->user_id = $user_id;
                $order->loc_id = $loc_id;
                $order->drop_off_loc_id = $drop_off_loc_id;
                $order->date_time_drop_off = $date_time_drop_off;
                $order->cat_id = $cat_id;
                $order->sub_cat_id = $sub_cat_id;
                $order->cat_price = $cat_price;
                $order->sub_cat_price = $sub_cat_price;
                $order->vend_id = $vend_id;
                $order->order_value = $total;
                $order->discount = 0;
                $order->total = 0;
                // Vat Inclusion
                {
                    $vat_exists = 0;
                    $vat_include = 0;
                    $vat_value = 0;
                    $final_value = 0;

                    if ($type == 0) {
                        $vat_details = get_vendor_bank_details_for_orders($vend_id);
                        if ($vat_details != null && !empty($vat_details)) {
                            $vat_exists = 1;
                            $vat_include = $vat_details['vat_percentage'];
                            if ($vat_include > 0) {
                                $vat_include = 0;
                            } else {
                                $vat_include = 1;
                            }
                        }
                        if ($vat_exists == 0 || $vat_include == 1) {
                            $vat_include = get_vat_value();
                        }

                        if ($vat_include > 0) {
                            $vat_value = (($vat_include / 100) * $total);
                            $vat_value = round($vat_value, 2);
                        }

                        $final_value = ($total + $vat_value);
                    }
                }

                $order->vat_included = $vat_include;
                $order->vat_value = $vat_value;
                $order->final_value = $final_value;


                $order->type = $type;

                $order->notes = $notes;
                $order->has_files = $has_files;


                $has_attributes = 0;
                $attributes_array = array();
                $values_array = array();
                $prices_array = array();

                if (($cat_id == 8 && (isset($request->need_pickup) && $request->need_pickup == 1)) || ((isset($request->additional_cost) && $request->additional_cost == 1))) {

                    $attributes = SvcVendorCategory::where('cat_id', $cat_id)->where('vend_id', $vend_id)->first();

                    if ($attributes != null && $attributes->attributes != null) {

                        $has_attributes = 1;

                        $attributes = $attributes->attributes;

                        $attributes = json_decode($attributes);


                        $prices_array = $attributes->prices;
                        $values_array = $attributes->values;
                    }
                }


                if ($cat_id == 5 || $cat_id == 7 || ((isset($request->need_material) && $request->need_material == 1) || (isset($request->need_ironing) && $request->need_ironing == 1) || (isset($request->covid) && $request->covid == 1))) {


                    $attributes = SvcVendorSubCategory::where('sub_cat_id', $sub_cat_id)->where('vend_id', $vend_id)->first();

                    if ($attributes != null && $attributes->attributes != null) {

                        $has_attributes = 1;

                        $attributes = $attributes->attributes;

                        $attributes = json_decode($attributes);


                        $prices_array = $attributes->prices;
                        $values_array = $attributes->values;
                    }
                }


                if ((isset($request->need_material) && $request->need_material == 1)) {

                    $order->need_material = $request->need_material;

                    $order->material_notes = $request->material_notes;

                    $index = array_search('Cleaning Material Charges', $values_array);

                    $cleaning_material = array();

                    $cleaning_material['name'] =  'Cleaning Material Charges';
                    $cleaning_material['price'] =  $prices_array[$index];
                    $cleaning_material['quantity'] = 1;

                    $attributes_array[] = $cleaning_material;
                }


                if (isset($request->need_ironing) && $request->need_ironing == 1) {

                    $order->need_ironing = $request->need_ironing;

                    $index = array_search('Ironing Charges', $values_array);

                    $ironing = array();

                    $ironing['name'] =  'Ironing Charges';
                    $ironing['price'] =  $prices_array[$index];
                    $ironing['quantity'] = 1;

                    $attributes_array[] = $ironing;
                }



                if (isset($request->covid) && $request->covid == 1) {

                    $order->covid = $request->covid;

                    $index = array_search('Covid Charges', $values_array);

                    $covid = array();

                    $covid['name'] =  'Covid Charges';
                    $covid['price'] =  $prices_array[$index];
                    $covid['quantity'] = 1;

                    $attributes_array[] = $covid;
                }


                if (isset($request->need_pickup) && $request->need_pickup == 1) {

                    $order->need_pickup = $request->need_pickup;

                    $index = array_search('Pickup Charges', $values_array);

                    $pickup['name'] =  'Pickup Charges';
                    $pickup['price'] =  $prices_array[$index];
                    $pickup['quantity'] = 1;

                    $attributes_array[] = $pickup;
                }


                if ($cat_id == 5 || $cat_id == 7) {

                    $index = array_search('Callout Price', $values_array);

                    $callout = array();

                    $callout['name'] =  'Callout Price';
                    $callout['price'] =  $prices_array[$index];
                    $callout['quantity'] = 1;

                    $attributes_array[] = $callout;
                }

                if (isset($request->additional_cost) && $request->additional_cost == 1) {

                    $order->additional_cost = $request->additional_cost;

                    $index = array_search('Additional Price', $values_array);

                    $additional = array();

                    $additional['name'] =  'Additional Price';
                    $additional['price'] =  $prices_array[$index];
                    $additional['quantity'] = 1;

                    $attributes_array[] = $additional;
                }

                if (isset($request->is_ladder) && $request->is_ladder == 1) {
                    $order->is_ladder = $request->is_ladder;
                    $order->ladder_length = $request->ladder_length;
                }

                if (isset($request->cleaners))
                    $order->cleaners = $request->cleaners;

                if (isset($request->date_time))
                    $order->date_time = strtotime($request->date_time);

                if (isset($request->current_wall_color))
                    $order->current_wall_color = $request->current_wall_color;

                if (isset($request->new_wall_color))
                    $order->new_wall_color = $request->new_wall_color;

                if (isset($request->add_white_color_cost))
                    $order->add_white_color_cost = $request->add_white_color_cost;

                if (isset($request->need_ceilings_painted))
                    $order->need_ceilings_painted = $request->need_ceilings_painted;

                if (isset($request->provide_paint))
                    $order->provide_paint = $request->provide_paint;

                if (isset($request->paint_code))
                    $order->paint_code = $request->paint_code;

                if (isset($request->rooms))
                    $order->rooms = $request->rooms;

                if (isset($request->type))
                    $order->type = $request->type;

                if (isset($request->sender_name))
                    $order->sender_name = $request->sender_name;

                if (isset($request->receiver_name))
                    $order->receiver_name = $request->receiver_name;

                if (isset($request->message))
                    $order->message = $request->message; {
                    $brand_id = 0; // this id is brand_option_id
                    if (isset($request->brand))
                        $brand_id = get_brand_id_by_name_and_sub_category($sub_cat_id, $request->brand);
                    elseif (isset($request->brand_id))
                        $brand_id = $request->brand_id;

                    if ($brand_id != 0)
                        $order->brand_id = $brand_id;
                } {
                    if (empty($attributes_array)) {
                        $attributes_array = null;
                    } else {
                        $attributes_array = json_encode($attributes_array);
                    }

                    $order->has_attributes = $has_attributes;
                    $order->attributes = $attributes_array;
                }



                $order->save();





                //reward code

                $reward_id = 0;
                $discount = 0;
                $fixed_value = 0;
                $discount_percentage = 0;

                $discount_value = 0;

                $silver_house = 0;
                $golden_house = 0;
                $platinum_house = 0;

                if ($claim_reward == 1) {
                    $Reward = Reward::where('status', 1)->first();
                    if (!empty($Reward)) {

                        $reward_user_check = RewardUser::where('user_id', $user_id)->first();

                        $reward = Reward::where('status', 1)->first();

                        $availble = 0;
                        if (!empty($reward_user_check)) {
                            if ($Reward->has_limitations == 1) {

                                $check = RewardUser::select('punch_count')->where('user_id', '=', $user_id)->where('created_at', '>=', date('Y-m-d H:i:s', ((strtotime($Reward->created_at)) * (24 * 60 * 60))))->first();
                                if (!empty($check)) {
                                    $availble = 1;
                                }
                            } elseif ($Reward->has_limitations == 2) {

                                $check = RewardUser::select('punch_count')->where('user_id', '=', $user_id)->where('created_at', '>=', date('Y-m-d H:i:s', $Reward->end_date))->get();
                                if (!empty($check)) {
                                    $availble = 1;
                                }
                            }

                            if ($reward_user_check->punch_count > $Reward->platinum_punches && $availble == 1) {

                                if ($reward->platinum_fixed_value != null) {
                                    $discount =  $reward->platinum_fixed_value;
                                }
                                if ($reward->platinum_discount_percentage != null) {
                                    $discount = $reward->platinum_discount_percentage;
                                    $discount = (($total * $reward->platinum_discount_percentage / 100));
                                }

                                //  $discount = $reward->discount_percentage;
                                if ($total > $discount) {
                                    $reward_user_check->punch_count -= $Reward->platinum_punches;
                                }
                                $reward_user_check->save();
                            } elseif ($reward_user_check->punch_count > $Reward->golden_punches && $availble == 1) {

                                if ($reward->golden_fixed_value != null) {
                                    $discount = $reward->golden_fixed_value;
                                }
                                if ($reward->golden_discount_percentage != null) {
                                    $discount = ($total * $reward->golden_discount_percentage / 100);
                                }
                                //  $discount = $reward->discount_percentage;

                                $reward_user_check->punch_count -= $Reward->golden_punches;
                                $reward_user_check->save();
                            } elseif ($reward_user_check->punch_count > $reward->silver_punches && $availble == 1) {

                                if ($reward->silver_fixed_value != null) {
                                    $discount = $reward->silver_fixed_value;
                                }
                                if ($reward->silver_discount_percentage != null) {
                                    $discount = ($total * $reward->golden_discount_percentage / 100);
                                }
                                //  $discount = $reward->discount_percentage;
                                $reward_user_check->punch_count -= $Reward->silver_punches;
                                $reward_user_check->save();
                            }
                        }
                    }
                } else {
                    $rewards = Reward::where('status', 1)->first();
                    if (!empty($rewards)) {
                        if ($total >= $rewards->min_order_value) {
                            $reward_user_check = RewardUser::where('user_id', $user_id)->first();
                            if (!$reward_user_check) {
                                $reward_user = new RewardUser();
                                $reward_user->reward_id = $rewards->id;
                                // $reward_user->vendor_id = $vend_id;
                                $reward_user->user_id = $user_id;
                                $reward_user->punch_count = 1;
                                $reward_user->save();
                            } else {
                                $reward_user = RewardUser::where('user_id', $user_id)->first();
                                $reward_user->punch_count += 1;
                                $reward_user->save();
                            }
                        }
                    }
                }

                $coupon_code = $request->coupon_code;
                $coupon_discount_value = 0;

                $message = "";

                if ($coupon_code != 0) {


                    $coupon = SvcCoupon::where("coupon_code", $coupon_code)->where("vendor_id", $vend_id)->where('status', 1)->first();

                    if (!empty($coupon)) {
                        $current_time = time();
                        if (($current_time > $coupon->start_time) && ($current_time < $coupon->end_time)) {

                            if ($total >= $coupon->min_order_value) {

                                $coupon_discount_value = $coupon->max_discount_value;

                                $message = 'Discount also applied!';
                            } else {
                                $message = 'To get coupon discount from this vendor, order value must be greater than ' . $coupon->min_order_value;
                            }
                        } else {
                            $message = 'Provided coupon is not available at this time';
                        }
                    } else {
                        $message = "Wrong Coupon Code provided!";
                    }
                }

                $total -= $coupon_discount_value;

                // Vat Inclusion
                {
                    $vat_exists = 0;
                    $vat_include = 0;
                    $vat_value = 0;
                    $final_value = 0;

                    if ($type == 0) {
                        $vat_details = get_vendor_bank_details_for_orders($vend_id);
                        if ($vat_details != null && !empty($vat_details)) {
                            $vat_exists = 1;
                            $vat_include = $vat_details['vat_percentage'];
                            if ($vat_include > 0) {
                                $vat_include = 0;
                            } else {
                                $vat_include = 1;
                            }
                        }
                        if ($vat_exists == 0 || $vat_include == 1) {
                            $vat_include = get_vat_value();
                        }

                        if ($vat_include > 0) {
                            $vat_value = (($vat_include / 100) * $total);
                            $vat_value = round($vat_value, 2);
                        }

                        $final_value = ($total + $vat_value);
                    }
                }

                // $order->vat_included = $vat_include;
                //$order->vat_value = $vat_value;
                //$order->final_value = $final_value;



                /////////

                $order_id = $order->id;
                $order_ids .= ',' . $order_id;

                $day = sprintf('%02d', date('d', time()));
                $month = sprintf('%02d', date('m', time()));
                $year = date('y', time());
                $code = sprintf("%04u", $order_id);
                $order_no = $year . "" . $month . "" . $day . "-" . $code;

                $order_update = SvcOrder::find($order_id);
                $order_update->order_no = $order_no;

                // $order_update->total = $total - $silver_house;
                // $order_update->total = $total - $golden_house;
                $order_update->total = ($total);

                if ($total > $discount) {

                    $order_update->discount = $discount;
                    $order_update->total = ($total - $discount);
                    $order_update->final_value -= $discount;
                }


                $order_update->vat_included = $vat_include;
                $order_update->vat_value = $vat_value;

                if ($coupon_discount_value != 0) {

                    $order_update->coupon_applied = 1;
                    $order_update->coupon_discount = $coupon_discount_value;
                    $order_update->final_value = $final_value;
                }
                $order_update->save();




                //  $vendor_rewards = Reward::where('vendor_id', $vend_id)->first();

                //  $order_count = SvcOrder::where('user_id', $user_id)->get();
                //  if($order_count->count() > $vendor_rewards->min_no_of_punches)
                //  {
                //     $history = RewardHistory::where('vendor_id', $vend_id)->get();

                //     if($history -> count() == 0)
                //     {
                //         $newHistory = new RewardHistory;
                //         $newHistory->claimable = 1;
                //         $newHistory->claimed = 0;				
                //         $newHistory->user_id = $user_id;
                //         $newHistory->vendor_id = $vend_id;
                //         $newHistory->reward_id = $vendor_rewards->id;
                //         $newHistory->save();

                //     }


                //     $rewardUser = RewardUser::where('user_id', $user_id)->get();

                //     if($rewardUser->count() == 0)
                //     {
                //         $newRewardUser = new RewardUser;
                //         $newRewardUser->reward_id = $Reward->id;
                //         $newRewardUser->user_id = $user_id;

                //         $newRewardUser->no_of_orders = 0;

                //         $newRewardUser->save();



                //     }
                // }




                //  $no_of_orders = RewardUser::where('user_id', $user_id)->first();

                // foreach($no_of_orders as $inc)
                /* {
                    $no_of_orders->no_of_orders ++;
                    

                    
                        $reward_history = RewardHistory::where('user_id', $user_id)->where('vendor_id', $vend_id)->where('reward_id',29)->first();
                        
                        
                            $reward_history->orders_count_for_silver_house ++;
                            $reward_history->orders_count_for_golden_house ++;
                            $reward_history->orders_count_for_platinum_house ++;
                            $reward_history->save();
                        
                        
                        
                        
                      //  $no_of_orders->no_of_orders = $no_of_orders->no_of_orders - $Reward->min_no_of_punches;
                   // }
                    $no_of_orders->save();
                    
                */


                //Creating Notifications
                {

                    if ($type == 0) {

                        //For App Notification
                        create_app_user_notification('Booking Created', $user_id, 'sod', 'order', $order_id);

                        //To Send SMS
                        send_email_or_sms_notification(1, 1, 1, $user_id, $order_no);

                        //To Send Email
                        send_email_or_sms_notification(2, 1, 1, $user_id, $order_no);

                        //To Send Vendor Notification
                        $notfication_message = 'Booking Created Against Order No. ' . $order_no;
                        backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
                    } elseif ($type == 1) {

                        $order_update = SvcOrder::find($order_id);
                        $order_update->status = 3;
                        $order_update->save();


                        //For App Notification
                        create_app_user_notification('Quote Requested', $user_id, 'sod', 'order', $order_id);

                        //To Send SMS
                        send_email_or_sms_notification(1, 2, 3, $user_id, $order_no);

                        //To Send Email
                        send_email_or_sms_notification(2, 2, 3, $user_id, $order_no);

                        //To Send Vendor Notification
                        $notfication_message = 'Quote Requested Against Order No. ' . $order_no;
                        backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
                    }
                }



                if (isset($request->images)) {
                    $images = $request->images;
                    $i = 0;
                    foreach ($images as $image) {
                        $i++;
                        //$allowedfileExtension=['jpeg','jpg','png','JPEG','JPG','PNG'];
                        $check = 1; //in_array($extension,$allowedfileExtension);

                        if ($check) {
                            /*$file_uploaded = $image;//$request->file('fileName');
								$extension = $file_uploaded->getClientOriginalExtension();
								$photo = date('YmdHis').".".$extension;
								$photo_type = 0;*/

                            $uploads_path = $this->uploads_orders_path;
                            if (!is_dir($uploads_path)) {
                                mkdir($uploads_path);
                                $uploads_root = $this->uploads_root;
                                $src_file = $uploads_root . "/index.html";
                                $dest_file = $uploads_path . "/index.html";
                                copy($src_file, $dest_file);
                            }

                            $uploads_path = $uploads_path . '/' . $order_id;
                            if (!is_dir($uploads_path)) {
                                mkdir($uploads_path);
                                $uploads_root = $this->uploads_root;
                                $src_file = $uploads_root . "/index.html";
                                $dest_file = $uploads_path . "/index.html";
                                copy($src_file, $dest_file);
                            }

                            /*$file_uploaded->move($uploads_path, $photo);*/
                            $image_parts = explode(";base64,", $image);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            $extension = 'png';
                            if ($image_type == 'jpeg')
                                $extension = 'jpeg';
                            elseif ($image_type == 'JPEG')
                                $extension = 'JPEG';
                            elseif ($image_type == 'jpg')
                                $extension = 'jpg';
                            elseif ($image_type == 'JPG')
                                $extension = 'JPG';
                            elseif ($image_type == 'png')
                                $extension = 'png';
                            elseif ($image_type == 'PNG')
                                $extension = 'PNG';
                            $photo = date('YmdHis') . "$i." . $extension;
                            $image_base64 = base64_decode($image_parts[1]);
                            $file = $uploads_path . '/' . $photo;
                            file_put_contents($file, $image_base64);


                            $order = new SvcOrderFile();
                            $order->order_id = $order_id;
                            $order->image = $photo;
                            $order->save();
                        }
                    }
                }
            }
        }

        return $order_ids;
    }



    public function category_1_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $claim_reward = 1;
        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity']; {
                            //$date_time = strtotime($detail['date_time']);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->quantity = $quantity;

                            $order_detail->service_price = $service_price;
                            //$order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_2_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $product_id = 0;
                        if (isset($detail['product_id']))
                            $product_id = $detail['product_id'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $product_price = 0;
                        if (isset($detail['product_price']))
                            $product_price = $detail['product_price'];

                        $price = get_product_price($product_id, $vend_id);
                        if ($price != null) {
                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->product_id = $product_id;
                            $order_detail->quantity = $quantity;
                            $order_detail->product_price = $product_price;

                            $order_detail->price = $price;

                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_3_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {


                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $covid = 0;
                        if (isset($detail['covid']))
                            $covid = $detail['covid'];

                        $cleaners = 0;
                        if (isset($detail['cleaners']))
                            $cleaners = $detail['cleaners'];

                        $need_material = 0;
                        if (isset($detail['need_material']))
                            $need_material = $detail['need_material'];

                        $material_notes = 0;
                        if (isset($detail['material_notes']))
                            $material_notes = $detail['material_notes'];

                        $need_ironing = 0;
                        if (isset($detail['need_ironing']))
                            $need_ironing = $detail['need_ironing'];

                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time']; {
                            $date_time = strtotime($date_time);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->service_price = $service_price;
                            $order_detail->sub_service_price = $sub_service_price;

                            $order_detail->quantity = $quantity;
                            $order_detail->covid = $covid;
                            $order_detail->cleaners = $cleaners;
                            $order_detail->need_material = $need_material;
                            $order_detail->material_notes = $material_notes;
                            $order_detail->need_ironing = $need_ironing;

                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        /*$array = get_order_data($order_id);*/

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_4_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $device_name = 0;
                        if (isset($detail['device_name']))
                            $device_name = $detail['device_name'];

                        //$price = get_service_price($service_id, $vend_id);
                        //if($price != null)
                        {
                            $date_time = strtotime($detail['date_time']);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->quantity = $quantity;

                            $order_detail->device_name = $device_name;

                            //$order_detail->price = $price;
                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_5_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $brand_id = 0; // this id is brand_option_id
                        if (isset($detail['brand']))
                            $brand_id = get_brand_id_by_name_and_service($service_id, $detail['brand']);
                        elseif (isset($detail['brand_id']))
                            $brand_id = $detail['brand_id'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $is_ladder = 0;
                        if (isset($detail['is_ladder']))
                            $is_ladder = $detail['is_ladder'];

                        $ladder_length = 0;
                        if (isset($detail['ladder_length']))
                            $ladder_length = $detail['ladder_length'];


                        /// painting

                        $home_type_id = 0;
                        if (isset($detail['home_type_id']))
                            $home_type_id = $detail['home_type_id'];

                        $bed_rooms = 0;
                        if (isset($detail['bed_rooms']))
                            $bed_rooms = $detail['bed_rooms'];

                        $living_rooms = 0;
                        if (isset($detail['living_rooms']))
                            $living_rooms = $detail['living_rooms'];

                        $dining_rooms = 0;
                        if (isset($detail['dining_rooms']))
                            $dining_rooms = $detail['dining_rooms'];

                        $maid_rooms = 0;
                        if (isset($detail['maid_rooms']))
                            $maid_rooms = $detail['maid_rooms'];

                        $storage_rooms = 0;
                        if (isset($detail['storage_rooms']))
                            $storage_rooms = $detail['storage_rooms'];

                        $current_wall_color = 0;
                        if (isset($detail['current_wall_color']))
                            $current_wall_color = $detail['current_wall_color'];

                        $required_wall_color = 0;
                        if (isset($detail['required_wall_color']))
                            $required_wall_color = $detail['required_wall_color'];

                        $is_ceileing_color = 0;
                        if (isset($detail['is_ceileing_color']))
                            $is_ceileing_color = $detail['is_ceileing_color'];

                        $ceileing_color = 0;
                        if (isset($detail['ceileing_color']))
                            $ceileing_color = $detail['ceileing_color'];

                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time']; {
                            $date_time = strtotime($date_time);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->service_price = $service_price;
                            $order_detail->sub_service_price = $sub_service_price;

                            $order_detail->brand_id = $brand_id;

                            $order_detail->quantity = $quantity;

                            $order_detail->is_ladder = $is_ladder;
                            $order_detail->ladder_length = $ladder_length;

                            $order_detail->home_type_id = $home_type_id;
                            $order_detail->bed_rooms = $bed_rooms;
                            $order_detail->living_rooms = $living_rooms;
                            $order_detail->dining_rooms = $dining_rooms;
                            $order_detail->maid_rooms = $maid_rooms;
                            $order_detail->storage_rooms = $storage_rooms;
                            $order_detail->current_wall_color = $current_wall_color;
                            $order_detail->required_wall_color = $required_wall_color;
                            $order_detail->is_ceileing_color = $is_ceileing_color;
                            $order_detail->ceileing_color = $ceileing_color;

                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        $array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            'data' => [
                'order' => $array
            ]
        ];

        return response()->json($response, 200);
    }

    public function category_6_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];


                        //$date_time = strtotime($detail['date_time']);

                        {
                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->quantity = $quantity;

                            $order_detail->service_price = $service_price;
                            //$order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_7_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $home_type_id = 0;
                        if (isset($detail['home_type_id']))
                            $home_type_id = $detail['home_type_id'];

                        $bed_rooms = 0;
                        if (isset($detail['bed_rooms']))
                            $bed_rooms = $detail['bed_rooms'];

                        $living_rooms = 0;
                        if (isset($detail['living_rooms']))
                            $living_rooms = $detail['living_rooms'];

                        $dining_rooms = 0;
                        if (isset($detail['dining_rooms']))
                            $dining_rooms = $detail['dining_rooms'];

                        $maid_rooms = 0;
                        if (isset($detail['maid_rooms']))
                            $maid_rooms = $detail['maid_rooms'];

                        $storage_rooms = 0;
                        if (isset($detail['storage_rooms']))
                            $storage_rooms = $detail['storage_rooms'];

                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time']; {

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->service_price = $service_price;
                            $order_detail->sub_service_price = $sub_service_price;
                            $order_detail->quantity = $quantity;

                            $order_detail->home_type_id = $home_type_id;
                            $order_detail->bed_rooms = $bed_rooms;
                            $order_detail->living_rooms = $living_rooms;
                            $order_detail->dining_rooms = $dining_rooms;
                            $order_detail->maid_rooms = $maid_rooms;
                            $order_detail->storage_rooms = $storage_rooms;

                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_8_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $pet_size = 0;
                        if (isset($detail['pet_size']))
                            $pet_size = $detail['pet_size'];

                        $need_pickup = 0;
                        if (isset($detail['need_pickup']))
                            $need_pickup = $detail['need_pickup'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time']; {
                            $date_time = strtotime($date_time);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->sub_service_price = $sub_service_price;
                            $order_detail->quantity = $quantity;

                            $order_detail->pet_size = $pet_size;
                            $order_detail->need_pickup = $need_pickup;

                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_9_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $has_attributes = 0;
                        // get attributes
                        {
                            if ((isset($detail['bed_rooms'])) || (isset($detail['living_rooms'])) || (isset($detail['dining_rooms'])) || (isset($detail['maid_rooms'])) || (isset($detail['storage_rooms'])) || (isset($detail['garage_or_garden']))) {
                                $attributes = SvcVendorService::where('service_id', $service_id)->where('sub_service_id', $sub_service_id)->first();
                                if ($attributes != null && $attributes->attributes != null) {
                                    $has_attributes = 1;
                                    $attributes = $attributes->attributes;
                                    $attributes = json_decode($attributes);

                                    $prices_array = $attributes->prices;
                                    $values_array = $attributes->values;
                                }
                            }
                        }


                        //to save details and sub details
                        {
                            $date_time = strtotime($date_time);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->service_price = $service_price;
                            $order_detail->sub_service_price = $sub_service_price;
                            $order_detail->quantity = $quantity;

                            $order_detail->date_time = $date_time;

                            // save attributes
                            {
                                if ((isset($detail['bed_rooms']))) {

                                    $order_detail->bed_rooms = $detail['bed_rooms'];

                                    $index = array_search('Bedroom Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Bedroom Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['bed_rooms'];

                                    $attributes_array[] = $cleaning_material;
                                }
                                if ((isset($detail['living_rooms']))) {

                                    $order_detail->living_rooms = $detail['living_rooms'];

                                    $index = array_search('Living Room Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Living Room Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['living_rooms'];

                                    $attributes_array[] = $cleaning_material;
                                }
                                if ((isset($detail['dining_rooms']))) {

                                    $order_detail->dining_rooms = $detail['dining_rooms'];

                                    $index = array_search('Dinning Room Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Dinning Room Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['dining_rooms'];

                                    $attributes_array[] = $cleaning_material;
                                }
                                if ((isset($detail['maid_rooms']))) {

                                    $order_detail->maid_rooms = $detail['maid_rooms'];

                                    $index = array_search('Maid Room Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Maid Room Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['maid_rooms'];

                                    $attributes_array[] = $cleaning_material;
                                }
                                if ((isset($detail['storage_rooms']))) {

                                    $order_detail->storage_rooms = $detail['storage_rooms'];

                                    $index = array_search('Storage Room Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Storage Room Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['storage_rooms'];

                                    $attributes_array[] = $cleaning_material;
                                }
                                if ((isset($detail['garage_or_garden']))) {

                                    $order_detail->garage_or_garden = $detail['garage_or_garden'];

                                    $index = array_search('Garage or Garden Price', $values_array);

                                    $cleaning_material = array();

                                    $cleaning_material['name'] =  'Garage or Garden Price';
                                    $cleaning_material['price'] =  $prices_array[$index];
                                    $cleaning_material['quantity'] = $detail['garage_or_garden'];

                                    $attributes_array[] = $cleaning_material;
                                }
                            }


                            if (empty($attributes_array)) {
                                $attributes_array = null;
                            } else {
                                $attributes_array = json_encode($attributes_array);
                            }

                            $order_detail->has_attributes = $has_attributes;
                            $order_detail->attributes = $attributes_array;
                            $order_detail->save();

                            $detail_id = $order_detail->id;
                            if (isset($detail["sub_details"])) {
                                $sub_details = $detail["sub_details"];
                                foreach ($sub_details as $sub_detail) {

                                    $item_id = 0;
                                    if (isset($sub_detail['item_id']))
                                        $item_id = $sub_detail['item_id'];

                                    $quantity = 1;
                                    if (isset($sub_detail['quantity']))
                                        $quantity = $sub_detail['quantity'];


                                    $price = 0;
                                    if (isset($sub_detail['price']))
                                        $price = $sub_detail['price'];
                                    //                                    echo $sub_detail['item_id'];
                                    //                                    exit;

                                    $order_sub_detail = new SvcOrderSubDetail();
                                    $order_sub_detail->detail_id = $detail_id;
                                    $order_sub_detail->item_id = $item_id;
                                    $order_sub_detail->quantity = $quantity;
                                    $order_sub_detail->price = $price;
                                    $order_sub_detail->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_10_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $home_type_id = 0;
                        if (isset($detail['home_type_id']))
                            $home_type_id = $detail['home_type_id'];

                        $bed_rooms = 0;
                        if (isset($detail['bed_rooms']))
                            $bed_rooms = $detail['bed_rooms'];

                        $living_rooms = 0;
                        if (isset($detail['living_rooms']))
                            $living_rooms = $detail['living_rooms'];

                        $dining_rooms = 0;
                        if (isset($detail['dining_rooms']))
                            $dining_rooms = $detail['dining_rooms'];

                        $maid_rooms = 0;
                        if (isset($detail['maid_rooms']))
                            $maid_rooms = $detail['maid_rooms'];

                        $storage_rooms = 0;
                        if (isset($detail['storage_rooms']))
                            $storage_rooms = $detail['storage_rooms'];

                        //$price = get_service_price($service_id, $vend_id);
                        //if($price != null)
                        {
                            $date_time = strtotime($detail['date_time']);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->quantity = $quantity;

                            $order_detail->home_type_id = $home_type_id;
                            $order_detail->bed_rooms = $bed_rooms;
                            $order_detail->living_rooms = $living_rooms;
                            $order_detail->dining_rooms = $dining_rooms;
                            $order_detail->maid_rooms = $maid_rooms;
                            $order_detail->storage_rooms = $storage_rooms;

                            //$order_detail->price = $price;
                            $order_detail->date_time = $date_time;
                            $order_detail->save();

                            $detail_id = $order_detail->id;
                            if (isset($request->sub_details)) {
                                $sub_details = $request->sub_details;
                                foreach ($sub_details as $sub_detail) {

                                    $item_id = 0;
                                    if (isset($sub_detail['item_id']))
                                        $item_id = $sub_detail['item_id'];

                                    $quantity = 0;
                                    if (isset($sub_detail['quantity']))
                                        $quantity = $sub_detail['quantity'];

                                    $price = 0;
                                    if (isset($sub_detail['price']))
                                        $price = $sub_detail['price'];

                                    $order_sub_detail = new SvcOrderSubDetail();
                                    $order_sub_detail->detail_id = $detail_id;
                                    $order_sub_detail->item_id = $item_id;
                                    $order_sub_detail->quantity = $quantity;
                                    $order_sub_detail->price = $price;
                                    $order_detail->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_11_orders($request, $User, $claim_reward)
    {
        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $sub_cat_id = 0;
        if (isset($request->sub_cat_id))
            $sub_cat_id = $request->sub_cat_id;

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $sub_service_id = 0;
                        if (isset($detail['sub_service_id']))
                            $sub_service_id = $detail['sub_service_id'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];


                        $date_time = 0;
                        if (isset($detail['date_time']))
                            $date_time = $detail['date_time']; {
                            $date_time = strtotime($date_time);

                            $order_detail = new SvcOrderDetail();
                            $order_detail->order_id = $order_id;
                            $order_detail->sub_cat_id = $sub_cat_id;
                            $order_detail->service_id = $service_id;
                            $order_detail->sub_service_id = $sub_service_id;
                            $order_detail->service_price = $service_price;
                            $order_detail->sub_service_price = $sub_service_price;
                            $order_detail->quantity = $quantity;

                            $order_detail->date_time = $date_time;
                            $order_detail->save();
                        }
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }

    public function category_12_orders($request, $User, $claim_reward)
    {
        $user_id = $User->id;

        $vend_id = $request->vendor_id;
        $vend_ids = explode(',', $vend_id);

        $order_ids = $this->save_order($request, $User, $claim_reward);
        $orders_count = 0;
        if ($order_ids != '0' || $order_ids != 0) {
            $order_ids = explode(',', $order_ids);
            foreach ($order_ids as $order_id) {
                if ($order_id != 0) {
                    $vend_id = $vend_ids[$orders_count];
                    $orders_count++;

                    $details = $request->details;
                    foreach ($details as $detail) {
                        $sub_cat_id = 0;
                        if (isset($detail['sub_cat_id']))
                            $sub_cat_id = $detail['sub_cat_id'];

                        $service_id = 0;
                        if (isset($detail['service_id']))
                            $service_id = $detail['service_id'];

                        $quantity = 1;
                        if (isset($detail['quantity']))
                            $quantity = $detail['quantity'];

                        $service_price = 0;
                        if (isset($detail['service_price']))
                            $service_price = $detail['service_price'];

                        $sub_service_price = 0;
                        if (isset($detail['sub_service_price']))
                            $sub_service_price = $detail['sub_service_price'];


                        $order_detail = new SvcOrderDetail();
                        $order_detail->order_id = $order_id;
                        $order_detail->sub_cat_id = $sub_cat_id;
                        $order_detail->service_id = $service_id;
                        $order_detail->quantity = $quantity;
                        $order_detail->service_price = $service_price;
                        $order_detail->sub_service_price = $sub_service_price;


                        $order_detail->save();
                    }
                }
            }
        }

        //$array = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Order created successfully!',
            /*'data' => [
                    'order' => $array
                ]*/
        ];

        return response()->json($response, 200);
    }



    public function orderCancel(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $cancel = 1;
        $exists = 0;

        $Records = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id');
        $Records = $Records->where(['svc_orders.id' => $id, 'svc_orders.user_id' => $user_id]);
        $Records = $Records->select(['svc_orders.status', 'svc_orders.type']);
        $Records = $Records->get();
        foreach ($Records as $record) {
            $exists = 1;
            $status = $record->status;
            if ($record->type == 0) {
                if ($status != 1 && $status != 3) {
                    $cancel = 0;
                }
            } else {
                echo "Yes";
                if ($status != 7) {
                    $cancel = 0;
                }
            }
        }

        $Response = null;
        $message = 'User Order canceled successfully.';
        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            if ($cancel == 1) {
                $record = SvcOrder::find($id);

                $order_id = $id;
                $order_no = $record->order_no;
                $vend_id = $record->vend_id;

                if ($record->type == 0) {
                    $record->status = 2;
                } else {
                    $record->status = 9;
                }
                $record->cancelled_time = time();
                $record->save();

                //Creating Notifications
                {

                    if ($record->type == 0) {

                        //For App Notification
                        create_app_user_notification('Booking Cancelled', $user_id, 'sod', 'order', $order_id);

                        //To Send SMS
                        send_email_or_sms_notification(1, 1, 2, $user_id, $order_no);

                        //To Send Email
                        send_email_or_sms_notification(2, 1, 2, $user_id, $order_no);

                        //To Send Vendor Notification
                        $notfication_message = 'Booking Cancelled Against Order No. ' . $order_no;
                        backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
                    } else {

                        //For App Notification
                        create_app_user_notification('Quotation Rejected', $user_id, 'sod', 'order', $order_id);

                        //To Send SMS
                        send_email_or_sms_notification(1, 2, 9, $user_id, $order_no);

                        //To Send Email
                        send_email_or_sms_notification(2, 2, 9, $user_id, $order_no);

                        //To Send Vendor Notification
                        $notfication_message = 'Quotation Rejected Against Order No. ' . $order_no;
                        backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
                    }
                }
            } else {
                $message = 'Order can not be canceled.';
            }

            $Response = get_order_data($id);
        }
        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $Response
        ];

        return response()->json($response, 200);
    }

    public function orderComplete(Request $request, $User)
    {
        if (!isset($request->id) || empty($request->id)) {
            return $this->sendError('Required parameters are missing!');
        }

        $id = $request->id;
        $user_id = $User->id;

        $complete = 1;
        $exists = 0;

        $Records = SvcOrder::leftjoin('svc_vendors', 'svc_orders.vend_id', '=', 'svc_vendors.id');
        $Records = $Records->where(['svc_orders.id' => $id, 'svc_orders.user_id' => $user_id, 'svc_vendors.status' => 1]);
        $Records = $Records->select(['svc_orders.status']);
        $Records = $Records->get();
        foreach ($Records as $record) {
            $exists = 1;
            $status = $record->status;
            if ($status != 8) {
                $complete = 0;
            }
        }

        $Response = null;
        $message = 'User Order Completed successfully.';
        if ($exists == 0) {
            return $this->sendError('Record Not Found!');
        } else {
            if ($complete == 1) {
                $record = SvcOrder::find($id);

                $record->status = 9;
                $record->cancelled_time = time();
                $record->save();

                $order_id = $record->id;
                $order_no = $record->order_no;
                $vend_id = $record->vend_id;
                $user_id = $record->user_id;

                //Creating Notifications
                {

                    //For App Notification
                    create_app_user_notification('Booking Completed', $user_id, 'sod', 'order', $order_id);

                    //To Send SMS
                    send_email_or_sms_notification(1, 1, 9, $user_id, $order_no);

                    //To Send Email
                    send_email_or_sms_notification(2, 1, 9, $user_id, $order_no);

                    //To Send Vendor Notification
                    $notfication_message = 'Booking Completed Against Order No. ' . $order_no;
                    backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
                }
            } else {
                $message = 'Order can not be Completed.';
            }

            $Response = get_order_data($id);
        }
        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $Response
        ];

        return response()->json($response, 200);
    }

    public function orderConfirm(Request $request, $User)
    {
        if ((!isset($request->order_id) || empty($request->order_id)) &&  (!isset($request->transaction_id) || empty($request->transaction_id)) &&  (!isset($request->card_number) || empty($request->card_number)) &&  (!isset($request->card_brand) || empty($request->card_brand)) &&  (!isset($request->card_type) || empty($request->card_type)) &&  (!isset($request->transaction_date_time) || empty($request->transaction_date_time)) &&  (!isset($request->nick_name) || empty($request->nick_name)) &&  (!isset($request->amount) || empty($request->amount))) {
            return $this->sendError('Required parameters are missing!');
        }

        $order_id = $request->order_id;

        $order = SvcOrder::find($order_id);

        if (empty($order)) {
            return $this->sendError('Order Not Found');
        } else {
            if ($order->type == 0) {
                if ($order->status != 1) {
                    return $this->sendError('Order Cannot be Confirmed.');
                }
            } else {
                if ($order->status != 7) {
                    return $this->sendError('Order Cannot be Confirmed.');
                }
            }
        }

        $user_id = $User->id;

        $transaction_id = $request->transaction_id;
        $card_number = $request->card_number;
        $card_brand = $request->card_brand;
        $card_type = $request->card_type;
        $transaction_date_time = strtotime($request->transaction_date_time);
        $nick_name = $request->nick_name;
        $amount = $request->amount;

        // Transaction Create
        {
            $transaction = new SvcTransaction();

            $transaction->order_id = $order_id;
            $transaction->user_id = $user_id;
            $transaction->transaction_id = $transaction_id;
            $transaction->card_number = $card_number;
            $transaction->card_brand = $card_brand;
            $transaction->card_type = $card_type;
            $transaction->transaction_date_time = $transaction_date_time;
            $transaction->nick_name = $nick_name;
            $transaction->amount = $amount;

            $transaction->save();
        }


        $record = SvcOrder::find($order_id);

        $order_no = $record->order_no;
        $vend_id = $record->vend_id;

        //Creating Notifications
        {
            if ($order->type == 0) {

                //For App Notification
                create_app_user_notification('Booking Confirmed', $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, 1, 3, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, 1, 3, $user_id, $order_no);

                //To Send Vendor Notification
                $notfication_message = 'Booking Confirmed Against Order No. ' . $order_no;
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
            } else {

                //For App Notification
                create_app_user_notification('Quotation Accepted', $user_id, 'sod', 'order', $order_id);

                //To Send SMS
                send_email_or_sms_notification(1, 2, 8, $user_id, $order_no);

                //To Send Email
                send_email_or_sms_notification(2, 2, 8, $user_id, $order_no);

                //To Send Vendor Notification
                $notfication_message = 'Quotation Accepted Against Order No. ' . $order_no;
                backend_notification($notfication_message, $user_id, $vend_id, 'sod', 'order', $order_id);
            }
        }


        $id = $transaction->id;

        // Order Update
        {
            if ($order->type == 0) {
                $order->status = 3;
            } else {
                $order->status = 8;
            }

            $order->transaction_id = $id;
            $order->save();
        }

        $message = 'Order Confirmed Successfully.';

        $Response = get_order_data($order_id);

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $Response
        ];

        return response()->json($response, 200);
    }

    public function reOrderData(Request $request, $User)
    {
        $user_id = $User->id;

        $order_id = 0;
        if (isset($request->order_id)) {
            $order_id = $request->order_id;
        }

        $Record = SvcOrder::leftjoin('restaurants', 'svc_orders.rest_id', '=', 'restaurants.id');
        $Record = $Record->where(['svc_orders.id' => $order_id, 'svc_orders.user_id' => $user_id, 'svc_orders.status' => 4, 'restaurants.status' => 1]);
        $Record = $Record->select(['svc_orders.id']);
        $Record = $Record->get();

        $order = null;
        $message  = 'No Record Found.';

        if (!empty($Record)) {
            $Record = SvcOrder::find($order_id);
            $rest_id = $Record->rest_id;

            $message  = 'Order Details for reOrder retrieved successfully.';
            $order = array();

            $pickup = array(); {
                $pickup_option = $Record->pickup_option;
                if ($pickup_option == 1) {
                    $pickup_option = 'car';
                } else {
                    $pickup_option = 'people';
                }
                $pickup['option'] = $pickup_option;

                $pickup_option = $Record->pickup_option;
                $pickup_option_id = $Record->pickup_option_id;
                $car_details = null;
                $people_details = null;
                if ($pickup_option == 1) {
                    $car_details = array();

                    $pickup_option = 'car';
                    $car = AppUserCar::find($pickup_option_id);

                    $car_details['id'] = $car->id;

                    $brand_id = $car->brand_id;
                    $brand = CarBrand::find($brand_id); {
                        $details['id'] = $brand->id;
                        $details['name'] = $brand->name;
                        $image = $brand->image;

                        $image_path = 'car_brands/';
                        if ($image == 'brand.png') {
                            $image_path = 'defaults/';
                        }
                        $image_path .= $image;
                        $image_path = uploads($image_path);
                        $details['image'] = $image_path;
                    }
                    $car_details['brand'] = $details;

                    $details = array();
                    $type_id = $car->type_id;
                    $type = CarType::find($type_id); {
                        $details['id'] = $type->id;
                        $details['name'] = $type->name;
                        $image = $type->image;

                        $image_path = 'car_types/';
                        if ($image == 'type.png') {
                            $image_path = 'defaults/';
                        }
                        $image_path .= $image;
                        $image_path = uploads($image_path);
                        $details['image'] = $image_path;
                    }
                    $car_details['type'] = $details;

                    $details = array();
                    $color_id = $car->color_id;
                    $color = CarColor::find($color_id); {
                        $details['id'] = $color->id;
                        $details['name'] = $color->name;
                        $details['value'] = $color->value;
                    }
                    $car_details['color'] = $details;

                    $car_details['plate_no'] = $car->plate_no;
                } else {
                    $people_details = array();

                    $people = AppUserPeople::find($pickup_option_id);

                    $people_details['id'] = $people->id;
                    $people_details['name'] = $people->name;
                    $people_details['phone'] = $people->phone;
                    $image = $people->image;
                    $image_path = 'app_user_people/';
                    if ($image == 'people.png') {
                        $image_path = 'defaults/';
                    }
                    $image_path .= $image;
                    $image_path = uploads($image_path);
                    $people_details['image'] = $image_path;
                }
                $pickup['car'] = $car_details;
                $pickup['people'] = $people_details;
            }
            $order['pickup'] = $pickup;

            $payment = array(); {
                $pay_details = null;

                $pay_method = $Record->pay_method;
                if ($pay_method == 'user_options') {
                    $pay_details = array();
                    $user_method = $Record->pay_method_id;

                    $pay_details['id'] = $user_method;
                    $user_method = AppUserPaymentMethod::find($user_method);

                    $method_id = $user_method->method_id;

                    $method_details = array();
                    $method = PaymentMethod::find($method_id); {
                        $method_details['id'] = $method->id;
                        $method_details['name'] = $method->name;
                        $image = $method->image;

                        $image_path = 'payment_methods/';
                        if ($image == 'method.png') {
                            $image_path = 'defaults/';
                        }
                        $image_path .= $image;
                        $image_path = uploads($image_path);
                        $method_details['image'] = $image_path;
                    }
                    $pay_details['method'] = $method_details;

                    $pay_details['paypal_email'] = $user_method->paypal_email;
                    $pay_details['card_number'] = $user_method->card_number;
                    $pay_details['card_expiry_month'] = $user_method->card_expiry_month;
                    $pay_details['card_expiry_year'] = $user_method->card_expiry_year;
                    $pay_details['card_civ'] = $user_method->card_civ;
                }

                $payment['pay_method'] = $pay_method;
                $payment['details'] = $pay_details;
            }
            $order['payment'] = $payment;

            $items = array(); {
                $order_details = SvcOrderDetail::where('order_id', '=', $order_id)->get();
                foreach ($order_details as $details) {
                    $detail_id = $details->id;
                    $item_id = $details->item_id;

                    $item_details = Items::where('id', '=', $item_id)->where('status', '=', 1)->get();
                    foreach ($item_details as $item_detail) {

                        $array = array();

                        $array['item'] = get_items_detail_for_order($item_id);
                        $array['quantity'] = $details->quantity;

                        $prices = get_items_prices_for_orders($item_id);

                        $item_value = (float)$prices['price'];
                        $discount = (float)$prices['discount'];
                        $discount_type = $prices['discount_type'];
                        if ($discount_type == 0) {
                            $discount_value = (($discount / 100) * $item_value);
                            $discount_value = round($discount_value, 2);
                        } else {
                            $discount_value = $discount;
                        }

                        $total_value = ($item_value - $discount_value);
                        $total_value = round($total_value, 2);


                        $array['item_value'] = $item_value;
                        $array['discount'] = $discount_value;
                        $array['total_value'] = $total_value;

                        $addons = array(); {
                            $order_sub_details = SvcOrderSubDetail::where('detail_id', '=', $detail_id)->get();
                            foreach ($order_sub_details as $sub_details) {
                                $addon_id = $sub_details->addon_id;

                                $sub_array = array();
                                $sub_array['addon'] = get_addon_detail_for_order($addon_id);
                                $prices = get_addon_prices_for_orders($addon_id);
                                $sub_array['total_value'] = $prices['price'];

                                $addons[] = $sub_array;
                            }
                        }
                        $array['addons'] = $addons;

                        $items[] = $array;
                    }
                }
            }
            $order['items'] = $items; {
                $modelData = Restaurant::find($rest_id);
                $order['restaurant'] = common_home($modelData, $this->_token, $this->lat, $this->lng);
            }
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => $message,
            'data' => $order,
        ];
        return response()->json($response, 200);
    }



    public function querySubmit(Request $request)
    {
        if ((!isset($request->name) || empty($request->name)) || (!isset($request->email) || empty($request->email)) || (!isset($request->subject) || empty($request->subject)) || (!isset($request->description) || empty($request->description))) {
            return $this->sendError('Required parameters are missing!');
        } {
            $record = new AppUserQuery();

            $record->name = $request->name;
            $record->email = $request->email;
            $record->subject = $request->subject;
            $record->description = $request->description;
            $record->status = 0;

            $record->save();
        }

        $response = [
            'code' => '201',
            'status' => true,
            'message' => 'User Query submitted successfully!'
        ];

        return response()->json($response, 200);
    }

    public function get_user_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['phone'] = $record->phone;
        $array['name'] = $record->name;
        $array['email'] = $record->email;
        $array['username'] = $record->username;
        $array['date_of_birth'] = $record->date_of_birth;
        $array['device_name'] = $record->device_name;
        $array['device_id'] = $record->device_id;

        if ($record->photo == "app_user.jpg") {
            $array['photo'] = uploads("/defaults/" . $record->photo);
        } else {
            $array['photo'] = uploads($this->uploads_path . "/" . $record->photo);
        }


        $array['interested_in'] = $record->interested_in;

        return $array;
    }

    public function get_user_setting_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['user_id'] = $record->user_id;
        $array['country'] = $record->country;
        $array['currency'] = $record->currency;
        $array['language'] = $record->language;
        $array['discount_sales'] = $record->discount_sales;
        $array['discount_sales_preference'] = $record->discount_sales_preference;
        $array['new_stuff'] = $record->new_stuff;
        $array['new_stuff_preference'] = $record->new_stuff_preference;
        $array['new_collections'] = $record->new_collections;
        $array['new_collections_preference'] = $record->new_collections_preference;
        $array['stock'] = $record->stock;
        $array['stock_preference'] = $record->stock_preference;
        $array['updates'] = $record->updates;
        $array['updates_preference'] = $record->updates_preference;
        $array['dark_mode'] = $record->dark_mode;

        return $array;
    }

    public function get_user_socials_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['user_id'] = $record->user_id;
        $array['google_status'] = $record->google_status;
        $array['google'] = $record->google;
        $array['facebook_status'] = $record->facebook_status;
        $array['facebook'] = $record->facebook;
        $array['instagram_status'] = $record->instagram_status;
        $array['instagram'] = $record->instagram;
        $array['pinterest_status'] = $record->pinterest_status;
        $array['pinterest'] = $record->pinterest;
        $array['twitter_status'] = $record->twitter_status;
        $array['twitter'] = $record->twitter;
        $array['apple_status'] = $record->apple_status;
        $array['apple'] = $record->apple;

        return $array;
    }
}

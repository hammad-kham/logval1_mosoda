<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\AppSlide as AppSlideResource;
use App\Models\AppSlide;
use Illuminate\Support\Facades\DB;
use Request;

class AppSlideApiController extends BaseController
{
    private $_token = null;
    private $lat= null;    
    private $lng=null;	
    private $radius=null;
	
    public function retMethod(Request $request)
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

        ((!empty($request->header('lat'))) ? $this->lat=$request->header('lat') : $this->lat=null);        

        ((!empty($request->header('lng'))) ? $this->lng=$request->header('lng') : $this->lng=null);        

        ((!empty($request->header('radius'))) ? $this->radius=$request->header('radius') : $this->radius=5);
		    
        $title = '';
        if (isset($_POST['title'])) {
            $title = trim($_POST['title']);
        }
		
        if ($title != null && !empty($title)) {
            return $this->show($title);
        }
        else {
            return $this->index();
        }
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelData = AppSlide::where('status', '=', '1')->where('module', '=', '0')->where('type', '=', '0')->get();
        if (is_null($modelData) || count($modelData) < 1) {
            return $this->sendError('App Slide not found.');
        }
        return $this->sendResponse(AppSlideResource::collection($modelData), 'AppSlide retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        $modelData = AppSlide::where('status', '=', '1')->where('module', '=', '1')->where('title', 'like', '%' . $title . '%')->get();

        if (is_null($modelData) || count($modelData) < 1) {
            return $this->sendError('App Slide not found.');
        }
        return $this->sendResponse(AppSlideResource::collection($modelData), 'App Slide retrieved successfully.');

    }
}

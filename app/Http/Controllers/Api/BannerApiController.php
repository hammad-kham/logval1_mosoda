<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Api\BaseApiController as BaseController;

use App\Http\Resources\Banner as BannerResource;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class BannerApiController extends BaseController
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
		
        $name = '';
        if (isset($_POST['name'])) {
           // $name = trim($_POST['name']);
        }

        if ($name != null && !empty($name)) {
            return $this->show($name);
        } else {
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



        $modelData = Banner::where('status', '=', '1')->get();

        if (is_null($modelData) || count($modelData) < 1) {

            return $this->sendError('Banner not found.');

        }


        return $this->sendResponse(banners($modelData), 'Banner retrieved successfully.');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($name)
    {
        $modelData = Banner::where('name', 'like', '%' . $name . '%')->where('status', '=', '1')->get();

        if (is_null($modelData) || count($modelData) < 1) {

            return $this->sendError('Banner not found.');

        }

        return $this->sendResponse(BannerResource::collection($modelData), 'Banner retrieved successfully.');

    }

}
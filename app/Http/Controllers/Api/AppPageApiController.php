<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Api\BaseApiController as BaseController;


use App\Models\AppPage;

use Illuminate\Support\Facades\DB;

use Request;



class AppPageApiController extends BaseController
{
    private $_token = null;
    private $lat= null;    
    private $lng=null;	
    private $radius=null;

    public function retMethod(Request $request, $action = 'listing')
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
		
        if($action == 'listing'){
            return $this->index();
        }
        elseif($action == 'details'){

            $page_id = '';

            if (isset($_POST['page_id'])) {
                $page_id = trim($_POST['page_id']);
            }
            else{
                return $this->sendError('Incorrect Parameters.');
            }

            if ($page_id != null && !empty($page_id)) {
                return $this->show($page_id);
            }

        }

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $modelData = AppPage::where('status', '=', '1')->get();

        if (is_null($modelData) || count($modelData) < 1) {

            return $this->sendError('App Page not found.');

        }


        return $this->sendResponse(app_page($modelData), 'App Pages retrieved successfully.');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($page_id)

    {

        $modelData = AppPage::where('id', $page_id)->where('status', '=', '1')->get();

        if (is_null($modelData) || count($modelData) < 1) {

            return $this->sendError('App Page not found.');

        }

        return $this->sendResponse(app_page($modelData), 'App Page retrieved successfully.');

    }

}
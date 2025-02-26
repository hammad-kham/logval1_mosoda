<?php



namespace App\Http\Controllers\Api;





use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\DB;



class BaseApiController extends Controller

{

   // protected $_key = "EX3hAgMk3IMktRDhOoodZXSk3anBk3UR";



    public function getKey()

    {

        return $_key;

    }

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendResponse($result, $message)

    {

        $response = [

            'code' => '201',

            'status' => true,

            'data' => $result,

            'message' => $message,

        ];



        return response()->json($response, 200);

    }



    /**

     * return error response.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendError($error, $errorMessages = [], $code = 400)

    {

        $response = [

           'code' => 101,

           'status' => false,

           'message' => $error,

       ];



       if (!empty($errorMessages)) {

        $response['data'] = $errorMessages;

    }



    return response()->json($response, $code);

}





//////////exception handling////////////

public function convertExceptionToArray(Exception $e, $response=false){



    if(!config('app.debug')){

        $statusCode=$e->getStatusCode();

        switch ($statusCode) {

            case 401:

            $response['message'] = 'Unauthorized';

            break;

            case 403:

            $response['message'] = 'Forbidden';

            break;

            case 404:

            $response['message'] = 'Resource Not Found';

            break;

            case 405:

            $response['message'] = 'Method Not Allowed';

            break;

            case 422:

            $response['message'] = 'Request unable to be processed';

            break;

            default:

            $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $e->getMessage();

            break;

        }

    }



    return parent::convertExceptionToArray($e,$response);

}

}
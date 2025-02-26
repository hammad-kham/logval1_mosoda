<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AuthKey
{
     protected $_key = "HY3hAgMk3IMktRDhOHYdZXSk3anBk3UR";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
            /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
        

        $key=$request->header('key');
        if ($key!=$this->_key) {
          return $this->sendError('You are not authorized');
       }

       return $next($request);
   }

   public function sendError($error, $errorMessages = [], $code = 404)
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Faq;
use App\Models\FaqTopic;
use App\Models\Language;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppApiController extends BaseController
{
    private $_token = null;
    private $lat= null;    
    private $lng=null;	
    private $radius=null;

    public function retMethod(Request $request, $action='listing')
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
		
        $page = 1;
        $limit = 10;
        (isset($request->page) ? $page = trim($request->page) : 1);
        (isset($request->limit) ? $limit = trim($request->limit) : 10);

        if($action == 'faq-topics')
        {
            return $this->faq_topics($request);
        }

        if($action == 'faqs')
        {
            return $this->faqs($request);
        }

        if($action == 'countries')
        {
            return $this->countries($request);
        }

        if($action == 'currencies')
        {
            return $this->currencies($request);
        }

        if($action == 'languages')
        {
            return $this->languages($request);
        }

        else
        {
            return $this->sendError('Invalid Action.');
        }
    }

    public function faq_topics(Request $request)
    {

        if(!isset($request->type) || empty($request->type))
        {
            return $this->sendError('Required parameters are missing!');
        }

        $type = $request->type;
        $Records = FaqTopic::where('type', '=', $type)->where('status', '=', 1)->get();


        $records_data = null;

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_faq_topics_array($model);
            }

        }

        $data = array();
        $data['type'] = $type;
        $data['Faq_topics'] = $records_data;

        $message = "Data Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function faqs(Request $request)
    {

        if(!isset($request->topic_id) || empty($request->topic_id))
        {
            return $this->sendError('Required parameters are missing!');
        }

        $topic_id = $request->topic_id;
        $Records = Faq::where('topic_id', '=', $topic_id)->where('status', '=', 1)->get();


        $records_data = null;

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_faqs_array($model);
            }

        }

        $data = array();
        $data['topic_id'] = $topic_id;
        $data['Faqs'] = $records_data;

        $message = "Data Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function countries(Request $request){


        $Records = Country::where('status', '=', 1)->get();


        $records_data = null;

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_counries_array($model);
            }

        }

        $data = array();
        $data['Countries'] = $records_data;

        $message = "Data Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function currencies(Request $request){


        $Records = Currency::where('status', '=', 1)->get();


        $records_data = null;

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_currencies_array($model);
            }

        }

        $data = array();
        $data['Currencies'] = $records_data;

        $message = "Data Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function languages(Request $request){


        $Records = Language::where('status', '=', 1)->get();


        $records_data = null;

        if(!empty($Records))
        {
            $records_data =  array();
            foreach($Records as $model)
            {
                $records_data[] = $this->get_languages_array($model);
            }

        }

        $data = array();
        $data['Languages'] = $records_data;

        $message = "Data Retrieved Successfully";

        $response = [
            'code' => '201',
            'status' => true,
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response,200);
    }

    public function get_faq_topics_array($record)
    {
        $record_id = $record->id;

        $faqs =  null;
        if($record->has_faqs == 1)
        {
            $faqs =  array();

            $modelData = Faq::where('topic_id', '=', $record_id)->where('status', '=', '1')->get();
            foreach($modelData as $model)
            {
                $faqs[] = $this->get_faqs_array($model);
            }
            if(count($faqs) == 0)
            {
                $faqs = null;
            }
        }


        $array = array();

        $array['id'] = $record->id;
        $array['title'] = $record->title;
        $array['type'] = $record->type;
        $array['has_faqs'] = $record->has_faqs;
        $array['faqs'] = $faqs;

        return $array;
    }

    public function get_faqs_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['topic_id'] = $record->topic_id;
        $array['question'] = $record->question;
        $array['answer'] = $record->answer;
        $array['visits'] = $record->visits;

        return $array;
    }

    public function get_counries_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['name'] = $record->name;
        $array['code'] = $record->code;

        return $array;
    }

    public function get_currencies_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['name'] = $record->name;
        $array['code'] = $record->code;
        $array['symbol'] = $record->symbol;
        $array['rate'] = $record->rate;
        $array['is_default'] = $record->is_default;

        return $array;
    }

    public function get_languages_array($record)
    {
        $array = array();

        $array['id'] = $record->id;
        $array['name'] = $record->name;

        return $array;
    }



}

?>
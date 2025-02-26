<?php

use App\Models\AppUser;
use App\Models\AppPage;
use App\Models\BackendNotification;
use App\Models\BadWord;
use App\Models\BannerLocation;
use App\Models\BannerPage;
use App\Models\EcomOrder;
use App\Models\EcomOrderDetail;
use App\Models\EcomOrderSubDetail;
use App\Models\EcomProduct;
use App\Models\EcomSeller;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\SvcOrder;
use App\Models\SvcReview;
use App\Models\SvcVendor;
use App\Models\Template;


if (! function_exists('app_users_status_update'))
{
	function app_users_status_update()
	{		
        $current_time = time();
		
        $Users = AppUser::select(['id','suspend_time'])->where('status', 2)->where('suspend_time', '<>',0)->get();
        foreach($Users as $User)
		{
            $User_id = $User->id;
            $suspend_time = $User->suspend_time;
			
			if($suspend_time <= $current_time)
			{				
				$User = AppUser::find($User_id);
				$User->status = 1;
				$User->suspend_time = 0;
				$User->save();
			}
        }
	}
}


if (! function_exists('get_review_badwords_status'))
{
	function get_review_badwords_status($review)
	{		
		$found = 0;	
		$review = strtolower(trim($review));
		$badwords = BadWord::select('badword')->where('status', 1)->get();	
		foreach($badwords as $badword)	
		{	
			$badword = strtolower(trim($badword->badword));
			if (strpos($review, $badword) !== false) 
			{	
				 $found = 1;	
			}	
		}		
		return $found;	
	}
}

if (! function_exists('get_auth_vend_id'))
{
	function get_auth_vend_id($request, $Auth_User)
	{
		$vend_id = 0;
		if($Auth_User->user_type == 'admin')
		{
			$vend_id = $request->vend_id;
		}
		else
		{
			$vend_id = $Auth_User->vend_id;
		}
		
		return $vend_id;
	}
	
}


if (! function_exists('gen_random'))

{
	
	function gen_random($chars=11,$type=0)
	
	{
		
		$min_chars=$chars;
		
		$max_chars=$chars;
		
		$use_chars='';
		
		
		
		if($type==0)
			
			$use_chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		
		elseif($type==1)
			
			$use_chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		if($type==2)
			
			$use_chars='0123456789';
		
		
		
		$num_chars  = rand($min_chars, $max_chars);
		
		$num_usable = strlen($use_chars) - 1;
		
		$string = '';
		
		
		
		for($i = 0; $i < $num_chars; $i++)
		
		{
			
			$rand_char = rand(0, $num_usable);
			
			$string .= $use_chars[$rand_char];
			
		}
		
		return $string;
		
	}
	
}




if (! function_exists('asset_url'))

{
	
	function asset_url($path, $secure = null)
	
	{
		
		$path = '/assets/'.$path;
		
		$url = app('url')->asset($path, $secure);
		
		return $url;
		
	}
	
}


if (! function_exists('uploads'))

{
	
	function uploads($path, $secure = null)
	
	{
		
		$path = '/uploads/'.$path;
		
		$url = app('url')->asset($path, $secure);
		
		return $url;
		
	}
	
}


if (! function_exists('createSlug'))

{
	
	function createSlug($str, $delimiter = '-', $secure = null)
	
	{
		
		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		
		return $slug;
		
	}
	
}


function badwords_found($id)
{
	$reviews = SvcReview::select('id', 'review')->where('id', $id)->get();
	$badwords = BadWord::select('badword')->get();
	
	$found = 0;
	foreach($reviews as $review)
	{
		foreach($badwords as $badword)
		{
			if (strpos($review->review, $badword->badword) !== false) {
				$found = 1;
			}
		}
	}
	if($found == 1)
	{
		return "Found";
	}
	else
	{
		return "Not Found";
	}
}


function total_badwords_found($id)
{
	$reviews = SvcReview::select('id', 'review')->where('id', $id)->get();
	$badwords = BadWord::select('badword')->get();
	
	$count = 0;
	foreach($reviews as $review)
	{
		foreach($badwords as $badword)
		{
			if (strpos($review->review, $badword->badword) !== false) {
				$count++;
			}
		}
	}
	return $count;
}

function badwords_status($id)
{
	$reviews = SvcReview::select('id', 'review')->where('id', $id)->get();
	$badwords = BadWord::select('badword')->get();
	
	$found = 0;
	$count = count($badwords);
	foreach($reviews as $review)
	{
		foreach($badwords as $badword)
		{
			if (strpos($review->review, $badword->badword) !== false) {
				$found = 1;
			}
		}
	}
	if($found == 1)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function total_badwords_of_eachuser($id)
{
	$reviews = SvcReview::select('id', 'review')->where('vend_id', $id)->get();
	$badwords = BadWord::select('badword')->get();
	
	$found = 0;
	$count = 0;
	foreach($reviews as $review)
	{
		foreach($badwords as $badword)
		{
			if (strpos($review->review, $badword->badword) !== false) {
				$count++;
			}
		}
	}
	return $count;
}

function badwords_names($id)
{
	$reviews = SvcReview::select('id', 'review')->where('id', $id)->get();
	$badwords = BadWord::select('badword')->get();
	
	$bad_words = "";
	$totalbadwords = count($badwords);
	foreach($reviews as $review)
	{
		foreach($badwords as $badword)
		{
			if (strpos($review->review, $badword->badword) !== false) {
				
				if($bad_words == "")
				{
					$bad_words = $badword->badword;
				}
				else
				{
					$bad_words .= ", ".$badword->badword;
				}
			}
		}
	}
	if($bad_words == ""){
		$bad_words = "-";
	}
	
	echo $bad_words;
}



if (! function_exists('app_page'))
{
	function app_page($Records)
	{
		$app_pages = array();
		
		foreach ($Records as  $Record) {
			
			$data_array=array();
			
			$data_array["id"] = $Record->id;
			$data_array["title"] = $Record->title;
			$data_array["ar_title"] = $Record->ar_title;
			$data_array["description"] = $Record->description;
			$data_array["ar_description"] = $Record->ar_description;
			
			$img=$Record->image;
			if ($img !== "" || $img == null) {
				$img=null;
			}
			else{
				$img=uploads('banners') .'/'.$img;
			}
			
			$data_array["image"] = $img;
			
			$app_pages[] = $data_array;
			
		}
		
		return $app_pages;
		
	}
}

if (! function_exists('banners'))
{
	function banners($Records)
	{
		$banners = array();
		
		foreach ($Records as  $Record) {
			
			$data_array=array();
			
			$data_array["id"] = $Record->id;
			$data_array["title"] = $Record->title;
			$data_array["ar_title"] = $Record->ar_title;
			
			$img=$Record->image;
			if ($img=="banner.png") {
				$img=uploads('defaults') .'/'.$img;
			}
			elseif ($img=="") {
				$img=null;
			}
			else{
				$img=uploads('banners') .'/'.$img;
			}
			
			$data_array["image"] = $img;
			
			$data_array["topic_app_page_id"] = $Record->topic_app_page_id;
			$data_array["topic_app_page_title"] = get_app_page_title($Record->topic_app_page_id);
			
			$banners[] = $data_array;
			
		}
		
		return $banners;
		
	}
}

if (! function_exists('get_banner_array')) {
	function get_banner_array($Record)
	{
		
		$data_array = array();
		
		$data_array["id"] = $Record->id;
		$data_array["title"] = $Record->title;
		$data_array["ar_title"] = $Record->ar_title;
		
		$img = $Record->image;
		if ($img == "banner.png") {
			$img = uploads('defaults') . '/' . $img;
		} elseif ($img == "") {
			$img = null;
		} else {
			$img = uploads('banners') . '/' . $img;
		}
		
		$data_array["image"] = $img;
		
		$data_array["topic_app_page_id"] = $Record->topic_app_page_id;
		$data_array["topic_app_page_title"] = get_app_page_title($Record->topic_app_page_id);
		
		return $data_array;
	}
}

if (! function_exists('get_to_do_array')) {
	function get_to_do_array($Record)
	{
		
		$data_array = array();
		
		$data_array["id"] = $Record->id;
		$data_array["title"] = $Record->title;
		$data_array["description"] = $Record->description;
		$data_array["is_pinned"] = $Record->is_pinned;
		$data_array["status"] = $Record->status;
		
		if($Record->status == 0){
			$data_array["status_text"] = "Pending";
		}
		elseif ($Record->status == 1){
			$data_array["status_text"] = "Done";
		}
		
		$data_array["created_by"] = $Record->created_by;
		$data_array["updated_by"] = $Record->updated_by;
		$data_array["created_at"] = $Record->created_at;
		$data_array["updated_at"] = $Record->updated_at;
		
		return $data_array;
	}
}

if (! function_exists('get_banner_page_name'))
{
	function get_banner_page_name($page_id)
	{
		$page = BannerPage::select('page')->where('id', $page_id)->first();
		return $page->page;
	}
}

if (! function_exists('get_banner_location_name'))
{
	function get_banner_location_name($location_id)
	{
		$location = BannerLocation::select('location')->where('id', $location_id)->first();
		return $location->location;
	}
}

if (! function_exists('get_app_page_title'))
{
	function get_app_page_title($page_id)
	{
		$location = AppPage::select('title')->where('id', $page_id)->first();
		return $location->title;
	}
}



if (! function_exists('get_email_template'))
{
	function get_email_template()
	{
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>[SUBJECT]</title>
  <style type="text/css">
  body {
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   margin:0 !important;
   width: 100% !important;
   -webkit-text-size-adjust: 100% !important;
   -ms-text-size-adjust: 100% !important;
   -webkit-font-smoothing: antialiased !important;
 }
 .tableContent img {
   border: 0 !important;
   display: block !important;
   outline: none !important;
 }

p, h2{
  margin:0;
}

div,p,ul,h2,h2{
  margin:0;
}

h2.bigger,h2.bigger{
  font-size: 32px;
  font-weight: normal;
}

h2.big,h2.big{
  font-size: 21px;
  font-weight: normal;
}

a.link1{
  color:#62A9D2;font-size:13px;font-weight:bold;text-decoration:none;
}

a.link2{
  padding:8px;background:#62A9D2;font-size:13px;color:#ffffff;text-decoration:none;font-weight:bold;
}

a.link3{
  background:#62A9D2; color:#ffffff; padding:8px 10px;text-decoration:none;font-size:13px;
}
.bgBody{
background: #F6F6F6;
}
.bgItem{
background: #ffffff;
}

@media only screen and (max-width:480px)
		
{
		
table[class="MainContainer"], td[class="cell"] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class="specbundle"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class="specbundle1"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}	
td[class="specbundle2"] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class="specbundle3"] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class="specbundle4"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class="spechide"] 
	{
		display:none !important;
	}
	    img[class="banner"] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class="left_pad"] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		 
}
	
@media only screen and (max-width:540px) 

{
		
table[class="MainContainer"], td[class="cell"] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class="specbundle"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		
	}
	td[class="specbundle1"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		
	}		
td[class="specbundle2"] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
	}
	td[class="specbundle3"] 
	{
		width:90% !important;
		float:left !important;
		font-size:14px !important;
		line-height:18px !important;
		display:block !important;
		padding-left:5% !important;
		padding-right:5% !important;
		padding-bottom:20px !important;
		text-align:center !important;
	}
	td[class="specbundle4"] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:20px !important;
		text-align:center !important;
		
	}
		
td[class="spechide"] 
	{
		display:none !important;
	}
	    img[class="banner"] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class="left_pad"] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		
	.font{
		font-size:15px !important;
		line-height:19px !important;
		
		}
}


</style>

</head>
<body paddingwidth="0" paddingheight="0"   style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0" style="margin-left:5px; margin-right:5px; margin-top:0px; margin-bottom:0px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"  style="font-family:helvetica, sans-serif;">
  
    <!--  =========================== The header ===========================  -->   
    
	<tbody>
        <tr>
            <td height="25" bgcolor="#e91e63" colspan="3"></td>
        </tr>
        
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                        
                            <td valign="top" class="spechide">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    
                                        <tr>
                                            <td height="130" bgcolor="#e91e63">&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </td>
                            
                            <td valign="top" width="600">
                                <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="MainContainer" bgcolor="#ffffff">
                                	<tbody>
   									<!--  =========================== The body ===========================  -->   
                                        <tr>
                                            <td class="movableContentContainer">
                                            
                                                <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" valign="top">
                                                        <tr>
                                                            <td height="40" bgcolor="#e91e63" valign="top" style="color:#FFF">
                                                                <div class="contentEditableContainer contentImageEditable">
                                                                    <div class="contentEditable" >
                                                                        <img src="../assets/img/logo.png" alt="Homely" data-default="placeholder" data-max-width="50" width="50" height="50">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                
                                                <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" valign="top">
                    
                                                        <tr><td height="5" bgcolor="#E2741B"></td></tr>
                                                        
                                                        <tr><td height="10" class="bgItem"></td></tr>
                                                        
                                                        <tr>
                                                            <td height="55" class="bgItem">                        
                                                                <div class="contentEditableContainer contentTextEditable">
                                                                    <div class="contentEditable" style="font-size:32px;color:#555555;font-weight:normal;">
                                                                        <h2 style="font-size:32px; padding:10px;">[SUBJECT]</h2>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                    
                    									<tr><td height="10" class="bgItem"></td></tr>

                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" valign="top" class="bgItem">

                      												<tr><td colspan="3" height="22" ></td></tr>

                                                                    <tr>
                                                                        <td width="10"></td>
                                                                            <td width="650">
                                                                                <div class="contentEditableContainer contentTextEditable">
                                                                                    <div class="contentEditable" style="font-size:13px;color:#99A1A6;line-height:19px;">
                                                                                        <p>[MESSAGEBODY]</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        <td width="10"></td>
                                                                    </tr>

                      												<tr><td colspan="3" height="45" ></td></tr>

                    											</table>
                  											</td>
                										</tr>
                									</table>
                                        		</div>                                        
                                        	</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            
      						<td valign="top" class="spechide">
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td height="130" bgcolor="#e91e63">&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
							</td>
                            
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

</body>
</html>';
		
		return $header;
	}
}



if (! function_exists('get_email_content_in_template'))
{
	function get_email_content_in_template($subject,$message)
	{
		$subject = trim($subject);
		$message = trim($message);
		
		$template = get_email_template();
		
		$template = str_replace('[SUBJECT]', $subject, $template);
		
		$template = str_replace('[MESSAGEBODY]', $message, $template);
		
		return $template;
	}
}



if (! function_exists('custom_mail'))
{
	function custom_mail($to,$subject,$message)
	{
		$site_title = env('APP_NAME');
		
		$from = env('MAIL_FROM_ADDRESS');
		
		$message = get_email_content_in_template($subject,$message);
		
		
		$header   = array();
		$header[] = "MIME-Version: 1.0";
		$header[] = "Content-type: text/html; charset=iso-8859-1";
		$header[] = "From: $site_title  <".$from.">";
		$header[] = "Reply-To: $site_title  <".$from.">";
		//$header[] = "Subject: {$subject}";
		$header[] = "X-Mailer: PHP/".phpversion();
		
		$bool=1;
		
		//mail($to,$subject,$message);
		
		if(!mail($to,$subject,$message, implode("\r\n", $header)))
		{
			print_r(error_get_last());
			$bool=0;
		}
		
		return $bool;
	}
}



if (! function_exists('get_time_to_hours_array'))
{
	function get_time_to_hours_array()
	{
		$time_to_hours = array();
		
		$j=0;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '00:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '00:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '01:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '01:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '02:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '02:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '03:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '03:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '04:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '04:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '05:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '05:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '06:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '06:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '07:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '07:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '08:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '08:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '09:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '09:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '10:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '10:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '11:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '11:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '12:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '12:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '13:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '13:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '14:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '14:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '15:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '15:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '16:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '16:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '17:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '17:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '18:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '18:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '19:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '19:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '20:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '20:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '21:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '21:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '22:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '22:30';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '23:00';
		
		$j++;
		$index = ($j * 30 * 60);
		$time_to_hours[$index] = '23:30';
		
		return $time_to_hours;
	}
	
}




if (! function_exists('create_app_user_notification'))
{
	function create_app_user_notification($title, $user_id, $module, $type, $type_id)
	{
		$notification = new Notification();
		
		$notification->title = $title;
		$notification->user_id = $user_id;
		$notification->module = $module;
		$notification->type = $type;
		$notification->type_id = $type_id;
		
		$notification->save();
	}
}




if (! function_exists('send_email_or_sms_notification'))
{
	function send_email_or_sms_notification($type, $type_for, $status, $user_id, $order_no)
	{

        $template = Template::where('type',$type)->where('type_for',$type_for)->where('status',$status)->first();
        $app_user = AppUser::find($user_id);

        $title = $template->title;
        $description = $template->description;
        $description = str_replace("[ORDERNO]", $order_no, $description);

        if($type == 1){

            $phone_no = $app_user->phone;

            //Send DESCRIPTION on PHONE_NO


        }
        elseif($type == 2){

            $email = $app_user->email;

            //Send TITLE, DESCRIPTION on EMAIL

        }

	}
}




if (! function_exists('backend_notification'))
{
	function backend_notification($message, $app_user_id, $user_id, $module, $type, $type_id)
    {
        $notification = new BackendNotification();

        $notification->message = $message;
        $notification->app_user_id = $app_user_id;
        $notification->user_id = $user_id;
        $notification->module = $module;
        $notification->type = $type;
        $notification->type_id = $type_id;

        $notification->save();
    }
}

if (! function_exists('notifications_array'))
{
	function notifications_array($record)
	{
		$array = array();
		
		$array['id'] = $record->id;
		$array['module'] = $record->module;
		$array['type'] = $record->type;
		$array['type_id'] = $record->type_id;
		$array['title'] = $record->title;
		$array['user_id'] = $record->user_id;
		$array['read_status'] = $record->read_status;
		$array['read_time'] = date('Y-m-d H:i:s',$record->read_time);
		$array['created_at'] = $record->created_at;
		
		if($record->module == 'sod'){
			if($record->type == 'order'){
				$order = SvcOrder::find($record->type_id);
				
				$vend_data = SvcVendor::find($order->vend_id);
				$vendor = get_vendor_basic_data($vend_data);
				
				$array['vendor'] = $vendor;
			}
		}
		
		if($record->module == 'ecom'){
			if($record->type == 'order'){
				$order = EcomOrder::find($record->type_id);
				
				$order_array = get_ecom_order_listing_array($order);
				
				$array['order'] = $order_array;
			}
			elseif($record->type == 'order_sub_detail'){
				$sub_detail = EcomOrderSubDetail::find($record->type_id);
				
				$product_data = EcomProduct::find($sub_detail->product_id);
				$product = get_ecom_product_array_without_details($product_data);
				
				$array['product'] = $product;
			}
		}
		
		return $array;
	}
}

if (! function_exists('get_notification_details'))
{
	function get_notification_details($record)
	{
		$array = array();
		
		$array['id'] = $record->id;
		$array['module'] = $record->module;
		$array['type'] = $record->type;
		$array['type_id'] = $record->type_id;
		$array['title'] = $record->title;
		$array['user_id'] = $record->user_id;
		$array['read_status'] = $record->read_status;
		$array['read_time'] = date('Y-m-d H:i:s',$record->read_time);
		$array['created_at'] = $record->created_at;
		
		
		if($record->module == 'sod'){
			if($record->type == 'order'){
				$order_data = SvcOrder::find($record->type_id);
				$order = get_order_data($record->type_id);
				
				$vend_data = SvcVendor::find($order_data->vend_id);
				$vendor = get_vendor_basic_data($vend_data);
				
				$array['vendor'] = $vendor;
				$array['order'] = $order;
			}
		}
		
		if($record->module == 'ecom'){
			if($record->type == 'order'){
				$order = EcomOrder::find($record->type_id);
				$order_array = get_ecom_order_details_array($order);
				
				$array['order'] = $order_array;
			}
			elseif($record->type == 'order_sub_detail'){
				$sub_detail = EcomOrderSubDetail::find($record->type_id);
				$sub_detail = ecom_order_sub_detail_array($sub_detail);
				
				$array['sub_detail'] = $sub_detail;
			}
		}
		
		return $array;
	}
}




if (! function_exists('get_vat_value'))
{
	function get_vat_value()
	{
		$vat = 0;
		$modelData = GeneralSetting::find(4);
		if(!empty($modelData))
		{
			$vat = $modelData->value;
		}
		return $vat;
	}
}




if (! function_exists('get_google_maps_link'))
{
	function get_google_maps_link()
	{
		$link = '';
		$key = '';
		$modelData = GeneralSetting::find(13);
		if(!empty($modelData))
		{
            $key = $modelData->value;
		}

        $link = "https://maps.google.com/maps/api/js?key=".$key."&libraries=places";

        return $link;
	}
}



if (! function_exists('get_notification_audio'))
{
    function get_notification_audio()
    {
        $Model_Data = GeneralSetting::find(12);
        $file_path = 'audios/';
        $file = $Model_Data->value;
        if($file == 'user_arrived.mp3')
        {
            $image_path = 'defaults/';
        }
        $file_path.= $file;
        return uploads($file_path);
    }
}


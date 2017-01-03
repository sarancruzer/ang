<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Hash;
use JWTAuth;

class ConnectionController extends Controller{

	public function getToken($request)
    {
        $token = null; 
        foreach (getallheaders() as $name => $value) {
            if($name == "Authorization")
            {
                return $token = str_replace("Bearer ", "", $value);
            }
        }
        return response()->json(['error' => "Authentication Not Provided"],401);
    }

    public function getAllConnectionList(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	$searchValue = $input['search_value'];
		
        $existConnectionLists = DB::table('connection_request as cr')
    								->select('cr.sender_id as sender_id','cr.receiver_id as receiver_id ')
    								->where('cr.receiver_id','=',$user['id'])
    								->orwhere('cr.sender_id','=',$user['id'])
    								->orderBy('cr.id', 'desc')	
    								->get();

         $arrays = [];                                    
		foreach($existConnectionLists as $object)
			{
			    $arrays[] = $object->sender_id;
			    $arrays[] = $object->receiver_id;
			}
		
		$sponsor = 'sponsor';
		$elder = 'elder';

    	$lists = DB::table('users as u')
    				->leftJoin('cb_sponsors as s', function($join)
                         {
                             $join->on('s.id', '=', 'u.user_type_id');
                             $join->on('u.user_type','=', DB::raw("'sponsor'"));
                         })
                 	->leftJoin('cb_elders as e', function($join)
                         {
                             $join->on('e.id', '=', 'u.user_type_id');
                             $join->on('u.user_type','=', DB::raw("'elder'"));
                         })
    				->select('u.id','u.user_type_id','u.user_type','s.name as s_name','s.email as s_email','e.name as name','e.email as e_email','u.avatar')
    				->where(function($query) use ($arrays)
                    {   
                        if(!empty($arrays)){
                        $query->whereNotIn('u.id', $arrays);    
                        }
                        
                    })
                    ->where(function($query) use ($sponsor,$elder)
                    {
                        $query->where('u.user_type','=', $sponsor);
                        $query->orWhere('u.user_type','=', $elder);
                    })
                    ->where(function($query) use ($searchValue)
	                    {
	                    if(!empty($searchValue)):
	                        $query->orWhere('s.name','like', $searchValue.'%');
	                    endif;

	                    if(!empty($searchValue)):
	                        $query->orWhere('s.email','like', $searchValue.'%');
	                    endif;

	                     if(!empty($searchValue)):
			            	 $query->orWhere('e.name','like', $searchValue.'%');
			             endif;

			             if(!empty($searchValue)):
			           	  	$query->orWhere('e.email','like', $searchValue.'%');
			             endif;
			           	
			         })
                    
					->orderBy('u.id', 'DESC')	
    				->paginate(5);
    				
		foreach ($lists as $key => $value) {
		    
				if($value->user_type == "sponsor"){
					$sponsor_list = DB::table('cb_sponsors as s')
									->leftjoin('cb_company as c','c.id','=','s.company_id')	
									->select('s.name as name','s.designation','s.email as email','s.mobile as mobile','c.name as company_name')
									->where('s.id','=',$value->user_type_id)
									->first();
					$lists[$key]->connections = $sponsor_list;
				}else if($value->user_type == "elder"){
					$elder_list = DB::table('cb_elders as e')
									->select('e.name as name','e.mobile as mobile','e.email as email')
									->where('e.id','=',$value->user_type_id)
									->first();
					$lists[$key]->connections = $elder_list;
				}
			}   


    	if(count($lists) > 0 ){
                $result = array();
                $result['info'] = $lists;
                return response()->json(['result'=>$result]);
            }else{
                return response()->json(['error'=>'no results found'],401);
            }    

    }


    public function getAllConnConnectionList(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	$user_id = $user['id'];

    	$lists = DB::table('users as u')
    				->select('u.id','u.user_type_id','u.user_type')
    				->where('u.id', '!=', $user_id)
    				->where('u.user_type','=','sponsor')	
    				->orwhere('u.user_type','=','elder')
    				->orderBy('u.id', 'DESC')	
    				->paginate($this->list_count);
		foreach ($lists as $key => $value) {
		    
				if($value->user_type == "sponsor"){
					$sponsor_list = DB::table('cb_sponsors as s')->where('s.id','=',$value->user_type_id)->first();
					$lists[$key]->connections = $sponsor_list;
				}else if($value->user_type == "elder"){
					$elder_list = DB::table('cb_elders as e')->where('e.id','=',$value->user_type_id)->first();
					$lists[$key]->connections = $elder_list;
				}
			}   

    	$result = array();			
    	if(count($lists) > 0){
    		$result['info'] = $lists;

    		return response()->json(['result' => $result]);
    	}
    }

    public function sendConnectionRequest(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	$user_id = $user['id'];
    	//$receiver_id = 73;
    	$receiver_id = $input['connect_id'];
    	$receiver_name = $input['connect_name'];

    	$req_data = array(
    		"sender_id" => $user_id,
    		"receiver_id" => $receiver_id,
    		"approve_status" => 0,
	   		"created_at" => date("Y-m-d h:i:sa")
    		);
    	$lists = DB::table('connection_request')->insertGetId($req_data);

    	$result = array();
   		if($lists)
		{
		$result['info'] = 'your request has been sent successfully';
		$result['name'] = $receiver_name;
		return response()->json(['result' => $result]);
 		}
    	 return response()->json(['result' => 'your request has sending failed']);

    }

    public function receiveConnectionRequest(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	$user_id = $user['id'];
        $searchValue = $input['searchValue'];
    
    	$lists = DB::table('connection_request as cr')
    				->leftjoin('users as u','u.id','=','cr.sender_id')
    				->select('cr.id as connection_id','cr.sender_id','cr.approve_status','u.id','u.user_type','u.user_type_id','u.avatar')
                    ->where('cr.receiver_id','=',$user_id)
    				->where('cr.approve_status','=',0)
                    ->where(function($query) use ($searchValue)
                        {
                        if(!empty($searchValue)):
                            $query->Where('u.name','like', $searchValue.'%');
                            $query->orWhere('u.email','like', $searchValue.'%');
                        endif;
                     })
    				->paginate(5);
		

		foreach ($lists as $key => $value) {
			
			if($value->user_type == "sponsor"){
				$sponsor_list = DB::table('cb_sponsors as s')
									->leftjoin('cb_company as c','c.id','=','s.company_id')
									->where('s.id','=',$value->user_type_id)
									->select('s.name as name','s.designation','s.email as email','s.mobile as mobile','c.name as company_name')
									->first();
				$lists[$key]->connections = $sponsor_list;									
			}else if($value->user_type == "elder"){
				$elder_list = DB::table('cb_elders as e')
									->where('e.id','=',$value->user_type_id)
									->select('e.name as name','e.mobile as mobile','e.email as email')
									->first();
				$lists[$key]->connections = $elder_list;																		
			}
		}    


		
		$result = array();
   		if(count($lists) > 0){
   			 $result['info'] = $lists;	
    		 return response()->json(['result' => $result]);
    	}
    	 	return response()->json(['error' => 'No Connections Found'],401);    			
    }

    public function sendResponse(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	//$connection_request_id = 3;
    	$conn_req__id = $input['conn_req__id'];
    	$res_data = array(
    		"approve_status" => $input['approve_status']
    		);

    	$lists = DB::table('connection_request')->where('id','=',$conn_req__id)->update($res_data);

    	if($lists){
    		return response()->json(['result'=>'your response has been sent successfully']);
    	}

    	return response()->json(['error' => 'your approve failed'],401);
    	

    }


    public function getConnectionList(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);

    	//$user_id = $user['id'];

        $user_id = $input['user_id'];

        $searchValue = $input['searchValue'];
        $lists = DB::table('connection_request as cr')
                    ->leftJoin('users as u', function($join)
                         {
                             $join->on('u.id', '=', 'cr.sender_id')->orOn('u.id','=', 'cr.receiver_id');
                         })
                    ->select('cr.id as connection_id','cr.sender_id as sen_id','cr.receiver_id as rec_id','cr.approve_status','u.id','u.user_type','u.user_type_id','u.avatar')
                    ->where(function($query) use ($user_id)
                        {
                        if(!empty($user_id)):
                            $query->Where('cr.receiver_id','=', $user_id);
                        endif;
                        if(!empty($user_id)):
                            $query->orWhere('cr.sender_id','=', $user_id);
                        endif;
                     })
                    ->where(function($query) use ($searchValue)
                        {
                        if(!empty($searchValue)):
                            $query->Where('u.name','like', $searchValue.'%');
                        endif;
                        if(!empty($searchValue)):
                            $query->orWhere('u.email','like', $searchValue.'%');
                        endif;
                     })
                    ->where('cr.approve_status','=',1)
                    ->where('u.id','!=',$user_id)
                    ->paginate(5);
                    //->toSql();

        foreach ($lists as $key => $value) {
            $lists[$key] = $value;
            if($value->user_type == "sponsor"){
                    $sponsor_list = DB::table('cb_sponsors as s')
                                    ->leftjoin('cb_company as c','c.id','=','s.company_id')
                                    ->where('s.id','=',$value->user_type_id)
                                    ->select('s.name as name','s.designation','s.email as email','s.mobile as mobile','c.name as company_name')
                                    ->first();
                    $lists[$key]->connections = $sponsor_list;  
                }else if($value->user_type == "elder"){
                $elder_list = DB::table('cb_elders as e')
                                    ->where('e.id','=',$value->user_type_id)
                                    ->select('e.name as name','e.mobile as mobile','e.email as email')
                                    ->first();
                $lists[$key]->connections = $elder_list;
                }

          }

    	$result = array();
   		if(count($lists) > 0){
   			 $result['info'] = $lists;	
    		 return response()->json(['result' => $result]);
    	}
    	 	return response()->json(['error' => 'No Connections Found'],401);  

    }

    public function getUserPosts(Request $request){

        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);
        
       $lists = DB::table('community_post as com_p')
                        ->join('community as com','com.id','=','com_p.com_id')
                        ->where('com_p.uid','=',$input['user_id'])
                        ->select('com_p.*','com.community_name','com.logo as community_logo')
                        ->orderBy('com_p.id','DESC')
                        ->paginate(5);
                        //->toSql();

          //print_r($lists);
        foreach ($lists as $key => $value) {
             $cp_details_comments = DB::table('community_post_comments as com_pc')                       ->leftjoin('users as u','u.id','=','com_pc.uid')
                                       ->where('com_pc.com_post_id','=',$value->id)
                                       ->select('com_pc.uid as uid','com_pc.comments as comments','com_pc.id as comments_id','u.avatar as profile_image')
                                       ->get();
            $lists[$key]->comments = $cp_details_comments;
            $lists[$key]->showComments = 0;
            if(isset($input["post"]) && !empty($input["post"]) && $input["post"] != 0){
                $pId = $value->id;
                if($pId == $input["post"]){
                    $lists[$key]->showComments = 1;    
                }
            }

            $cp_details_comments_count = DB::table('community_post_comments as com_pc')
                                       ->where('com_pc.com_post_id','=',$value->id)
                                       ->count();

            $lists[$key]->comment_count = $cp_details_comments_count;

             $cp_details_likes = DB::table('community_post_likes as com_pl')                      ->where('com_pl.com_post_id','=',$value->id)
                                       ->where('com_pl.uid','=',$user['id'])
                                       ->select('com_pl.likes as likes')
                                       ->first();
                                       
            
            if(!empty($cp_details_likes)){
                $lists[$key]->likes = $cp_details_likes->likes;
            }else{
   
                $lists[$key]->likes = 0;
            }
           
              $cp_details_likecount = DB::table('community_post_likes as com_pl')
                                         ->where('com_pl.com_post_id','=',$value->id)
                                         ->where('com_pl.likes','=',1)
                                         ->select(DB::raw('COUNT(com_pl.likes) as likecount'))
                                         ->first();
            $lists[$key]->likecount = $cp_details_likecount->likecount;


          }

        $result = array();
        if(count($lists) > 0 ){
            $result['info']['lists'] = $lists;
            return response()->json(['result'=>$result]);
        }
        return response()->json(['error'=> "No Posts Found"],401);

    }

    public function getProfileDetail(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $job_board = new JobBoardController();
       
        $profile_details = $job_board->getUserByID($input['user_id'],"user");   

        $profile_user_id = $input['user_id'];
        $userId = $user['id'];
       
        $approve_list = DB::table('connection_request as cr')
                    ->where('cr.receiver_id','=',$profile_user_id)
                    ->where('cr.sender_id','=',$user['id'])
                    ->where(function($query) use ($profile_user_id,$userId)
                    {
                        $query->where('cr.receiver_id','=',$profile_user_id);
                        $query->where('cr.sender_id','=',$userId);
                    })
                    ->orwhere(function($query) use ($profile_user_id,$userId)
                    {
                        $query->where('cr.receiver_id','=',$profile_user_id);
                        $query->where('cr.sender_id','=',$userId);
                    })
                    ->select('cr.id','cr.approve_status')
                    ->first();

        if(count($approve_list) >0 ){
            $approve_status['status'] = $approve_list->approve_status;
        }else{
            if($profile_user_id == $userId){
                    $approve_status['status'] = 1;
                }else{
                   $approve_status['status'] = 3;
                }
            }

        $result = array();
        if(count($profile_details) > 0 ){
            $result['info']['profile_details'] = $profile_details;
            $result['info']['approve_status'] = $approve_status;
            return response()->json(['result'=>$result]);
        }

        return response()->json(['error'=> "no results found"],401);

    }

    public function sendComments(Request $request){

    $input = $request->all();
    $token = $this->getToken($request);
    $user = JWTAuth::toUser($token);

    $postId = $input['info']['postId'];
    $comments = $input['info']['comments'];

    $cpcData = array(
        "com_post_id"=>$postId,
        "comments"=>$comments,
        "uid"=>$user['id']
            );
    $lists = DB::table('community_post_comments')->insertGetId($cpcData);

    $result = array();
    if($lists){
        return response()->json(['result'=>'your comments sent successfully']);
    }   
    return response()->json(['result'=>'your comments not inserted !!'],401);              

    }

    public function myAccountDetail(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);




    }

    public function sendLikes(Request $request){

    $input = $request->all();
    $token = $this->getToken($request);
    $user = JWTAuth::toUser($token);

    $postId = $input['info']['postId'];
    
    $cplData = array(
        "com_post_id"=>$postId,
        "likes"=>1,
        "uid"=>$user['id']
            );

    $lists = DB::table('community_post_likes')
                ->where('com_post_id','=',$postId)
                ->where('uid','=',$user['id'])
                ->first();

    if(count($lists)>0){
        if($lists->likes == 1){
            $query = DB::table('community_post_likes')
                        ->where('com_post_id','=',$postId)
                        ->where('uid','=',$user['id'])
                        ->update(['likes' => 0]);    
        }else{

            $query = DB::table('community_post_likes')
                        ->where('com_post_id','=',$postId)
                        ->where('uid','=',$user['id'])
                        ->update(['likes'=>1]);    
        }    
        
    }else{

        $query = DB::table('community_post_likes')->insertGetId($cplData);    
    }

    $result = array();
    if($query){
        return response()->json(['result'=>'your likes sent successfully']);
    }   
    return response()->json(['result'=>'your likes not inserted !!'],401);              

    }


    public function getCommunityMembers(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $lists = DB::table('community_members as com_m')
                        ->leftjoin('community as com','com.id','=','com_m.community_id') 
                        ->where('com_m.uid','=',$input['user_id'])
                        ->where('com_m.status','=',1)
                        ->select('com.*')
                        ->paginate(5);

       $result = array();
       if(count($lists)>0){

        $result['info']=$lists;
        return response()->json(['result'=>$lists]);
       }                         
       return response()->json(['error'=>'No Communities Found'],401);

    }


    public function getSentRequestLists(Request $request){

        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $user_id = $user['id'];
        $searchValue = $input['searchValue'];

        $lists = DB::table('connection_request as cr')
                    ->leftjoin('users as u','u.id','=','cr.receiver_id')
                    ->select('cr.id as connection_id','cr.receiver_id','cr.approve_status','u.id','u.user_type','u.user_type_id','u.avatar','cr.created_at as sent_date ')
                    ->where('cr.sender_id','=',$user_id)
                    ->where('cr.approve_status','=',0)
                    ->where(function($query) use ($searchValue)
                        {
                        if(!empty($searchValue)):
                            $query->Where('u.name','like', $searchValue.'%');
                            $query->orWhere('u.email','like', $searchValue.'%');
                        endif;
                     })
                    ->paginate(5);
        

        foreach ($lists as $key => $value) {
            
            if($value->user_type == "sponsor"){
                $sponsor_list = DB::table('cb_sponsors as s')
                                    ->leftjoin('cb_company as c','c.id','=','s.company_id')
                                    ->where('s.id','=',$value->user_type_id)
                                    ->select('s.name as name','s.designation','s.email as email','s.mobile as mobile','c.name as company_name')
                                    ->first();
                $lists[$key]->connections = $sponsor_list;                                  
            }else if($value->user_type == "elder"){
                $elder_list = DB::table('cb_elders as e')
                                    ->where('e.id','=',$value->user_type_id)
                                    ->select('e.name as name','e.mobile as mobile','e.email as email')
                                    ->first();
                $lists[$key]->connections = $elder_list;                                                                        
            }
        }    


        
        $result = array();
        if(count($lists) > 0){
             $result['info'] = $lists;  
             return response()->json(['result' => $result]);
        }
            return response()->json(['error' => 'No Requests Found'],401);   



    }


}
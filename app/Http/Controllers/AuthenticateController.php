<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use DB;
class AuthenticateController extends Controller
{

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
 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
       
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


    $user = User::where("email", $credentials["email"])->first();
    $details["id"] = $user->id;
    $details["email"] = $user->email;
    $details["user_type"] = $user->user_type;
    $details["name"] = (!$user->email ? "Admin" : $user->email);
    $details["avatar"] = $user->avatar;

    User::where("id", $user->id)->update(array('last_login' => date("Y-m-d H:i:s") ));

        // if no errors are encountered we can return a JWT
    return response()->json(compact('details','token'));
    }

    public function getUsers(Request $request)
  {
      $input = $request->all();
      $token = $this->getToken($request);
      $user = JWTAuth::toUser($token);

      $lists = DB::table('users')->paginate(5);
      

      $result = array();      
      if(count($lists) > 0){
        $result['info'] = $lists;
          return response()->json(['result' => $result]);
      }
  }

  public function profile(Request $request){
    $input = $request->all();
    $token = $this->getToken($request);
    $user = JWTAuth::toUser($token);

    $lists = DB::table('users')
                ->where('id','=',$user['id'])
                ->get();
      
      $result = array();      
      if(count($lists) > 0){
        $result['info'] = $lists;
          return response()->json(['result' => $result]);
      }

      return response()->json(['error'=>'No Results Found'],401);

  }
  
}
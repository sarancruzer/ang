<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Hash;
use JWTAuth;

class ProductController extends Controller{

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

    
    public function getProductList(Request $request){
    	$input = $request->all();
    	$token = $this->getToken($request);
    	$user = JWTAuth::toUser($token);


        $searchValue= $input['searchValue'];

    	$lists = DB::table('products as p')
                        ->where('p.status','=',1)
                        ->where(function($query) use ($searchValue)
                        {
                        if(!empty($searchValue)):
                            $query->Where('p.product_name','like', $searchValue.'%');
                        endif;
                        
                     })
                        ->paginate(5);
		

    	$result = array();			
    	if(count($lists) > 0){
    		$result['info'] = $lists;
        	return response()->json(['result' => $result]);
    	}
    }

    public function addProduct(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        date_default_timezone_set('Asia/Kolkata');

        $data['supplier_name'] = $input['supplier_name'];
        $data['email'] = $input['email'];
        $data['mobile'] = $input['mobile'];
        $data['address'] = $input['address'];
        $data['supplier_code'] = $input['supplier_code'];
        $data['created_at'] = date('Y-m-d H:i:s');



        $lists = DB::table('suppliers')->insertGetId($data);

        $result = array();
        if($lists)
        {
        $result['info'] = 'supplier has been added successfully ';
        return response()->json(['result' => $result]);
        }
         return response()->json(['result' => 'your request has sending failed']);

    }

     public function editSupplier(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $supplier_id = $input['supplier_id'];
        $lists = DB::table('suppliers')
                        ->where('id','=',$supplier_id)
                        ->get();

        $result = array();          
        if(count($lists) > 0){
            $result['info'] = $lists;
            return response()->json(['result' => $result]);
        }

    }


     public function updateSupplier(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $supplier_id = $input['supplier_id'];

        $data['supplier_name'] = $input['supplier_name'];
        $data['email'] = $input['email'];
        $data['mobile'] = $input['mobile'];
        $data['address'] = $input['address'];
        $data['supplier_code'] = $input['supplier_code'];
        
        $lists = DB::table('suppliers')
                    ->where('id','=',$supplier_id)
                    ->update($data);

        if($lists){
            return response()->json(['result'=>'supplier has been updated successfully!!!']);
        }
        return response()->json(['error' => 'your update has been failed!!!'],401);

    } 

     public function deleteSupplier(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $supplier_id = $input['supplier_id'];

        $lists = DB::table('suppliers')
                        ->where('id', '=', $supplier_id)
                        ->delete();

        $result = array();
        if($lists)
        {
        $result['info'] = 'supplier has been deleted successfully ';
        return response()->json(['result' => $result]);
        }
         return response()->json(['result' => 'your request has failed']);

    }   


}
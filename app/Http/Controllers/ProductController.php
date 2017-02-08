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
                            $query->Where('p.product_name','like', '%'.$searchValue.'%');
                        endif;
                        
                     })
                        ->paginate(5);
		

    	$result = array();			
    	if(count($lists) > 0){
    		$result['info'] = $lists;
        	return response()->json(['result' => $result]);
    	}
            return response()->json(['error' => 'No Results Found'],401);
    }

    public function productAdd(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        date_default_timezone_set('Asia/Kolkata');

        $data['supplier_id'] = $input['supplier_id'];
        $data['product_code'] = $input['product_code'];
        $data['product_name'] = $input['product_name'];
        $data['product_cost'] = $input['product_cost'];
        $data['percentage'] = $input['percentage'];
        $data['created_at'] = date('Y-m-d H:i:s');


        $lists = DB::table('products')->insertGetId($data);

        $result = array();
        if($lists)
        {
        $result['info'] = 'product has been added successfully ';
        return response()->json(['result' => $result]);
        }
         return response()->json(['error' => 'your request has sending failed'],401);

    }

     public function getProductById(Request $request,$id){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $product_id = $id;
        $lists = DB::table('products')
                        ->where('id','=',$product_id)
                        ->get();

        $result = array();          
        if(count($lists) > 0){
            $result['info'] = $lists;
            return response()->json(['result' => $result]);
        }

        return response()->json(['error' => 'No Results Found'],401);

    }


     public function productUpdate(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $product_id = $input['id'];

        $data['supplier_id'] = $input['supplier_id'];
        $data['product_code'] = $input['product_code'];
        $data['product_name'] = $input['product_name'];
        $data['product_cost'] = $input['product_cost'];
        $data['percentage'] = $input['percentage'];
        
        $lists = DB::table('products')
                    ->where('id','=',$product_id)
                    ->update($data);

        if($lists){
            return response()->json(['result'=>'product has been updated successfully!!!']);
        }
        return response()->json(['error' => 'your update has been failed!!!'],401);

    } 

     public function productDelete(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $product_id = $input['product_id'];

        $lists = DB::table('products')
                        ->where('id', '=', $product_id)
                        ->delete();

        $result = array();
        if($lists)
        {
        $result['info'] = 'product has been deleted successfully ';
        return response()->json(['result' => $result]);
        }
         return response()->json(['result' => 'your request has failed']);

    }   

    public function productinwardAdd(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);
        date_default_timezone_set('Asia/Kolkata');

        print_r($input);
        $total_cost = round($input['quantity'] * $input['unit_cost']);
        $data = array(
           'product_id' => $input['product_id'],
           'quantity' => $input['quantity'],
           'unit_cost' => $input['unit_cost'],
           'total_cost' => $input['total_cost'],
           'invoice_no' => $input['invoice_no'],
           "invoice_date"=>$input['invoice_date'],
           "created_at"=>date('Y-m-d'),
            );

        $result = array();                            
        $lists = DB::table('product_inward')->insertGetId($data);            
        if(count($lists)>0){

            
           $this->addProductToStock($data);
         
           $result['info'] = 'product has been added successfully '; 
           return response()->json(['result' => $result]);
        }                            
         return response()->json(['result' => 'your request has failed']);

    }


    public function addProductToStock($data){
        $exists_product = DB::table('stock')
                                ->where('product_id','=',$data['product_id'])
                                ->first();
        
        unset($data['invoice_no']);                                
        unset($data['invoice_date']);                                


        if(count($exists_product)>0){
            $data['quantity'] = $data['quantity']+$exists_product->quantity;
            $data['unit_cost'] = $exists_product->unit_cost;
            $data['total_cost'] =  ($data['quantity']*$exists_product->unit_cost)+$exists_product->total_cost;
       }
        if(count($exists_product)>0){
            $lists = DB::table('stock')->where('product_id','=',$data['product_id'])->update($data);
       }else{
            $lists = DB::table('stock')->insertGetId($data);
       }                            

    }



    public function productInward(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);


        $product_id = $input['product_id'];
        $lists = DB::table('product_inward')
                            ->where('product_id','=',$product_id)
                            ->get();

        date_default_timezone_set('Asia/Kolkata');                            
     
        $total_cost = round($input['quantity'] * $input['unit_cost']);
        $data = array(
            'product_id' => $input['product_id'],
                               'supplier_id' => $input['supplier_id'],
                               'quantity' => DB::raw('quantity+'.$input['quantity']),
                               'unit_cost' => $input['unit_cost'],
                               'total_cost' => $total_cost,
                               'invoice_no' => $input['invoice_no'],
                               "invoice_date"=>date('Y-m-d'),
                               "total_amount"=>DB::raw('total_amount+'.$total_cost),
                               "created_at"=>date('Y-m-d'),

            );
        $result = array();                            
        if(count($lists) > 0 ){
            $lists = DB::table('product_inward')
                            ->where('product_id','=',$input['product_id'])
                            ->update($data);
            
            $result['info'] = 'product has been added successfully '; 
            return response()->json(['result' => $result]);
        }else{
            $lists = DB::table('product_inward')
                            ->insertGetId($data);            
            $result['info'] = 'product has been added successfully '; 
            return response()->json(['result' => $result]);
        }                            
         return response()->json(['result' => 'your request has failed']);

    }

    public function getAllSuppliers(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $lists = DB::table('suppliers')
                        ->select('id','supplier_name')    
                        ->get();
        
        $result = array();                        
        if(count($lists)>0){
            $result['info'] = $lists;
            return response()->json(['result'=>$lists]);
        }                

        return response()->json(['error'=>'No Results Found']);
    }    

    public function getProductinwardList(Request $request){
         $input = $request->all();   
         $token = $this->getToken($request);
         $user = JWTAuth::toUser($token);

         $lists = DB::table('product_inward as pi')
                        ->leftjoin('products as p','p.id','=','pi.product_id')
                        ->select('p.product_code','p.product_name','pi.*')
                        ->orderBy('p.id','desc')
                        ->paginate(5);

         $result = array();
         if(count($lists)>0){
            $result['info']=$lists;
            return response()->json(['result'=>$result]);
         }  
         return response()->json(['error'=>'No Results Found'],401);



    }

    public function getProductinwardById(Request $request,$id){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $product_inward_id = $id;
        $lists = DB::table('product_inward')
                        ->where('id','=',$product_inward_id)
                        ->first();

        $result = array();          
        if(count($lists) > 0){
            $result['info'] = $lists;
            return response()->json(['result' => $result]);
        }

        return response()->json(['error' => 'No Results Found'],401);

    }


    public function getAllProducts(Request $request){
        $input = $request->all();
        $token = $this->getToken($request);
        $user = JWTAuth::toUser($token);

        $lists = DB::table('products')
                        ->select('id','product_code','product_name')    
                        ->get();
        
        $result = array();                        
        if(count($lists)>0){
            $result['info'] = $lists;
            return response()->json(['result'=>$lists]);
        }                

        return response()->json(['error'=>'No Results Found']);
    }    

    public function getProductCost(Request $request){
            $input = $request->all();
            $token = $this->getToken($request);
            $user = JWTAuth::toUser($token);

            $productId = $input['productId'];

            $lists = DB::table('products')
                            ->select('product_cost','percentage')
                            ->where('id','=',$productId)
                            ->first();
            $productCost = ($lists->product_cost * $lists->percentage) / 100;
            $unit_cost = $lists->product_cost + $productCost;
            if(count($lists)>0){
                return response()->json(['result'=>$unit_cost]);
            }                

    }
}
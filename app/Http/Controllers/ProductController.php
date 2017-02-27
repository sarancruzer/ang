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

        //print_r($input);

        $product_inward = $input['productInward'];
        $inward = $input['inward'];
        $grand_total = $input['grandTotal'];

        $data_hdr = array(
           'supplier_id' => $product_inward['supplier_id'],
           'po_number' => $product_inward['po_number'],
           'invoice_no' => $product_inward['invoice_no'],
           "invoice_date"=> date('Y-m-d'), //$product_inward['invoice_date'],
           "grand_total" =>$grand_total,
           "created_at"=>date('Y-m-d'),
            );

        $return_id = DB::table('product_inward')->insertGetId($data_hdr);            

        $data_child = array();

        if($return_id){
        foreach ($inward as $key => $value) {
            $data_child['product_inward_id'] = $return_id;
            $data_child['product_id'] = $value['product_id'];
            $data_child['unit_cost'] = $value['unit_cost'];
            $data_child['quantity'] = $value['quantity'];
            $data_child['total_cost'] = $value['total_cost'];
            $data_child['grand_total'] = $grand_total;
            $data_child['created_at'] = date('Y-m-d');
            
            $product_inward_child_id = DB::table('product_inward_child')->insertGetId($data_child);             
        }
    }
    
        if($return_id){

           $this->addProductToStock($inward);
           $result['info'] = 'product has been added successfully '; 
           return response()->json(['result' => $result]);
        }                            
         return response()->json(['result' => 'your request has failed']);

    }


    public function addProductToStock($data){
                      
        foreach ($data as $key => $value) {
            $exists_product = DB::table('stock')
                                ->where('product_id','=',$value['product_id'])
                                ->first();
            

            $records['quantity'] = $value['quantity']+$exists_product['quantity'];
            $records['unit_cost'] = $value['unit_cost'];
            $records['total_cost'] =  ($value['quantity']*$value['unit_cost'])+$exists_product['total_cost'];

            $update_product = DB::table('stock')
                                ->where('product_id','=',$value['product_id'])
                                ->update($records);
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
                        //->leftjoin('product_inward_child as pic','pic.product_inward_id','=','pi.id')
                        ->leftjoin('suppliers as s','s.id','=','pi.supplier_id')
                        ->select('s.supplier_name','pi.*')
                        ->orderBy('pi.id','desc')
                        ->paginate(5);

         $result = array();
         if(count($lists)>0){
            $result['info']=$lists;
            return response()->json(['result'=>$result]);
         }  
         return response()->json(['error'=>'No Results Found'],401);



    }

     public function getProductinwardDetailById(Request $request){
         $input = $request->all();   
         $token = $this->getToken($request);
         $user = JWTAuth::toUser($token);

         $product_inward_id = $input['productInwardId'];

         $lists = DB::table('product_inward as pi')
                        ->leftjoin('product_inward_child as pic','pic.product_inward_id','=','pi.id')
                        ->leftjoin('products as p','p.id','=','pic.product_id')
                        ->leftjoin('suppliers as s','s.id','=','pi.supplier_id')
                        ->select('p.product_code','p.product_name','s.supplier_name','pi.*','pic.*')
                        ->orderBy('pi.id','desc')
                        ->where('pi.id','=',$product_inward_id)
                        ->get();

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

    public function getStockList(Request $request){
            $input = $request->all();
            $token = $this->getToken($request);
            $user = JWTAuth::toUser($token);

            $lists = DB::table('stock')
                            ->orderBy('id','desc')
                            ->paginate(5);

            if(count($lists)>0){
                $result = [];
                $result['info'] = $lists;
                return response()->json(['result'=>$result]);
            }                                    

            return response()->json(['error'=>'No Results Found']);
    }
}
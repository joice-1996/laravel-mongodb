<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Order;
use App\OrderDetail;
use Auth;
use Hash;
use Config;
use Response;
use Validator;

class MongodbController extends Controller
{
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param 
    * @Date 01-06-2021
    * @module 
    * Description: display login form
    **/
    public function login()
    {
        return view('login');
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param Request $request
    * @Date 01-06-2021
    * @module 
    * Description: login validation
    **/
    public function login_search(Request $request)
    {
        $request->validate([
        
            'email' => 'email|required',
            'password'=>'required',
        ]);
        
        $email = $request->email;
        $password=$request->password;
        
            if(Auth::attempt(['email'=>$email,'password'=>$password])){
                
                if(Auth::user()->user_type =="admin"){
                    return redirect('dashboard');
                   // return redirect('admin/dashboard')->with('success','Successfully login');
                   
                }
               
            } else {
                
                return redirect()->back()->with('fail','Invalid Email or Password');
            }
        
    
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param 
    * @Date 01-06-2021
    * @module 
    * Description: dashboard
    **/
    public function dashboard()
    {
        return view('dashboard');
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param 
    * @Date 01-06-2021
    * @module 
    * Description: order details
    **/
    public function order()
    {
       
        $active = Config::get('constants.ACTIVE');
        $users=User::where('status',$active)
                ->where('user_type','!=','admin')->get();
        $products=Product::where('status',$active)->get();
        $orders=Order::with(array('users'=>function($query){
            $query->select('name','_id');
        }))->where('status',$active)->paginate(3);
        return view('order',compact('users','products','orders'));
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param 
    * @Date 01-06-2021
    * @module 
    * Description: Logout
    **/
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param $id
    * @Date 01-06-2021
    * @module 
    * Description: get_user
    **/
    public function get_user($id)
    {
        $users=User::where('_id',$id)->first();
        return Response::json($users);
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param 
    * @Date 01-06-2021
    * @module 
    * Description: get product
    **/
    public function get_product()
    {
        //return 1;
        $active = Config::get('constants.ACTIVE');
        $products=Product::where('status',$active)->pluck('product_name','_id');
        return Response::json($products);
    }
      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param Request $request
    * @Date 01-06-2021
    * @module 
    * Description: Order now
    **/
    public function order_now(Request $request)
    {
        //return "success";
        $input=$request->all();
        //return $input;
         $user = json_decode($input['user']);
         $user = json_decode(json_encode($user), true);
         $error=Validator::make($user['user'],[
            'user_id'=>'required'
         ]);
         if($error->fails()){
            return $error->messages()->toArray();
        }
         //return $user;
         $order_details= json_decode($input['order_details']);
         $order_details = json_decode(json_encode($order_details), true);
        // return $order_details;
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        $id=Order::insertGetId([
            'user_id'=>(string)$user['user']['user_id'],
            'total_rate'=>(float)$user['user']['final_rate'],
            'status'=>1,
            'order_date'=>$date
        ]);
            $i=0;
            foreach($order_details as $key )
            {
                $error1=Validator::make([$key[$i]],[
                    'product_id'=>'',
                    'rate'=>'numeric',
                    'quantity'=>'numeric'
                ]);
                if($error1->fails()){
                    return $error1->messages()->toArray();
                }
                $i=$i+1;
                foreach ($key as $value)
                {                
                    OrderDetail::insert([
                        "order_id"=>(string)$id,
                        "product_id"=>(string)$value['product_id'],
                        "rate"=>(float)$value['rate'],
                        "quantity"=>(int)$value['quantity'],
                        "status"=>1,
                        "order_date"=>$date
                    ]);
                }
                
            }
            
            return "Success";    
    }

      /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param $id
    * @Date 02-06-2021
    * @module 
    * Description: Order now
    **/
    public function get_order($id)
    {
        $orders=Order::with(array('users'=>function($query){
            $query->select('name','_id');
        }))->with(array('order_details'=>function($query){
            $query->select('order_id','product_id','quantity','rate','_id');
            $query->where('status',1)->
            with(array('products'=>function($query){
                $query->select('product_name','_id');
            }));
        }))->where('_id',$id)->first();
        return Response::json($orders);

    }
    /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param $id
    * @Date 02-06-2021
    * @module 
    * Description: Particular product delete from order_details
    **/
    public function product_delete($id)
    {
        $query=OrderDetail::where('_id',$id)->update(['status'=>0]);
        if($query)
        {
            $rate=OrderDetail::where('_id',$id)->where('status',0)->first(array('order_id','rate','quantity'));
            $rate1= $rate->rate;
            $quantity=$rate->quantity;
            $tot_rate=$rate1*$quantity;
            $order_id= $rate->order_id;
            $query1=Order::where('_id',$order_id)->decrement('total_rate',$tot_rate);
            if($query1)
            {
                return "success";
            }
            
        }

    }
     /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param Request $request
    * @Date 03-06-2021
    * @module 
    * Description: Add new order with update
    **/
    public function add_new_order(Request $request)
    {
        $input=$request->all();
        $order_details= json_decode($input['order_details']);
        $order_details = json_decode(json_encode($order_details), true);
        //return $order_details;
        $error=Validator::make([ $order_details['new_order']],[
            'product_id'=>'',
            'rate'=>'numeric',
            'quantity'=>'numeric'
        ]);
        if($error->fails()){
            return $error->messages()->toArray();
        }
        $product=OrderDetail::where('order_id',$order_details['new_order']['order_id'])
                ->where('status',1)->get();
        $new_product_id=$order_details['new_order']['product_id'];
        foreach($product as $value)
        {
            if($value['product_id'] == $new_product_id)
            {
                return "exist";
            }
        }
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        $query=OrderDetail::insert([
            'order_id'=>(string)$order_details['new_order']['order_id'],
            'product_id'=>(string)$order_details['new_order']['product_id'],
            'rate'=>(float)$order_details['new_order']['rate'],
            'quantity'=>(float)$order_details['new_order']['quantity'],
            'status'=>1,
            'order_date'=>$date
        ]);
        if($query)
        {
            $tot_rate=(float)$order_details['new_order']['total_rate'];
            //return $tot_rate;
            $query2=Order::where('_id',$order_details['new_order']['order_id'])
                    ->increment('total_rate',$tot_rate);
            if($query2)
            {
                return "success";
            }
        }
        

    }
     /**
    Laravel 6.0
    * @package Cart 
    * @author Joice Sara Joseph
    * @param $id
    * @Date 03-06-2021
    * @module 
    * Description: delete order
    **/
    public function order_delete($id)
    {
        $query=OrderDetail::where('order_id',$id)->update(['status'=>0]);
        if($query)
        {
            $query1=Order::where('_id',$id)->update(['status'=>0]);
            if($query1)
            {
                return "success";
            }
        }
    }


}

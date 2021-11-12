<?php

namespace App\Http\Controllers;
use App\User as User;
use App\Product as Product;

use Auth;
use Cookie;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Response;
use Session;
use Validator;

class LoginController extends Controller
{

    /**
     * Laravel  6.0
     * @package FACTFOKUZ
     * @author  AYUSH
     * @param  Request $request
     * @Date   24-01-2020
     * @module Login
     * @Input   Username and Password
     * output message and ability
     * Description:Login
     **/

    public function login(Request $request)
    {        
        $data['value'] = (int)200;
        $id = Product::insertGetId($data);
        $data['new_id'] = (string)$id;
        Product::where('_id', $id)->update($data);

        return $input = Product::sum('value');
    }

}

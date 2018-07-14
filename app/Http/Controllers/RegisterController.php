<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Validator;
use Redirect;
use App\Register;

use Auth;

class RegisterController extends Controller
{
    //

    public function store(){

       // echo "test";
       $data=Input::except(array('token'));

      // var_dump($data); 
    $rule=array(
        'username'=>'required',
        'email'=>'required|email',
        'password'=>'required|min:6',
        'cpassword'=>'required|same:password'
    );  
        
     $message=array(
            'cpassword.required' =>'the confirm password is required',
            'cpassword.min' =>'the confirm password must be at least 6 characters',
            'cpassword.same' =>'the confirm password and password must be same',
        
    );

    $validator=Validator::make($data,$rule,$message);

    if($validator->fails()) {
       return Redirect::to('register')->withErrors($validator);
    }else {
            Register::formstore(Input::except(array('token','cpassword')));
       return Redirect::to('register')->with('success','successfullly registered');
        }
    
    }


    public function login(){
       // echo"loginfucnt";
       $data=Input::except(array('token'));

       // var_dump($data); 
     $rule=array(
        
         'email'=>'required|email',
         'password'=>'required'

     );  
         
     
     $validator=Validator::make($data,$rule);
 
     if($validator->fails()) {
        return Redirect::to('signin')->withErrors($validator);
     }else {
       // $data=Input::except(array('token'));
       $userdata=array(
           'email'=>Input::get('email'),
           'password'=>Input::get('password')
       );

       if(Auth::attempt($userdata)){
         return Redirect::to('');
       
       }else{
        return Redirect::to('signin');
 

       }
     }

    }
 
}

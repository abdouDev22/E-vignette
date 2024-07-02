<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaseContent extends Controller
{
   protected $valid=false;


   function index(){
    return view('Auth.connexion');
   }
   function vigetteObetnu(){
      return view('vigetteObetnu');
     }
     function achatVignette(){
      $voitures = DB::select('select matricule,chevaux from voitures');
      return view('voitureachat',compact('voitures'));
     }
     function vignette(){
      return view('achatvignette');
     }
     function service(){
      return view('service');
     }
     function profile(){
      return view('profile');
     }



     public function login(Request $request)
    {
     
      $email = request('email');
      $password = request('password');
      $users = DB::select("select id,email,password from users");
      $valid=false;
        foreach ($users as $user) {
            if ($user->email === $email && $user->password === $password) {
                Auth::loginUsingId($user->id);
                $valid=true;    
                $voitures = DB::select('select matricule,chevaux from voitures');
                return View('Welcome',compact('voitures'));
            }
        }
        
        return view('auth.connexion')->with('valid', $valid);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

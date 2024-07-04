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
   function welcome(){
    $userId = Auth::id();
    $voitures = DB::table('voitures')
      ->where('id_client', $userId)
      ->select('id','matricule', 'chevaux')
      ->get();
    return View('welcome',compact('voitures'));
   }
   function vigetteObetnu($id_voiture){
    $userId = Auth::id();
        $achatVignettes = DB::table('achat')
          ->where('id_client', $userId)
          ->where('id_voiture', $id_voiture)
          ->select('prix', 'Date')
          ->get();
      return view('vigetteObetnu',compact('achatVignettes'));
     }
     function achatVignette(){
        $userId = Auth::id();
        $voitures = DB::table('voitures') 
          ->where('id_client', $userId)
          ->select('id','matricule', 'chevaux')
          ->get();
      return view('voitureachat',compact('voitures'));
     }
     function vignette($id_voiture){
        $userId = Auth::id();
        $achatVignettes = DB::table('vignettes')
        ->select('date','prix')
        ->get();


        $voitures = DB::table('voitures') 
        ->where('id_client', $userId)
        ->where('id', $id_voiture)
        ->select('id','matricule', 'chevaux')
        ->get();

        if ($voitures->isNotEmpty()) {
          foreach ($voitures as $voiture) {
              $chevaux = $voiture->chevaux;
      
              foreach ($achatVignettes as $achatVignette) {
                  if ($chevaux > 6) {
                      $prix = $achatVignette->prix * 2;
                      $achatVignette->prix = $prix;
                  }
              }
          }
      }
        return view('achatvignette',compact('achatVignettes'));
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

                $userId = Auth::id();
                $voitures = DB::table('voitures')
                  ->where('id_client', $userId)
                  ->select('id','matricule', 'chevaux')
                  ->get();
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

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaseContent extends Controller
{
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
        ->select('id','date','prix')
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
        return view('achatvignette',compact('achatVignettes'),compact('voitures'));
     }
     function service($id_voiture,$id_vignette){
      $userId = Auth::id();

      $voitures = DB::table('voitures') 
        ->where('id_client', $userId)
        ->where('id', $id_voiture)
        ->select('id','matricule', 'chevaux')
        ->get();

      return view('service', ['voiture' => $id_voiture,
      'vignette' => $id_vignette]);
     }

     function codeqr($id_voiture,$id_vignette){
      $userId = Auth::id();

      $voitures = DB::table('voitures') 
        ->where('id_client', $userId)
        ->where('id', $id_voiture)
        ->select('id','matricule', 'chevaux')
        ->get();

      return view('service', ['voiture' => $id_voiture,
      'vignette' => $id_vignette]);
     }

     function profile(){
      return view('profile');
     }
}

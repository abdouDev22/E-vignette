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
        
        $mode_paiements = DB::table('mode_paiement') 
        ->select('id','mode')
        ->get();

      return view('service', ['voiture' => $id_voiture,
      'vignette' => $id_vignette],compact('mode_paiements'));
     }

     function codeqr($id_voiture,$id_vignette,$id_mode){
      $userId = Auth::id();

      return view('api.api_waafi_connexion', ['voiture' => $id_voiture,
      'vignette' => $id_vignette,'id_mode'=>$id_mode]);
     }


     public function page_achat(Request $request, $id_voiture, $id_vignette, $id_mode)
{
    $userId = Auth::id();
    $phone = $request->input('phone');
    $password = $request->input('password');

    $solde = DB::table('api_waafi_1')
        ->where('tel', $phone)
        ->where('password', $password)
        ->value('solde');

    $achatVignette = DB::table('vignettes')
        ->where('id', $id_vignette)
        ->first(['id', 'date', 'prix']);

    $voiture = DB::table('voitures')
        ->where('id_client', $userId)
        ->where('id', $id_voiture)
        ->first(['id', 'matricule', 'chevaux']);

    if ($voiture && $solde !== null && $achatVignette) {
        $prix = $voiture->chevaux > 6 ? $achatVignette->prix * 2 : $achatVignette->prix;

        if ($solde >= $prix) {
            DB::beginTransaction();

            try {
                DB::table('api_waafi_1')
                    ->where('tel', $phone)
                    ->where('password', $password)
                    ->decrement('solde', $prix);

                DB::table('achat')->insert([
                    'Date' => now(),
                    'prix' => $prix,
                    'id_mode_paiement' => $id_mode,
                    'id_voiture' => $id_voiture,
                    'id_vignette' => $id_vignette,
                    'id_code_q_r' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'id_client' => $userId
                ]);

                DB::commit();
                return view('api.api_waafi_affiche', ['id_mode' => $id_mode]);
            } catch (\Exception $e) {
                DB::rollBack();
                return view('api.api_waafi_connexion',['voiture' => $id_voiture,
                'vignette' => $id_vignette,'id_mode'=>$id_mode])->with('error', 'Transaction failed');
            }
        } else {
            return view('api.api_waafi_connexion',['voiture' => $id_voiture,
            'vignette' => $id_vignette,'id_mode'=>$id_mode])->with('error', 'Insufficient balance');
        }
    } else {
        return view('api.api_waafi_connexion',['voiture' => $id_voiture,
        'vignette' => $id_vignette,'id_mode'=>$id_mode])->with('error', 'Invalid data');
    }
}

}

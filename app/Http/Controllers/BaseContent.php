<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaseContent extends Controller
{
   function index(){
      $voitures = DB::select('select matricule,chevaux from voitures');
    return view('welcome',compact('voitures'));
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
}

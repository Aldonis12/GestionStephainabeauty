<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employe;
use App\Models\Genre;
use App\Models\Influenceur;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function RechercheEmploye(Request $request){

        session(['search_values' => $request->all()]);

        $query = Employe::query();
        if($request->nom != null){
            $query->where(function ($query) use ($request) {
                $query->where('nom', 'LIKE', '%' . $request->nom . '%')
                ->orWhere('prenom', 'LIKE', '%' . $request->nom . '%');
            });
        }
        /*if($request->age != null){
            $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $request->age);
        }*/
        if ($request->genre > 0) {
            $query->where('idgenre', $request->genre);
        }
        if($request->disponibilite < 2){
            $query->where('iscanceled', $request->disponibilite);
        }
        if($request->stagiaire < 2){
            $query->where('isinternship', $request->stagiaire);
        }
        //echo($query->toSql());
        $employes = $query->orderBy('id')->paginate(100);
        $titre = "employe";
        $genres = Genre::all();
        return view('Admin/liste',compact('titre','employes','genres'));
    }

    public function RechercheInfluenceur(Request $request){
        session(['search_values_influenceur' => $request->all()]);

        $query = Influenceur::query();
        if($request->nom != null){
            $query->where(function ($query) use ($request) {
                $query->where('nom', 'LIKE', '%' . $request->nom . '%')
                ->orWhere('prenom', 'LIKE', '%' . $request->nom . '%');
            });
        }
        if($request->age != null){
            $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $request->age);
        }
        $influenceurs = $query->orderBy('id')->paginate(100);
        $titre = "influenceur";
        $genres = Genre::all();
        return view('Admin/liste',compact('titre','influenceurs','genres'));
    }

    public function RechercheClient(Request $request){
        session(['search_values_client' => $request->all()]);

        $query = Client::query();
        if($request->nom != null){
            $query->where(function ($query) use ($request) {
                $query->where('nom', 'LIKE', '%' . $request->nom . '%')
                ->orWhere('prenom', 'LIKE', '%' . $request->nom . '%');
            });
        }
        if($request->age != null){
            $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $request->age);
        }
        if ($request->genre > 0) {
            $query->where('idgenre', $request->genre);
        }
        if($request->adresse != null){
            $query->where('adresse', 'LIKE', '%' . $request->adresse . '%');
        }
        $clients = $query->orderBy('inserted','desc')->paginate(100);
        $titre = "client";
        $genres = Genre::all();
        return view('Admin/liste',compact('titre','clients','genres'));
    }
}

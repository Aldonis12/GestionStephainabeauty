<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employe;
use App\Models\Genre;
use App\Models\Influenceur;
use App\Models\Question;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function PageUpdateSalon($id){
        $salon = Salon::find($id);
        $titre = "salon";
        return view('Admin/update',compact('titre','salon','id'));
    }

    public function UpdateSalon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'adresse' => 'required',

        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'adresse.required' => 'Le champ adresse est requis.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $salon = Salon::find($request->id);
        $salon->nom = $request->nom;
        /*if (Str::startsWith($request->adresse, 'Lieu: ')) {
            $salon->adresse = Str::replaceFirst('Lieu: ', '', $request->adresse);
        } else {
            $salon->adresse = $request->adresse;
        }*/
        $salon->adresse = $request->adresse;
        $salon->update();

        return redirect('/DetailSalon/'.$request->id);
    }

    public function PageUpdateService($id){
        $service = Service::find($id);
        $types = Types::all();
        $titre = "service";
        return view('Admin/update',compact('types','titre','service','id'));
    }

    public function UpdateService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'id' => 'required',
            'idtypes' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'idtypes.required' => 'Le champ Type est requis.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->id);
        $service->nom = $request->nom;
        $service->idtypes = $request->idtypes;
        $service->update();

        return redirect('/DetailService/'.$request->id);
    }

    public function PageUpdateEmploye($id){
        $genres = Genre::all();
        $employe = Employe::find($id);
        $titre = "employe";
        return view('Admin/update',compact('genres','titre','employe','id'));
    }

    public function UpdateEmploye(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'required|integer|min:0',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'genre.required' => 'Le champ genre est requis.',
            'genre.integer' => 'Le champ genre est requis.',
            'idgenre.min' => 'Le champ genre doit être réel et positif.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employe = Employe::find($request->id);
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->idgenre = $request->genre;
        $employe->update();

        return redirect('/DetailEmploye/'.$request->id);
    }

    public function PageUpdateClient($id){
        $genres = Genre::all();
        $client = Client::find($id);
        $titre = "client";
        return view('Admin/update',compact('genres','titre','client','id'));
    }

    public function UpdateClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'required|integer|min:0',
            'date_naissance' => 'required|before:today',
            'numero' => 'required',
            'adresse' => 'required',
            'email' => 'required',
            'profession' => 'required',
            'charge' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'genre.required' => 'Le champ genre est requis.',
            'genre.integer' => 'Le champ genre est requis.',
            'idgenre.min' => 'Le champ genre doit être réel et positif.',
            'date_naissance.before' => 'La date de naissance doit être inférieure à aujourd\'hui.',
            'numero.required' => 'Le champ numero est requis.',
            'adresse.required' => 'Le champ adresse est requis.',
            'email.required' => 'Le champ email est requis.',
            'profession.required' => 'Le champ profession est requis.',
            'charge.required' => 'Le champ charge est requis.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = Client::find($request->id);
        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->date_naissance = $request->date_naissance;
        $client->idgenre = $request->genre;
        $client->numero = $request->numero;
        $client->adresse = $request->adresse;
        $client->email = $request->email;
        $client->profession = $request->profession;
        $client->charge = $request->charge;
        $client->update();

        return redirect('/DetailClient/'.$request->id);
    }

    public function PageUpdateQuestion($id){
        $questions = DB::table('question')
        ->select('question.id','question.question','reponse.valeur','reponse.reponse')
        ->join('reponse', 'question.id', '=', 'reponse.idquest')
        ->where('question.id', '=', $id)
        ->orderBy('question.id')
        ->orderBy('reponse.valeur')
        ->get();
        $titre = "question";
        return view('Admin/update',compact('titre','questions','id'));
    }

    public function UpdateQuestion(Request $request) {
        $id = $request->input('id');
        $nouvelleQuestion = $request->input('question');

        $reponses = $request->input('reponses');
    
        try {
            DB::beginTransaction();
    
            DB::table('question')
                ->where('id', $id)
                ->update(['question' => $nouvelleQuestion]);
    
            foreach ($reponses as $key => $reponseData) {
                $valeur = $reponseData['valeur'];
                $reponse = $reponseData['reponse'];
    
                DB::table('reponse')
                    ->where('idquest', $id)
                    ->where('valeur', $valeur)
                    ->update(['reponse' => $reponse]);
            }
    
            DB::commit();
    
            return redirect('/ListQuestion');
    
        } catch (\Exception $e) {
            DB::rollback();
    
            return redirect()->back();
        }
    }

    public function PageUpdateInfluenceur($id){
        $genres = Genre::all();
        $influenceur = Influenceur::find($id);
        $titre = "influenceur";
        return view('Admin/update',compact('genres','titre','influenceur','id'));
    }

    public function UpdateInfluenceur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'code' => 'required',
            'email' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'code.required' => 'Le champ code est requis.',
            'email.required' => 'Le champ email est requis.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $influenceur = Influenceur::find($request->id);
        $influenceur->nom = $request->nom;
        $influenceur->code = $request->code;
        $influenceur->email = $request->email;
        $influenceur->update();

        return redirect('/DetailInfluenceur/'.$request->id);
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDetails;
use App\Models\Employe;
use App\Models\Genre;
use App\Models\Influenceur;
use App\Models\InfluenceurDetails;
use App\Models\InfluenceurPrestataire;
use App\Models\ReseauxSociaux;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function PageAddClient()
    {
        $genres = Genre::all();
        $codes = Influenceur::select('id', 'code')->get();
        return view('User/ajout', compact('genres', 'codes'));
    }

    public function AddClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'required|integer|min:0',
            'date_naissance' => 'required|before:today',
            'adresse' => 'required',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'genre.required' => 'Le champ genre est requis.',
            'genre.integer' => 'Le champ genre est requis.',
            'idgenre.min' => 'Le champ genre doit être réel et positif.',
            'date_naissance.before' => 'La date de naissance doit être inférieure à aujourd\'hui.',
            'adresse.required' => 'Le champ adresse est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = DB::table('client')
            ->select('id')
            ->where('nom', $request->nom)
            ->where('prenom', $request->prenom)
            ->where('date_naissance', $request->date_naissance)
            ->first();

        if ($client) {
            return redirect()->back()->with('message', 'Ce client est déjà enregistré.');
        } else {
            $client = new Client();
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->date_naissance = $request->date_naissance;
            $client->idgenre = $request->genre;
            $client->numero = $request->numero;
            $client->adresse = $request->adresse;
            $client->email = $request->email;
            $client->profession = $request->profession;
            if ($request->code>0) {
                $client->code = $request->code;
            }
            $client->save();

            return redirect('/AddClient');
        }
    }

    public function PageActionClient()
    {
        $titre = 'ActionClient';
        $questions = DB::table('question')
            ->select('question.id', 'question.question', 'reponse.reponse', 'reponse.valeur')
            ->join('reponse', 'question.id', '=', 'reponse.idquest')
            ->orderBy('question.id')
            ->orderBy('reponse.valeur')
            ->get();

        $groupedQuestions = [];

        foreach ($questions as $questionItem) {
            $questionId = $questionItem->id;

            if (!isset($groupedQuestions[$questionId])) {
                $groupedQuestions[$questionId] = [
                    'question' => $questionItem->question,
                    'reponses' => [],
                    'valeurs' => [],
                ];
            }

            $groupedQuestions[$questionId]['reponses'][] = [
                'reponse' => $questionItem->reponse,
                'valeur' => $questionItem->valeur,
            ];
        }

        return view('User/AjoutAction', compact('titre', 'groupedQuestions'));
    }

    public function AddActionClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idclient' => 'required',
            'idservice' => 'required',
            'idemploye' => 'required',
            'idsalon' => 'required',
        ], [
            'idclient.required' => 'Le champ Nom Client est requis.',
            'idservice.required' => 'Le champ Service est requis.',
            'idemploye.required' => 'Le champ Employé est requis.',
            'idsalon.required' => 'Le champ Salon est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $clientDetails = new ClientDetails();
            $clientDetails->idclient = $request->idclient;
            $clientDetails->idservice = $request->idservice;
            $clientDetails->idemploye = $request->idemploye;
            $clientDetails->idsalon = $request->idsalon;
            $clientDetails->save();

            $reponsesSelectionnees = $request->all();

            foreach ($reponsesSelectionnees as $name => $value) {
                $parts = explode('_', $name);

                if (count($parts) == 2 && $parts[0] == 'question') {
                    $idquestion = $parts[1];

                    DB::table('reponseclient')->insert([
                        'idclient' => $request->idclient,
                        'idquestion' => $idquestion,
                        'reponse' => $value,
                        'idsalon' => $request->idsalon,
                    ]);
                }
            }

            DB::commit();

            return redirect('/AddClient');
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function PageActionInfluenceur()
    {
        $titre = 'ActionInfluenceur';
        return view('User/AjoutAction', compact('titre'));
    }

    public function AddActionInfluenceur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idinfluenceur' => 'required',
            'idservice' => 'required',
            'idemploye' => 'required',
            'idsalon' => 'required',
        ], [
            'idinfluenceur.required' => 'Le champ Nom est requis.',
            'idservice.required' => 'Le champ Service est requis.',
            'idemploye.required' => 'Le champ Employé est requis.',
            'idsalon.required' => 'Le champ Salon est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $Influenceur = new InfluenceurPrestataire();
            $Influenceur->idinfluenceur = $request->idinfluenceur;
            $Influenceur->idservice = $request->idservice;
            $Influenceur->idemploye = $request->idemploye;
            $Influenceur->idsalon = $request->idsalon;
            $Influenceur->save();

            return redirect('/AddClient');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        $results = Client::where('nom', 'LIKE', '%' . $term . '%')
            ->orWhere('prenom', 'LIKE', '%' . $term . '%')
            ->distinct('nom', 'prenom')
            ->get();

        return response()->json($results);
    }

    public function autocompleteService(Request $request)
    {
        $term = $request->input('term');
        $results = Service::where('nom', 'LIKE', '%' . $term . '%')
            ->get();

        return response()->json($results);
    }

    public function autocompleteEmploye(Request $request)
    {
        $term = $request->input('term');
        $results = Employe::where('nom', 'LIKE', '%' . $term . '%')
            ->orWhere('prenom', 'LIKE', '%' . $term . '%')
            ->distinct('nom', 'prenom')
            ->get();

        return response()->json($results);
    }

    public function autocompleteInfluenceur(Request $request)
    {
        $term = $request->input('term');
        $results = Influenceur::where('nom', 'LIKE', '%' . $term . '%')
            ->orWhere('prenom', 'LIKE', '%' . $term . '%')
            ->distinct('nom', 'prenom')
            ->get();

        return response()->json($results);
    }

    public function ListInfluenceur()
    {
        $titre = "influenceur";
        $resultats = DB::table('v_influenceurreseaux')->get();
        return view('User/Details', compact('titre', 'resultats'));
    }

    public function DetailsInfluenceur($id)
    {
        $titre = "Detailinfluenceur";
        $reseaux = DB::select('select r.nom,followers from influenceurreseauxsociaux JOIN ReseauxSociaux r on influenceurreseauxsociaux.idreseauxsociaux=r.id where idinfluenceur=' . $id . ' order by idreseauxsociaux');
        $details = InfluenceurDetails::where('idinfluenceur', $id)->orderBy('idreseauxsociaux')->orderBy('inserted', 'desc')->get();
        $detailsByReseau = $details->groupBy('idreseauxsociaux');
        return view('User/Details', compact('titre', 'detailsByReseau', 'id', 'reseaux'));
    }

    public function UpdateDetailinfluenceur($id)
    {
        $titre = "UpdateInfluenceur";
        $Influenceur = InfluenceurDetails::where('id', $id)->first();
        $reseaux = ReseauxSociaux::all();
        return view('User/Details', compact('titre', 'Influenceur', 'reseaux'));
    }

    public function UpdateDetailinfluenceurValid(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'idreseau' => 'required',
            'lien' => 'required',
            'like' => 'required',
            'commentaire' => 'required',
            'daty' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'idreseau.required' => 'Le champ Reseau est requis.',
            'lien.required' => 'Le champ Lien est requis.',
            'like.required' => 'Le champ Mention est requis.',
            'commentaire.required' => 'Le champ Commentaire est requis.',
            'daty.required' => 'Le champ Date est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $Influenceur = InfluenceurDetails::find($request->id);
            $Influenceur->idreseauxsociaux = $request->idreseau;
            $Influenceur->lien = $request->lien;
            $Influenceur->likes = $request->like;
            $Influenceur->comments = $request->commentaire;
            $Influenceur->inserted = $request->daty;
            $Influenceur->update();

            return redirect('/InfluenceurDetails/' . $Influenceur->idinfluenceur);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function PageAddPublication($id)
    {
        $titre = "AddPublication";
        $reseaux = ReseauxSociaux::all();
        return view('User/Details', compact('titre', 'reseaux', 'id'));
    }

    public function AddPublication(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'idreseau' => 'required',
            'lien' => 'required',
            'like' => 'required',
            'commentaire' => 'required',
            'daty' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'idreseau.required' => 'Le champ Reseau est requis.',
            'lien.required' => 'Le champ Lien est requis.',
            'like.required' => 'Le champ Mention est requis.',
            'commentaire.required' => 'Le champ Commentaire est requis.',
            'daty.required' => 'Le champ Date est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $Influenceur = new InfluenceurDetails;
            $Influenceur->idinfluenceur = $request->id;
            $Influenceur->idreseauxsociaux = $request->idreseau;
            $Influenceur->lien = $request->lien;
            $Influenceur->likes = $request->like;
            $Influenceur->comments = $request->commentaire;
            $Influenceur->inserted = $request->daty;
            $Influenceur->save();

            return redirect('/InfluenceurDetails/' . $request->id);
        } catch (\Exception $e) {
            return $e;
        }
    }


    public function UpdateReseauxInfluenceur($id)
    {
        $titre = "UpdateReseauxInfluenceur";
        $reseaux = DB::select('select r.nom,idreseauxsociaux,followers from influenceurreseauxsociaux JOIN ReseauxSociaux r on influenceurreseauxsociaux.idreseauxsociaux=r.id where idinfluenceur=' . $id . ' order by idreseauxsociaux');
        return view('User/Details', compact('titre', 'reseaux', 'id'));
    }

    public function UpdateReseauxInfluenceurValid(Request $request)
    {
        try {
            $data = $request->input('followers');

            foreach ($data as $reseauId => $followers) {
                $reseau = DB::table('influenceurreseauxsociaux')->where('idinfluenceur', $request->id)->where('idreseauxsociaux', $reseauId)->first();
                if ($reseau) {
                    DB::select('update influenceurreseauxsociaux set followers = ' . $followers . ' where idinfluenceur = ' . $request->id . ' and idreseauxsociaux = ' . $reseauId);
                }
            }

            return redirect('/InfluenceurDetails/' . $request->id);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function PageAddInfluenceur()
    {
        $titre = "AddInfluenceur";
        $reseaux = ReseauxSociaux::all();
        return view('User/Details', compact('titre', 'reseaux'));
    }

    public function AddInfluenceur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'email' => 'required',
            'code' => 'required',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'code.required' => 'Le champ code est requis.',
            'email.required' => 'Le champ email est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            DB::beginTransaction();

            $Influenceur = new Influenceur();
            $Influenceur->nom = $request->nom;
            $Influenceur->email = $request->email;
            $Influenceur->code = $request->code;
            $Influenceur->save();

            $id = $Influenceur->id;

            $data = $request->input('followers');

            foreach ($data as $reseauId => $followers) {
                DB::select('insert into influenceurreseauxsociaux(idinfluenceur,idreseauxsociaux,followers) values (' . $id . ',' . $reseauId . ',' . $followers . ')');
            }

            DB::commit();

            return redirect('/UserListInfluenceur');
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function DeleteDetailinfluenceur($id)
    {
        $Influenceur = InfluenceurDetails::find($id);
        $Influenceur->delete();

        return redirect()->back();
    }
}

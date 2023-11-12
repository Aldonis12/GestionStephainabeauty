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

    public function checkClientCode(Request $request)
    {
        $code = $request->input('code');

        $client = Client::where('code_qr', $code)->first();

        if ($client) {
            $clientDetails = [
                'nom' => $client->nom,
                'prenom' => $client->prenom,
            ];

            $serviceDetails = DB::table('clientdetails')
                ->join('service', 'clientdetails.idservice', '=', 'service.id')
                ->select('service.nom', DB::raw('COUNT(*) as nombre'))
                ->where('clientdetails.idclient', $client->id)
                ->groupBy('service.nom')
                ->get();

            return response()->json(['exists' => true, 'clientDetails' => $clientDetails, 'serviceDetails' => $serviceDetails]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function UpdateClientCode()
    {
        $titre = 'Update Code';
        return view('User/AjoutAction', compact('titre'));
    }


    public function UpdateClientCodeValid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idclient' => 'required',
            'code_qr' => ['required', 'regex:/^CLI-/'],
        ], [
            'idclient.required' => 'Le champ idclient est requis.',
            'code_qr.required' => 'Le champ code_qr est requis.',
            'code_qr.regex' => 'Le champ code_qr doit commencer par "CLI-".',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = Client::find($request->idclient);
        $client->code_qr = $request->code_qr;
        $client->update();

        return redirect('/AddClient');
    }

    public function ScannerCodeClient()
    {
        $titre = 'Scanner Code';
        return view('User/AjoutAction', compact('titre'));
    }


    public function PageAddClient()
    {
        $genres = Genre::orderBy('id', 'DESC')->get();
        $codes = Influenceur::select('id', 'code')->get();
        return view('User/ajout', compact('genres', 'codes'));
    }

    public function AddClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'required|integer|min:0',
            'adresse' => 'required',
            'code_qr' => 'required',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'genre.required' => 'Le champ genre est requis.',
            'genre.integer' => 'Le champ genre est requis.',
            'idgenre.min' => 'Le champ genre doit être réel et positif.',
            'adresse.required' => 'Le champ adresse est requis.',
            'code_qr.required' => 'Le champ Code QR est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = Client::whereRaw('LOWER(nom) = ? AND LOWER(prenom) = ?', [strtolower($request->nom), strtolower($request->prenom)])->first();

        $clientCode = Client::where('code_qr', $request->code_qr)->first();

        /*$number = mt_rand(1000000000, 9999999999);

        if ($this->QrcodeExist($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }*/

        if ($clientCode) {
            return redirect()->back()->withInput()->with('message', 'Ce code QR est déjà utilisé, Veuillez utiliser un autre code.');
        }

        if ($client) {
            return redirect()->back()->withInput()->with('message', 'Veuillez ajouter un initial sur votre prenom pour eviter le conflit avec un autre client : ' . $client->nom . ' ' . $client->prenom . '.');
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
            if ($request->code > 0) {
                $client->code = $request->code;
            }
            $client->code_qr = $request->code_qr;
            $client->save();

            return redirect('/AddClient');
        }
    }

    /*public function QrcodeExist($number)
    {
        return Client::where('qr_code', $number)->exists();
    }*/


    public function AddAPIClient(Request $request)
    {
        $client = DB::table('client')
            ->select('id')
            ->where('nom', $request->nom)
            ->where('prenom', $request->prenom)
            ->where('date_naissance', $request->date_naissance)
            ->first();

        if ($client) {
            return response()->json('Ce client est déjà enregistré.');
        } else {
            $client = new Client();
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->date_naissance = $request->date_naissance;
            $client->idgenre = $request->genre;
            $client->save();
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
            'idservice' => 'array|required',
            'idemploye' => 'array|required',
            'idsalon' => 'required',
            'prix' => 'array|required',
        ], [
            'idclient.required' => 'Le champ Nom Client est requis.',
            'idservice.required' => 'Le champ Service est requis.',
            'idemploye.required' => 'Le champ Employé est requis.',
            'idsalon.required' => 'Le champ Salon est requis.',
            'prix.required' => 'Le champ Prix est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = Client::where('code_qr', $request->idclient)->first();

        if (!$id) {
            return redirect()->back()->with('message', 'Ce code n\'existe pas dans la base!');
        }

        try {
            DB::beginTransaction();

            $idservices = $request->idservice;
            $idemployes = $request->idemploye;
            $prix = $request->prix;

            foreach (range(0, count($idservices) - 1) as $index) {
                $clientDetails = new ClientDetails();
                $clientDetails->idclient = $id->id;
                $clientDetails->idservice = $idservices[$index];
                $clientDetails->idemploye = $idemployes[$index];
                $clientDetails->idsalon = $request->idsalon;
                $clientDetails->prix = $prix[$index];
                $clientDetails->save();
            }

            $reponsesSelectionnees = $request->all();

            foreach ($reponsesSelectionnees as $name => $value) {
                $parts = explode('_', $name);

                if (count($parts) == 2 && $parts[0] == 'question') {
                    $idquestion = $parts[1];

                    DB::table('reponseclient')->insert([
                        'idclient' => $id->id,
                        'idquestion' => $idquestion,
                        'reponse' => $value,
                        'idsalon' => $request->idsalon,
                    ]);
                }
            }

            DB::commit();

            $servicesDetails = DB::table('clientdetails')
                ->join('service', 'clientdetails.idservice', '=', 'service.id')
                ->select('service.nom', DB::raw('COUNT(*) as nombre'))
                ->where('clientdetails.idclient', $id->id)
                ->groupBy('service.id', 'service.nom')
                ->get();

            $nombrePrestations = 0;

            foreach ($servicesDetails as $service) {
                $nombrePrestations += $service->nombre;

                if ($nombrePrestations % 10 == 0) {
                    $servicesGratuitsDizeine = session()->put('servicesGratuitsDizeine', []);
                    $servicesGratuitsDizeine[] = $service->nom;
                    session()->put(['servicesGratuitsDizeine' => $servicesGratuitsDizeine]);
                    return redirect('/AddActionClient');
                }
            }

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
            'idservice' => 'array|required', // Changement : 'idservice' doit être un tableau
            'idemploye' => 'array|required',
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
            $idservices = $request->idservice;
            $idemployes = $request->idemploye;

            foreach (range(0, count($idservices) - 1) as $index) {
                $Influenceur = new InfluenceurPrestataire();
                $Influenceur->idinfluenceur = $request->idinfluenceur;
                $Influenceur->idservice = $idservices[$index];
                $Influenceur->idemploye  = $idemployes[$index];
                $Influenceur->idsalon = $request->idsalon;
                $Influenceur->save();
            }
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
            ->where('issalon', 1)
            ->get();

        return response()->json($results);
    }

    public function autocompleteEmploye(Request $request)
    {
        $term = $request->input('term');
        $results = DB::table('employe')
            ->join('employeservice', 'employe.id', '=', 'employeservice.idemploye')
            ->join('service', 'employeservice.idservice', '=', 'service.id')
            ->where('service.idtypes', 1)
            ->where(function ($query) use ($term) {
                $query->where('employe.nom', 'LIKE', '%' . $term . '%')
                    ->orWhere('employe.prenom', 'LIKE', '%' . $term . '%');
            })
            ->distinct()
            ->get(['employe.*']);

        return response()->json($results);
    }

    public function autocompleteInfluenceur(Request $request)
    {
        $term = $request->input('term');
        $results = Influenceur::where('nom', 'LIKE', '%' . $term . '%')
            ->distinct('nom')
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

    public function clearSession()
{
    session()->forget('servicesGratuitsDizeine');
    return response()->json(['success' => true]);
}
}

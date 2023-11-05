<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\clientfidele;
use App\Models\Employe;
use App\Models\Genre;
use App\Models\Influenceur;
use App\Models\Question;
use App\Models\Salon;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function ListSalon()
    {
        $titre = "salon";
        $salons = Salon::all();
        return view('Admin/liste', compact('titre', 'salons'));
    }

    public function ListService()
    {
        $titre = "service";
        $services = Service::OrderBy('idtypes')->paginate(10);
        return view('Admin/liste', compact('titre', 'services'));
    }

    public function ListEmploye()
    {
        session()->forget('search_values');
        $titre = "employe";
        $employes = Employe::orderBy('id')->paginate(20);
        $genres = Genre::all();
        return view('Admin/liste', compact('titre', 'employes', 'genres'));
    }

    public function ListClient()
    {
        session()->forget('search_values_client');
        $titre = "client";
        $genres = Genre::all();
        $clients = Client::orderBy('inserted', 'desc')->paginate(10);
        return view('Admin/liste', compact('titre', 'clients', 'genres'));
    }

    public function ListClientCode()
    {
        $titre = "client code";
        $clientcode = DB::table('v_listclientcode')->get();
        return view('Admin/liste', compact('titre', 'clientcode'));
    }

    public function ListClientByCode($id)
    {
        $titre = "clientbycode";
        $code = Influenceur::where('id', $id)->value('code');
        $clients = Client::where('code',$id)->orderBy('inserted', 'desc')->paginate(10);
        return view('Admin/liste', compact('titre', 'clients','code'));
    }


    public function ListClientFidele()
    {
        $titre = "clientFidele";
        
        $clients = ClientFidele::where('annee', Carbon::now()->year)
            ->where('mois', Carbon::now()->month)
            ->where('visite','>', 1)
            ->paginate(10);

        return view('Admin/liste', compact('titre', 'clients'));
    }

    public function listClientBySalon(Request $request)
    {
        $titre = "Clients par Salon";
        
        $Daty = $request->input('daty',date('Y-m-d'));

        $clients = DB::table('clientdetails')
            ->select('salon.id as salon_id', 'salon.nom as nom_du_salon', 'client.id as client_id', 'client.nom as nom_du_client', 'client.prenom as prenom_du_client', 'client.numero')
            ->join('salon', 'clientdetails.idsalon', '=', 'salon.id')
            ->join('client', 'clientdetails.idclient', '=', 'client.id')
            ->whereDate('clientdetails.inserted', '=', $Daty)
            ->get();

            $clientsGroupedBySalon = $clients->groupBy('salon_id');

            return view('Admin.liste', compact('titre', 'clientsGroupedBySalon'));
    }

    public function ListInfluenceur()
    {
        session()->forget('search_values_influenceur');
        $titre = "influenceur";
        $influenceurs = Influenceur::orderBy('id')->paginate(10);
        $genres = Genre::all();
        return view('Admin/liste', compact('titre', 'influenceurs', 'genres'));
    }

    public function ListInfluenceurReseaux()
    {
        $titre = "influenceurReseaux";
        $resultats = DB::table('v_influenceurreseaux')->get();
        return view('Admin/liste', compact('titre', 'resultats'));
    }

    public function ListQuestion()
    {
        $titre = "question";
        $questions = DB::table('question')
            ->select('question.id', 'question.question', 'reponse.reponse')
            ->join('reponse', 'question.id', '=', 'reponse.idquest')
            ->orderBy('question.id')
            ->orderBy('reponse.valeur')
            ->get();
        return view('Admin/liste', compact('titre', 'questions'));
    }

    public function exportCSV(Request $request)
    {
        $searchValues = session('search_values', []);

        $query = Employe::query();

        if (!empty($searchValues['nom']) || !empty($searchValues['genre']) || !empty($searchValues['disponibilite']) || !empty($searchValues['stagiaire'])) {
            if (!empty($searchValues['nom'])) {
                $query->where('nom', 'LIKE', '%' . $searchValues['nom'] . '%')
                    ->orWhere('prenom', 'LIKE', '%' . $searchValues['nom'] . '%');
            }

            /*if (!empty($searchValues['age'])) {
                $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $searchValues['age']);
            }*/

            if (!empty($searchValues['genre'])) {
                $query->where('idgenre', $searchValues['genre']);
            }

            if (isset($searchValues['disponibilite'])) {
                if ($searchValues['disponibilite'] == null) {
                    $query->where('iscanceled', 0);
                } elseif ($searchValues['disponibilite'] < 2) {
                    $query->where('iscanceled', $searchValues['disponibilite']);
                }
            }

            if (isset($searchValues['stagiaire'])) {
                if ($searchValues['stagiaire'] == null) {
                    $query->where('isinternship', 0);
                } elseif ($searchValues['stagiaire'] < 2) {
                    $query->where('isinternship', $searchValues['stagiaire']);
                }
            }

            $data = $query->get();
        } else {
            $data = Employe::all();
        }

        //dd($query->toSql(), $query->getBindings());

        $filename = 'export_employes.csv';

        $handle = fopen($filename, 'w');

        $headers = ['Nom', 'Prenom', 'Genre'];
        fputcsv($handle, $headers, ';');

        foreach ($data as $row) {
            $genre = $row->genre->nom;
            
            $row_data = [
                ucfirst($row->nom),
                $row->prenom,
                $genre,
            ];
            fputcsv($handle, $row_data, ';');
        }

        fclose($handle);

        session(['search_values' => $searchValues]);
        session()->forget('search_values');

        return response()->download($filename)->deleteFileAfterSend(true);
    }


    public function exportCSVclient(Request $request)
    {
        $searchValues = session('search_values_client', []);

        $query = Client::query();

        if (!empty($searchValues['nom']) || !empty($searchValues['age']) || !empty($searchValues['genre']) || !empty($searchValues['adresse'])) {
            if (!empty($searchValues['nom'])) {
                $query->where('nom', 'LIKE', '%' . $searchValues['nom'] . '%')
                    ->orWhere('prenom', 'LIKE', '%' . $searchValues['nom'] . '%');
            }

            if (!empty($searchValues['age'])) {
                $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $searchValues['age']);
            }

            if (!empty($searchValues['genre'])) {
                $query->where('idgenre', $searchValues['genre']);
            }

            if (!empty($searchValues['adresse'])) {
                $query->where('adresse', 'LIKE', '%' . $request->adresse . '%');
            }

            $data = $query->get();
        } else {
            $data = Client::all();
        }

        $filename = 'export_client.csv';

        $handle = fopen($filename, 'w');

        $headers = ['Nom', 'Prenom', 'Date de naissance', 'Genre', 'Numero', 'Email','Profession'];
        fputcsv($handle, $headers, ';');

        foreach ($data as $row) {
            $dateNaissance = Carbon::parse($row->date_naissance)->format('d/m/Y');
            $genre = $row->genre->nom;
            $numero = $row->numero;
            $email = $row->email;

            $row_data = [
                ucfirst($row->nom),
                $row->prenom,
                $dateNaissance,
                $genre,
                $numero,
                $email,
                $row->profession,
            ];
            fputcsv($handle, $row_data, ';');
        }

        fclose($handle);

        session(['search_values_client' => $searchValues]);
        session()->forget('search_values_client');

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportCSVInfluenceur(Request $request)
    {
        $searchValues = session('search_values_influenceur', []);

        $query = Influenceur::query();

        if (!empty($searchValues['nom']) || !empty($searchValues['age']) || !empty($searchValues['genre'])) {
            if (!empty($searchValues['nom'])) {
                $query->where('nom', 'LIKE', '%' . $searchValues['nom'] . '%')
                    ->orWhere('prenom', 'LIKE', '%' . $searchValues['nom'] . '%');
            }

            if (!empty($searchValues['age'])) {
                $query->whereRaw('EXTRACT(YEAR FROM AGE(date_naissance)) = ?', $searchValues['age']);
            }

            if (!empty($searchValues['genre'])) {
                $query->where('idgenre', $searchValues['genre']);
            }

            $data = $query->get();
        } else {
            $data = Influenceur::all();
        }

        $filename = 'export_influenceur.csv';

        $handle = fopen($filename, 'w');

        $headers = ['Nom', 'Prenom', 'Date de naissance', 'Genre', 'Numero', 'Email'];
        fputcsv($handle, $headers, ';');

        foreach ($data as $row) {
            $dateNaissance = Carbon::parse($row->date_naissance)->format('d/m/Y');
            $genre = $row->genre->nom;
            $numero = $row->numero;
            $email = $row->email;

            $row_data = [
                ucfirst($row->nom),
                $row->prenom,
                $dateNaissance,
                $genre,
                $numero,
                $email,
            ];
            fputcsv($handle, $row_data, ';');
        }

        fclose($handle);

        session(['search_values_influenceur' => $searchValues]);
        session()->forget('search_values_influenceur');

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}

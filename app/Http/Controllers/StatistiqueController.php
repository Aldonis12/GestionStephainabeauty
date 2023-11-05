<?php

namespace App\Http\Controllers;

use App\Models\Influenceur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Utils\FonctionDashboard;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function exportChart(Request $request)
    {
        $canvasId = 'nombreclient-chart';
        $dataUrl = $request->input('dataUrl');

        if ($dataUrl && $canvasId === $request->input('canvasId')) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataUrl));

            $filename = 'chart.png';
            $path = 'charts/' . $filename;

            Storage::disk('public')->put($path, $imageData);

            $filePath = storage_path("app/public/$path");

            return response()->file($filePath, ['Content-Disposition' => "attachment; filename=$filename"]);
        }

        return response()->json(['error' => 'ID de canvas incorrect'], 400);
    }


    public function StatistiqueSalonClient(Request $request)
    {
        $titre = "salon";
        $salons = Salon::pluck('id');
        $fonction = new FonctionDashboard();

        $selectedYear = $request->input('annee', date('Y'));

        $salonData = [];
        $reponseData = [];

        foreach ($salons as $salonID) {
            $moisClients = DB::select("SELECT EXTRACT(MONTH FROM inserted) AS mois, COUNT(*) AS nombre_de_clients FROM ClientDetails WHERE EXTRACT(year FROM inserted) = ? AND idsalon = ? GROUP BY mois ORDER BY mois", [$selectedYear, $salonID]);
            $labelsClients = [];
            $dataClients = [];

            foreach ($moisClients as $moisData) {
                $date = Carbon::create(null, $moisData->mois, null);
                $moisLettres = $date->formatLocalized('%B');
                $labelsClients[] = $moisLettres;
                $dataClients[] = $moisData->nombre_de_clients;
            }

            $salonData[$salonID] = [
                'labels' => $labelsClients,
                'data' => $dataClients,
            ];

            $reponseClients = DB::select("SELECT EXTRACT(MONTH FROM inserted) AS mois, SUM(CASE WHEN reponse = 1 THEN 1 ELSE 0 END) AS reponse_1, SUM(CASE WHEN reponse = 2 THEN 1 ELSE 0 END) AS reponse_2, SUM(CASE WHEN reponse = 3 THEN 1 ELSE 0 END) AS reponse_3 FROM reponseclient WHERE EXTRACT(year FROM inserted) = ? AND idsalon = ? GROUP BY mois ORDER BY mois", [$selectedYear, $salonID]);

            $reponseMois = [];
            $reponseBien = [];
            $reponseMoyen = [];
            $reponseMauvais = [];

            foreach ($reponseClients as $reponseCli) {
                $date = Carbon::create(null, $reponseCli->mois, null);
                $moisLettres = $date->formatLocalized('%B');
                $reponseMois[] = $moisLettres;
                $reponseBien[] = $reponseCli->reponse_1;
                $reponseMoyen[] = $reponseCli->reponse_2;
                $reponseMauvais[] = $reponseCli->reponse_3;
            }

            $reponseData[$salonID] = [
                'labels' => $reponseMois,
                'databien' => $reponseBien,
                'datamoyen' => $reponseMoyen,
                'datamauvais' => $reponseMauvais,
            ];
        }

        return view('Admin/statistique', compact('titre', 'salons', 'salonData', 'reponseData', 'selectedYear'));
    }

    public function StatistiqueDashboard(Request $request)
    {
        $selectedYear = $request->input('annee', date('Y'));

        $mois = DB::table('v_dashclientmensuel')->where('annee', $selectedYear)->get();
        $labels = [];
        $data = [];

        foreach ($mois as $moisData) {
            $date = Carbon::create(null, $moisData->mois, null);
            $moisLettres = $date->formatLocalized('%B');
            $labels[] = $moisLettres;
            $data[] = $moisData->nombre_de_clients;
        }

        $salonsData = [];
        $salonIds = DB::table('salon')->pluck('id');
        $salonName = DB::table('salon')->pluck('nom');

        foreach ($salonIds as $salonId) {
            $salonsemaine = DB::select("SELECT nom, nombre FROM v_salonsemaine WHERE idsalon={$salonId} AND EXTRACT(week FROM current_date) = semaine AND EXTRACT(year FROM current_date) = annee ORDER BY nombre DESC LIMIT 3");

            $labelsalon = [];
            $datasalon = [];

            foreach ($salonsemaine as $salonsemaines) {
                $labelsalon[] = $salonsemaines->nom;
                $datasalon[] = $salonsemaines->nombre;
            }

            $salonsData[$salonId] = [
                'labels' => $labelsalon,
                'data' => $datasalon,
            ];
        }

        $reponseclient = DB::table('v_dashreponseclientmensuel')->where('annee', $selectedYear)->get();

        $reponsemois = [];
        $reponsebien = [];
        $reponsemoyen = [];
        $reponsemauvais = [];

        foreach ($reponseclient as $reponsecli) {
            $date = Carbon::create(null, $reponsecli->mois, null);
            $moisLettres = $date->formatLocalized('%B');
            $reponsemois[] = $moisLettres;
            $reponsebien[] = $reponsecli->reponse_1;
            $reponsemoyen[] = $reponsecli->reponse_2;
            $reponsemauvais[] = $reponsecli->reponse_3;
        }

        return view('Admin/dashboard', compact('labels','data','salonsData','salonIds','salonName','reponsemois','reponsebien','reponsemoyen','reponsemauvais','selectedYear'));
    }

    /*public function StatistiqueSalonService(Request $request)
    {
        $titre = "service";
        $salons = Salon::pluck('id');
        $fonction = new FonctionDashboard();

        $selectedYear = $request->input('annee', date('Y'));

        $DataService = [];

        $couleurs = [
            '#FF5733', '#33FF57', '#5733FF', '#FFFF33',
            '#33FFFF', '#FF33FF', '#FF5733', '#33FF57',
            '#5733FF', '#FFFF33', '#33FFFF', '#FF33FF',
        ];
        
        shuffle($couleurs);

        foreach ($salons as $salonID) {
            
            $Service = DB::select("SELECT EXTRACT(MONTH FROM inserted) AS mois,idservice, COUNT(*) AS nombre FROM ClientDetails WHERE EXTRACT(year FROM inserted) = ? AND idsalon = ?  GROUP BY mois,idservice ORDER BY mois", [$selectedYear, $salonID]);

            $labelsService = [];
            $nomService = [];
            $dataService = [];

            foreach ($Service as $moisData) {
                $date = Carbon::create(null, $moisData->mois, null);
                $moisLettres = $date->formatLocalized('%B');
                $labelsService[] = $moisLettres;
                $nomService[] = $moisData->idservice;
                $dataService[] = $moisData->nombre;
            }

            $DataService[$salonID] = [
                'labels' => $labelsService,
                'nom' => $nomService,
                'data' => $dataService,
                'couleur' => array_shift($couleurs),
            ];
        }
        return view('Admin/statistique', compact('titre', 'salons', 'DataService', 'selectedYear'));
    }*/

    public function StatistiqueCodeClient(Request $request)
    {
        $titre = "influenceur";
        $influenceur = Influenceur::pluck('id');
        $fonction = new FonctionDashboard();

        $selectedYear = $request->input('annee', date('Y'));

        $influenceurData = [];

        foreach ($influenceur as $influenceurID) {
            $moisClients = DB::select("SELECT EXTRACT(MONTH FROM inserted) AS mois, COUNT(*) AS nombre_de_clients FROM Client WHERE EXTRACT(year FROM inserted) = ? AND code = ? GROUP BY mois ORDER BY mois", [$selectedYear, $influenceurID]);
            $labelsClients = [];
            $dataClients = [];

            foreach ($moisClients as $moisData) {
                $date = Carbon::create(null, $moisData->mois, null);
                $moisLettres = $date->formatLocalized('%B');
                $labelsClients[] = $moisLettres;
                $dataClients[] = $moisData->nombre_de_clients;
            }

            $influenceurData[$influenceurID] = [
                'labels' => $labelsClients,
                'data' => $dataClients,
            ];
        }

        return view('Admin/statistique', compact('titre', 'influenceur', 'influenceurData', 'selectedYear'));
    }
}

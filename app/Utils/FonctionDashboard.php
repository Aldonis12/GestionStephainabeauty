<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

class FonctionDashboard
{

    public function Pourcentage($nom)
    {
        $i = DB::table('salon')->where('nom', $nom)->value('id');
        if ($nom == "") {
            $newValueQuery = DB::select("SELECT COUNT(*) AS client FROM ClientDetails WHERE DATE(inserted) = CURRENT_DATE")[0]->client;
            $previousDateQuery = DB::select("SELECT COUNT(*) AS client FROM ClientDetails WHERE DATE(inserted) = (SELECT MAX(DATE(inserted)) FROM ClientDetails WHERE DATE(inserted) < CURRENT_DATE)")[0]->client;
        } else {
            $newValueQuery = DB::select("SELECT COUNT(*) AS client FROM ClientDetails WHERE DATE(inserted) = CURRENT_DATE AND idsalon=" . $i)[0]->client;
            $previousDateQuery = DB::select("SELECT COUNT(*) AS client FROM ClientDetails WHERE DATE(inserted) = (SELECT MAX(DATE(inserted)) FROM ClientDetails WHERE DATE(inserted) < CURRENT_DATE) AND idsalon=" . $i)[0]->client;
        }
        if ($previousDateQuery > 0) {
            $percentageChange = (($newValueQuery - $previousDateQuery) / $previousDateQuery) * 100;
        } else {
            $percentageChange = 0;
        }
        if ($previousDateQuery - $newValueQuery == 1) {
            if ($percentageChange == 0) {
                return '';
            } else {
                return round($percentageChange, 2) . '% par rapport à hier';
            }
        } else if ($previousDateQuery - $newValueQuery == 0) {
            return '';
        } else if ($previousDateQuery - $newValueQuery > 1) {
            return round($percentageChange, 2) . '% par rapport à la dernière fois';
        }
    }

    public function generateClientDetails()
    {
        $html = '';
        $salon = DB::select("SELECT salon.nom , COUNT(*) AS client FROM clientdetails  JOIN salon ON clientdetails.idsalon = salon.id WHERE DATE(inserted) = CURRENT_DATE GROUP BY salon.nom");

        $classes = ['card-dark-blue', 'card-light-blue', 'card-tale','card-light-warning'];
        shuffle($classes);
        $totalClients = 0;

        foreach ($salon as $salons) {
            $class = array_shift($classes);
            $html .= $this->DetailsClient($salons->nom, $salons->client, $this->Pourcentage($salons->nom), $class);
            $totalClients += $salons->client;
        }
        $html .= $this->DetailsClient('Nombre de clients d\'aujourd\'hui', $totalClients, $this->Pourcentage(""), 'card-light-danger');
        return $html;
    }

    public function DetailsClient($nom, $valeur, $pourcentage, $classeCarte)
    {
        return '<div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card ' . $classeCarte . '">
                    <div class="card-body">
                      <p class="mb-4" id="card-' . $nom . '">' . ucfirst($nom) . '</p>
                      <p class="fs-30 mb-2">' . $valeur . '</p>
                      <p>' . $pourcentage . '</p>
                    </div>
                  </div>
                </div>';
    }

    public function generateSalonDetails()
    {
        $vDashcarouselData = DB::table('v_dashcarousel')->get();
        $salonsFromDatabase = DB::table('salon')->select('id', 'nom', 'adresse')->get();

        $salons = [];

        foreach ($salonsFromDatabase as $index => $salon) {
            $servicesFromDatabase = $vDashcarouselData->where('salon_id', $salon->id);

            $services = $servicesFromDatabase->map(function ($service) {
                return [
                    'nom' => $service->service_nom,
                    'nombre' => $service->nombre_emp,
                ];
            });

            $salons[] = [
                'active' => $index === 0 ? 'active' : '',
                'id' => $salon->id,
                'nom' => strtoupper($salon->nom),
                'adresse' => $salon->adresse,
                'services' => $services->toArray(),
            ];
        }
        $html = '';

        $html_first = '<div class="col-md-12 grid-margin stretch-card">
        <div class="card position-relative">
          <div class="card-body">
            <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
              <div class="carousel-inner">';


        foreach ($salons as $salon) {
            $html .= $this->DetailsSalon(
                $salon['active'],
                $salon['id'],
                $salon['nom'],
                $salon['adresse'],
                $salon['services']
            );
        }

        $html_second = '</div>
                <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>';

        return $html_first . $html . $html_second;
    }

    public function DetailsSalon($active, $id, $nom, $adresse, $services)
    {

        $html = '<div class="carousel-item ' . $active . '">
            <div class="row">
              <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                <div class="ml-xl-4 mt-3">
                <p class="card-title">Stephaina Beauty</p>
                  <h3 class="font-weight-500 mb-xl-4 text-primary">' . $nom . '</h3>
                  <p class="mb-2 mb-xl-0">' . $adresse . '</p>
                </div>  
                </div>
              <div class="col-md-12 col-xl-9">
                <div class="row">
                  <div class="col-md-6 border-right">
                    <div class="table-responsive mb-3 mb-md-0 mt-3">
                      <table class="table table-borderless report-table">';

        foreach ($services as $service) {
            $html .= '<tr>
                                        <td class="text-muted">' . $service['nom'] . '</td>
                                        <td><h5 class="font-weight-bold mb-0">' . $service['nombre'] . '</h5></td>
                                        </tr>';
        }
        $html .= '</table>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p>Les meilleures services de la semaine : </p>
                            <canvas id="donut-' . $id . '"></canvas>
                            <div id="legend-' . $id . '"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>';
        return $html;
    }

    public function StatistiqueClient()
    {
        return '<div id="nombreclient" class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Nombre de client</p>
                    <button id="export-chart-btn" class="btn btn-outline-info btn-icon-text"><i class="ti-upload btn-icon-prepend"> Exporter en png</i></button>
                </div>
                <div id="nombreclient-legend" class="chartjs-legend"></div>
                <canvas id="nombreclient-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Avis Client</p>
                </div>
                <div id="avisclient-legend" class="chartjs-legend"></div>
                <canvas id="avisclient-chart"></canvas>
            </div>
        </div>
    </div>';
    }

    public function StatistiqueClientSalon($id, $salon)
    {
        return '<div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Nombre de client <strong>' . $salon . '</strong></p>
                </div>
                <div id="nombreclient-legend-' . $id . '" class="chartjs-legend"></div>
                <canvas id="nombreclient-chart-' . $id . '"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Avis Client <strong>' . $salon . '</strong></p>
                </div>
                <div id="avisclient-legend-' . $id . '" class="chartjs-legend"></div>
                <canvas id="avisclient-chart-' . $id . '"></canvas>
            </div>
        </div>
    </div>';
    }


    public function StatistiqueServiceSalon($id, $salon)
    {
        return '<div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Nombre de Service <strong>' . $salon . '</strong></p>
                </div>
                <div id="nombreservice-legend-' . $id . '" class="chartjs-legend"></div>
                <canvas id="nombreservice-chart-' . $id . '"></canvas>
            </div>
        </div>
    </div>';
    }

    public function StatistiqueClientCODE($id, $code)
    {
        return '<div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Nombre de client par <strong>' . $code . '</strong></p>
                </div>
                <div id="nombrecode-legend-' . $id . '" class="chartjs-legend"></div>
                <canvas id="nombrecode-chart-' . $id . '"></canvas>
            </div>
        </div>
    </div>';
    }
}

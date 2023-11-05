<?php
use App\Utils\FonctionDashboard;
$fonction = new FonctionDashboard();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Statistique - STEPHAINA BEAUTY</title>
    @include('contenu.header')
</head>

<style>
    .selecta {
        padding: 5px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .button_recherche {
        padding: 7px 20px;
        font-size: 16px;
        background-color: #7a96b3;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .button_recherche:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <div class="container-scroller">
        @include('contenu.navhorizontal')

        <div class="container-fluid page-body-wrapper">
            @include('contenu.navvertical')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Statistique {{ $selectedYear }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($titre == 'salon')
                        <form method="get" action="/StatistiqueSalonClient">
                            <label for="annee">Sélectionner une année : </label>
                            <select name="annee" id="annee" class="selecta">
                                @foreach (range(date('Y') - 1, date('Y') + 1) as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="button_recherche">Rechercher</button>
                        </form>
                        <br>
                        @foreach ($salons as $salonID)
                            @php
                                $salon = \App\Models\Salon::find($salonID);
                                $salonNom = ucfirst($salon->nom);
                            @endphp

                            <div class="row">
                                {!! $fonction->StatistiqueClientSalon($salonID, $salonNom) !!}
                            </div>
                        @endforeach
                    @endif

                    @if ($titre == 'service')
                        <form method="get" action="/StatistiqueSalonService">
                            <label for="annee">Sélectionner une année : </label>
                            <select name="annee" id="annee" class="selecta">
                                @foreach (range(date('Y') - 1, date('Y') + 1) as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="button_recherche">Rechercher</button>
                        </form>
                        <br>
                        @foreach ($salons as $salonID)
                            @php
                                $salon = \App\Models\Salon::find($salonID);
                                $salonNom = ucfirst($salon->nom);
                            @endphp

                            <div class="row">
                                {!! $fonction->StatistiqueServiceSalon($salonID, $salonNom) !!}
                            </div>
                        @endforeach
                    @endif

                    @if ($titre == 'influenceur')
                        <form method="get" action="/StatistiqueCodeClient">
                            <label for="annee">Sélectionner une année : </label>
                            <select name="annee" id="annee" class="selecta">
                                @foreach (range(date('Y') - 1, date('Y') + 1) as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="button_recherche">Rechercher</button>
                        </form>
                        <br>
                        @foreach ($influenceur as $influenceurID)
                            @php
                                $influ = \App\Models\Influenceur::find($influenceurID);
                                $influNom = ucfirst($influ->code) . ' ('.ucfirst($influ->nom).')';
                            @endphp

                            <div class="row">
                                {!! $fonction->StatistiqueClientCODE($influenceurID, $influNom) !!}
                            </div>
                        @endforeach
                    @endif
                </div>
                @include('contenu.footer')
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('assets/js/sbdashboard.js') }}"></script>

@if ($titre == 'salon')
    @foreach ($salons as $salonID)
        @php
            $salon = $salonData[$salonID];
            $labels = $salon['labels'];
            $data = $salon['data'];
            $variableID = '#nombreclient-chart-' . $salonID;
            $legendID = 'nombreclient-legend-' . $salonID;
        @endphp

        <script>
            var variableID = "{!! $variableID !!}";
            var legendID = "{!! $legendID !!}";
            var dataclient = {!! json_encode($data) !!};
            var labelclient = {!! json_encode($labels) !!};
            NombreClient(variableID, legendID, labelclient, dataclient);
        </script>

        @php
            $reponse = $reponseData[$salonID];
            $labelsdata = $reponse['labels'];
            $databien = $reponse['databien'];
            $datamoyen = $reponse['datamoyen'];
            $datamauvais = $reponse['datamauvais'];
            $variabledataID = '#avisclient-chart-' . $salonID;
            $legenddataID = 'avisclient-legend-' . $salonID;
        @endphp

        <script>
            var avisId = "{!! $variabledataID !!}";
            var avislegendId = "{!! $legenddataID !!}";
            var avislabel = {!! json_encode($labelsdata) !!};
            var reponsebien = {!! json_encode($databien) !!};
            var reponsemoyen = {!! json_encode($datamoyen) !!};
            var reponsemauvais = {!! json_encode($datamauvais) !!};
            AvisClient(avisId, avislegendId, avislabel, reponsebien, reponsemoyen, reponsemauvais);
        </script>
    @endforeach
@endif


@if ($titre == 'service')
    @foreach ($salons as $salonID)
        @php
            $salonService = $DataService[$salonID];
            $labelService = $salonService['labels'];
            $nomService = $salonService['nom'];
            $dataService = $salonService['data'];
            $couleurService = $salonService['couleur'];
            $variableIDService = '#nombreservice-chart-' . $salonID;
            $legendIDService = 'nombreservice-legend-' . $salonID;
        @endphp

        <script>
            var variableIDService = "{!! $variableIDService !!}";
            var legendIDService = "{!! $legendIDService !!}";
            var dataservice = {!! json_encode($dataService) !!};
            var labelservice = {!! json_encode($labelService) !!};
            var nomService = {!! json_encode($nomService) !!};
            var couleurService = {!! json_encode($couleurService) !!};
            NombreService(variableIDService, legendIDService, labelservice, nomService, dataservice, couleurService);
        </script>
    @endforeach
@endif


@if ($titre == 'influenceur')
    @foreach ($influenceur as $influenceurID)
        @php
            $salon = $influenceurData[$influenceurID];
            $labels = $salon['labels'];
            $data = $salon['data'];
            $variableID = '#nombrecode-chart-' . $influenceurID;
            $legendID = 'nombrecode-legend-' . $influenceurID;
        @endphp

        <script>
            var variableID = "{!! $variableID !!}";
            var legendID = "{!! $legendID !!}";
            var dataclient = {!! json_encode($data) !!};
            var labelclient = {!! json_encode($labels) !!};
            NombreClientCODE(variableID, legendID, labelclient, dataclient);
        </script>
    @endforeach
@endif

</html>

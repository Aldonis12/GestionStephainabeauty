@php
    use Carbon\Carbon;
    use App\Utils\FonctionDashboard;
    $fonction = new FonctionDashboard();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - STEPHAINA BEAUTY</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
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
                                    <h3 class="font-weight-bold">Tableau de bord</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                {!! $fonction->generateClientDetails() !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {!! $fonction->generateSalonDetails() !!}
                    </div>
                    <br>
                    <form method="get" action="/StatistiqueDashboard">
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
                    <div class="row">
                        {!! $fonction->StatistiqueClient() !!}
                    </div>

                </div>
                @include('contenu.footer')
            </div>
        </div>
    </div>
</body>

</html>

<script src="{{ asset('assets/js/sbdashboard.js') }}"></script>
<script>
    var variableID = "#nombreclient-chart";
    var legendID = "nombreclient-legend";
    var dataclient = {!! json_encode($data) !!};
    var labelclient = {!! json_encode($labels) !!};
    NombreClient(variableID, legendID, labelclient, dataclient);
    const container = document.getElementById('nombreclient');
    const exportButton = document.getElementById('export-chart-btn');
    exportButton.onclick = function() {
        ExportPNG(container, exportButton, 'client');
    }
</script>
<script>
    @foreach ($salonIds as $salonId)
        var chartId = "#donut-" + {{ $salonId }};
        var legendId = "legend-" + {{ $salonId }};
        var labels = {!! json_encode($salonsData[$salonId]['labels']) !!};
        var data = {!! json_encode($salonsData[$salonId]['data']) !!};
        createDonutChart(chartId, legendId, labels, data);
    @endforeach
</script>
<script>
    var avisId = "#avisclient-chart";
    var avislegendId = "avisclient-legend";
    var avislabel = {!! json_encode($reponsemois) !!};
    var reponsebien = {!! json_encode($reponsebien) !!};
    var reponsemoyen = {!! json_encode($reponsemoyen) !!};
    var reponsemauvais = {!! json_encode($reponsemauvais) !!};
    console.log(avislabel, reponsebien, reponsemoyen, reponsemauvais);
    AvisClient(avisId, avislegendId, avislabel, reponsebien, reponsemoyen, reponsemauvais);
</script>

<script>
    @foreach ($salonName as $salonNames)
        const element{{ $salonNames }} = document.getElementById('card-{{ $salonNames }}');

        element{{ $salonNames }}.onclick = function() {
            alert('/okk');
        };
    @endforeach
</script>

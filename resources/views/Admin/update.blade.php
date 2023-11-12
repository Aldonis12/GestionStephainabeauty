<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update {{ $titre }} - STEPHAINA BEAUTY</title>
    @include('contenu.header')
    @if ($titre == 'salon')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-scroller">
        @include('contenu.navhorizontal')

        <div class="container-fluid page-body-wrapper">
            @include('contenu.navvertical')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if (session('message'))
                                        <div class="alert alert-success">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if ($titre == 'salon')
                                        <h4 class="card-title">Modifier Salon</h4>
                                        <form action="/UpdateSalonValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    value="{{ $salon->nom }}" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Adresse</label>
                                                <input type="text" class="form-control" placeholder="Adresse"
                                                    value="{{ $salon->adresse }}" name="adresse" id="adresse"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'service')
                                        <h4 class="card-title">Modifier Service / <a
                                                href="/DetailService/{{ $id }}">Revenir</a></h4>
                                        <form action="/UpdateServiceValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    value="{{ $service->nom }}" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Types</label>
                                                <select class="form-control" name="idtypes" required>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ $type->id == $service->idtypes ? 'selected' : '' }}>
                                                            {{ $type->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'employe')
                                        <h4 class="card-title">Modifier employé / <a
                                                href="/DetailEmploye/{{ $id }}">Revenir</a></h4>
                                        <form action="/UpdateEmployeValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    value="{{ $employe->nom }}" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Prenom</label>
                                                <input type="text" class="form-control" placeholder="Prenom"
                                                    value="{{ $employe->prenom }}" name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Genre</label>
                                                <select class="form-control" name="genre" required>
                                                    @foreach ($genres as $genre)
                                                        <option value="{{ $genre->id }}"
                                                            {{ $genre->id == $employe->idgenre ? 'selected' : '' }}>
                                                            {{ $genre->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'client')
                                        <h4 class="card-title">Modifier client / <a
                                                href="/DetailClient/{{ $id }}">Revenir</a></h4>
                                        <form action="/UpdateClientValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    value="{{ $client->nom }}" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Prenom</label>
                                                <input type="text" class="form-control" placeholder="Prenom"
                                                    value="{{ $client->prenom }}" name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Date de naissance</label>
                                                <input type="date" class="form-control" placeholder="nom"
                                                    value="{{ $client->date_naissance }}" name="date_naissance"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Genre</label>
                                                <select class="form-control" name="genre" required>
                                                    @foreach ($genres as $genre)
                                                        <option value="{{ $genre->id }}"
                                                            {{ $genre->id == $client->idgenre ? 'selected' : '' }}>
                                                            {{ $genre->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Numero</label>
                                                <input type="text" class="form-control"
                                                    placeholder="+261** ** *** **" value="{{ $client->numero }}"
                                                    name="numero" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Adresse</label>
                                                <input type="text" class="form-control" placeholder="Adresse"
                                                    name="adresse" value="{{ $client->adresse }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" placeholder="Email"
                                                    name="email" value="{{ $client->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Profession</label>
                                                <input type="text" class="form-control" placeholder="Profession"
                                                    value="{{ $client->profession }}" name="profession" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Charge</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $client->charge }}" name="charge" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'question')
                                        <h4 class="card-title">Modifier Question / <a
                                                href="/ListQuestion">Revenir</a></h4>
                                                <form action="/UpdateQuestionValid" method="POST">
                                                  @csrf
                                                  <input type="hidden" value="{{ $id }}" name="id">
                                                  
                                                  <div class="form-group">
                                                    <label>Question</label>
                                                    <textarea class="form-control" name="question" required>{{ $questions[0]->question }}</textarea>
                                                </div>
                                            
                                                @foreach($questions as $key => $question)
                                                <div class="form-group">
                                                  <input type="hidden" name="reponses[{{ $key }}][valeur]" value="{{ $question->valeur }}">
                                                  <label>Réponse N°{{ $key + 1 }}</label>
                                                  <input type="text" class="form-control" placeholder="Réponse"
                                                      value="{{ $question->reponse }}" name="reponses[{{ $key }}][reponse]" required>
                                              </div>
                                                @endforeach
                                              
                                                  <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                              </form>
                                              <div>
                                              <br>
                                              <button onclick="DeleteQuestion({{$id}})" class="btn btn-inverse-danger btn-fw">Supprimer cette question</button>
                                    @endif

                                    @if ($titre == 'influenceur')
                                        <h4 class="card-title">Modifier influenceur / <a
                                                href="/DetailInfluenceur/{{ $id }}">Revenir</a></h4>
                                        <form action="/UpdateInfluenceurValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    value="{{ $influenceur->nom }}" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" placeholder="Email"
                                                    name="email" value="{{ $influenceur->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" class="form-control" placeholder="Code"
                                                    value="{{ $influenceur->code }}" name="code" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Modifier</button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('contenu.footer')
            </div>
        </div>
    </div>
</body>

</html>

@if ($titre == 'salon')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        let mapOptions = {
            center: [-18.8792, 47.5079],
            zoom: 13.5
        }

        let map = new L.map('map', mapOptions);

        let layer = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);

        let geocoder = L.Control.geocoder().addTo(map);

        geocoder.on('markgeocode', function(e) {
            let latlng = e.geocode.center;
            let adresse = e.geocode.name;

            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
            document.getElementById('adresse').value = `Lieu: ${adresse}`;
        });

        let marker = null;
        map.on('click', (event) => {
            if (marker !== null) {
                map.removeLayer(marker);
            }

            fetch(
                    `https://nominatim.openstreetmap.org/reverse?lat=${event.latlng.lat}&lon=${event.latlng.lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    const adresse = data.display_name;
                    marker = new L.Marker([event.latlng.lat, event.latlng.lng]).addTo(map);
                    document.getElementById('latitude').value = event.latlng.lat;
                    document.getElementById('longitude').value = event.latlng.lng;
                    document.getElementById('adresse').value = `Lieu: ${adresse}`;
                })
                .catch(error => {
                    console.error('Erreur de géocodage inversé :', error);
                });
        })
    </script>
@endif
<script src="{{ asset('assets/js/details.js') }}"></script>

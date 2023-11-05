<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add {{ $titre }} - STEPHAINA BEAUTY</title>
    @include('contenu.header')

    <!--    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    -->
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
                                        <h4 class="card-title">Ajout Salon</h4>
                                        <form action="/AddSalonValid" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    name="nom" required>
                                            </div>
                                            <!--<div class="form-group">
                                                <label>Localisation</label>
                                                <div id="map"
                                                    style="width: 100%; height: 350px; border-radius: 10px;"></div>
                                                <input type="text" id="latitude" name="latitude"
                                                    class="form-control" hidden placeholder="latitude">
                                                <input type="text" id="longitude" name="longitude"
                                                    class="form-control" hidden placeholder="longitude">
                                            </div>
                                            <div class="form-group">
                                                <label>Adresse</label>
                                                <input type="text" class="form-control" placeholder="Adresse"
                                                    name="adresse" id="adresse" required>
                                            </div>-->
                                            <div class="form-group">
                                                <label>Adresse</label>
                                                <input type="text" class="form-control" placeholder="Adresse"
                                                    name="adresse" id="adresse" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Ajouter</button>
                                            <button class="btn btn-light" type="reset">Annuler</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'service')
                                        <h4 class="card-title">Ajout Service</h4>
                                        <form action="/AddServiceValid" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Types</label>
                                                <select class="form-control" name="idtypes" required>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Ajouter</button>
                                            <button class="btn btn-light" type="reset">Annuler</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'employe')
                                        <h4 class="card-title">Ajout employé</h4>
                                        <form action="/AddEmployeValid" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Nom</label>
                                                <input type="text" class="form-control" placeholder="nom"
                                                    name="nom">
                                            </div>
                                            <div class="form-group">
                                                <label>Prenom</label>
                                                <input type="text" class="form-control" placeholder="Prenom"
                                                    name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Genre</label>
                                                <select class="form-control" name="genre" required>
                                                    @foreach ($genres as $genre)
                                                        <option value="{{ $genre->id }}">{{ $genre->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Ajouter</button>
                                            <button class="btn btn-light" type="reset">Annuler</button>
                                        </form>
                                    @endif

                                    @if ($titre == 'employeservice')
                                        <h3 class="card-title">Ajout service pour l'employé @if ($lien != 'new')
                                                / <a href="/DetailEmploye/{{ $id }}">Revenir</a>
                                            @endif
                                        </h3>
                                        <form action="/AddEmployeServiceValid" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $id }}" name="id">
                                            <input type="hidden" value="{{ $lien }}" name="lien">
                                            <div class="form-group">
                                                <label>Service</label>
                                                <select class="form-control" name="idservice" required>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Salon</label>
                                                <select class="form-control" name="idsalon" required>
                                                    @foreach ($salons as $salon)
                                                        <option value="{{ $salon->id }}">{{ $salon->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Ajouter</button>
                                        </form>
                                        <br>
                                        <h3 class="card-title">Ses services</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Salon</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($empservice as $employe)
                                                    <tr>
                                                        <td>{{ $employe->service->nom }}</td>
                                                        <td>{{ $employe->salon->nom }}</td>
                                                        <td><a href="/DeleteEmployeService/{{ $employe->id }}"
                                                                class="btn btn-info mr-2">Supprimer</a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    @if ($titre == 'question')
                                        <h4 class="card-title">Ajout un nouveau question</h4>
                                        <form action="/AddQuestionValid" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" class="form-control" placeholder="question"
                                                    name="question" required>
                                            </div>

                                            @for ($i = 1; $i < 4; $i++)
                                                <div class="form-group">
                                                    <label>Reponse {{ $i }}
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="reponse {{ $i }}"
                                                        name="reponse_{{ $i }}"
                                                        @if ($i < 3) required @endif>
                                                </div>
                                            @endfor

                                            <button type="submit" class="btn btn-primary mr-2">Ajouter</button>
                                            <button class="btn btn-light" type="reset">Annuler</button>
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

<!-- <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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
                    `https://nominatim.openstreetmap.org/reverse?lat=${event.latlng.lat}&lon=${event.latlng.lng}&format=json`
                    )
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
-->

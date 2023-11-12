@php
    use Carbon\Carbon;
    use App\Utils\FonctionList;
    $fonction = new FonctionList();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>List {{ $titre }} - STEPHAINA BEAUTY</title>
    @include('contenu.header')
</head>

<body>
    <div class="container-scroller">
        @include('contenu.navhorizontal')

        <div class="container-fluid page-body-wrapper">
            @include('contenu.navvertical')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">

                                    @if ($titre == 'salon')
                                        <h4 class="card-title">Liste des salons</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Adresse</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($salons as $salon)
                                                        <tr>
                                                            <td>{{ ucfirst($salon->nom) }}</td>
                                                            <td>{{ $salon->adresse }}</td>
                                                            <td><a href="/DetailSalon/{{ $salon->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Details</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($titre == 'service')
                                        <h4 class="card-title">Liste des services</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Types</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($services as $service)
                                                        <tr>
                                                            <td>{{ ucfirst($service->nom) }}</td>
                                                            <td>{{ $service->Types->nom }}</td>
                                                            <td><a href="/DetailService/{{ $service->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Details</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $services->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'employe')
                                        <h4 class="card-title">Liste des employés</h4>
                                        <h3> <button id="toggleButton"
                                                class="btn btn-inverse-secondary btn-fw">Filtrer</button>
                                                <button onclick="window.location.href='/ExportEmploye'"
                                                class="btn btn-inverse-secondary btn-fw">Exporter CSV</button>
                                            </h3>
                                        <div id="myDiv" style="display:none">
                                            <form action="/RechercheEmploye" method="GET">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label>Nom</label>
                                                        <div id="nom">
                                                            <input class="typeahead" type="text" name="nom"
                                                                placeholder="nom / prenom">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Genre</label>
                                                        <div id="genre">
                                                            <select class="form-control" name="genre" required>
                                                                <option value="0">choisir</option>
                                                                @foreach ($genres as $genre)
                                                                    <option value="{{ $genre->id }}">
                                                                        {{ $genre->nom }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Disponibilité</label>
                                                        <div id="disponibilite">
                                                            <select class="form-control" name="disponibilite" required>
                                                                <option value="2">choisir</option>
                                                                <option value="0">disponible</option>
                                                                <option value="1">indisponible</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Stagiaire</label>
                                                        <div id="stagiaire">
                                                            <select class="form-control" name="stagiaire" required>
                                                                <option value="2">choisir</option>
                                                                <option value="1">Oui</option>
                                                                <option value="0">Non</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label> </label>
                                                        <div style="margin-top: 3%;">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="ti-search"></i>Rechercher
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Genre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($employes as $employe)
                                                        <tr>
                                                            <td>{{ ucfirst($employe->nom) }}</td>
                                                            <td>{{ $employe->prenom }}</td>
                                                            <td>{{ $employe->Genre->nom }}</td>
                                                            <td>
                                                                @if ($employe->isinternship == 1)
                                                                    <label class="badge badge-success">Stagiaire</label>
                                                                @endif
                                                                @if ($employe->iscanceled == 1)
                                                                    <label class="badge badge-danger">Canceled</label>
                                                                @endif
                                                            </td>
                                                            <td><a href="/DetailEmploye/{{ $employe->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Details</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $employes->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'client')
                                        <h4 class="card-title">Liste des clients</h4>
                                        <h3> <button id="toggleButton"
                                                class="btn btn-inverse-secondary btn-fw">Filtrer</button>
                                                <button onclick="window.location.href='/ExportClient'"
                                                class="btn btn-inverse-secondary btn-fw">Exporter CSV</button>
                                            </h3>
                                        <div id="myDiv" style="display:none">
                                            <form action="/RechercheClient" method="GET">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label>Nom</label>
                                                        <div id="nom">
                                                            <input class="typeahead" type="text" name="nom"
                                                                placeholder="nom / prenom">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <div id="age">
                                                            <input class="typeahead" type="text" name="age"
                                                                placeholder="age">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Genre</label>
                                                        <div id="genre">
                                                            <select class="form-control" name="genre" required>
                                                                <option value="0">choisir</option>
                                                                @foreach ($genres as $genre)
                                                                    <option value="{{ $genre->id }}">
                                                                        {{ $genre->nom }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Adresse</label>
                                                        <div id="adresse">
                                                            <input class="typeahead" type="text" name="adresse"
                                                                placeholder="adresse">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label> </label>
                                                        <div style="margin-top: 3%;">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="ti-search"></i>Rechercher
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Date de naissance</th>
                                                        <th>Genre</th>
                                                        <th>Numero</th>
                                                        <th>adresse</th>
                                                        <th>Profession</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($clients as $client)
                                                        @php
                                                            $dateNaissance = new DateTime($client->date_naissance);
                                                            $aujourdhui = new DateTime();
                                                            $age = $aujourdhui->diff($dateNaissance)->y;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ ucfirst($client->nom) }}</td>
                                                            <td>{{ $client->prenom }}</td>
                                                            <td>{{ $client->date_naissance }} ({{ $age }})
                                                            </td>
                                                            <td>{{ $client->Genre->nom }}</td>
                                                            <td>{{ $client->numero }}</td>
                                                            <td>{{ $client->adresse }}</td>
                                                            <td>{{ $client->profession }}</td>
                                                            <td><a href="/DetailClient/{{ $client->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Details</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clients->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'clientFidele')
                                        @if(session('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif

                                        <h4 class="card-title">Liste des clients</h4>
                                        <p class="card-description">Les clients qui sont passés au moins 2 fois ce mois ci.</p>
                                        <p class="card-description">Envoyer un email à ces clients <button id="toggleButton">Message <i class="ti-world"></i></button></p>
                                        <form method="post" action="/sendEmailClientFidele" id="myDiv" style="display: none;">
                                            @csrf
                                            <div class="form-group">
                                                <label>Objet</label>
                                                <input type="text" class="form-control" name="objet" placeholder="Objet" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea class="form-control" name="message" placeholder="Message directement" rows="4" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">Envoyer l'email</button>
                                            <br><br>
                                        </form>
                
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Genre</th>
                                                        <th>Numero</th>
                                                        <th>Email</th>
                                                        <th>Adresse</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($clients as $client)
                                                        
                                                        <tr>
                                                            <td>{{ ucfirst($client->Client->nom) }}</td>
                                                            <td>{{ $client->Client->prenom }}</td>
                                                            <td>{{ $client->Client->Genre->nom }}</td>
                                                            <td>{{ $client->Client->numero }}</td>
                                                            <td>{{ $client->Client->email }}</td>
                                                            <td>{{ $client->Client->adresse }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clients->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'client code')
                                        <h4 class="card-title">Influenceur et Nombre client par code</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Code</th>
                                                        <th>Nombre</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($clientcode as $client)
                                                    <tr>
                                                            <td>{{ ucfirst($client->nom) }}</td>
                                                            <td>{{ $client->code }}</td>
                                                            <td>{{ $client->nombre }}</td>
                                                            <td><a href="/ListClientByCode/{{ $client->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Voir les clients</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($titre == 'clientbycode')
                                        <h4 class="card-title">Liste des clients par : {{$code}} / <a href="/ListClientCode">Revenir</a></h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Date de naissance</th>
                                                        <th>Genre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($clients as $client)
                                                        @php
                                                            $dateNaissance = new DateTime($client->date_naissance);
                                                            $aujourdhui = new DateTime();
                                                            $age = $aujourdhui->diff($dateNaissance)->y;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($client->nom) }}</td>
                                                            <td>{{ $client->prenom }}</td>
                                                            <td>{{ $client->date_naissance }} ({{ $age }})
                                                            </td>
                                                            <td>{{ $client->Genre->nom }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clients->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'Clients par Salon')
                                        <h4 class="card-title">Liste des clients par salon</h4>
                                        <h3> <button id="toggleButton"
                                            class="btn btn-inverse-secondary btn-fw">Rechercher par date</button>
                                        </h3>
                                        <div id="myDiv" style="display:none">
                                            <form action="/listClientBySalon" method="GET">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label>Date Debut</label>
                                                        <div id="daty">
                                                            <input class="typeahead" type="date" name="daty_debut">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Date Fin</label>
                                                        <div id="daty">
                                                            <input class="typeahead" type="date" name="daty_fin">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label> </label>
                                                        <div style="margin-top: 2%;">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="ti-search"></i>Rechercher
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                        @foreach ($clientsGroupedBySalon as $salonId => $salonClients)
                                            @php
                                                $salon = $salonClients->first();
                                                $lastClientName = null;
                                                $clientCount = 0;
                                                $totalClients = $salonClients->count();
                                            @endphp
                                            <br>
                                            <h4 class="card-title">Salon {{ $salon->nom_du_salon . ' ('.$totalClients. ')' }}</h4>
                                            <div class="table-responsive pt-3">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nom Prenom</th>
                                                            <th>Contact</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($salonClients as $client)
                                                            @if ($client->nom_du_client !== $lastClientName)
                                                                <tr>
                                                                    <td>{{ $client->nom_du_client .' '.$client->prenom_du_client }} @if($salonClients->where('nom_du_client', $client->nom_du_client)->count() > 1) ({{ $salonClients->where('nom_du_client', $client->nom_du_client)->count() }}) @endif</td>
                                                                    <td>{{ $client->numero }}</td>
                                                                </tr>
                                                                @php
                                                                    $lastClientName = $client->nom_du_client;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                        </div>
                                    @endif

                                    @if ($titre == 'influenceur')
                                        <h4 class="card-title">Liste des influenceurs</h4>
                                        <h3> <button id="toggleButton"
                                                class="btn btn-inverse-secondary btn-fw">Filtrer</button>
                                                <button onclick="window.location.href='/ExportInfluenceur'"
                                                class="btn btn-inverse-secondary btn-fw">Exporter CSV</button>
                                            </h3>
                                        <div id="myDiv" style="display:none">
                                            <form action="/RechercheInfluenceur" method="GET">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label>Nom</label>
                                                        <div id="nom">
                                                            <input class="typeahead" type="text" name="nom"
                                                                placeholder="nom / prenom">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <div id="age">
                                                            <input class="typeahead" type="text" name="age"
                                                                placeholder="age">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <label> </label>
                                                        <div style="margin-top: 3%;">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="ti-search"></i>Rechercher
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Code</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($influenceurs as $influenceur)
                                                        <tr>
                                                            <td>{{ ucfirst($influenceur->nom) }}</td>
                                                            <td>{{ $influenceur->code }}</td>
                                                            <td>{{ $influenceur->email }}</td>
                                                            <td>
                                                                @if ($influenceur->iscanceled == 1)
                                                                    <label class="badge badge-danger">Canceled</label>
                                                                @endif
                                                            </td>
                                                            <td><a href="/DetailInfluenceur/{{ $influenceur->id }}"><button
                                                                        type="button"
                                                                        class="btn btn-inverse-info btn-fw">Details</button></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $influenceurs->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailSalonService')
                                        <h4 class="card-title">Liste des services / <a
                                                href="/DetailSalon/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Service</th>
                                                        <th>Employé</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($EmployeServices as $EmployeService)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($EmployeService->Service->nom) }}</td>
                                                            <td>{{ ucfirst($EmployeService->Employe->nom) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $EmployeServices->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailSalonEmploye')
                                        <h4 class="card-title">Liste des Employés / <a
                                                href="/DetailSalon/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Genre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($employes as $employe)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($employe->Employe->nom) }} @if ($employe->Employe->iscanceled == 1)
                                                                    <label class="badge badge-danger">X</label>
                                                                @endif
                                                            </td>
                                                            <td>{{ $employe->Employe->prenom }}</td>
                                                            <td>{{ $employe->Employe->Genre->nom }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $employes->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailSalonClient')
                                        <h4 class="card-title">Liste des Clients / <a
                                                href="/DetailSalon/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nom</th>
                                                        <th>Prenom</th>
                                                        <th>Date de naissance</th>
                                                        <th>Genre</th>
                                                        <th>Numero</th>
                                                        <th>adresse</th>
                                                        <th>Profession</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($clients as $client)
                                                        @php
                                                            $dateNaissance = new DateTime($client->Client->date_naissance);
                                                            $aujourdhui = new DateTime();
                                                            $age = $aujourdhui->diff($dateNaissance)->y;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($client->Client->nom) }}</td>
                                                            <td>{{ $client->Client->prenom }}</td>
                                                            <td>{{ $client->Client->date_naissance }}
                                                                ({{ $age }})</td>
                                                            <td>{{ $client->Client->Genre->nom }}</td>
                                                            <td>{{ $client->Client->numero }}</td>
                                                            <td>{{ $client->Client->adresse }}</td>
                                                            <td>{{ $client->Client->profession }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clients->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailServiceSalon')
                                        <h4 class="card-title">Liste des Salons et des Employés / <a
                                                href="/DetailService/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Salon</th>
                                                        <th>Employé</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($empserv as $empservice)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($empservice->Salon->nom) }}</td>
                                                            <td>{{ ucfirst($empservice->Employe->nom) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $empserv->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailServiceEmploye')
                                        <h4 class="card-title">Liste des services / <a
                                                href="/DetailEmploye/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Service</th>
                                                        <th>Client</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employes as $emp)
                                                        @php
                                                            $date = Carbon::parse($emp->inserted);
                                                            $dateSansSecondes = $date->format('Y-m-d H:i');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($emp->Service->nom) }}</td>
                                                            <td>{{ $emp->Client->nom }}</td>
                                                            <td>{{ $dateSansSecondes }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $employes->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'detailActionClient')
                                        <h4 class="card-title">Liste des actions / <a
                                                href="/DetailClient/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Salon</th>
                                                        <th>Service</th>
                                                        <th>Employe</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($clients as $client)
                                                        @php
                                                            $date = Carbon::parse($client->inserted);
                                                            $dateSansSecondes = $date->format('Y-m-d H:i');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($client->Salon->nom) }}</td>
                                                            <td>{{ ucfirst($client->Service->nom) }}</td>
                                                            <td>{{ ucfirst($client->Employe->nom) }}</td>
                                                            <td>{{ $dateSansSecondes }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clients->links('contenu.pagination') }}
                                        </div>
                                    @endif

                                    @if ($titre == 'question')
                                        <h4 class="card-title">Liste des questions avec réponses / <a href="/AddQuestion">Ajouter une autre</a></h4>
                                        @php $currentQuestion = null; @endphp
                                        @php $question = null; @endphp
                                        @foreach ($questions as $questionItem)
                                            @if ($questionItem->question !== $currentQuestion)
                                                @if ($currentQuestion !== null)
                                                    </ol>
                                                    <a href="/UpdateQuestion/{{$question->id}}"><button class="btn btn-outline-secondary btn-fw">Modifier / Supprimer</button></a>
                                                    </blockquote>
                                                @endif
                                                <blockquote class="blockquote">
                                                    <p class="mb-0">{{ $questionItem->question }}</p>
                                                    <br>
                                                    <ol>
                                                        @php $currentQuestion = $questionItem->question; @endphp
                                            @endif
                                            <li>{{ $questionItem->reponse }}</li>
                                            @php $question = $questionItem; @endphp
                                        @endforeach

                                        @if ($currentQuestion !== null)
                                            </ol>
                                            <a href="/UpdateQuestion/{{$question->id}}"><button class="btn btn-outline-secondary btn-fw">Modifier / Supprimer</button></a>
                                            </blockquote>
                                        @endif
                                    @endif

                                    @if ($titre == 'influenceurReseaux')
                                        <h4 class="card-title">Influenceur - Reseaux Sociaux</h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th></th>
                                                    <th>FACEBOOK</th>
                                                    <th>INSTAGRAM</th>
                                                    <th>TIK TOK</th>
                                                </tr>
                                                @php $data = []; @endphp
                                                @foreach ($resultats as $resultat)
                                                    @if (!array_key_exists($resultat->nom, $data))
                                                        @php
                                                            $data[$resultat->nom] = [
                                                                'Facebook' => ['followers' => '--', 'publication' => '--'],
                                                                'Instagram' => ['followers' => '--', 'publication' => '--'],
                                                                'Tiktok' => ['followers' => '--', 'publication' => '--'],
                                                            ];
                                                        @endphp
                                                    @endif

                                                    @php
                                                        $data[$resultat->nom][$resultat->reseau]['followers'] = $resultat->followers;
                                                        $data[$resultat->nom][$resultat->reseau]['publication'] = $resultat->publication;
                                                    @endphp
                                                @endforeach

                                                @foreach ($data as $nom => $valeurs)
                                                    <tr>
                                                        <td rowspan="2"><strong>{{ $nom }}</strong></td>
                                                        <td>{{ $fonction->formatNumber($valeurs['Facebook']['followers']) }}</td>
                                                        <td>{{ $fonction->formatNumber($valeurs['Instagram']['followers']) }}</td>
                                                        <td>{{ $fonction->formatNumber($valeurs['Tiktok']['followers']) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>@if($valeurs['Facebook']['publication']>0){{{ $valeurs['Facebook']['publication'] . ' post' . ($valeurs['Facebook']['publication'] > 1 ? 's' : '') }}}@else--@endif
                                                        </td>
                                                        <td>@if($valeurs['Instagram']['publication']>0){{{ $valeurs['Instagram']['publication'] . ' post' . ($valeurs['Instagram']['publication'] > 1 ? 's' : '') }}}@else--@endif
                                                        </td>
                                                        <td>@if($valeurs['Tiktok']['publication']>0){{{ $valeurs['Tiktok']['publication'] . ' post' . ($valeurs['Tiktok']['publication'] > 1 ? 's' : '') }}}@else--@endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                             </table>
                                        </div>
                                    @endif

                                    @if ($titre == 'detailActionInfluenceur')
                                        <h4 class="card-title">Liste des actions / <a
                                                href="/DetailInfluenceur/{{ $id }}">Revenir</a></h4>
                                        <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Salon</th>
                                                        <th>Service</th>
                                                        <th>Employe</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($influenceurs as $influenceur)
                                                        @php
                                                            $date = Carbon::parse($influenceur->inserted);
                                                            $dateSansSecondes = $date->format('Y-m-d H:i');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucfirst($influenceur->Salon->nom) }}</td>
                                                            <td>{{ ucfirst($influenceur->Service->nom) }}</td>
                                                            <td>{{ ucfirst($influenceur->Employe->nom) }}</td>
                                                            <td>{{ $dateSansSecondes }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $influenceurs->links('contenu.pagination') }}
                                        </div>
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
<script>
    var myDiv = document.getElementById("myDiv");
    var toggleButton = document.getElementById("toggleButton");
    toggleButton.addEventListener("click", function() {
        if (myDiv.style.display === "none" || myDiv.style.display === "") {
            myDiv.style.display = "block";
        } else {
            myDiv.style.display = "none";
        }
    });
</script>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add {{ $titre }} - STEPHAINA BEAUTY</title>
    @include('contenu.header')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-scroller">
        @include('contenu.navhorizontal')

        <div class="container-fluid page-body-wrapper">
            @include('contenu.navvertical')

            <div class="main-panel">
                <div class="content-wrapper">
                    @if ($titre == 'detailSalon')
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Salon {{ ucfirst($salon->nom) }} / <a
                                                href="/ListSalon">Revenir</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Services / <a href="/DetailSalonService/{{ $salon->id }}"
                                                        class="text-info">voir details</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Les services avec le nombre d'employés</p>
                                        <ul>
                                            @foreach ($services as $service)
                                                <li>{{ ucfirst($service->service_nom) }} : {{ $service->nombre_emp }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-user icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Employe / <a href="/DetailSalonEmploye/{{ $salon->id }}"
                                                        class="text-info">voir details</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title text-success">Disponible : {{ $empdisp }}</h4>
                                        @if ($empdisp > 0)
                                            <ul>
                                                <li>Homme : {{ $hommedisp }}</li>
                                                <li>Femme : {{ $femmedisp }}</li>
                                            </ul>
                                        @endif
                                        <h4 class="card-title text-danger">indisponible : {{ $empindisp }}</h4>
                                        @if ($empindisp > 0)
                                            <ul>
                                                <li>Homme : {{ $hommeindisp }}</li>
                                                <li>Femme : {{ $femmeindisp }}</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-id-badge icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Client / <a href="/DetailSalonClient/{{ $salon->id }}"
                                                        class="text-info">voir details</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Le nombre de client de ce mois : {{ $nbclient }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-marker-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/UpdateSalon/{{ $salon->id }}"
                                                        class="text-info">Modifier le salon</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="cursor: pointer;" onclick="DeleteSalon({{ $salon->id }})">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-face-sad icon-md text-danger"></i>
                                            <p style="font-size: 20px; color:red;" class="mb-0 ml-1">
                                                <strong> Supprimer ce salon</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($titre == 'detailService')
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Service {{ ucfirst($service->nom) }} / <a
                                                href="/ListService">Revenir</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Salon / <a href="/DetailServiceSalon/{{ $service->id }}"
                                                        class="text-info">voir details</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Les salons avec le nombre de service {{ ucfirst($service->nom) }}</p>
                                        <ul>
                                            @foreach ($SalonEmp as $salon)
                                                <li>{{ ucfirst($salon->nom) }} : {{ $salon->nombre }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Client</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Les clients de ce mois</p>
                                        <ul>
                                            <li>Homme : {{ $hommeClient }}</li>
                                            <li>Femme : {{ $femmeClient }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-marker-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/UpdateService/{{ $service->id }}"
                                                        class="text-info">Modifier le service</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="cursor: pointer;" onclick="DeleteService({{ $service->id }})">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-face-sad icon-md text-danger"></i>
                                            <p style="font-size: 20px; color:red;" class="mb-0 ml-1">
                                                <strong> Supprimer ce service</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($titre == 'detailEmploye')
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Employé : {{ ucfirst($employe->nom) }} / <a
                                                href="/ListEmploye">Revenir</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-more icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Details</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Nom</p>
                                                    <p>
                                                        {{ ucfirst($employe->nom) }}
                                                    </p>
                                                    <p class="font-weight-bold">Prenom</p>
                                                    <p>
                                                        {{ ucfirst($employe->prenom) }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Genre</p>
                                                    <p>
                                                        {{ $employe->Genre->nom }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">
                                                        Service :
                                                    </p>
                                                    <ul>
                                                        @foreach ($serv as $service)
                                                            <li>{{ $service->Service->nom }}</li>
                                                        @endforeach
                                                    </ul>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address class="text-primary">
                                                    <p class="font-weight-bold">
                                                        Disponibilité
                                                    </p>
                                                    @if ($employe->iscanceled == 0)
                                                        <p class="mb-2">
                                                            OUI
                                                        </p>
                                                    @else
                                                        <p class="mb-2">
                                                            NON
                                                        </p>
                                                    @endif
                                                </address>
                                            </div>
                                            @if ($employe->isinternship == 1)
                                            <div class="col-md-6">
                                                <address class="text-success">
                                                    <p class="font-weight-bold">
                                                        Stagiaire
                                                    </p>
                                                    
                                                        <p class="mb-2">
                                                            OUI
                                                        </p>
                                                </address>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-plus icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/AddEmployeService/{{ $employe->id }}/old"
                                                        class="text-info">Ajouter un autre service </a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/DetailServiceEmploye/{{ $employe->id }}"
                                                        class="text-info">Voir ses actions </a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-marker-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/UpdateEmploye/{{ $employe->id }}"
                                                        class="text-info">Modifier l'employé</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($employe->iscanceled == 0)
                            <div class="row" style="cursor: pointer;"
                                onclick="AlertEmploye({{ $employe->id }},'quit')">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center">
                                                <i class="ti-face-sad icon-md text-danger"></i>
                                                <p style="font-size: 20px; color:red;" class="mb-0 ml-1">
                                                    <strong> Enlever l'employé</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row" style="cursor: pointer;"
                                onclick="AlertEmploye({{ $employe->id }},'return')">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center">
                                                <i class="ti-face-smile icon-md text-success"></i>
                                                <p style="font-size: 20px; color:rgb(13, 159, 13);" class="mb-0 ml-1">
                                                    <strong> Reprendre l'employé</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if ($titre == 'detailClient')
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Client : {{ ucfirst($client->nom) }} / <a
                                                href="/ListClient">Revenir</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-more icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Details</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Nom</p>
                                                    <p>
                                                        {{ ucfirst($client->nom) }}
                                                    </p>
                                                    <p class="font-weight-bold">Prenom</p>
                                                    <p>
                                                        {{ ucfirst($client->prenom) }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Date de naissance</p>
                                                    <p>
                                                        {{ $client->date_naissance }}
                                                    </p>
                                                    <p class="font-weight-bold">Genre</p>
                                                    <p>
                                                        {{ $client->Genre->nom }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Numero</p>
                                                    <p>
                                                        {{ $client->numero }}
                                                    </p>
                                                    <p class="font-weight-bold">Email</p>
                                                    <p>
                                                        {{ $client->email }}
                                                    </p>
                                                </address>
                                            </div>

                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Profession</p>
                                                    <p>
                                                        {{ $client->profession }}
                                                    </p>
                                                </address>
                                            </div>


                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Code QR</p>
                                                    <p>
                                                        <p>{!! DNS2D::getBarcodeHTML("CLI-$client->id",'QRCODE',3,3)!!}</p>
                                                        <p>
                                                            {{ $client->code_qr }}
                                                        </p>
                                                    </p>
                                                </address>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/DetailActionClient/{{ $client->id }}"
                                                        class="text-info">Voir ses actions </a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-marker-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/UpdateClient/{{ $client->id }}"
                                                        class="text-info">Modifier le client</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="cursor: pointer;" onclick="DeleteClient({{ $client->id }})">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-na icon-md text-danger"></i>
                                            <p style="font-size: 20px; color:red;" class="mb-0 ml-1">
                                                <strong>Supprimer le client</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($titre == 'detailInfluenceur')
                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="row">
                                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                        <h3 class="font-weight-bold">Influenceur : {{ ucfirst($influenceur->nom) }} /
                                            <a href="/ListInfluenceur">Revenir</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-more icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong> Details</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Nom</p>
                                                    <p>
                                                        {{ ucfirst($influenceur->nom) }}
                                                    </p>
                                                    <p class="font-weight-bold">Code</p>
                                                    <p>
                                                        {{ ucfirst($influenceur->code) }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">Email</p>
                                                    <p>
                                                        {{ $influenceur->email }}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6">
                                                <address>
                                                    <p class="font-weight-bold">
                                                        Publication : @if (!$publications)
                                                            Aucune publication pour le moment!
                                                        @endif
                                                    </p>
                                                    <ul>
                                                        @foreach ($publications as $publication)
                                                            <li>{{ $publication->reseau }} :
                                                                {{ $publication->nombre }}</li>
                                                        @endforeach
                                                    </ul>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-layers-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/DetailActionInfluenceur/{{ $influenceur->id }}"
                                                        class="text-info">Voir ses préstations </a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="ti-marker-alt icon-md text-warning"></i>
                                            <p style="font-size: 20px;" class="mb-0 ml-1">
                                                <strong><a href="/UpdateInfluenceur/{{ $influenceur->id }}"
                                                        class="text-info">Modifier l'influenceur</a></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($influenceur->iscanceled == 0)
                            <div class="row" style="cursor: pointer;"
                                onclick="AlertInfluenceur({{ $influenceur->id }},'quit')">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center">
                                                <i class="ti-face-sad icon-md text-danger"></i>
                                                <p style="font-size: 20px; color:red;" class="mb-0 ml-1">
                                                    <strong> Enlever l'influenceur</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row" style="cursor: pointer;"
                                onclick="AlertInfluenceur({{ $influenceur->id }},'return')">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center">
                                                <i class="ti-face-smile icon-md text-success"></i>
                                                <p style="font-size: 20px; color:rgb(13, 159, 13);" class="mb-0 ml-1">
                                                    <strong> Reprendre l'influenceur</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
                @include('contenu.footer')
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('assets/js/details.js') }}"></script>

</html>

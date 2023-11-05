<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Gestion Site STEPHAINA BEAUTY</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Accueil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/AddImageActualite">Image premier Carousel</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/UpdateImageRes">Image reservation</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/AddContact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/AddSalonSW">Salon</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Service
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/UpdateImagePlanService">Image premier plan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/AddImageService">Service</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>

    @if (session('message'))
        <div class="alert alert-danger">
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

    @if ($titre == 'imageactualite')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter une image pour le carousel</h2>
                    <form enctype="multipart/form-data" action="AddImageActualiteValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Image moins de 2Mo et de type JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <h2 class="mt-4">Liste des Images</h2>
            <div class="row">
                @foreach ($actualites as $actualite)
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $actualite->image64 }}" class="card-img-top">
                            <div class="card-body">
                                <a href="/UpdateImageActualite/{{ $actualite->id }}"
                                    class="btn btn-primary">Modifier</a>
                                <a href="/DeleteImageActualite/{{ $actualite->id }}"
                                    class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    @if ($titre == 'imageres')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Modifier cette image de description Reservation</h2>
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $imageres->image64 }}" class="card-img-top">
                        </div>
                    </div>

                    <form enctype="multipart/form-data" action="/UpdateImageActualiteValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Image moins de 2Mo et de type JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file" required>
                            <input type="hidden" name="id" value="{{ $imageres->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($titre == 'imageplanservice')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Modifier cette image de plan pour Service</h2>
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $imageplanservice->image64 }}" class="card-img-top">
                        </div>
                    </div>

                    <form enctype="multipart/form-data" action="/UpdateImageActualiteValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Image moins de 2Mo et de type
                                JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file" required>
                            <input type="hidden" name="id" value="{{ $imageplanservice->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($titre == 'service')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter un Service</h2>
                    <form enctype="multipart/form-data" action="AddImageServiceValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Image moins de 2Mo et de type
                                JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <h2 class="mt-4">Liste des Images Services</h2>
            <div class="row">
                @foreach ($services as $service)
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $service->image64 }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->nom }}</h5>
                                <p class="card-text">{{ $service->description }}</p>
                                <a href="/UpdateImageService/{{ $service->id }}"
                                    class="btn btn-primary">Modifier</a>
                                <a href="/DeleteImageService/{{ $service->id }}"
                                    class="btn btn-danger">Supprimer</a>
                            </div>
                            <br>
                            <div class="card-body">
                                <a href="/AddPrixService/{{ $service->id }}" class="btn btn-secondary">Voir
                                    prix</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    @if ($titre == 'Contact')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter un contact</h2>
                    <form action="AddContactValid" method="POST">
                        @csrf
                        <select class="form-select" name="idsalon" aria-label="Default select example">
                            <option>Choisir</option>
                            @foreach ($salons as $salon)
                                <option value="{{ $salon->id }}">{{ $salon->nom }}</option>
                            @endforeach
                        </select>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="contact" placeholder="Contact"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <h2 class="mt-4">Liste des Contacts</h2>
            <form action="/UpdateContactValid" method="POST">
                @csrf
                @foreach ($contacts as $contact)
                    <div class="col-auto">
                        <input type="hidden" name="contact[{{ $contact->id }}][id]" value="{{ $contact->id }}">
                        <input type="text" readonly class="form-control-plaintext"
                            name="contact[{{ $contact->id }}][nom]" value="{{ ucfirst($contact->nomSalon) }}">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="contact[{{ $contact->id }}][contact]"
                            placeholder="{{ $contact->contact }}" value="{{ $contact->contact }}">
                    </div>
                @endforeach
                <br>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Modifier</button>
                </div>
            </form>
        </div>
    @endif


    @if ($titre == 'Salon')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter un Salon</h2>
                    <form action="AddSalonSWValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="mb-3">
                            <textarea type="text" class="form-control" name="localisation"
                                placeholder="Localisation en utilisant IFRAME de Google" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <h2 class="mt-4">Liste des Salons</h2>
            <form action="/UpdateSalonSWValid" method="POST">
                @csrf
                @foreach ($salons as $salon)
                    <div class="col-auto">
                        <input type="hidden" name="salon[{{ $salon->id }}][id]" value="{{ $salon->id }}">
                        <input type="text" class="form-control-plaintext" name="salon[{{ $salon->id }}][nom]"
                            value="{{ $salon->nom }}">
                    </div>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="salon[{{ $salon->id }}][localisation]" rows="7" cols="70">{{ $salon->localisation }}</textarea>
                    </div>
                    <div><a href="/DeleteSalonSW/{{ $salon->id }}" class="btn btn-secondary">Supprimer</a></div>
                    <br>
                @endforeach
                <br>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Modifier le nom et la localisation</button>
                </div>
            </form>
        </div>
    @endif

    @if ($titre == 'PrixService')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter un nouveau / <a href="/AddImageService">Revenir</a></h2>
                    <form action="/AddPrixServiceValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                            <input type="hidden" name="id" value="{{$id}}" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="prix" placeholder="Prix">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="description" placeholder="Description">
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>

            <h2 class="mt-4">Liste des prix</h2>
            <p>Veuillez cliquer sur un catégorie pour le modifier</p>
            @foreach ($categories as $category)
                <div class="category">
                    <span style="cursor: pointer;" onclick="window.location.href='/UpdatePrixService/{{$category->id}}'" class="nomService"> - {{ ucfirst(strtolower($category->nom)) }}</span>
                    @if ($category->prix > 0)
                        <div class="line"></div>
                        <span class="prixService">{{ $category->prix }} Ar</span>
                    @endif
                </div>
                @if ($category->description != '')
                    <div class="descriptionService">
                        {{ $category->description }}
                    </div>
                @endif

                @foreach ($subcategories as $subcategory)
                    @if ($subcategory->idservicecategorie == $category->id)
                        <div class="subcategory">
                            <span class="nomSubService">{{ ucfirst(strtolower($subcategory->nom)) }}</span>
                            @if ($subcategory->prix > 0)
                                <div class="line"></div>
                                <span class="prixService">{{ $subcategory->prix }} Ar</span>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        <style>
            .nomService {
                font-weight: bold;
                font-family: "Helvetica Neue", sans-serif;

            }

            .nomSubService {
                font-weight: bold;
                color: rgb(155, 154, 154);
                font-family: "Helvetica Neue", sans-serif;

            }

            .prixService {
                color: rgb(155, 154, 154);
                font-family: "Helvetica Neue", sans-serif;
            }

            .descriptionService {
                font-size: 12px;
                font-family: "Helvetica Neue", sans-serif;
                line-height: 15px;
                color: rgba(192, 192, 192, 1);
            }


            .category,
            .subcategory {
                display: flex;
                align-items: center;
                padding: 5px 0;
            }

            .nomService,
            .prixService {
                flex: 0.15;
            }

            .nomSubService,
            .prixService {
                flex: 0.15;
            }
        </style>
    @endif
</body>

</html>

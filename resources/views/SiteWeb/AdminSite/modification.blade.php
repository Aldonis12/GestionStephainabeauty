<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification Image Carousel</title>
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
                    <h2>Modifier cette image</h2>
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $actualite->image64 }}" class="card-img-top">
                        </div>
                    </div>

                    <form enctype="multipart/form-data" action="/UpdateImageActualiteValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Image moins de 2Mo et de type JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file" required>
                            <input type="hidden" name="id" value="{{ $id }}">
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
                    <h2>Modifier ce service</h2>
                    <div class="col-sm-6">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ $services->image64 }}" class="card-img-top">
                        </div>
                    </div>

                    <form enctype="multipart/form-data" action="/UpdateImageServiceValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" value="{{ $services->nom }}"
                                required>
                            <input type="hidden" name="id" value="{{ $id }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description"
                                value="{{ $services->description }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nouvelle image mais moins de 2Mo
                                et de type JPEG
                                ou PNG.</label>
                            <input type="file" class="form-control" name="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($titre == 'prixservice')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Ajouter un sous-catégorie / <a href="/AddPrixService/{{ $category->idservice }}">Revenir</a></h2>
                    <form action="/AddSousCategorieServiceValid" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                            <input type="hidden" name="id" value="{{ $id }}" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="prix" placeholder="Prix">
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
            <br>
            <h2>Catégorie</h2>
            <form action="/UpdatePrixServiceValid" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}" required>
                <div class="category">
                    <p>Nom :<input type="text" value="{{ ucfirst(strtolower($category->nom)) }}" name="nom">
                        @if ($category->prix > 0)
                            Prix :<input type="number" step="any" value="{{ $category->prix }}"
                                name="prix">
                        @endif
                    </p>
                    <p> Description :<input type="text" step="any" class="form-control" value="{{ $category->description }}"
                        name="description">
                    </p>
                </div>
                
                @if (isset($subcategories) && count($subcategories) > 0)
                    <p>Sous-catégorie :</p> 
                    @foreach ($subcategories as $subcategory)
                        @if ($subcategory->idservicecategorie == $category->id)
                            <div class="subcategory">
                                <input type="hidden" name="idSub[]" value="{{ $subcategory->id }}" required>
                                <p> - <input type="text" name="nomSub[]"
                                        value="{{ ucfirst(strtolower($subcategory->nom)) }}">

                                    @if ($subcategory->prix > 0)
                                        <input type="number" step="any" value="{{ $subcategory->prix }}"
                                            name="prixSub[]">
                                    @endif
                                    <button
                                        onclick="window.location.href='/DeleteSubcategorie/{{ $subcategory->id }}'"
                                        class="btn btn-outline-danger">X</button>
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endif
            <button type="submit" class="btn btn-primary">Modifier</button>  
            <a href="/DeleteCategorie/{{$category->id}}" class="btn btn-danger">Supprimer</a>  
            </form>
        </div>
    @endif
</body>

</html>

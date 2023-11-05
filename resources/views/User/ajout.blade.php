<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout Client</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <br>
        <strong style="cursor: pointer;" onclick="location.href ='/AddActionClient'"><svg
                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg> Action </strong>
        <div style="display: flex; justify-content: center; align-items: center;">
            <img src="{{ asset('assets/images/logoSB.svg') }}" style="width: 250px;height: auto;" alt="logo" />
        </div>
        @if (session('message'))
            <br>
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <br>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/AddClientValid" method="POST">
            @csrf
            <fieldset>
                <legend></legend>

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prenom</label>
                    <input type="text" class="form-control" name="prenom" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" name="date_naissance" max="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Genre</label>
                    <select name="genre" id="selection" class="form-control" required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresse</label>
                    <input type="text" class="form-control" name="adresse" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Numero</label>
                    <input type="text" class="form-control" name="numero">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Profession</label>
                    <input type="text" class="form-control" name="profession">
                </div>

                <div class="mb-3">
                    <label class="form-label">CODE INFLUENCEUR</label>
                    <select name="code" id="selection" class="form-control" required>
                        <option value="0">choisir</option>
                        @foreach ($codes as $code)
                            <option value="{{ $code->id }}">{{ $code->code }} {{ $code->id }}</option>
                        @endforeach
                    </select>
                </div>

                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-secondary" type="submit">Ajouter</button>
                </div>
                <br>

            </fieldset>
        </form>
    </div>
</body>

</html>

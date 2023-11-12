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
        <script src="{{ asset('assets/js/instascan.js') }}"></script>
        <script src="{{ asset('assets/js/vue.js') }}"></script>
        <script src="{{ asset('assets/js/adapter.js') }}"></script>
</head>

<body>
    <div class="container">
        <br>
        <strong style="cursor: pointer;" onclick="location.href ='/AddActionClient'"><svg
                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg> Action </strong> / 
        <strong style="cursor: pointer;" onclick="location.href ='/ScannerCode'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z"/>
                <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z"/>
                <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z"/>
                <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z"/>
                <path d="M12 9h2V8h-2v1Z"/>
              </svg> Scanner
        </strong> / 
        <strong style="cursor: pointer;" onclick="location.href ='/UpdateClientCode'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
                <path d="M2 2h2v2H2V2Z"/>
                <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z"/>
                <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z"/>
                <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z"/>
                <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z"/>
              </svg> Modifier Code
        </strong>
        
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
                    <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prenom</label>
                    <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" name="date_naissance" max="{{ date('Y-m-d') }}"
                        value="{{ old('date_naissance') }}">
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
                    <input type="text" class="form-control" name="adresse" value="{{ old('adresse') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Numero</label>
                    <input type="text" class="form-control" name="numero" value="{{ old('numero') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Profession</label>
                    <input type="text" class="form-control" name="profession" value="{{ old('profession') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">CODE INFLUENCEUR</label>
                    <select name="code" id="selection" class="form-control" required>
                        <option value="0">choisir</option>
                        @foreach ($codes as $code)
                            <option value="{{ $code->id }}">{{ $code->code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">

                    <label class="form-label"><button id="toggleButton" type="button">Scanner le code</button></label>
                    <div class="scanqr" style="display: none;">
                        <br>
                        <video id="preview" width="30%"></video>
                    </div>
                    <input type="text" readonly id="selectedId" name="code_qr" class="form-control" placeholder="Code QR" required>

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
<script src="{{ asset('assets/js/codeAjout.js') }}"></script>

</html>

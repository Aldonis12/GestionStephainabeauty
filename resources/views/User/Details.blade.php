@php
    use Carbon\Carbon;
    use App\Utils\FonctionList;
    $fonction = new FonctionList();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titre }} - GESTION_INFUENCEUR - STEPHAINA BEAUTY</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @if ($titre == 'influenceur')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Influenceur - Reseaux Sociaux</u></h4>
            <br>
            <button style="float: left; margin-right: 10px;" type="button" class="btn btn-primary btn-sm"
                onclick="window.location.href = '/AddInfluenceur'"><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg> Ajouter un influenceur</button>
            <br><br>
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
                                'id' => $resultat->id,
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
                        <td rowspan="2" style="cursor: pointer;" onmouseover="this.style.backgroundColor='grey';"
                            onmouseout="this.style.backgroundColor='initial';"
                            onclick="window.location.href = '/InfluenceurDetails/{{ $valeurs['id'] }}'">
                            <strong>{{ $nom }}</strong>
                        </td>
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

    @if ($titre == 'Detailinfluenceur')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Influenceur - Reseaux Sociaux</u> / <a href="/UserListInfluenceur">Revenir à la
                    liste</a></h4>
            <br>
            <div>
                <button id="toggleButton" style="float: left; margin-right: 10px;" type="button"
                    class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                    </svg> Followers</button>
                <button style="float: left; margin-right: 10px;" type="button" class="btn btn-primary btn-sm"
                    onclick="window.location.href = '/AddPublication/{{ $id }}'"><svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg> Nouvelle publication</button>
                <br>
            </div>
            <div id="myDiv" style="display: none;">
                <br>
                <table class="table">
                    <thead class="table-dark">
                        <th>Reseaux</th>
                        <th>Followers</th>
                    </thead>
                    <tbody>
                        @foreach ($reseaux as $reseau)
                            <tr>
                                <td>{{ $reseau->nom }}</td>
                                <td>{{ $reseau->followers }}</td>
                            <tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><button type="button" class="btn btn-secondary btn-sm"
                                    onclick="window.location.href = '/UpdateReseauxInfluenceur/{{ $id }}'">Modifier</button>
                            </td>
                        <tr>
                    </tbody>
                </table>
                <br>
            </div>
            <br>
            @foreach ($detailsByReseau as $idReseau => $details)
                <p style="color: blue"><strong>{{ $details[0]->reseau->nom }}</strong></p>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>Lien</th>
                        <th>Likes</th>
                        <th>Commentaires</th>
                        <th>Date d'ajout</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($details as $detail)
                        @php
                            $date = Carbon::parse($detail->inserted);
                            $dateSansSecondes = $date->format('Y-m-d H:i');
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ $detail->lien }}">{{ $detail->lien }}</a></td>
                            <td>{{ $detail->likes }}</td>
                            <td>{{ $detail->comments }}</td>
                            <td>{{ $dateSansSecondes }}</td>
                            <td style="cursor: pointer;" onmouseover="this.style.backgroundColor='grey';"
                                onmouseout="this.style.backgroundColor='initial';"
                                onclick="window.location.href = '/UpdateDetailinfluenceur/{{ $detail->id }}'">
                                Modifier</td>
                                <td style="cursor: pointer;" onmouseover="this.style.backgroundColor='grey';"
                                onmouseout="this.style.backgroundColor='initial';"
                                onclick="window.location.href = '/DeleteDetailinfluenceur/{{ $detail->id }}'">
                                Supprimer</td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
        </div>
    @endif

    @if ($titre == 'UpdateInfluenceur')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Modification</u> / <a
                    href="/InfluenceurDetails/{{ $Influenceur->idinfluenceur }}">Revenir</a></h4>
            <br>
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
            <br>
            <form action="/UpdateDetailinfluenceurValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <input type="hidden" name="id" value="{{ $Influenceur->id }}">

                    <div class="mb-3">
                        <label>Réseau Social</label>
                        <select class="form-control" name="idreseau" required>
                            @foreach ($reseaux as $reseau)
                                <option value="{{ $reseau->id }}"
                                    {{ $reseau->id == $Influenceur->idreseauxsociaux ? 'selected' : '' }}>
                                    {{ $reseau->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lien</label>
                        <input type="text" class="form-control" name="lien" value="{{ $Influenceur->lien }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mention j'aime</label>
                        <input type="text" class="form-control" name="like" value="{{ $Influenceur->likes }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Commentaire</label>
                        <input type="text" class="form-control" name="commentaire"
                            value="{{ $Influenceur->comments }}" required>
                    </div>

                    <div class="mb-3">
                        @php
                            $date = Carbon::parse($Influenceur->inserted);
                            $dateSansSecondes = $date->format('Y-m-d H:i');
                        @endphp
                        <label class="form-label">Date d'ajout</label>
                        <input type="datetime" class="form-control" name="daty" value="{{ $dateSansSecondes }}"
                            required>
                    </div>


                    <br>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-secondary" type="submit">Modifier</button>
                    </div>
                    <br>

                </fieldset>
            </form>
        </div>
    @endif

    @if ($titre == 'AddInfluenceur')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Ajouter un influenceur </u> / <a href="/UserListInfluenceur">Revenir</a></h4>
            <br>
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
            <form action="/AddInfluenceurValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <h5><strong><u>Information</u></strong></h5>
                    <br>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Code</label>
                        <input type="text" class="form-control" name="code">
                    </div>

                    <br>
                    <h5><strong><u>Followers</u></strong></h5>
                    <br>
                    @foreach ($reseaux as $reseau)
                        <div class="form-group">
                            <label class="form-label">{{ $reseau->nom }}</label>
                            <input type="number" class="form-control" name="followers[{{ $reseau->id }}]"
                                value="0" required>
                        </div>
                    @endforeach



                    <br>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-secondary" type="submit">Ajouter</button>
                    </div>
                    <br>

                </fieldset>
            </form>
        </div>
    @endif

    @if ($titre == 'AddPublication')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Nouvelle publication</u> / <a
                    href="/InfluenceurDetails/{{ $id }}">Revenir</a></h4>
            <br>
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
            <br>
            <form action="/AddPublicationValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="mb-3">
                        <label>Réseau Social</label>
                        <select class="form-control" name="idreseau" required>
                            @foreach ($reseaux as $reseau)
                                <option value="{{ $reseau->id }}">
                                    {{ $reseau->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lien</label>
                        <input type="text" class="form-control" name="lien" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mention j'aime</label>
                        <input type="number" class="form-control" name="like" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Commentaire</label>
                        <input type="number" class="form-control" name="commentaire" required>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Date d'ajout</label>
                        <input type="datetime-local" class="form-control" name="daty"
                            max="{{ date('Y-m-d\TH:i') }}" required>
                    </div>


                    <br>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-secondary" type="submit">Ajouter</button>
                    </div>
                    <br>

                </fieldset>
            </form>
        </div>
    @endif

    @if ($titre == 'UpdateReseauxInfluenceur')
        <div style="width: 80%;margin: 0 auto;padding: 20px;text-align: center;box-sizing: border-box; ">
            <h4 class="card-title"><u>Modification Followers</u> / <a
                    href="/InfluenceurDetails/{{ $id }}">Revenir</a></h4>
            <br>
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
            <br>
            <form action="/UpdateReseauxInfluenceurValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <input type="hidden" name="id" value="{{ $id }}">

                    @foreach ($reseaux as $reseau)
                        <div class="mb-3">
                            <label class="form-label">{{ $reseau->nom }} {{ $reseau->idreseauxsociaux }}</label>
                            <input type="number" class="form-control"
                                name="followers[{{ $reseau->idreseauxsociaux }}]" value="{{ $reseau->followers }}"
                                required>
                        </div>
                    @endforeach

                    <br>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-secondary" type="submit">Modifier</button>
                    </div>
                    <br>

                </fieldset>
            </form>
        </div>
    @endif

</body>

<script>
    const toggleButton = document.getElementById('toggleButton');
    const myDiv = document.getElementById('myDiv');
    toggleButton.addEventListener('click', function() {
        if (myDiv.style.display === 'none' || myDiv.style.display === '') {
            myDiv.style.display = 'block';
        } else {
            myDiv.style.display = 'none';
        }
    });
</script>

</html>

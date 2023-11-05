<!DOCTYPE html>
<html>

<head>
    <title>Ajout {{ $titre }} - STEPHAINA BEAUTY</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    </head>

<style>
    .tt-menu {
        background-color: #fff;
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
    }

    .tt-suggestion {
        padding: 8px 45px;
        cursor: pointer;
    }

    .tt-suggestion:hover {
        background-color: #f0f0f0;
    }
</style>

<body>

    <div class="container">
        <br>
        <strong style="cursor: pointer;" onclick="location.href ='/AddClient'"><svg xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle-fill"
                viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg> Ajout </strong>
        <div style="display: flex; justify-content: center; align-items: center;">
            <img src="{{ asset('assets/images/logoSB.svg') }}" style="width: 250px;height: auto;" alt="logo" />
        </div>
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

        @if ($titre == 'ActionClient')
        <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href = '/AddActionInfluenceur'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
          </svg>Influenceur</button>
            <form action="AddActionClientValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <br>
                    <div style="border: 0.5px solid #000; padding: 10px;">
                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Nom client</strong></label>
                            <input type="text" class="form-control typeahead" id="nom" required>
                            <input type="hidden" id="selectedId" name="idclient">
                        </div>

                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Service {{ session('idsalon') }}</strong></label>
                            <input type="text" class="form-control typeahead" id="service" required>
                            <input type="hidden" id="selectedIdService" name="idservice">
                        </div>

                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Employé</strong></label>
                            <input type="text" class="form-control typeahead" id="employe" required>
                            <input type="hidden" id="selectedIdEmploye" name="idemploye">
                            <input type="hidden" id="selectedIdEmploye" name="idsalon"
                                value="{{ session('idsalon') }}">
                        </div>
                    </div>
                    <br>

                    @foreach ($groupedQuestions as $questionId => $questionData)
                        <div style="border: 0.5px solid #000; padding: 10px;">
                            <div class="mb-3">
                                <label class="form-label"><strong>{{ $loop->iteration }} -
                                        {{ $questionData['question'] }}</strong></label>
                                <br>

                                @foreach ($questionData['reponses'] as $reponse)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="{{ 'question_' . $questionId }}" value="{{ $reponse['valeur'] }}">
                                        <label style="font-size: 17px;"
                                            class="form-check-label">{{ $reponse['reponse'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>
                    @endforeach
                    <div class="text-center">
                        <button class="btn btn-secondary" style="width: 50%;" type="submit">Ajouter</button>
                    </div>
                    <br>
                </fieldset>
            </form>
            <script>
                const checkbox = document.getElementById("flexSwitchCheckDefault");
                checkbox.addEventListener("change", function() {
                    if (checkbox.checked) {
                        window.location.href = "/AddActionInfluenceur";
                    }
                });
            </script>
        @endif

        @if ($titre == 'ActionInfluenceur')
        <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href = '/AddActionClient'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
          </svg>Client</button>
            <form action="AddActionInfluenceurValid" method="POST">
                @csrf
                <fieldset>
                    <legend></legend>
                    <br>
                    <div style="border: 0.5px solid #000; padding: 10px;">
                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Influenceur</strong></label>
                            <input type="text" class="form-control typeahead" id="nominfluenceur" required>
                            <input type="hidden" id="selectedIdinfluenceur" name="idinfluenceur">
                        </div>

                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Service</strong></label>
                            <input type="text" class="form-control typeahead" id="service" required>
                            <input type="hidden" id="selectedIdService" name="idservice">
                        </div>

                        <div style="display: inline-block; width: 30%;">
                            <label class="form-label"><strong>Employé</strong></label>
                            <input type="text" class="form-control typeahead" id="employe" required>
                            <input type="hidden" id="selectedIdEmploye" name="idemploye">
                            <input type="hidden" id="selectedIdEmploye" name="idsalon"
                                value="{{ session('idsalon') }}">
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-secondary" style="width: 50%;" type="submit">Ajouter</button>
                    </div>
                    <br>
                </fieldset>
            </form>
        @endif
    </div>

    <script src="{{ asset('assets/js/ajoutAction.js') }}"></script>

</body>

</html>

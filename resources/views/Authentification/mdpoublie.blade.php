<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mot de passe oublié - STEPHAINA BEAUTY</title>
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logoSB.svg') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset('assets/images/logoSB.svg') }}" alt="logo">
              </div>
              <h6 class="font-weight-light">Changement de mot de passe</h6>
              @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
              <form class="pt-3" action="/updatepassword" method="post">
                @csrf
                <div class="form-group">
                  <input type="texte" name="mail" class="form-control form-control-lg" id="email" placeholder="Email actuel" required>
                  <span id="email-error" style="color: red; font-size: 10"></span>
                </div>
                <div class="form-group">
                  <input type="password" name="mdp" class="form-control form-control-lg" id="password" placeholder="Nouveau mot de passe" minlength="6" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confmdp" class="form-control form-control-lg" id="confirmPassword" placeholder="Confirmer mot de passe" minlength="6" required>
                    <span id="passwordError" style="color: red;"></span>
                  </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium square-black-button" id="button-modifier" type="submit">Modifier</button>
                </div>
              </form>
              <div class="mt-3">
                <a href="/"><button class="btn btn-block btn-primary btn-lg font-weight-medium square-black-button" style="background-color: brown">Annuler</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
  <script src="{{ asset('assets/js/todolist.js') }}"></script>
  <script src="{{ asset('assets/js/login.js') }}"></script>
</body>

</html>

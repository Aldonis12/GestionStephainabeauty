<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - STEPHAINA BEAUTY</title>
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
              @if(session('pass')=='admin')
                <h6 class="font-weight-light text-center">ADMINISTRATEUR</h6>
              @endif
              @if(session('pass')=='salon')
                <h6 class="font-weight-light text-center">GESTION - SALON</h6>
              @endif
              @if(session('pass')=='influenceur')
                <h6 class="font-weight-light text-center">GESTION - INFLUENCEUR</h6>
              @endif
              <form class="pt-3" action="/login" method="post">
                @csrf
                <div class="form-group">
                  <input type="texte" name="mail" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="EMAIL" required>
                </div>
                @if(session('pass')=='admin')
                  <div class="form-group">
                    <input type="password" name="mdp" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="MOT DE PASSE" required>
                  </div>
                @endif
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium square-black-button"  type="submit">VALIDER</button>
                </div>
                @if(session('pass')=='admin')
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                      </label>
                    </div>
                    <a href="/forgetpassword" class="auth-link text-black">Mot de passe oublié ?</a>
                  </div>
                  @if (session('error'))
                  <br>
                  <p><strong>Email ou mot de passe invalide.</strong></p>
                  @endif
                  @if (session('success'))
                  <br>
                  <p style="color: green">Mot de passe mis à jour avec succès.</p>
                  @endif
                @endif
              </form>
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
</body>

</html>

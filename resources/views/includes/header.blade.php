
      <nav class="navbar navbar-expand-lg navbar-light mx-auto py-0 px-5 mt-0 w-100 bg-white" id="navbar" style="position:fixed;">
          <div class="container-fluid">
            <a href="http://localhost:8000/"><img src="/images/logo.png" alt="Logo azzurro zafferano" class="logo-img"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-3 navbar-margin-top" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0 hidden-mobile">
                <li class="nav-item dropdown btn btn-sm rounded-pill" style="font-size:1.2em; background-color:#FFA84D;">
                  <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding-top:0.2em !important;padding-bottom:0.2em !important;">
                    Categorie
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('showByFilter', 'Antipasti') }}">Antipasti</a></li>
                    <li><a class="dropdown-item" href="{{ route('showByFilter', 'Primi Piatti') }}">Primi</a></li>
                    <li><a class="dropdown-item" href="{{ route('showByFilter', 'Secondi Piatti') }}">Secondi</a></li>
                    <li><a class="dropdown-item" href="{{ route('showByFilter', 'Dolci') }}">Dolci</a></li>
                  </ul>
                </li>
              </ul>

            <input class="form-control me-2 rounded-pill bg-light py-2 width-search" type="search" placeholder="Cerca una ricetta" id="searchBar" aria-label="Search" font-size:1.2em;">

              <div class="hidden px-6 py-4 sm:block">
                <div class="d-flex align-items-center">
                  <img src="@if (Auth::user()) {{ asset('images/avatars/' . Auth::user()->avatar) }} @else {{ asset('images/user.png') }} @endif" alt="Avatar" class="rounded-circle me-2" style="width:40px; height:40px;">
                  @guest
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-sm text-gray-700 dark:text-gray-500 dropdown-toggle" style="font-size:1.1em; color:#05326D;">Accedi</a>
                        @else
                        <ul class="navbar-nav ms-auto" style="display:inline-block;">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" style="padding-left: 0.3rem; font-size:1.2em;" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                              @if (Auth::user()->role < 3)
                                <a class="dropdown-item" href="{{ route('admin') }}">
                                {{ __('Admin panel') }}
                                </a>
                              @endif  
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Profilo') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                
                            </div>
                        </li>
                        </ul>
                    @endguest
                  </div>
              </div>
          
            </div>
          </div>
        </nav>

<!-- Modal SETPASSWORD -->
{{-- <div class="modal fade" id="modalSetPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Accedi o Registrati</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form>
                <div class="row mb-3">
                    <label for="emailLogin" class="col-md-4 col-form-label text-md-end">{{ __('Indirizzo email') }}</label>
  
                    <div class="col-md-6">
                        <input id="emailLogin" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
  
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
  
                <div class="row mb-3">
                    <label for="passwordLogin" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
  
                    <div class="col-md-6">
                        <input id="passwordLogin" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
  
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
  
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
  
                            <label class="form-check-label" for="remember">
                                {{ __('Ricordami') }}
                            </label>
                        </div>
                    </div>
                </div>
  
                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-success">
                            {{ __('Entra') }}
                        </button>
  
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Password smarrita?') }}
                            </a>
                        @endif
                    </div>
              </div>
          </form>
          <div class="row mt-5">
              <div class="col ms-auto">
                  <a href="{{ url('auth/facebook') }}" class="btn btn-primary">
                      <i class="fa-brands fa-facebook"></i> Entra con Facebook
                  </a>
              </div>
          </div>
      </div>
        <div class="modal-footer d-flex justify-content-between">
            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><span class="text-decoration-underline">Non hai un account?</span></a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
        </div>
      </div>
    </div>
  </div> --}}

        <!-- Modal LOGIN -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Accedi o Registrati</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="row mb-3">
                  <label for="emailLogin" class="col-md-4 col-form-label text-md-end">{{ __('Indirizzo email') }}</label>

                  <div class="col-md-6">
                      <input id="emailLogin" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="row mb-3">
                  <label for="passwordLogin" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                  <div class="col-md-6">
                      <input id="passwordLogin" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="row mb-3">
                  <div class="col-md-6 offset-md-4">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                              {{ __('Ricordami') }}
                          </label>
                      </div>
                  </div>
              </div>

              <div class="row mb-0">
                  <div class="col-md-8 offset-md-4">
                      <button type="submit" class="btn btn-success">
                          {{ __('Entra') }}
                      </button>

                      @if (Route::has('password.request'))
                          <a class="btn btn-link" href="{{ route('password.request') }}">
                              {{ __('Password smarrita?') }}
                          </a>
                      @endif
                  </div>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col ms-auto">
                <a href="{{ url('auth/facebook') }}" class="btn btn-primary">
                    <i class="fa-brands fa-facebook"></i> Entra con Facebook
                </a>
            </div>
        </div>
    </div>
      <div class="modal-footer d-flex justify-content-between">
          <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><span class="text-decoration-underline">Non hai un account?</span></a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal REGISTER -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Accedi o Registrati</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
              @csrf
          
              <div class="row mb-3">
                  <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
          
                  <div class="col-md-6">
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          
              <div class="row mb-3">
                  <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Cognome') }}</label>
          
                  <div class="col-md-6">
                      <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
          
                      @error('lastname')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          
              <div class="row mb-3">
                  <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Indirizzo email') }}</label>
          
                  <div class="col-md-6">
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
          
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          
              <div class="row mb-3">
                  <label for="user-image" class="col-md-4 col-form-label text-md-end">{{ __('Immagine profilo') }}</label>
          
                  <div class="col-md-6">
                      <input id="user_image" type="file" class="form-control @error('user_image') is-invalid @enderror" name="user_image" value="{{ old('user_image') }}">
          
                      @error('user_image')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          
              <div class="row mb-3">
                  <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
          
                  <div class="col-md-6">
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
          
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          
              <div class="row mb-3">
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Conferma Password') }}</label>
          
                  <div class="col-md-6">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
              </div>
          
              <div class="row mb-0">
                  <div class="col-md-6 offset-md-4">
                      <button type="submit" class="btn btn-primary">
                         Registrati
                      </button>
                  </div>
              </div>
          </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
          <a href="#"><span class="text-decoration-underline">Non hai un account?</span></a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous" defer></script>
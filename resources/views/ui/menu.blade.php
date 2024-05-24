<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="/">Főoldal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="/list_books">Könyvkereső</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="/add_book">Könyv hozzáadása</a>
        </li>
        @if (!auth()->check())
          <li>
            <a href="/log_reg" class="nav-link active">Bejelentkezés/Regisztráció</a>
          </li>
        @endif
        @auth
          <li class="nav-item">
            <a class="nav-link active" target="_blank" href="http://localhost:7000">PhpMyAdmin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" target="_blank" href="http://localhost:8081">Redis Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" target="_blank" href="http://localhost:8085">MemCached Admin</a>
          </li>
          <li>
            <a href="/logout" class="nav-link active">Kijelentkezés</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Összes könyv</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
</head>
<body style="background-color: #F1EEDC;">
    <div class="container mt-5">
        <div class="col text-center">
            <h2>Könyvkereső</h2>
            @include("ui.menu")
        </div>

        <div class="row">
            <div class="col">
                <form action="/list_books" method="GET">
                    <div class="row mt-3">
                        <div class="col-3">
                            <label for="filter">Szűrés ez alapján</label>
                                <select class="form-select" name="filter" id="filter">
                                    <option selected value="title">Cím</option>
                                    <option value="genre">Műfaj</option>
                                    <option value="publish_date">Megjelenési dátum</option>
                                    <option value="writers">Szerző</option>
                                    <option value="publisher">Kiadó</option>
                                    <option value="language">Nyelv</option>
                                </select>
                        </div>
                        <div class="col-3">
                            <label for="value">Érték</label>
                            <input class="form-control" type="text" name="value" id="value">
                        </div>
                        <div class="col-3">
                            <br>
                            <button class="form-control btn btn-success" type="submit">Szűrés</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($books) == 0)
            <div class="container mt-5 h-100">
                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                    <div class="col text-center">
                        <h2>Jelenleg a könyvtár üres vagy nincs olyan könyv ami megfelel a szűrési kritériumnak.</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <h3><a href="add_book" class="link-offset-2 link-underline link-underline-opacity-100">Könyv hozzáadása</a></h3>
                    </div>
                </div>
            </div>
        @endif


        @php
            $counter = 1;
        @endphp
        @for ($j = 0; $j < count($books); $j++)
            @if ($counter == 1)
                <div class="row mt-4">
            @endif

            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset($books[$j]['cover']) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $books[$j]["title"] }}</h5>
                        <p>{{ $books[$j]["writers"] }}</p>
                        <a href="view_book/{{$books[$j]['isbn']}}" class="btn btn-primary">Megtekintés</a>
                    </div>
                </div>
            </div>           
            
            @if ($counter == 4 || $counter + 1 == count($books))
                </div>
                @php
                    $counter = 1;
                @endphp
            @else
                @php
                    $counter++;
                @endphp
            @endif
            
        @endfor



        <!--
        <div class="row mt-3">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/stalker2.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>      
</body>
</html>
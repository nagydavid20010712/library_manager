<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $book->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
</head>
<body style="background-color: #F1EEDC;">
    @include("ui.change_book_data_modal")

    <div class="modal fade" id="confirm_del_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Törlés megerősítése</h5>
                </div>
                <div class="modal-body">
                    <h5>Biztos törölni szeretnéd?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                    <button type="button" class="btn btn-danger" id="confirm_book_delete" value="{{ $book->isbn }}">Igen</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="error_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hiba</h5>
                </div>
                <div class="modal-body">
                    <h5 id="error_info"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="success_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Siker</h5>
                </div>
                <div class="modal-body">
                    <h5 id="success_info"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Bezárás</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        @include("ui.menu")
        <div class="row mt-5">
            <div class="col-4 text-center">
                <img class="img-fluid" src="{{ asset($book->cover) }}" alt="" srcset="">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-primary" id="open_modal">Könyv szerkesztése</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" id="del_open_modal" value="1">Könvy törlése</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <!--cím-->
                            <h4 id="book_title">{{ $book->title }}</h4>
                        </div>
                        <div class="col-6">
                            <div class="row float-end">
                                <div class="col">
                                    <select name="lang" id="lang" class="form-select">
                                        @foreach ($supported_languages as $sl)
                                            <option value="{{ $sl['language'] }}">{{ $sl["name"] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="h_isbn" id="h_isbn" value="{{ $book->isbn }}">
                                    <button type="button" class="btn btn-primary" id="btn_translate">Fordítás</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <h5>Rövid ismertető</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- rövid ismertető helye -->
                            <p style="text-align: justify;" id="book_description">
                                <!--Hemul, a kommandós kiképzőből lett stalker rosszul tűri, ha csapata nem az elvárásai szerint viselkedik. Ám mivel kockázatos küldetéseiért kapott pénze rendszerint kifolyik a keze közül, most mégis kénytelen kísérőül szegődni egy csoport extrém kalandokat kereső, öntörvényű turista mellé. A Zóna azonban nem az a hely, ahová önfeledt szafarikra járhat az ember.
                                A vadásztúra ígéretesen indul, ám a mutánsoktól hemzsegő vidék korántsem veszélytelen. Az első összecsapások után a csapat tagjai arra is ráébrednek, hogy a legveszedelmesebb szörnyeknek olykor emberarcuk van. No persze olykor a turisták sem egyszerű turisták. De hogy az önként vállalt vesszőfutást ki ússza meg élve, ki juthat ki a Zónából - ha ki lehet még jutni belőle egyáltalán -, azt még egy tapasztalt stalker sem tudja előre megmondani.-->
                                {{ $book->description }}
                            </p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <h5>Adatok</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- adatok helye -->
                            <table class="table" style="border-color: black;">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Kiadó:</td>
                                        <td style="background-color: #F1EEDC;" id="book_publisher">{{ $book->publisher }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Kiadás éve:</td>
                                        <td style="background-color: #F1EEDC;" id="book_publish_date">{{ $book->publish_date }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Oldalak száma:</td>
                                        <td style="background-color: #F1EEDC;" id="book_number_of_pages">{{ $book->number_of_pages }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Szerző(k):</td>
                                        <td style="background-color: #F1EEDC;" id="book_writers">{{ $book->writers }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Műfajo(k):</td>
                                        <td style="background-color: #F1EEDC;" id="book_genre">{{ $book->genre }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Nyelv:</td>
                                        <td style="background-color: #F1EEDC;" id="book_language">{{ $book->language }}</td>
                                    <tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">ISBN:</td>
                                        <td style="background-color: #F1EEDC;">{{ $book->isbn }}</td>
                                    <tr>
                                    <tr>
                                        <td style="background-color: #F1EEDC;">Széria:</td>
                                        <td style="background-color: #F1EEDC;">
                                            @if ($series_name == null)
                                                nem tartozik szériához
                                            @else
                                                {{ $series_name->name }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>Könyv további részei</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <!--<div class="col">
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
                    <img src="{{ asset('images/stalker3.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">S.T.A.L.K.E.R. - Tűzvonal</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>-->
            @if ($series_name == null && $series == null)
                <div class="col d-flex justify-content-center align-items-center">
                    <h3>Ehhez a könyvhöz nem tartozik széria.</h3>
                </div>    
            @elseif ($series_name != null && count($series) == 0) 
                <div class="col d-flex justify-content-center align-items-center">
                    <h3>Jelenleg nem tartoznak további részek a szériához.</h3>
                </div> 
            @else
                
                @foreach ($series as $s)
                    
                    <div class="col d-flex justify-content-center overflow-x-auto">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset($s->cover) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $s->title }}</h5>
                                <a href="/view_book/{{ $s->isbn }}" class="btn btn-primary">Megtekintés</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        <div class="row mt-5">
            <div class="col">
                <h3>Hasonló könyvek</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            @if (count($same) == 0) 
                <div class="col d-flex justify-content-center align-items-center">
                    <h3>Nincsenek ehhez hasonló könyvek.</h3>
                </div> 
            @else
                @foreach ($same as $s)
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset($s->cover) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $s->title }}</h5>
                                <p>{{ $s->writers }}</p>
                                <a href="/view_book/{{ $s->isbn }}" class="btn btn-primary">Megtekintés</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script src="{{ asset('js/view_book.js') }}"></script>
</body>
</html>
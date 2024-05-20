<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Könyv hozzáadása</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
</head>
<body style="background-color: #F1EEDC;">

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

    <div class="container mt-5">
        <div class="col text-center">
            <h2>Könyv hozzáadása</h2>
            @include("ui.menu")
        </div>

        <div class="row mt-5" style="background-color: #F1F0E8;">
            <div class="col">
                <div class="row">
                    <div class="col-6">
                        <label for="isbn">ISBN</label>
                        <input type="number" name="isbn" id="isbn" class="form-control">
                        <div class="alert alert-danger mt-2" id="isbn_error" role="alert">
               
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="publisher">Kiadó</label>
                        <input type="text" name="publisher" id="publisher" class="form-control">
                        <div class="alert alert-danger mt-2" id="publisher_error" role="alert">

                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="title">Cím</label>
                        <input type="text" name="title" id="title" class="form-control">
                        <div class="alert alert-danger mt-2" id="title_error" role="alert">
               
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="publish">Megjelenés éve</label>
                        <input type="number" name="publish" id="publish" class="form-control">
                        <div class="alert alert-danger mt-2" id="publish_error" role="alert">
               
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="description">Ismertető</label>
                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        <div class="alert alert-danger mt-2" id="description_error" role="alert">
                        
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="writers">Szerző(k)</label>
                        <input type="text" name="writers" id="writers" class="form-control">
                        <div class="alert alert-danger mt-2" id="writers_error" role="alert">
                        
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="language">Nyelv</label>
                        <input type="text" class="form-control" name="language" id="language">
                        <div class="alert alert-danger mt-2" id="language_error" role="alert">
                    
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="number_of_pages">Oldalak száma</label>
                        <input type="number" class="form-control" name="number_of_pages" id="number_of_pages">
                        <div class="alert alert-danger mt-2" id="number_of_pages_error" role="alert">
                    
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label for="genre">Műfaj</label>
                        <input type="text" name="genre" id="genre" class="form-control">
                        <div class="alert alert-danger mt-2" id="genre_error" role="alert">
                    
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="cover">Borítókép</label>
                        <input type="file" class="form-control" name="cover" id="cover">
                        <div class="alert alert-danger mt-2" id="cover_error" role="alert">
                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                               
                                @if (count($series) == 0)
                                    <br>
                                    <h6>Jelenleg nincsenek szériák az adatbázisban.</h6>
                                @else
                                    <label for="series">Széria</label>
                                    <select name="series" class="form-select" id="series">
                                        <option value="ns">Nem tartozik szériába</option>
                                        @foreach ($series as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="switch" class="form-check-label">Nem szerepel, magam adom meg. </label>
                                    <input type="checkbox" name="switch" class="form-check-input" id="switch">
                                @endif
                            </div>
                            <div class="col-6">
                                <label for="new_series">Új széria neve</label>
                                <input type="text" class="form-control" name="new_series" id="new_series">
                                <div class="alert alert-danger mt-2" id="new_series_error" role="alert">
                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <br>
                        <button type="button" id="upload_btn" class="btn btn-primary float-end w-25">Feltöltés</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/add_book.js') }}"></script>
</body>
</html>
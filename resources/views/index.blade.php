<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Főoldal</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
</head>
<body style="background-color: #F1EEDC;">
    <div class="container mt-5">
        <div class="col text-center">
            <h2>Könyvtárkezelő</h2>
            @include("ui.menu")
        </div>
    
        <div class="row mt-5 ">
            @if (count($recommends) == 0)
                <div class="col text-center">
                    <h3>Jelenleg nem ajánlott senki sem könyvet vagy üres az adatbázis.</h3>
                </div>
            @else
                @php
                    $counter = 1;
                @endphp
                @for ($i = 0; $i < count($recommends); $i++)
                    @if ($counter == 1)
                        <div class="row mt-4">
                    @endif

                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <h5 class="text-center">ajánla: {{ $recommends[$i]["fname"] }} {{ $recommends[$i]["lname"] }}</h5>
                            <img src="{{ asset($recommends[$i]['cover']) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $recommends[$i]["title"] }}</h5>
                                <p>{{ $recommends[$i]["writers"] }}</p>
                                <a href="view_book/{{$recommends[$i]['isbn']}}" class="btn btn-primary">Megtekintés</a>
                            </div>
                        </div>
                    </div>          
                    @php
                        $counter++
                    @endphp
                    @if ($counter == 5)
                        </div>

                        @php
                        $counter = 1    
                        @endphp
                    @endif
                    
                @endfor

                @if ($counter != 1)
                    
                    @for ($i = 0; $i <= 4 - $counter; $i++)
                        <div class="col"></div>
                    @endfor

                    </div>
                @endif

            @endif
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <script src="{{ asset('js/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
    <title>Bejelentkezés/Regisztráció</title>
</head>
<body style="background-color: #F1EEDC">

    @if (session('success'))
        <div class="modal" id="success" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Siker</h5>
                    </div>
                    <div class="modal-body">
                        <p>{{ session('success') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Rendben</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(() => {
                $("#success").modal("show");
            });
            //console.log($("#log_failed").modal())
            //$("#log_failed").modal("show");
        </script>
    @endif

    @error('failed')
        <div class="modal" id="failed" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hiba</h5>
                    </div>
                    <div class="modal-body">
                        <p>{{ $message }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Rendben</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(() => {
                $("#failed").modal("show");
            });
            //console.log($("#log_failed").modal())
            //$("#log_failed").modal("show");
        </script>
    @enderror

    <div class="container mt-5">
        <div class="col text-center">
            <h2>Bejelentkezés/Regisztráció</h2>
            @include("ui.menu")
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <h4>Bejelentkezés</h4>
                <form action="/login" method="post" id="log_form">
                    @csrf
                    <div class="mb-3">
                        <label for="log_email" class="form-label">Email cím</label>
                        <input type="email" class="form-control" id="log_email" name="log_email">
                        @error('log_email')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="log_password" class="form-label">Jelszó</label>
                        <input type="password" class="form-control" id="log_password" name="log_password" required>
                        @error('log_password')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Bejelentkezés</button>
                </form>
            </div>
            <div class="col-6">
                <h4>Regisztráció</h4>
                <form action="/registration" method="post" id="reg_form">
                    @csrf
                    <div class="mb-3">
                        <label for="reg_fname" class="form-label">Vezetéknév</label>
                        <input type="text" name="reg_fname" id="reg_fname" class="form-control" name="reg_fname" >
                        @error('reg_fname')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="reg_lname" class="form-label">Keresztnév</label>
                        <input type="text" name="reg_lname" id="reg_lname" class="form-control" name="reg_lname" >
                        @error('reg_lname')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="reg_email" class="form-label">Email cím</label>
                        <input type="email" class="form-control" id="reg_email" name="reg_email" >
                        @error('reg_email')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror 
                    </div>
                    <div class="mb-3">
                        <label for="reg_password" class="form-label">Jelszó (min 6 karakter)</label>
                        <input type="password" class="form-control" id="reg_password" name="reg_password" >
                        @error('reg_password')
                            <div class="alert alert-danger mt-2" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Regisztráció</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/log_reg.js') }}"></script>
</body>
</html>
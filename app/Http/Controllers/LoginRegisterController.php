<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use App\Models\User;

use Purifier;

class LoginRegisterController extends Controller
{
    public function index() {
        return view("log_reg");
    }


    public function login(Request $request) {
        $validated = Validator::make($request->all(), [
            "log_email" => "required|email",
            "log_password" => "required"
        ], [
            "log_email.required" => "E-mail mező kitöltése kötelező!",
            "log_email.email" => "A beírt érték nem felel meg az e-mail formátumnak!",
            "log_password.required" => "Jelszó megadása kötelező!"
        ]);

        if($validated->fails()) {
            return back()->withErrors($validated->errors());
        }

        $w_log_email = preg_replace('/\s+/', '', $request->input("log_email"));
        $w_log_password = preg_replace('/\s+/', '', $request->input("log_password"));

        $cleaned_log_email = Purifier::clean($w_log_email);
        $cleaned_log_password = Purifier::clean($w_log_password);

        if($w_log_email == $cleaned_log_email && $w_log_password == $cleaned_log_password) {
            
            if(Auth::attempt(["email" => $request->input("log_email"), "password" => $request->input("log_password")])) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }

            return back()->withErrors([
                "failed" => "A megadott hitelesítési adatok hibásak!"
            ]);
        }

        return back()->withErrors([
            "failed" => "Ismeretlen hiba történt"
        ]);
    }

    public function registration(Request $request) {
        $validated = Validator::make($request->all(), [
            "reg_fname" => "required",
            "reg_lname" => "required",
            "reg_email" => "required|email",
            "reg_password" => "required|min:6"
        ],
        [
            "reg_fname.required" => "Vezetéknév megadása kötelező!",
            "reg_lname.required" => "Keresztnév megadása kötelező!",
            "reg_password.required" => "Jelszó megadása kötelező!",
            "reg_password.min" => "A jelszónak minimum 6 karakter hosszúnak kell lennie!",
            "reg_email.required" => "Az e-mail megadása kötelező!",
            "reg_email.email" => "A megadott érték nem felel meg az e-mail formátumnak!"
        ]);

        if($validated->fails()) {
            return back()->withErrors($validated->errors());
        }

        $w_reg_fname = preg_replace('/\s+/', '', $request->input("reg_fname"));
        $w_reg_lname = preg_replace('/\s+/', '', $request->input("reg_lname"));
        $w_reg_email = preg_replace('/\s+/', '', $request->input("reg_email"));
        $w_reg_password = preg_replace('/\s+/', '', $request->input("reg_password"));

        if(!preg_match('/^[a-zA-Z0-9]+$/', $w_reg_password)) {
            return back()->withErrors([
                "reg_password" => "A jelszó csak kisbetűket, nagybetűket és számokat tartalmazhat!"
            ]);
        }


        $cleaned_reg_fname = Purifier::clean($w_reg_fname);
        $cleaned_reg_lname = Purifier::clean($w_reg_lname);
        $cleaned_reg_email = Purifier::clean($w_reg_email);
        $cleaned_reg_password = Purifier::clean($w_reg_password);

        if($w_reg_fname == $cleaned_reg_fname &&
           $w_reg_lname == $cleaned_reg_lname && 
           $w_reg_email == $cleaned_reg_email &&
           $w_reg_password == $cleaned_reg_password ) {

            try{
                User::create([
                    "lname" => $request->input("reg_lname"),
                    "fname" => $request->input("reg_fname"),
                    "email" => $request->input("reg_email"),
                    "password" => Hash::make($request->input("reg_password"))
                ]);

                return back()->with("success", "Sikeres regisztráció");

            } catch(\Illuminate\Database\QueryException $e) {
                if($e->errorInfo[1] == 1062) {
                    return back()->withErrors([
                        "failed" => "Ezzel az e-mail címmel már regisztráltak!"
                    ]); 
                }
            } catch(\Exception $ex) {
                return back()->withErrors([
                    "failed" => "Ismeretlen hiba történt regisztrálás közben!"
                ]);
            }

        }
        return back()->withErrors([
            "failed" => "Ismeretlen hiba történt"
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validiere die Anmeldeinformationen des Benutzers
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        // Finde den Benutzer anhand der E-Mail-Adresse
        $user = User::where('email', $credentials['email'])->first();

        // Authentifiziere den Benutzer basierend auf den übermittelten Anmeldeinformationen
        if ($user && Hash::check($credentials['password'], $user->password)) {


            // Logge den Erfolg der Passwort-Überprüfung
            Log::info('Password check successful', ['email' => $credentials['email']]);

            // Authentifiziere den Benutzer manuell
            Auth::login($user);

            // Die Anmeldeinformationen sind korrekt

            // Führe weitere Aktionen aus, z.B. Sitzung regenerieren
            $request->session()->regenerate();

            // Weiterleiten des Benutzers nach erfolgreicher Anmeldung
            return redirect()->intended('/dashboard');
        }


        // Logge das Scheitern der Authentifizierung
        Log::warning('Authentication failed', ['email' => $credentials['email']]);

        // Anmeldeinformationen sind ungültig, leite den Benutzer zurück
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}

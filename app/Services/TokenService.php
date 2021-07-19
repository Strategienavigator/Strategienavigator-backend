<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class TokenService
{

    /**
     * Erstellt eine zufällige hexadezimal nummer, welche als string zurück gegeben wird
     * @param bool $strong definiert ob die Zufallszahl 16 (false) oder 32 (true) bytes lang ist
     * @return string|bool Gibt den Token zurück wenn er generiert wurde. Gibt false zurück wenn kein token generiert werden konnte.
     */
    public function createToken(bool $strong = false)
    {
        try {
            $randomBytes = random_bytes($strong ? 32 : 16);
            return bin2hex($randomBytes);
        } catch (\Exception $e) {
            Log::critical("couldn't create random bytes to create a token",$e);
        }
        return false;
    }


    /** prüft ob beide übergebenen token übereinstimmen
     * @param string $toCheck token welcher geprüft werden soll
     * @param string $token token welcher sicher richtig ist
     * @return bool true wenn beide token übereinstimmen
     */
    public function checkToken(string $toCheck, string $token):bool
    {
        return $toCheck === $token;
    }

}

<?php

namespace App\Services;

use Illuminate\Http\Request;

class CaptchaService
{


    public function checkRequest(Request $request, string $keyName = "captcha_key", string $captchaName = "captcha"): void
    {
        $key = $request->validate([
            $keyName => ["required", "string"]
        ])[$keyName];

        $request->validate([
            $captchaName => ["required", "captcha_api:" . $key]
        ]);

    }

}

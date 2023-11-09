<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{

    const FRONTEND_BETA_VIEW = "frontend-beta";
    const FRONTEND_VIEW = 'frontend';
    const MANIFEST_FILE = "manifest.json";
    const MANIFEST_BETA_FILE = 'manifest-backend.json';
    static int $BETA_SETTING_ID = 3;

    public function index(Request $request): View
    {

        if ($this->showBeta($request)) {

            return view(self::FRONTEND_BETA_VIEW);
        }

        return view(self::FRONTEND_VIEW);
    }


    public function manifest(Request $request)
    {
        $manifestPath = resource_path("app" . DIRECTORY_SEPARATOR . self::MANIFEST_FILE);
        if ($this->showBeta($request)) {
            $manifestPath = resource_path("app" . DIRECTORY_SEPARATOR . self::MANIFEST_BETA_FILE);
        }

        return response()->json(file_get_contents($manifestPath));
    }

    private
    function showBeta(Request $request)
    {
        if (view()->exists(self::FRONTEND_BETA_VIEW)) {
            /** @var User $user */
            $user = $request->user();
            if (!is_null($user)) {
                $userSetting = $user->getUserSetting(self::$BETA_SETTING_ID, false);
                if (!is_null($userSetting)) {
                    $beta = json_decode($userSetting->value);

                    if ($beta) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}

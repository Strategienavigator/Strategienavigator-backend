<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SettingController extends Controller
{
    /**
     * Zeigt alle Einstellungen an
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $this->authorize("viewAny",Setting::class);
        return SettingResource::collection(Setting::paginate());
    }

    /**
     * Zeigt eine Einstellung an
     *
     * @param Setting $setting
     * @return SettingResource
     */
    public function show(Setting $setting)
    {
        $this->authorize($setting);
        return new SettingResource($setting);
    }
}

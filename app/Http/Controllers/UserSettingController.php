<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSettingResource;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserSetting;
use Database\Seeders\UserSeeder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserSettingController extends Controller
{

    public function index(User $user): AnonymousResourceCollection
    {
        $this->authorize("viewMany",[UserSetting::class,$user]);
        return UserSettingResource::collection($user->settings()->paginate());
    }

    public function store(Request $request, User $user): Response
    {

        $this->authorize("create", [UserSetting::class, $user]);

        $validated = $request->validate([
            "setting" => ["required","exists:settings,id"],
            "value" => ["required", "json"]
        ]);

        $setting = Setting::find($validated["setting"]);

        $user->settings()->attach($setting, ["value" => $validated["value"]]);

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function show(User $user, Setting $setting): UserSettingResource
    {
        $userSetting = $user->getUserSetting($setting->id);
        $this->authorize("view", [UserSetting::class, $userSetting]);
        return new UserSettingResource($userSetting);
    }

    public function update(Request $request, User $user, Setting $setting)
    {
        $userSetting = $user->getUserSetting($setting->id);

         $this->authorize("update", [UserSetting::class, $userSetting]);

        $validated = $request->validate([
            "value" => ["json"]
        ]);
        $userSetting->fill($validated);
        $userSetting->save();

        return \response()->noContent(Response::HTTP_OK);
    }

    public function destroy(User $user, Setting $setting)
    {
        $this->authorize("delete",[UserSetting::class,$user]);
        $user->settings()->detach($setting);
        return \response()->noContent(Response::HTTP_OK);
    }
}

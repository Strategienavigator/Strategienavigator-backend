<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\EmailVerification;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize("viewAny", User::class);
        return UserResource::collection(User::with(['saves','invitedSaves','accessibleShares'])->whereNotNull("email_verified_at")->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, EmailService $emailService): Response
    {
        // $this->authorize("create", User::class);

        $validated = \Validator::validate($request->all(), [
            "username" => ["required", "string", "unique:users"],
            // regex from https://www.ocpsoft.org/tutorials/regular-expressions/password-regular-expression/ (added some back slashes)
            "password" => ["required", "string", "min:7", "regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}\[\]:;<>,.?\/~_+-=\|]).+$/"],
            "email" => ["required", "email", "unique:users,email", "unique:" . EmailVerification::class . ",email"]
        ], [
            "password.regex" => __("passwords.invalid_regex")
        ]);

        $u = new User();
        $this->updateUser($u, array_merge(["anonym" => false,], $validated), $emailService);
        return response()->created('users', $u);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        $this->authorize("view",$user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user, EmailService $emailService): Response
    {
        $this->authorize("update", $user);

        $validated = \Validator::validate($request->all(), [
            "username" => ["string", "unique:users"],
            // regex from https://www.ocpsoft.org/tutorials/regular-expressions/password-regular-expression/ (added some back slashes)
            "password" => ["string", "min:7", "regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}\[\]:;<>,.?\/~_+-=\|]).+$/"],
            // "email" => ["email", "unique:users,email", "unique:" . EmailVerification::class . ",email"]
        ], [
            "password.regex" => __("passwords.invalid_regex")
        ]);

        $this->updateUser($user, $validated, $emailService);
        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $this->authorize("delete",$user);
        $user->delete();
        return response()->noContent(Response::HTTP_OK);
    }


    public function checkUsername(Request $request):JsonResponse{
        $validated = $request->validate([
            "username" => ["string","required"]
        ]);
        return response()->json(["data" =>[
            "available" => User::whereUsername($validated["username"])->count()==0
        ]]);

    }


    /**
     * does update the given user model with the given data. If the email is changed
     * @param User $u a user model
     * @param array $data array with the new data
     * @param EmailService $emailService the email service
     */
    private function updateUser(User $u, array $data, EmailService $emailService)
    {
        $u->fill($data);
        if (key_exists("password", $data)) {
            $u->password = $data["password"];
        }

        if (key_exists("anonym", $data)) {
            $u->anonym = $data["anonym"];
        }

        $u->save();
        if (key_exists("email", $data)) {
            $emailService->requestEmailChangeOfUser($u, $data["email"]);
        }
    }
}

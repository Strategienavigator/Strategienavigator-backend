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

    private static $passwordRegex = "/^(?=.*[a-zäöüß])(?=.*[A-ZÄÖÜ])(?=.*\d)(?=.*[$&§+,:;=?@#|'<>.^*()%!_-])[A-Za-zäöüßÄÖÜ\d$&§+,:;=?@#|'<>.^*()%!_-].+$/";


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize("viewAny", User::class);
        return UserResource::collection(User::with(['saves', 'invitedSaves', 'accessibleShares'])->whereNotNull("email_verified_at")->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function store(Request $request, EmailService $emailService): Response
    {
        $validated = \Validator::validate($request->all(), [
            "anonymous" => ["boolean"],
            "username" => ["prohibited_if:anonymous,true", "required_unless:anonymous,true", "string", "unique:users"],
            "password" => ["prohibited_if:anonymous,true", "required_unless:anonymous,true", "string", "min:8", "max:120", "regex:" . UserController::$passwordRegex],
            "email" => ["prohibited_if:anonymous,true", "required_unless:anonymous,true", "email", "unique:users,email", "unique:" . EmailVerification::class . ",email"]
        ], [
            "password.regex" => __("passwords.invalid_regex")
        ]);

        if(array_key_exists("anonymous", $validated) && $validated["anonymous"] === True){
            $password = "anoPassword";
            $u = $this->createAnonymousUser($password);
            $u->save();
            return \response()->created('users', $u)->setContent(["username"=>$u->username,"password"=>$password]);
        }else{
            $u = new User();
            $this->updateUser($u, array_merge(["anonym" => false,], $validated), $emailService);
            return \response()->created('users', $u);
        }
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

        $u->save();
        if (key_exists("email", $data)) {
            $emailService->requestEmailChangeOfUser($u, $data["email"]);
        }
    }

    /**
     * @param User $u the anonymous user which gets upgraded
     * @param array $data array with username, password and email fields
     * @param EmailService $emailService
     */
    private function upgradeAnonymousUser(User $u, array $data, EmailService $emailService){
        if($u->anonym){
            $u->anonym = false;
            $u->fill($data);
            $u->password = $data["password"];
            $emailService->requestEmailChangeOfUser($u,$data["email"]);
            $u->save();
        }
    }

    /**
     * @return User
     * @throws \Exception
     */
    private function createAnonymousUser(string $password){
        $u = new User();
        $u->anonym = true;
        $u->password = $password;
        do{
            $u->username = "anoym". random_int(1000,1000000);
        }while(User::whereUsername($u->username)->exists());

        return $u;
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        $this->authorize("view", $user);

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
            "password" => ["string", "min:8", "max:120", "regex:" . UserController::$passwordRegex],
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
        $this->authorize("delete", $user);
        $user->delete();
        return response()->noContent(Response::HTTP_OK);
    }

    public function checkUsername(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "username" => ["string", "required"]
        ]);
        return response()->json(["data" => [
            "available" => User::whereUsername($validated["username"])->count() == 0
        ]]);

    }
}

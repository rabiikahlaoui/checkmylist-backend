<?php

namespace App\Http\Controllers;

use App\Constants\TranslationCode;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /** @var UserService */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->userService = new UserService();
    }

    /**
     * Register the user, send activation code on email
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->userService->validateRegisterRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        $request->merge(['password' => Hash::make($request->get('password'))]);

        DB::beginTransaction();

        $this->userService->registerUser($request);

        DB::commit();

        return $this->successResponse();
    }

    /**
     * Update profile
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function updateLoggedUser(Request $request)
    {
        $user = $request->auth;

        $validator = $this->userService->validateUpdateUserRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        $email = $request->get('email');

        if ($user->email !== $email) {
            $userExists = User::where('email', $email)->first();

            if ($userExists) {
                return $this->userErrorResponse(['email' => TranslationCode::ERROR_UPDATE_EMAIL_REGISTERED]);
            }
        }

        if ($request->has('newPassword') && !app('hash')->check($request->get('oldPassword'), $user->password)) {
            return $this->userErrorResponse(['oldPassword' => TranslationCode::ERROR_UPDATE_OLD_PASSWORD_WRONG]);
        }

        DB::beginTransaction();

        $this->userService->updateLoggedUser($user, $request);

        DB::commit();

        return $this->successResponse($user);
    }

    /**
     * Get logged user
     *
     * @return JsonResponse
     */
    public function getLoggedUser(Request $request)
    {
        return $this->successResponse($request->auth);
    }
}

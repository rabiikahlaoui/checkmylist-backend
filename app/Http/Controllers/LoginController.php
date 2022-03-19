<?php

namespace App\Http\Controllers;

use App\Constants\TranslationCode;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LoginController
 * 
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{

    /** @var UserService */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Login user with email and password
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = $this->userService->validateLoginRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        $user = $this->userService->loginUser($request->only('email', 'password'));

        if (!$user) {
            return $this->userErrorResponse(['credentials' => TranslationCode::ERROR_CREDENTIALS_INVALID]);
        }

        $loginData = $this->userService->generateLoginData($user, $request->has('remember'));

        return $this->successResponse($loginData);
    }
}

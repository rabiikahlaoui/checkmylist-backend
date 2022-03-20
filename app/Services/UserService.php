<?php

namespace App\Services;

use App\Constants\TranslationCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use IonGhitun\MysqlEncryption\Models\BaseModel;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
{
    /**
     * Validate request on login
     *
     * @param  Request  $request
     *
     * @return ReturnedValidator
     */
    public function validateLoginRequest(Request $request)
    {
        $rules = [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required'
        ];

        $messages = [
            'email.required'    => TranslationCode::ERROR_EMAIL_REQUIRED,
            'email.email'       => TranslationCode::ERROR_EMAIL_INVALID,
            'email.exists'      => TranslationCode::ERROR_EMAIL_NOT_REGISTERED,
            'password.required' => TranslationCode::ERROR_PASSWORD_REQUIRED
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Get user from email and password
     *
     * @param  array  $credentials
     *
     * @return User|null
     */
    public function loginUser(array $credentials)
    {
        // $builder = self::getUserBuilderForLogin();

        /** @var User|null $user */
        $user = User::where('email', $credentials['email'])
                        ->first();

        if (!$user) {
            return null;
        }

        $password = $user->password;

        if (app('hash')->check($credentials['password'], $password)) {
            return $user;
        }

        return null;
    }


    /**
     * Get user builder for login
     *
     * @return Builder|BaseModel
     */
    public static function getUserBuilderForLogin()
    {
        return User::with([
            'role' => function ($query) {
                $query->select(['id', 'name'])
                      ->with(['permissions']);
            }
        ]);
    }

    /**
     * Validate request on register
     *
     * @param  Request  $request
     *
     * @return ReturnedValidator
     */
    public function validateRegisterRequest(Request $request)
    {
        $rules = [
            'name'           => 'required',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'retypePassword' => 'required|same:password'
        ];

        $messages = [
            'name.required'           => TranslationCode::ERROR_REGISTER_NAME_REQUIRED,
            'email.required'          => TranslationCode::ERROR_REGISTER_EMAIL_REQUIRED,
            'email.email'             => TranslationCode::ERROR_REGISTER_EMAIL_INVALID,
            'email.unique'            => TranslationCode::ERROR_REGISTER_EMAIL_REGISTERED,
            'password.required'       => TranslationCode::ERROR_REGISTER_PASSWORD_REQUIRED,
            'password.min'            => TranslationCode::ERROR_REGISTER_PASSWORD_MIN8,
            'retypePassword.required' => TranslationCode::ERROR_REGISTER_RETYPE_PASSWORD_REQUIRED,
            'retypePassword.same'     => TranslationCode::ERROR_REGISTER_RETYPE_PASSWORD_SAME
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Register user
     *
     * @param  Request  $request
     */
    public function registerUser(Request $request)
    {
        $user = new User();

        $user->name            = $request->get('name');
        $user->email           = $request->get('email');
        $user->password        = $request->get('password');

        $user->save();
    }

    /**
     * Generate returned data on login
     *
     * @param  User  $user
     *
     * @return array
     */
    public function generateLoginData(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 3600 * 3600 // Expiration time
        ];

        $data = [
            'user'  => $user,
            'token' => JWT::encode($payload, env('JWT_SECRET'), 'HS256')
        ];

        return $data;
    }

    /**
     * Validate request on update user
     *
     * @param  Request  $request
     *
     * @return ReturnedValidator
     */
    public function validateUpdateUserRequest(Request $request)
    {
        $rules = [
            'name'           => 'required',
            'email'          => 'required|email',
            'oldPassword'    => 'required_with:newPassword',
            'newPassword'    => 'nullable|min:8',
            'retypePassword' => 'required_with:newPassword|same:newPassword',
        ];

        $messages = [
            'name.required'                => TranslationCode::ERROR_UPDATE_NAME_REQUIRED,
            'email.required'               => TranslationCode::ERROR_UPDATE_EMAIL_REQUIRED,
            'email.email'                  => TranslationCode::ERROR_UPDATE_EMAIL_INVALID,
            'oldPassword.required_with'    => TranslationCode::ERROR_UPDATE_OLD_PASSWORD_REQUIRED,
            'newPassword.min'              => TranslationCode::ERROR_UPDATE_NEW_PASSWORD_MIN8,
            'retypePassword.required_with' => TranslationCode::ERROR_UPDATE_RETYPE_PASSWORD_REQUIRED,
            'retypePassword.same'          => TranslationCode::ERROR_UPDATE_RETYPE_PASSWORD_SAME,
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Update logged user
     *
     * @param  User  $user
     * @param  Request  $request
     */
    public function updateLoggedUser(User &$user, Request $request)
    {
        $email        = $request->get('email');

        if ($user->email !== $email) {
            $user->email           = $email;
        }

        if ($request->has('newPassword')) {
            $user->password = Hash::make($request->get('newPassword'));
        }

        $user->name = $request->get('name');

        $user->save();
    }
}
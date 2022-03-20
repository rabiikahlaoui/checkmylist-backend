<?php

namespace App\Http\Controllers;

use App\Constants\TranslationCode;
use App\Services\ListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ListController
 *
 * @package App\Http\Controllers
 */
class ListController extends Controller
{
    /** @var ListService */
    private $listService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->listService = new ListService();
    }

    /**
     * Get users lists
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function getUserLists(Request $request)
    {
        $user = $request->auth;

        $userLists = $this->listService->getListsBuilder($user)->get();

        return $this->successResponse($userLists);
    }

    /**
     * Create a list
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function createList(Request $request)
    {
        $validator = $this->listService->validateCreateRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        DB::beginTransaction();

        $this->listService->createList($request);

        DB::commit();

        return $this->successResponse();
    }

    /**
     * Get a list
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function getList(Request $request, $id)
    {
        $user = $request->auth;

        $userLists = $this->listService->getListsBuilder($user);

        $userList = $userLists->where('id', $id)->first();

        if (!$userList) {
            return $this->userErrorResponse(['notFound' => TranslationCode::ERROR_NOT_FOUND]);
        }

        return $this->successResponse($userList);
    }

    /**
     * Update a list
     *
     * @param $id
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function updateList($id, Request $request)
    {
        $user = $request->auth;

        $userLists = $this->listService->getListsBuilder($user);

        $userList = $userLists->where('id', $id)->first();

        if (!$userList) {
            return $this->userErrorResponse(['notFound' => TranslationCode::ERROR_NOT_FOUND]);
        }

        $validator = $this->listService->validateUpdateRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        DB::beginTransaction();

        $this->listService->updateList($userList, $request);

        DB::commit();

        return $this->successResponse();
    }

    /**
     * Delete a list
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteList(Request $request, $id)
    {
        $user = $request->auth;

        $userLists = $this->listService->getListsBuilder($user);

        $userList = $userLists->where('id', $id)->first();

        if (!$userList) {
            return $this->userErrorResponse(['notFound' => TranslationCode::ERROR_NOT_FOUND]);
        }

        DB::beginTransaction();

        $userList->delete();

        DB::commit();

        return $this->successResponse();
    }
}

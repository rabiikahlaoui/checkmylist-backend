<?php

namespace App\Http\Controllers;

use App\Constants\TranslationCode;
use App\Services\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ItemController
 *
 * @package App\Http\Controllers
 */
class ItemController extends Controller
{
    /** @var ItemService */
    private $itemService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->itemService = new ItemService();
    }

    /**
     * Get lists items
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function getListItems(Request $request, $id)
    {
        $user = $request->auth;

        $ListItems = $this->itemService->getItemsBuilder($id)->get();

        return $this->successResponse($ListItems);
    }

    /**
     * Create an item
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function createItem(Request $request)
    {
        $validator = $this->itemService->validateCreateRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        DB::beginTransaction();

        $this->itemService->createItem($request);

        DB::commit();

        return $this->successResponse();
    }

    /**
     * Update an item
     *
     * @param $id
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function updateItem(Request $request, $id, $itemId)
    {
        $ListItems = $this->itemService->getItemsBuilder($id);

        $ListItem = $ListItems->where('id', $itemId)->first();

        if (!$ListItem) {
            return $this->userErrorResponse(['notFound' => TranslationCode::ERROR_NOT_FOUND]);
        }

        $validator = $this->itemService->validateUpdateRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        DB::beginTransaction();

        $this->itemService->updateList($ListItem, $request);

        DB::commit();

        return $this->successResponse();
    }

    /**
     * Delete a item
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteItem(Request $request, $id, $itemId)
    {
        $ListItems = $this->itemService->getItemsBuilder($id);

        $ListItem = $ListItems->where('id', $itemId)->first();

        if (!$ListItem) {
            return $this->userErrorResponse(['notFound' => TranslationCode::ERROR_NOT_FOUND]);
        }

        $validator = $this->itemService->validateUpdateRequest($request);

        if (!$validator->passes()) {
            return $this->userErrorResponse($validator->messages()->toArray());
        }

        DB::beginTransaction();

        $ListItem->delete();

        DB::commit();

        return $this->successResponse();
    }
}

<?php

namespace App\Services;

use App\Constants\TranslationCode;
use App\Models\ListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class ItemService
 *
 * @package App\Services
 */
class ItemService
{
    /**
     * Get items builder.
     *
     * @param  $id
     *
     * @return List
     */
    public function getItemsBuilder($id)
    {
        $ListItems = ListItem::where('list_id', $id);

        return $ListItems;
    }

    /**
     * Validate create request
     *
     * @param  Request  $request
     *
     * @return ReturnedValidator
     */
    public function validateCreateRequest(Request $request)
    {
        $rules = [
            'title'       => 'required|max:255',
            'list_id'     => 'required',
        ];

        $messages = [
            'title.required'   => TranslationCode::ERROR_ITEM_TITLE_REQUIRED,
            'title.max'        => TranslationCode::ERROR_ITEM_TITLE_MAX255,
            'list_id.required' => TranslationCode::ERROR_ITEM_LIST_REQUIRED,
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create an item
     *
     * @param  Request  $request
     */
    public function createItem(Request $request)
    {
        $list = new ListItem();

        $list->title       = $request->get('title');
        $list->description = $request->get('description');
        $list->list_id     = $request->get('list_id');

        $list->save();
    }

    /**
     * Validate request on update item
     *
     * @param  Request  $request
     *
     * @return ReturnedValidator
     */
    public function validateUpdateRequest(Request $request)
    {
        $rules = [
            'title'       => 'required|max:255',
        ];

        $messages = [
            'title.required' => TranslationCode::ERROR_LIST_TITLE_REQUIRED,
            'title.max'      => TranslationCode::ERROR_LIST_TITLE_MAX255,
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Update item
     *
     * @param  ListItem &$item
     * @param  Request  $request
     */
    public function updateList(ListItem &$item, Request $request)
    {
        $item->title       = $request->get('title');
        $item->description = $request->get('description');

        $item->save();
    }
}

<?php

namespace App\Services;

use App\Constants\TranslationCode;
use App\Models\User;
use App\Models\userList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class ListService
 *
 * @package App\Services
 */
class ListService
{
    /**
     * Get lists builder.
     *
     * @param  int  $canManage
     * @param  bool  $onlyOwn
     *
     * @return List
     */
    public function getListsBuilder(User $user)
    {

        $userLists = userList::where('user_id', $user->id);

        return $userLists;
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
        ];

        $messages = [
            'title.required' => TranslationCode::ERROR_LIST_TITLE_REQUIRED,
            'title.max'      => TranslationCode::ERROR_LIST_TITLE_MAX255,
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create list
     *
     * @param  Request  $request
     */
    public function createList(Request $request)
    {
        $list = new userList();

        $list->title       = $request->get('title');
        $list->description = $request->get('description');
        $list->user_id     = $request->auth->id;

        $list->save();
    }

    /**
     * Validate request on update list
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
     * Update list
     *
     * @param  UserList &$list
     * @param  Request  $request
     */
    public function updateList(UserList &$list, Request $request)
    {
        $list->title       = $request->get('title');
        $list->description = $request->get('description');

        $list->save();
    }
}

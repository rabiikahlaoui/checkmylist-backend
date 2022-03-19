<?php

namespace App\Constants;

/**
 * Class TranslationCode
 *
 * @package App\Constants
 */
class TranslationCode
{
    /* Misc */
    const ERROR_APPLICATION = 'errors.application';
    const ERROR_NOT_FOUND = 'errors.notFound';

    /* Login */
    const ERROR_EMAIL_REQUIRED = 'errors.email.required';
    const ERROR_EMAIL_INVALID = 'errors.email.invalid';
    const ERROR_EMAIL_NOT_REGISTERED = 'errors.email.notRegistered';
    const ERROR_PASSWORD_REQUIRED = 'errors.password.required';
    const ERROR_CREDENTIALS_INVALID = 'errors.credentials.invalid';

    /* Register */
    const ERROR_REGISTER_NAME_REQUIRED = 'errors.registerName.required';
    const ERROR_REGISTER_EMAIL_REQUIRED = 'errors.registerEmail.required';
    const ERROR_REGISTER_EMAIL_INVALID = 'errors.registerEmail.invalid';
    const ERROR_REGISTER_EMAIL_REGISTERED = 'errors.registerEmail.registered';
    const ERROR_REGISTER_PASSWORD_REQUIRED = 'errors.registerPassword.required';
    const ERROR_REGISTER_PASSWORD_MIN8 = 'errors.registerPassword.min8';
    const ERROR_REGISTER_RETYPE_PASSWORD_REQUIRED = 'errors.registerRetypePassword.required';
    const ERROR_REGISTER_RETYPE_PASSWORD_SAME = 'errors.registerRetypePassword.same';

    /* Update profile */
    const ERROR_UPDATE_NAME_REQUIRED = 'errors.updateName.required';
    const ERROR_UPDATE_EMAIL_REQUIRED = 'errors.updateEmail.required';
    const ERROR_UPDATE_EMAIL_INVALID = 'errors.updateEmail.invalid';
    const ERROR_UPDATE_OLD_PASSWORD_REQUIRED = 'errors.updateNewPassword.requiredOldPassword';
    const ERROR_UPDATE_NEW_PASSWORD_MIN8 = 'errors.updateNewPassword.min8';
    const ERROR_UPDATE_RETYPE_PASSWORD_REQUIRED = 'errors.updateNewPassword.required';
    const ERROR_UPDATE_RETYPE_PASSWORD_SAME = 'errors.updateNewPassword.same';
    const ERROR_UPDATE_EMAIL_REGISTERED = 'errors.updateEmail.registered';
    const ERROR_UPDATE_OLD_PASSWORD_WRONG = 'errors.updateOldPassword.wrong';

    /* List */
    const ERROR_LIST_TITLE_REQUIRED = 'errors.listName.required';
    const ERROR_LIST_TITLE_MAX255 = 'errors.listName.max255';

    /* Items */
    const ERROR_ITEM_TITLE_REQUIRED = 'errors.itemName.required';
    const ERROR_ITEM_TITLE_MAX255 = 'errors.itemName.max255';
    const ERROR_ITEM_LIST_REQUIRED = 'errors.itemList.required';
}

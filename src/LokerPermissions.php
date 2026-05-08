<?php

namespace Bale\Loker;

class LokerPermissions
{
    const VIEW_LOKER = 'loker.view';
    const CREATE_LOKER = 'loker.create';
    const UPDATE_LOKER = 'loker.update';
    const DELETE_LOKER = 'loker.delete';

    const VIEW_CATEGORY = 'loker.category.view';
    const CREATE_CATEGORY = 'loker.category.create';
    const UPDATE_CATEGORY = 'loker.category.update';
    const DELETE_CATEGORY = 'loker.category.delete';

    const VIEW_TYPE = 'loker.type.view';
    const CREATE_TYPE = 'loker.type.create';
    const UPDATE_TYPE = 'loker.type.update';
    const DELETE_TYPE = 'loker.type.delete';

    const VIEW_COMPANY = 'loker.company.view';
    const CREATE_COMPANY = 'loker.company.create';
    const UPDATE_COMPANY = 'loker.company.update';
    const DELETE_COMPANY = 'loker.company.delete';

    const ALL = [
        self::VIEW_LOKER,
        self::CREATE_LOKER,
        self::UPDATE_LOKER,
        self::DELETE_LOKER,

        self::VIEW_CATEGORY,
        self::CREATE_CATEGORY,
        self::UPDATE_CATEGORY,
        self::DELETE_CATEGORY,

        self::VIEW_TYPE,
        self::CREATE_TYPE,
        self::UPDATE_TYPE,
        self::DELETE_TYPE,

        self::VIEW_COMPANY,
        self::CREATE_COMPANY,
        self::UPDATE_COMPANY,
        self::DELETE_COMPANY,
    ];
}

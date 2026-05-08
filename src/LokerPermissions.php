<?php

namespace Bale\Loker;

class LokerPermissions
{
    const VIEW_LOKER = 'bale-loker.view';
    const CREATE_LOKER = 'bale-loker.create';
    const UPDATE_LOKER = 'bale-loker.update';
    const DELETE_LOKER = 'bale-loker.delete';

    const ALL = [
        self::VIEW_LOKER,
        self::CREATE_LOKER,
        self::UPDATE_LOKER,
        self::DELETE_LOKER,
    ];
}

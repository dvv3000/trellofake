<?php

use App\Enums\BoardUserRole;
use App\Enums\CardStatusEnum;

    if (!function_exists('getRole')) {
        function getRole($role)
        {
            return BoardUserRole::getKey($role);
        }
    }

    if (!function_exists('getStatus')) {
        function getStatus($status)
        {
            return CardStatusEnum::getKey($status);
        }
    }

    if (!function_exists('isAssigned')) {
        function isAssigned($card)
        {
            return $card->member ? true : false;
        }
    }

    if (!function_exists('isCompleted')) {
        function isCompleted($status)
        {
            return $status ? 'completed' : '';
        }
    }

?>
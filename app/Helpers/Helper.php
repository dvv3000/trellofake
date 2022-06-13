<?php

use App\Enums\BoardUserRole;
use App\Enums\CardLabelEnum;

    if (!function_exists('getRole')) {
        function getRole($role)
        {
            return BoardUserRole::getKey($role);
        }
    }

    if (!function_exists('isAssigned')) {
        function isAssigned($card)
        {
            return $card->member ? true : false;
        }
    }

?>
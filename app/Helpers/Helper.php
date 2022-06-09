<?php

use App\Enums\BoardUserRole;

    if (!function_exists('getRole')) {
        function getRole($board)
        {
            return BoardUserRole::getKey($board->pivot->role);
        }
    }

?>
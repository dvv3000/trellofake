<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CardStatusEnum extends Enum
{
    public const PENDING =  0;
    public const COMPLETED = 1;
}

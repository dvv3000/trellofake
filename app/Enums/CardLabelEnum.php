<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CardLabelEnum extends Enum
{
    public const MORE_IMPORTANT =  0;
    public const IMPORTANT =   1;
    public const LESS_IMPORTANT = 2;
}

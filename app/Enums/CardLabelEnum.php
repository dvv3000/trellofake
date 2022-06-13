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
    public const IMPORTANT =  0;
    public const WARNING =   1;
    public const INFOMATIONAL = 2;
}

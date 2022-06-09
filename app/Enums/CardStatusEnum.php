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
    public const WAITING =   0;
    public const PENDING =   1;
    public const COMPLETED = 2;
}

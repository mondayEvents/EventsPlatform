<?php
namespace App\Abstraction;

use App\Abstraction\E;

/**
 * Activity Type Enum Class
 *
 */
abstract class ActivityTypeEnum extends Enum
{
    const __default = self::LECTURE;

    const LECTURE = 1;
    const WORKSHOP = 2;
    const DISCUSSION_PANEL = 3;

}

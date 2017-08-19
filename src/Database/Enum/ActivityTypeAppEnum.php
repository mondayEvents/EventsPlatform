<?php
namespace App\Database\Enum;

use App\Database\Enum\AppEnum;

/**
 * Activity Type AppEnum Class
 *
 */
abstract class ActivityTypeAppEnum extends AppEnum
{
    const __default = self::LECTURE;

    const LECTURE = 1;
    const WORKSHOP = 2;
    const DISCUSSION_PANEL = 3;

}

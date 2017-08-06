<?php
namespace App\Model\Table;

use App\Utility\BasicEnum;

/**
 * Activities Type Enum Class
 *
 */
abstract class ActivityTypeTable extends BasicEnum
{
    const __default = self::LECTURE;

    const LECTURE = 1;
    const WORKSHOP = 2;
    const DISCUSSION_PANEL = 3;

}

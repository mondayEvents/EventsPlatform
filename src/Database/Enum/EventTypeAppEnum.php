<?php
namespace App\Database\Enum;

use App\Database\Enum\AppEnum;

/**
 * Event Type AppEnum Class
 *
 */
abstract class EventTypeAppEnum extends AppEnum
{
    const __default = self::CONFERENCE;

    const CONFERENCE = 1;
    const SYMPOSIUM = 2;
    const SCIENTIFIC_WEEK = 3;

}

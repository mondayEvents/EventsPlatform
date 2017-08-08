<?php
namespace App\Abstraction;

use App\Abstraction\Enum;

/**
 * Event Type Enum Class
 *
 */
abstract class EventTypeEnum extends Enum
{
    const __default = self::CONFERENCE;

    const CONFERENCE = 1;
    const SYMPOSIUM = 2;
    const SCIENTIFIC_WEEK = 3;

}

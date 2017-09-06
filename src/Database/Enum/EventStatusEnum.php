<?php
namespace App\Database\Enum;

use App\Database\Enum\AppEnum;

/**
 * Activity Type AppEnum Class
 *
 */
abstract class  EventStatusEnum extends AppEnum
{
    const __default = self::UNPUBLISHED;

    const UNPUBLISHED = 0;
    const NEW = 1;
    const OPEN = 2;
    const IN_PROGRESS = 3;
    const FINISHED = 4;
}

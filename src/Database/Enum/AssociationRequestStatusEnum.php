<?php
namespace App\Database\Enum;

use App\Database\Enum\AppEnum;

/**
 * Activity Type AppEnum Class
 *
 */
abstract class AssociationRequestStatusEnum extends AppEnum
{
    const __default = self::PENDING;

    const PENDING = 0;
    const ACCEPTED = 1;
    const DECLINED = 2;
}

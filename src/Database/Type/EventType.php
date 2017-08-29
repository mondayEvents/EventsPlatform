<?php
namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use App\Database\Enum\EventTypeEnum as TypeEnum;
use PDO;

class EventType extends Type
{

    /**
     * @param mixed $value
     * @param Driver $driver
     * @return null|string
     */
    public function toPHP($value, Driver $driver)
    {
        if ($value === null) {
            return null;
        }
        return TypeEnum::getNameByValue((int) $value);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function marshal($value)
    {
        if (is_array($value) || $value === null) {
            $value = TypeEnum::__default;
        }
        return TypeEnum::getNameByValue((int) $value);
    }

    /**
     * @param mixed $value
     * @param Driver $driver
     * @return int
     */
    public function toDatabase($value, Driver $driver)
    {
        return TypeEnum::getValueByName(strtolower($value));
    }

    /**
     * @param mixed $value
     * @param Driver $driver
     * @return int
     */
    public function toStatement($value, Driver $driver)
    {
        if ($value === null) {
            return PDO::PARAM_NULL;
        }
        return PDO::PARAM_INT;
    }

}
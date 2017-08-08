<?php
namespace App\Utility;

/**
 * Activities Model
 *
 */
abstract class BasicEnum
{
    private static $constCacheArray = NULL;

    public static function getConstants()
    {
        if (self::$constCacheArray == NULL)
        {
            self::$constCacheArray = [];
        }

        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray))
        {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict)
        {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue ($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    /**
     * @param $value
     * @return false|int|string
     * @throws \Exception
     */
    public static function getNameByValue ($value)
    {
        if (!self::isValidValue($value))
        {
            throw new \Exception("Invalid enum value");
        }

        $constants = self::getConstants();
        unset($constants['__default']);

        return array_search($value, $constants);
    }
}
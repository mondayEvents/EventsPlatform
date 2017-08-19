<?php
namespace App\Database\Enum;

use Cake\Utility\Text;
/**
 * Activities Model
 *
 */
abstract class AppEnum
{
    private static $constCacheArray = NULL;

    /**
     * Get Constants as array. If parameter pretty is true,
     * returns a cake-list-like array format
     *
     * @param bool $pretty
     * @return array
     */
    public static function getConstants(bool $pretty = false) : array
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

        $constants = self::$constCacheArray[$calledClass];

        if ($pretty)
        {
            unset($constants['__default']);

            $constants = array_change_key_case($constants, CASE_LOWER);
            return array_map('ucwords', str_replace('_',' ', array_flip($constants)));
        }

        return $constants;
    }

    /**
     * Check if given name is a valid Constant
     *
     * @param $name
     * @param bool $strict
     * @return bool
     */
    public static function isValidName($name, $strict = false) : bool
    {
        $constants = self::getConstants();

        if ($strict)
        {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Check if given value is a valid Constant value
     *
     * @param $value
     * @param bool $strict
     * @return bool
     */
    public static function isValidValue ($value, $strict = true) : bool
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    /**
     * Get Constant value by its name
     *
     * @param $value
     * @return string
     * @throws \Exception
     */
    public static function getNameByValue ($value) : string
    {
        if (!self::isValidValue($value))
        {
            throw new \Exception("Invalid enum value");
        }

        $constants = self::getConstants();
        unset($constants['__default']);

        return self::prettify(array_search($value, $constants));
    }

    /**
     * Get Constant name by its value
     *
     * @param $value
     * @return int
     * @throws \Exception
     */
    public static function getValueByName ($value) : int
    {

        if (!self::isValidName($value))
        {
            throw new \Exception("Invalid enum name");
        }

        $constants = self::getConstants();
        return $constants[Text::slug(strtoupper($value), '_')];
    }

    /**
     * @param string $value
     * @return string
     */
    private static function prettify (string $value) : string
    {
        return ucwords(strtolower(str_replace('_', ' ', $value)));
    }
}
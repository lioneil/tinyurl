<?php

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    /**
     * Retrieve the keys of the parent class constants.
     *
     * @return array
     */
    static function getKeys ()
    {
        $class = new ReflectionClass(get_called_class());

        return array_keys($class->getConstants());
    }

    /**
     * Retrieve the values of the parent class constants.
     *
     * @return array
     */
    static function getValues ()
    {
        $class = new ReflectionClass(get_called_class());

        return array_values($class->getConstants());
    }
}

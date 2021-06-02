<?php

class Lambda
{
    private $function;

    function __construct(callable $function)
    {
        $this->function = $function;
    }
    function __invoke(...$params)
    {
        $argumentsCount  = (new ReflectionFunction($this->function))->getNumberOfParameters();

        if (func_num_args() < $argumentsCount)
        {
//            return $this->__curry(...$params);
            return self::curry($this->function, ...$params);
        }
        else
        {
            return call_user_func_array($this->function, [...$params]);
        }
    }
//    public function __curry(...$params)
//    {
//        return function (...$args) use ($params) {
//            return ($this->function)(...$params, ...$args);
//        };
//    }

    static function curry($fn, ...$params)
    {
        return function (...$args) use ($fn, $params) {
            return ($fn)(...$params, ...$args);
        };
    }

    static function compose(...$params)
    {
        return function(...$args) use ($params)
        {
            $ret = array_shift($params)(...$args);
            foreach($params as $fn)
            {
                $ret = $fn($ret);
            }

            return $ret;
        };
    }

    static function __map(): Lambda
    {
        return lambda(fn($fn, $array) => array_map($fn, $array));
    }
    static function map($fn = null, $array = [])
    {
        return self::__map()(...func_get_args());
    }
    static function __pluck(): Lambda
    {
        return lambda(fn($field, $array) => array_column($array, $field));
    }
    static function pluck($field = null, $array = [])
    {
        return self::__pluck()(...func_get_args());
    }
    static function __sum(): Lambda
    {
        return lambda(fn($array) => array_sum($array));
    }
    static function sum($array = [])
    {
        return self::__sum()(...func_get_args());
    }
}

function lambda(callable $function)
{
    return new Lambda($function);
}

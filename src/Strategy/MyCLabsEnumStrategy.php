<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use MyCLabs\Enum\Enum;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class MyCLabsEnumStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class MyCLabsEnumStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    private $classFqn;

    public function __construct($classFqn)
    {
        $this->classFqn = $classFqn;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed|Enum $value
     *
     * @return mixed|string
     */
    public function extract($value)
    {
        if ($value instanceof Enum && get_class($value) === $this->classFqn) {
            return (string)$value;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed|string $value
     *
     * @return mixed|Enum
     */
    public function hydrate($value)
    {
        try {
            return call_user_func("{$this->classFqn}::$value");
        } catch (\Exception $e) {
            //
        }

        return $value;
    }
}
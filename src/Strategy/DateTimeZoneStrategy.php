<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class DateTimeZoneStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class DateTimeZoneStrategy implements StrategyInterface
{
    /**
     * @inheritdoc
     *
     * @param mixed|\DateTimeZone $value
     *
     * @return mixed|string
     */
    public function extract($value)
    {
        return ($value instanceof \DateTimeZone) ? $value->getName() : $value;
    }

    /**
     * @inheritdoc
     *
     * @param mixed|string $value
     *
     * @return mixed|\DateTimeZone
     */
    public function hydrate($value)
    {
        try {
            return new \DateTimeZone($value);
        } catch (\Exception $e) {
            //;
        }

        return $value;
    }
}